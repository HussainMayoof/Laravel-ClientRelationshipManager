@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-2"><a href="/users" style="all: unset !important;">Users</a></h2>

                    @if ($users->isEmpty())
                        <p>No users</p>
                    @else
                    <table class="table table-striped table-hover">

                        <div class="container mb-2">
                            <form action="/users/search" method="get" role="search">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="query"
                                        placeholder="Search users"> <span class="input-group-btn">
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number of Projects</th>
                                <th>Number of Tasks</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr onclick="window.location.href = '/users/{{$user->id}}';">
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->projects()->count()}}</td>
                                    <td>{{$user->tasks->count()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection