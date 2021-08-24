<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $currencies = Cryptocurrency::all()->toArray();
        return ['currencies'=>$currencies];

    }
}
