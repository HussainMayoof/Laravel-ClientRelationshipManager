<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resources belonging to the user.
     */
    public function index()
    {
        return view('projects.index', ['projects' => Project::where('user_id', auth()->user()->id)->where('is_open', 1)->orderBy('deadline')->paginate(5), 'tab'=>1]);
    }

    /**
     * Display a listing of the resource.
     */
    public function allIndex()
    {
        return view('projects.index', ['projects' => Project::where('is_open', 1)->orderBy('deadline')->paginate(5), 'tab'=>2]);
    }

    /**
     * Display a listing of the resources that are complete.
     */
    public function completeIndex()
    {
        return view('projects.index', ['projects' => Project::where('is_open', 0)->orderBy('deadline')->paginate(5), 'tab'=>3]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create', ['users' => User::all(), 'clients' => Client::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => ['required', "date_format:Y-m-d"],
            'client_id' => ['required', Rule::exists('clients', 'id')]
        ]);

        if (auth()->user()->is_admin) {
            $incomingId = $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')]
            ]);

            $incomingFields['user_id'] = $incomingId['user_id'];
        } else{
            $incomingFields['user_id'] = auth()->user()->id;
        }

        $incomingFields['is_open'] = 1;

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);
        $incomingFields['deadline'] = strip_tags($incomingFields['deadline']);

        Project::create($incomingFields);

        return redirect('projects');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (auth()->user()->cannot('update', $project)) {
            abort(403);
        }

        return view('projects.edit', ['project' => $project, 'users' => User::all(), 'clients' => Client::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        if (auth()->user()->cannot('update', $project)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => ['required', "date_format:Y-m-d"],
            'client_id' => ['required', Rule::exists('clients', 'id')]
        ]);

        if ($request['is_open'] == 'on') {
            $incomingFields['is_open'] = 0;
        }

        if (auth()->user()->is_admin) {
            $incomingId = $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')]
            ]);

            $incomingFields['user_id'] = $incomingId['user_id'];
        } else{
            $incomingFields['user_id'] = auth()->user()->id;
        }

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);
        $incomingFields['deadline'] = strip_tags($incomingFields['deadline']);

        $project->update($incomingFields);

        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->cannot('delete', $project)) {
            abort(403);
        }

        $project->delete();

        return redirect('projects');
    }

    public function search(Request $request) {
        $query = $request['query'];
        $tab = $request['tab'];

        if ($query != "") {

            if ($tab == 1) {
                $projects = Project::where('user_id', auth()->user()->id)->where('is_open', 1)->search($query)->orderBy('deadline')->paginate(5)->setPath('');
                $projects->appends(['query' => $query, 'tab' => $tab]);

                if (count($projects) > 0){
                    return view('projects.index', ['projects'=>$projects, 'tab'=>1]);
                }
            } else if ($tab == 2) {
                $projects = Project::where('is_open', 1)->search($query)->orderBy('deadline')->paginate(5)->setPath('');
                $projects->appends(['query' => $query, 'tab' => $tab]);

                if (count($projects) > 0){
                    return view('projects.index', ['projects'=>$projects, 'tab'=>2]);
                }
            } else if ($tab == 3) {
                $projects = Project::where('is_open', 0)->search($query)->orderBy('deadline')->paginate(5)->setPath('');
                $projects->appends(['query' => $query, 'tab' => $tab]);

                if (count($projects) > 0){
                    return view('projects.index', ['projects'=>$projects, 'tab'=>3]);
                }
            }
        }

        return redirect(url()->previous())->withErrors(['search' => 'No search results found']);
    }
}
