@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-2">Projects</h2>
                    <a class="btn btn-success mb-4" href="/projects/create">New Project</a>
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <a href="/projects" class="nav-link {{ $tab==1 ? 'active' : '' }}">Your Projects</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a href="/projects/all" class="nav-link {{ $tab==2 ? 'active' : '' }}">All Projects</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="/projects/complete" class="nav-link {{ $tab==3 ? 'active' : '' }}">Completed Projects</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active mt-2">
                            @if ($projects->isEmpty())
                                @if ($tab == 1)
                                    <p>You don't have any projects</p>
                                @endif

                                @if ($tab == 2)
                                    <p>No projects</p>
                                @endif

                                @if ($tab == 3)
                                    <p>You don't have any completed projects</p>
                                @endif
                            @else
                            <table class="table table-striped table-hover">

                                <div class="container mb-2">
                                    <form action="/projects/search" method="get" role="search">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="query"
                                                placeholder="Search projects"> <span class="input-group-btn">
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
                                {{ $projects->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection