<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $user = User::All();
        return view('pages.homepage');
    }
}
