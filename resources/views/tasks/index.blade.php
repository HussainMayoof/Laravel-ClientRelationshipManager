@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-2">Tasks</h2>
                    <a class="btn btn-success mb-4" href="/tasks/create">New Task</a>
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <a href="/tasks" class="nav-link {{ $tab==1 ? 'active' : '' }}">Your Tasks</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="/tasks/complete" class="nav-link {{ $tab==2 ? 'active' : '' }}">Completed Tasks</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active mt-2">
                            @if ($tasks->isEmpty())
                                @if ($tab == 1)
                                    <p>You don't have any tasks</p>
                                @else
                                    <p>You don't have any completed tasks</p>
                                @endif
                            @else
                            <table class="table table-striped table-hover">

                                <div class="container mb-2">
                                    <form action="/tasks/search" method="get" role="search">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="query"
                                                placeholder="Search tasks"> <span class="input-group-btn">
                                            <input type="hidden" name="tab" value="{{$tab}}">
                                                <button type="submit" class="btn btn-default">
                                                    <img src="https://icons.getbootstrap.com/assets/icons/search.svg" alt="Bootstrap" width="32" height="32">
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                    @error('search')
                                        <strong>{{ $message }}</strong>
                                    @enderror
                                </div>

                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr onclick="window.location.href = '/tasks/{{$task->id}}';">
                                            <td>{{$task->title}}</td>
                                            <td>{{Str::limit($task->description, 50)}}</td>
                                            <td>{{!is_null($task->project) ? $task->project->title : 'N/A'}}</td>
                                            @if ($tab == 1)
                                                <td style="text-align: right">
                                                    <a class="btn btn-primary" href="/tasks/{{$task->id}}/edit">Edit</a>
                                                    <a class="btn btn-success" href="javascript:document.getElementById('update-form-{{$task->id}}').submit();">Mark Complete</a>
                                                    <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$task->id}}').submit();">Delete</a>

                                                    <form id="delete-form-{{$task->id}}" method="post" action="/tasks/{{$task->id}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <form id="update-form-{{$task->id}}" method="post" action="/tasks/{{$task->id}}/markComplete">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination">
                                {{ $tasks->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection