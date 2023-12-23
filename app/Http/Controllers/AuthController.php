<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request ->validate([
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        $user = User::create([
            'name'=> $fields['name'],
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);
        $token = $user ->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token'=>$token
        ];
        return response($response ,201);
    }

    public function registerClient(Request $request){
        $fields = $request ->validate([
            'firstName'=>'required|string',
            'lastName'=>'required|string',
            'phone'=>'required|string',
            'adresse'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string'
        ]);
        $client = Client::create([
            'firstName'=> $fields['firstName'],
            'lastName'=> $fields['lastName'],
            'phone'=> $fields['phone'],
            'adresse'=> $fields['adresse'], 
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);
        $token = $client ->createToken('myapptoken')->plainTextToken;
        $response = [
            'client' => $client,
            'token'=>$token
        ];
        return response($response ,201);
    }

    public function loginClient(Request $request){
        $fields = $request ->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        $client=Client::where('email',$fields['email'])->first();
        if (!$client || !Hash::check($fields['password'],$client->password)){
            return response([
                'message' => 'Bad creds'
            ],401);
        }
        $token = $client ->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $client,
            'token'=>$token
        ];
        return response($response ,201);
    }

    public function login(Request $request){
        $fields = $request ->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        $user=User::where('email',$fields['email'])->first();
        if (!$user || !Hash::check($fields['password'],$user->password)){
            return response([
                'message' => 'Bad creds'
            ],401);
        }
        $token = $user ->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token'=>$token
        ];
        return response($response ,201);
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return[
            'message'=>'logged out'
        ];
    }
}
