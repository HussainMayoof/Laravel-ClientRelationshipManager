@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$task->title}}</h2>

                        <div class="col mb-4">
                            <h4>Description</h4>
                            <span>{{$task->description}}</span>
                        </div>

                        @if (!is_null($task->project))
                            <div class="col mb-4">
                                <h4>Project</h4>
                                <p>{{$task->project->title}}</p>
                            </div>
                        @endif

                        <div class="col mb-4">
                            <input type="checkbox" class="btn-check" id="is_open" name="is_open" autocomplete="off"{{$task->is_complete ? ' checked' : ''}}>
                            <label class="btn btn-outline-success disabled" for="is_open">{{$task->is_complete ? 'Complete' : 'Incomplete'}}</label>
                        </div>

                        <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection