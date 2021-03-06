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
use Illuminate\Support\Facades\Validator;

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

        return ['userList' =>  $users];
    }



    // add user
    public function addUser(Request $request)
    {
        // Validate format data request
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|string|unique:users,email',
            'status' => 'required'
        ]);
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
        //Validate format request
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|string',
            'status' => 'required'
        ]);
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



    // Return informations of User
    public function getAdminInfos()
    {
        return ['adminInfos' => Auth::user()];
    }



    // edit Admi infos
    public function EditAdminInfos($id, Request $request)
    {
        // validator request informations user
        $validator_user = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|string|email'
        ]);
        // validator request for password user
        $validator_user_password = Validator::make($request->all(), [
            'password' => 'required',
            'repeatPassword' => 'required|same:password'
        ]);
        if ($validator_user->fails()) {
            return response()->json(['done' => false]);
        }
        //Get id of User connection
        $user = User::find($id);
        if ($validator_user_password->fails()) {
            //update informations of user
            $user->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email')
            ]);
        } else {
            //update informations and password of user
            $user->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
        }
        return response()->json(['done' => true]);
    }
}
