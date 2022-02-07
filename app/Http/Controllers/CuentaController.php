<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CuentaController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('cuenta.home');
    }

    public function config(){

        return view('cuenta.config');
    }

    public function update(Request $request){

        $request->validate([
            'nombre' => ['required', 'string'],
            'usuario' => ['required', 'string', 'unique:users,username,'.\Auth::user()->id],
            'email' => ['required', 'email', 'unique:users,email,'.\Auth::user()->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,png,webp,jpeg'],
            ]
        );

        
        $nombre = $request->get('nombre');
        $usuario = $request->get('usuario');
        $email = $request->get('email');
        $avatar = $request->file('avatar');


        $user = \Auth::user();

        if($user){

            if(!is_null($avatar)){

                if(!is_null(\Auth::user()->avatar)){
                    \Storage::disk('avatar')->delete(\Auth::user()->avatar);
                }
            
                $avatar_nombre = time() ."_". $avatar->getClientOriginalName();
            
                //Guardamos en el Storage las imagenes
                \Storage::disk('avatar')->put($avatar_nombre, \File::get($avatar));

                $user->avatar = $avatar_nombre;
                
            }    

            $user->name = $nombre;
            $user->username = $usuario;
            $user->email = $email;
            $user->updated_at = \Carbon\Carbon::now();
            $user->update();
    
            return back()->with('exito', 'Configuración cambiada!');
        }

        return back()->with('error', 'Error al modificar el usuario.');

    }

    public function changePassword(Request $request){

        $request->validate([
            'actual_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'confirmed', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            ]
        );

        $actual_password = $request->get('actual_password');
        $password = $request->get('password');
        $confirm_password = $request->get('confirm_password');

        $user = \Auth::user();

        if($user){
            
            if(!\Hash::check($actual_password, $user->password)){
                return back()->with('error', 'La contraseña actual introducida es incorrecta.');
            }

            if(\Hash::check($password, $user->password)){
                return back()->with('error', 'La nueva contraseña no puede ser idéntica a la actual.');
            }

            $user->password = \Hash::make($password);
            $user->updated_at = \Carbon\Carbon::now();
            $user->update();
    
            return back()->with('exito', 'Contraseña cambiada!');
        }

        return back()->with('error', 'Error al modificar la contraseña.');

    }

}
