<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller{

    public function register(Request $request){
        $request->validate([
            'nombre' => ['required', 'string'],
            'usuario' => ['required', 'string', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,png,webp,jpeg'],
            ]
        );

        $nombre = $request->get('nombre');
        $usuario = $request->get('usuario');
        $email = $request->get('email');
        $password = $request->get('password');
        $avatar = $request->file('avatar');


        $user = new User();

        if($user){

            if(!is_null($avatar)){
            
                $avatar_nombre = time() ."_". $avatar->getClientOriginalName();
            
                //Guardamos en el Storage las imagenes
                \Storage::disk('avatar')->put($avatar_nombre, \File::get($avatar));

                $user->avatar = $avatar_nombre;
                
            }    

            $user->name = $nombre;
            $user->username = $usuario;
            $user->email = $email;
            $user->password = \Hash::make($password);
            $user->save();

            $user->assignRole('user');
    
            return back()->with('exito', 'Usuario creado.');
        }

        return back()->with('error', 'Error al crear el usuario.');


    }

}
