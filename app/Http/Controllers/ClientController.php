<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Models\ClientInterest;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = ClientInterest::with('client:id,first_name,last_name,birthday,contact_no','interest:id,name')->get();
        return $clients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $validatedData = $request->validated();

        $client = ClientInterest::create([
            'user_id' => $validatedData['user_id'],
            'interest_id' => $validatedData['interest_id'],
        ]);

        return response()->json($client, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        $validatedData = $request->validated();

        try {
            $client = ClientInterest::findOrFail($id);

            $client->update([
                'user_id' => $validatedData['user_id'],
                'interest_id' => $validatedData['interest_id'],
            ]);

            return response()->json($client, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating client.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_clients(Request $req)
    {
        $users = User::select('id', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"))->get();
        return ($users);
    }
    public function get_interests(Request $req)
    {
        $interests = Interest::select('id', 'name')->get();
        return ($interests);
    }
}
