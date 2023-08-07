@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Edit Account</h2>
                        <form action="/users/{{$user->id}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('name')?' is-invalid':''}}" id="name" name="name" value="{{old('name') ?? $user->name}}" placeholder="Example name">
                                <label for="name" style="margin-left: 10px">Name</label>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('email')?' is-invalid':''}}" id="email" name="email" value="{{old('email') ?? $user->email}}" placeholder="example@email.com">
                                <label for="email" style="margin-left: 10px">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="col mb-4">
                                <input type="hidden" id="changeP" name="changeP" value="{{(session('open') OR $errors->first('password') OR $errors->first('password_confirmation'))?'on':'off'}}">
                                <input type="checkbox" class="btn-check" id="btn-check" name="change-password" autocomplete="off" onclick="$('#change-password').toggle();document.getElementById('changeP').value='on';">
                                <label class="btn btn-primary" for="btn-check" href="#change-password" data-toggle="collapse">Change Password</label>
                            </div>
                            
                            <div id="change-password" class="collapse{{(session('open') OR $errors->first('password') OR $errors->first('password_confirmation'))?'-in':''}}">
                                <div class="form-floating col mb-4">
                                    <input type="password" class="form-control{{$errors->first('oldPassword')?' is-invalid':''}}" id="oldPassword" name="oldPassword" placeholder="Old Password">
                                    <label for="oldPassword" style="margin-left: 10px">Old Password</label>
                                    @error('oldPassword')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-floating col mb-4">
                                    <input type="password" class="form-control{{$errors->first('password')?' is-invalid':''}}" id="password" name="password" placeholder="New Password">
                                    <label for="password" style="margin-left: 10px">New Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-floating col mb-4">
                                    <input type="password" class="form-control{{$errors->first('password')?' is-invalid':''}}" id="password_confirmation" name="password_confirmation" placeholder="New Password">
                                    <label for="password_confirmation" style="margin-left: 10px">Confirm Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection