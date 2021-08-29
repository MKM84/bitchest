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

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    // Get Cryptos
    public function index()
    {
        $currencies = Cryptocurrency::all()->toArray();

        return ['currencies' => $currencies];
    }

    // Get all users
    public function users()
    {
        $users = array_reverse(User::all()->toArray());

        return ['userList' => $users];
    }

    // add user
    public function addUser(Request $request)
    {
        $user = new User([
            'lastname' => $request->input('lastname'),
            'firstname' => $request->input('firstname'),
            'email' => $request->input('email'),
            'password' => Hash::make('password'),
            'status' => $request->input('status'),
            'user_solde' => 89588.00,
        ]);
        $user->save();

        return response()->json([
            'done' => true,
            'id' => $user->id
        ]);
    }

    // edit user
    public function editUser($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json(['done' => true]);
    }

    // delete user
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['done' => true]);
    }
}
