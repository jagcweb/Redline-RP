<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use Illuminate\Http\Response;

class ForoController extends Controller{

    public function index()
    {

        $temas = Tema::orderBy('oculto', 'asc')->orderBy('nombre', 'asc')->get();

        return view('foro.home', [
            'temas' => $temas
        ]);
    }

    public function save(Request $request)
    {

        $request->validate([
            'nombre' => ['required', 'string'],
            'oculto' => ['nullable', 'alpha_num'],
            ]
        );

        $nombre = $request->get('nombre');
        $oculto = $request->get('oculto');
        
        $tema = new Tema();

        if($tema){
            $tema->nombre = $nombre;
            $tema->oculto = $oculto;
            $tema->save();

            return back()->with('exito', 'Tema creado');
        }

        return back()->with('error', 'Error al crear el Tema');
    }

    public function update($id, Request $request)
    {
        $id = \Crypt::decryptString($id);

        $request->validate([
            'nombre' => ['required', 'string'],
            'oculto' => ['nullable', 'alpha_num'],
            ]
        );

        $nombre = $request->get('nombre');
        $oculto = $request->get('oculto');
        
        $tema = Tema::find($id);

        if($tema){
            $tema->nombre = $nombre;
            $tema->oculto = $oculto;
            $tema->updated_at = \Carbon\Carbon::now();
            $tema->save();

            return back()->with('exito', 'Tema actualizado');
        }

        return back()->with('error', 'Error al crear el Tema');
    }

    public function getImage($filename) {
        $file = \Storage::disk('avatar')->get($filename);

        return new Response($file, 200);
    }

}
