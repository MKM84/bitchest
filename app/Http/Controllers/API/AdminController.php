<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use App\Models\User;
use Illuminate\Http\Request;

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
}
