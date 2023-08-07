@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    Before proceeding, please check your email, <strong>{{auth()->user()->email}}</strong> for a verification link.
                    If you did not receive the email,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
                    </form>
                    <form action="/email/changeEmail" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-floating col mb-2 mt-4">
                            <input type="email" class="form-control{{$errors->first('email')?' is-invalid':''}}" id="email" name="email" value="{{old('email')}}" placeholder="Email">
                            <label for="email" style="margin-left: 10px">Change Email</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Change Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
