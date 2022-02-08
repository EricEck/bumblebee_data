<?php

namespace App\Http\Controllers;

use App\Models\Bumblebee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BumblebeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Bumblebee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|unique:bumblebees',
            'manufactured_date' => 'date|nullable',
            'current_version' => 'string|nullable',
            'manufacturer_id' => 'integer|nullable',
            'owner_id' => 'integer|nullable',
            'install_id' => 'integer|nullable',
            'assigned_to_owner_on' => 'date|nullable',
            'removed_from_service' => 'boolean',
            'api_password' => 'string|nullable',
            'remember_token' => 'string|nullable'
        ]);

        $request['api_password'] = Hash::make($request['api_password']);
        $request['remember_token'] = Str::uuid();

        return response(Bumblebee::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return Measurement::find($id);
        return response(Bumblebee::find($id),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $bumblebee = Bumblebee::find($id);

        // hash a new password or keep the old one
        if (strlen($request['api_password']) === 0){
            $request['api_password'] = $bumblebee['api_password'];
        } else {
            $request['api_password'] = Hash::make($request['api_password']);
        }

        $bumblebee->update($request->all());

        return response($bumblebee, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Bumblebee::destroy($id), 200);
    }

    /**
     * Find all when the bumblebee id matches
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        return response(Bumblebee::where('id', $id)->get(), 200);
    }

}
