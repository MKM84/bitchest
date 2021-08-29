<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cryptocurrency;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $userSold;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
        $this->middleware(function ($request, $next) {
            $this->userSold = Auth::user()->user_solde;
            return $next($request);
        });
    }

    // Get Cryptos
    public function index()
    {
        $currencies = Cryptocurrency::all()->toArray();

        return ['currencies' => $currencies, 'userSolde' => $this->userSold];
    }
}
