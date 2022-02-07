<?php

  

namespace App\Http\Controllers;

  

use Illuminate\Http\Request;

use App\Models\User;

  

class UserController extends Controller{
    public function get($username){
        $user = User::where('username', $username)->first();

        return view('user.home', [
            'user' => $user
        ]);
    }
}