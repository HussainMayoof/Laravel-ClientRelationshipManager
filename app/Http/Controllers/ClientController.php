<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.index', ['clients' => Client::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Client::class)) {
            abort(403);
        }
            
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot('create', Client::class)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'company' => 'required',
            'zip' => 'required',
            'address' => 'required',
        ]);

        $incomingFields['company'] = strip_tags($incomingFields['company']);
        $incomingFields['zip'] = strip_tags($incomingFields['zip']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        Client::create($incomingFields);

        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', ['client' => $client, 'projects' => Project::where('client_id', $client->id)->where('is_open', 1)->paginate(5)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        if (auth()->user()->cannot('update', $client)) {
            abort(403);
        }

        return view('clients.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        if (auth()->user()->cannot('update', $client)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'company' => 'required',
            'zip' => 'required',
            'address' => 'required',
        ]);

        $incomingFields['company'] = strip_tags($incomingFields['company']);
        $incomingFields['zip'] = strip_tags($incomingFields['zip']);
        $incomingFields['address'] = strip_tags($incomingFields['address']);

        $client->update($incomingFields);

        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if (auth()->user()->cannot('delete', $client)) {
            abort(403);
        }

        $client->delete();

        return redirect('/clients');
    }

    public function search(Request $request) {
        $query = $request['query'];

        if ($query != "") {
            $clients = Client::where('company', 'LIKE', '%'.$query.'%')->orWhere('zip', 'LIKE', '%'.$query.'%')->orWhere('address', 'LIKE', '%'.$query.'%')->paginate(5)->setPath('');
            $clients->appends(['query' => $query]);

            if (count($clients) > 0){
                return view('clients.index', ['clients'=>$clients]);
            }
        }

        return redirect('clients')->withErrors(['search' => 'No search results found']);
    }
}
