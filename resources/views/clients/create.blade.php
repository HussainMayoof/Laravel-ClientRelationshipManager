@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">New Client</h2>
                        <form action="/clients" method="post">
                            @csrf
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('company')?' is-invalid':''}}" id="company" name="company" value="{{old('company')}}" placeholder="name@example.com">
                                <label for="company" style="margin-left: 10px">Company Name</label>
                                @error('company')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('zip')?' is-invalid':''}}" id="zip" name="zip" value="{{old('zip')}}" placeholder="12345">
                                <label for="zip" style="margin-left: 10px">ZIP Code</label>
                                @error('zip')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating col mb-4">
                                <input type="text" class="form-control{{$errors->first('address')?' is-invalid':''}}" id="address" name="address" value="{{old('address')}}" placeholder="123 Street 0">
                                <label for="address" style="margin-left: 10px">Address</label>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Save Client</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection