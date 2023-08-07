@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$project->title}}</h2>

                        <div class="col mb-4">
                            <h4>Description</h4>
                            <span>{{$project->description}}</span>
                        </div>

                        @if ($project->is_open)
                            <div class="col mb-4">
                                <h4>Deadline</h4>
                                <p>{{($project->date)}}</p>
                            </div>
                        @endif

                        <div class="col mb-4">
                            <h4>Client</h4>
                            <p><a href="/clients/{{$project->client->id}}">{{$project->client->company}}</a></p>
                        </div>

                        <div class="col mb-4">
                            <h4>Assigned User</h4>
                            <p><a href="/users/{{$project->user->id}}">{{$project->user->name}}</a></p>
                        </div>

                        <div class="col mb-4">
                            <input type="checkbox" class="btn-check" id="is_open" name="is_open" autocomplete="off"{{!$project->is_open ? ' checked' : ''}}>
                            <label class="btn btn-outline-success disabled" for="is_open">{{!$project->is_open ? 'Complete' : 'Incomplete'}}</label>
                        </div>

                        <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection