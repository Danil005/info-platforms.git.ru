<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function profile($id =null)
    {
        $user = DB::table('users')->where('access_id', $id)
            ->first();
        return view('profile')->with('user', $user);
    }
}
