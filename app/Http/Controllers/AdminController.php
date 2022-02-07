<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller{

    public function getUserAjax($type, $value){

        if($type == "email"){
            $user = User::where('email', $value)->with('roles')->first();
        }

        if($type == "username"){
            $user = User::where('username', $value)->with('roles')->first();
        }

        
        if($user){
            $status = 200;
            return response(json_encode($user), $status)->header('Content-type', 'text/plain');
        }else{
            $status = 404;
            return response($status);
        }
    }

    public function ban($id){

        $user = User::find($id);

        if($user){
            $user->banned = 1;
            $user->update();
        }

    }

    public function unban($id){

        $user = User::find($id);

        if($user){
            $user->banned = null;
            $user->update();
        }

    }

    public function makeUser($id){

        $user = User::find($id);

        if($user){
            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole('user');
        }

    }

    public function makeMod($id){

        $user = User::find($id);

        if($user){
            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole('mod');
        }

    }

    public function makeAdmin($id){

        $user = User::find($id);

        if($user){
            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole('admin');
        }

    }

}
