<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use App\Models\Progression;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    // Get all users
    public function users()
    {
        //get all users (client and admin)
        $connectedUser = Auth::user();
        $users = array_reverse(User::all()->where('id', '!=', $connectedUser->id)->toArray());

        return ['userList' =>  $users ];

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
            'user_solde' => 0,
        ]);
        // Add user to database
        $user->save();

        return response()->json([
            'done' => true,
            'id' => $user->id
        ]);
    }
    // Edit user
    public function editUser($id, Request $request)
    {
        // Get one user by $id
        $user = User::find($id);
        //Update user to database
        $user->update($request->all());
        return response()->json(['done' => true]);
    }
    // Delete user
    public function deleteUser($id)
    {
        // Get one user by $id
        $user = User::find($id);
        //Delete user to database
        $user->delete();
        return response()->json(['done' => true]);
    }
}
