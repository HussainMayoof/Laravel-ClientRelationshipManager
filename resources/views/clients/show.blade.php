@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$client->company}}</h2>
                        <div class="col mb-4">
                            <h4>ZIP Code</h4>
                            <p>{{$client->zip}}</p>
                        </div>

                        <div class="col mb-4">
                            <h4>Address</h4>
                            <p>{{$client->address}}</p>
                        </div>

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
                            @endif
                        </div>
                        <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection