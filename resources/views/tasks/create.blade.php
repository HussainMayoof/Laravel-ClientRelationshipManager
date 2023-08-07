@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">New Task</h2>
                        <form action="/tasks" method="post">
                            @csrf
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('title')?' is-invalid':''}}" id="title" name="title" value="{{old('title')}}" placeholder="">
                                <label for="title" style="margin-left: 10px">Task Name</label>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-floating col mb-4">
                                <textarea type="text" class="form-control{{$errors->first('description')?' is-invalid':''}}" id="description" name="description" placeholder="" style="height: 150px;">{{old('description')}}</textarea>
                                <label for="description" style="margin-left: 10px">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating col mb-4">
                                <input class="form-control{{$errors->first('project_id')?' is-invalid':''}}" list="projectDataList" id="project_id" name="project_id" value="{{old('project_id')}}" placeholder="">
                                    <label for="project_id" style="margin-left: 10px">Project ID (Optional)</label>
                                    
                                    <datalist id="projectDataList">
                                        @foreach ($projects as $project)
                                            <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </datalist>
                                @error('project_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Save Task</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection