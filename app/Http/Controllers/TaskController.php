<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tasks.index', ['tasks' => Task::where('user_id', auth()->user()->id)->where('is_complete', 0)->paginate(5), 'tab' => 1]);
    }

    /**
     * Display a listing of the resources that are complete.
     */
    public function completeIndex()
    {
        return view('tasks.index', ['tasks' => Task::where('user_id', auth()->user()->id)->where('is_complete', 1)->paginate(5), 'tab' => 2]);
    }

    public function markComplete(Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            abort(403);
        }

        $task->update(['is_complete' => 1]);

        return redirect('tasks');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create', ['projects' => Project::where('user_id', auth()->user()->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->user()->id;

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);

        if (!is_null($request['project_id'])) {
            $incomingId = $request->validate([
                'project_id' => [Rule::exists('clients', 'id')]
            ]);

            if (Project::where('id',$incomingId['project_id'])->first()->user_id != auth()->user()->id) {
                return back()->withErrors(['project_id' => 'You are not the project owner']);
            }

            $incomingFields['project_id'] = $incomingId['project_id'];
        }

        Task::create($incomingFields);

        return redirect('tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if (auth()->user()->cannot('view', $task)) {
            abort(403);
        }

        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            abort(403);
        }

        return view('tasks.edit', ['task' => $task, 'projects' => Project::where('user_id', auth()->user()->id)->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($request['is_complete']=='on') {
            $incomingFields['is_complete'] = 1;
        }

        if (isset($request['project_id'])) {
            $incomingId = $request->validate([
                'project_id' => Rule::exists('clients', 'id')
            ]);

            if (Project::where('id',$incomingId['project_id'])->first()->user_id != auth()->user()->id) {
                return back()->withErrors(['project_id' => 'You are not the project owner']);
            }

            $incomingFields['project_id'] = $incomingId['project_id'];
        }

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);

        $task->update($incomingFields);

        return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (auth()->user()->cannot('delete', $task)) {
            abort(403);
        }

        $task->delete();

        return redirect('tasks');
    }

    public function search(Request $request) {
        $query = $request['query'];
        $tab = $request['tab'];

        if ($query != "") {

            if ($tab == 1){
                $tasks = Task::where('user_id', auth()->user()->id)->where('is_complete', 0)->search($query)->paginate(5)->setPath('');
                $tasks->appends(['query' => $query, 'tab' => $tab]);

                if (count($tasks) > 0){
                    return view('tasks.index', ['tasks'=>$tasks, 'tab'=>1]);
                }
            } else if ($tab == 2) {
                $tasks = Task::where('user_id', auth()->user()->id)->where('is_complete', 1)->search($query)->paginate(5)->setPath('');
                $tasks->appends(['query' => $query, 'tab' => $tab]);

                if (count($tasks) > 0){
                    return view('tasks.index', ['tasks'=>$tasks, 'tab'=>2]);
                }
            }
        }

        return redirect(url()->previous())->withErrors(['search' => 'No search results found']);
    }
}
