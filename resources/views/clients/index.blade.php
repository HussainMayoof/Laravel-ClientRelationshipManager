@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title"><a href="/clients" style="all: unset !important;">Clients</a></h2>
                    @if (auth()->user()->is_admin)
                        <a class="btn btn-success mb-4" href="/clients/create">New Client</a>
                    @endif
                    @if ($clients->isEmpty())
                        <p>No clients</p>
                    @else
                    <table class="table table-striped table-hover">

                        <div class="container mb-2">
                            <form action="/clients/search" method="get" role="search">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="query"
                                        placeholder="Search clients"> <span class="input-group-btn">
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
                                <th>Company</th>
                                <th>ZIP Code</th>
                                <th>Address</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($clients as $client)
                                <tr onclick="window.location.href = 'clients/{{$client->id}}';">
                                    <td>{{$client->company}}</td>
                                    <td>{{$client->zip}}</td>
                                    <td>{{$client->address}}</td>
                                    @if (auth()->user()->is_admin)
                                        <td>
                                            <a class="btn btn-primary" href="/clients/{{$client->id}}/edit">Edit</a>
                                            <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$client->id}}').submit();">Delete</a>
                                            <form id="delete-form-{{$client->id}}" method="post" action="/clients/{{$client->id}}">
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
                        {{ $clients->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection