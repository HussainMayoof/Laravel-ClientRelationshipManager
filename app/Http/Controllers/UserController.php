<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return view('users.index', ['users' => User::paginate(5)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (Route::getCurrentRoute()->getName() == 'dashboard') {
            $user = auth()->user();
        }
        
        return view('users.show', ['user' => $user, 'tasks' => Task::where('user_id', $user->id)->where('is_complete', 0)->paginate(5, ['*'], 'tasks'), 'projects' => Project::where('user_id', $user->id)->where('is_open', 1)->paginate(5, ['*'], 'projects')]);
    }

    public function edit(User $user)
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }

        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'email' => 'email'
        ]);

        if (isset($request['name'])) {
            $user->name = strip_tags($request['name']);
        }

        if ($request['changeP'] == 'on') {
            if (!(Hash::check($request['oldPassword'], $user->password))) {
                return back()->withErrors(['oldPassword' => 'Incorrect password'])->with(['open'=>1]);
            }
            
            $incomingPasswords = $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $user->password = strip_tags($incomingPasswords['password']);
        }

        if (isset($request['email'])) {
            $user->email = strip_tags($incomingFields['email']);
            $user->email_verified_at = null;

            $user->save();
            $user->sendEmailVerificationNotification();

            return redirect('/email/verify');
        }


        $user->save();

        return redirect('users/'.$user->id);
    }

    public function makeAdmin(Request $request, User $user)
    {
        if (!(auth()->user()->is_admin)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'is_admin' => 'required'
        ]);

        if ($incomingFields['is_admin'] != 1) {
            return back()->withErrors(['is_admin' => 'Unexpected value']);
        }

        $user->is_admin = 1;
        $user->save();

        return redirect('/users/'.$user->id);
    }

    public function search(Request $request) {
        $query = $request['query'];

        if ($query != "") {
            $users = User::where('name', 'LIKE', '%'.$query.'%')->orWhere('email', 'LIKE', '%'.$query.'%')->paginate(5)->setPath('');
            $users->appends(['query' => $query]);

            if (count($users) > 0){
                return view('users.index', ['users'=>$users]);
            }
        }

        return redirect('users')->withErrors(['search' => 'No search results found']);
    }
}
