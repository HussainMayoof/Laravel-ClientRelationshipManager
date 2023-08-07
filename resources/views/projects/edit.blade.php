@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Edit Project</h2>
                        <form action="/projects/{{$project->id}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('title')?' is-invalid':''}}" id="title" name="title" value="{{old('title') ?? $project->title}}" placeholder="Example Title">
                                <label for="title" style="margin-left: 10px">Project Title</label>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-floating col mb-4">
                                <textarea type="text" class="form-control{{$errors->first('description')?' is-invalid':''}}" id="description" name="description" placeholder="Example description" style="height: 200px;">{{old('description')  ?? $project->description}}</textarea>
                                <label for="description" style="margin-left: 10px">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating col mb-4">
                                <input type="date" class="form-control{{$errors->first('deadline')?' is-invalid':''}}" id="deadline" name="deadline" value="{{old('deadline')  ?? $project->deadline}}" placeholder="12th May 2023">
                                <label for="deadline" style="margin-left: 10px">Deadline</label>
                                @error('deadline')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            @if (auth()->user()->is_admin)
                                <div class="form-floating col mb-4">
                                    <input class="form-control{{$errors->first('user_id')?' is-invalid':''}}" list="userDataList" id="user_id" name="user_id" value="{{old('user_id')  ?? $project->user_id}}" placeholder="Type to search">
                                        <label for="user_id" style="margin-left: 10px">User ID</label>
                                        
                                        <datalist id="userDataList">
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </datalist>
                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            @endif

                            <div class="form-floating col mb-4">
                                <input class="form-control{{$errors->first('client_id')?' is-invalid':''}}" list="clientDataList" id="client_id" name="client_id" value="{{old('client_id')  ?? $project->client_id}}" placeholder="Type to search">
                                    <label for="client_id" style="margin-left: 10px">Client ID</label>
                                    
                                    <datalist id="clientDataList">
                                        @foreach ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->company}}</option>
                                        @endforeach
                                    </datalist>
                                @error('client_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="col mb-4">
                                <input type="checkbox" class="btn-check" id="is_open" name="is_open" autocomplete="off"{{!$project->is_open ? ' checked' : ''}}>
                                <label class="btn btn-outline-success" for="is_open">Incomplete</label>
                            </div>

                            <button class="btn btn-primary" type="submit">Save Project</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                            <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$project->id}}').submit();">Delete</a>
                        </form>
                        <form id="delete-form-{{$project->id}}" method="post" action="/projects/{{$project->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var btn = $("#is_open");
            var label = $("[for='is_open']")
            var toggled = false;
            btn.on("click", function() {
                if(!toggled)
                {
                toggled = true;
                label.text("Complete");
                } else {
                toggled = false;
                label.text("Incomplete");
                }
            });
        });
    </script>
@endsection