@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <div class="card-title mb-4">
                        <h2 class="d-inline-block">{{$user->name}}</h2>
                        @if (auth()->user()->id == $user->id)
                            <a href="/users/{{$user->id}}/edit" class="btn btn-outline-secondary btn-sm mx-2">Edit Account</a>
                        @endif
                        @if ((auth()->user()->is_admin) AND !($user->is_admin))
                            <form action="/users/{{$user->id}}/makeAdmin" method="post" style="all: unset !important;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_admin" id="is_admin" value="1">
                            <button type="submit" class="btn btn-outline-secondary btn-sm mx-2">Make Admin</button>
                            </form>
                        @endif
                        @if ($user->is_admin)
                            <button class="btn btn-info disabled">Admin</button>
                        @endif
                    </div>
                        <div class="col mb-4">
                            <h4>Email</h4>
                            <p>{{$user->email}}</p>
                        </div>

                        @if ((auth()->user()->id == $user->id) OR boolval(auth()->user()->is_admin))
                        <div class="col mb-4">
                            <h4>Tasks</h4>
                            @if ($tasks->isEmpty())
                            <p>No Tasks</p>
                            @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr onclick="window.location.href = '/tasks/{{$task->id}}';">
                                            <td>{{$task->title}}</td>
                                            <td>{{Str::limit($task->description, 50)}}</td>
                                            <td>
                                                <a class="btn btn-primary" href="/tasks/{{$task->id}}/edit">Edit</a>
                                                <a class="btn btn-success" href="javascript:document.getElementById('update-form-{{$task->id}}').submit();">Mark Complete</a>
                                                <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$task->id}}').submit();">Delete</a>

                                                
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="delete-form-{{$task->id}}" method="post" action="/tasks/{{$task->id}}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <form id="update-form-{{$task->id}}" method="post" action="/tasks/{{$task->id}}/markComplete">
                                @csrf
                                @method('PUT')
                            </form>
                            <div class="pagination">
                                {{ $tasks->appends(['projects' => $projects->currentPage()])->links() }}
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="col mb-4">
                            <h4>Projects</h4>
                            @if ($projects->isEmpty())
                            <p>No Projects</p>
                            @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Deadline</th>
                                        <th>Client</th>
                                        <th>Assigned User</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr onclick="window.location.href = '/projects/{{$project->id}}';">
                                            <td>{{$project->title}}</td>
                                            <td>{{$project->date}}</td>
                                            <td>{{$project->client->company}}</td>
                                            <td>{{$project->user->name}}</td>
                                            @if (auth()->user()->can('update', $project))
                                                <td>
                                                    <a class="btn btn-primary" href="/projects/{{$project->id}}/edit">Edit</a>
                                                    <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$project->id}}').submit();">Delete</a>
                                                    <form id="delete-form-{{$project->id}}" method="post" action="/projects/{{$project->id}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination">
                                {{ $projects->appends(['tasks' => $tasks->currentPage()])->links() }}
                            </div>
                            @endif
                        </div>
                        @if (Route::getCurrentRoute()->getName() != 'dashboard')
                            <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection