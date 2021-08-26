<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $currencies = Cryptocurrency::all()->toArray();

        return ['currencies' => $currencies];

    }
    public function users()
    {
        $users = User::all()->toArray();

        return ['userList' => $users];
    }

    public function addUser(Request $request)
    {
        $user = new User([
            'lastname' => $request->input('lastname'),
            'firstname' => $request->input('firstname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'status' => $request->input('status'),
            'user_solde' => 89588.00,
        ]);
        $user->save();

        return response()->json([
            'done'=>true
        ]);

        throw ValidationException::withMessages([
            'lastname' => ['lastname incorrecte.'],
            'firstname' => ['lastname incorrecte.'],
            'email' => ['email incorrecte.'],
            'password' => ['Mot de passe incorrecte.'],
            'status' => ['status incorrecte.'],
            'user_solde' => ['user_solde incorrecte.'],

        ]);
    }
}
