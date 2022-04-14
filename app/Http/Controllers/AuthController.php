<?php

namespace App\Http\Controllers;

use App\Models\Bumblebee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function logout(Request $request){
//        auth()->user()->tokens()->
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logged Out'
        ], 200);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'remember_token' => 'required|string',
            'api_password' => 'required|string'
        ]);

        // Check Key
        $bumblebee = Bumblebee::where('remember_token', $fields['remember_token'])->first();

        if (!$bumblebee || !Hash::check($fields['api_password'], $bumblebee->api_password)){
            return response([
                'message' => 'bad credentials'
            ], 401);
        }

        $token = $bumblebee->createToken($bumblebee->serial_number.'_api')->plainTextToken;

        $bow_id = $bumblebee->ellipticProduct->bowComponent->bodyOfWater->id;
        $response = [
            'bumblebee' => $bumblebee,
            'bodies_of_water_id' => $bow_id,
            'application' => config('app.name'),
            'data_model' => 'bumblebee',
            'api_version' => config('app.api_version'),
            'token' => $token,
        ];

        return response($response, 200);

    }


    public function register(Request $request)
    {
        $fields = $request->validate([
            'serial_number' => 'required|string|match:bumblebees,serial_number',
            'remember_token' => 'required|string|match:bumblebees,remember_token',
            'api_password' => 'required|string'
        ]);

        $bumblebee = Bumblebee::create([
            'serial_number' => $fields['serial_number'],
            'remember_token' => $fields['remember_token'],
            'api_password' => bcrypt($fields['api_password'])
        ]);

        $token = $bumblebee->createToken($fields['serial_number'].'_api')->plainTextToken;

        $response = [
            'bumblebee' => $bumblebee,
            'token' => $token
        ];

        return response($response, 200);

    }
}
