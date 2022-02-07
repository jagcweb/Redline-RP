<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtema;
use App\Models\Post;

class SubtemaController extends Controller{

    public function index($tema, $subtema)
    {
        $subt = Subtema::where('nombre', $subtema)
        ->whereHas(
            'tema', function($q) use($tema){
                $q->where('nombre', $tema);
            }
        )->first();

        $posts = Post::where('subtema_id', $subt->id)->orderBy('updated_at', 'desc')->get();

        return view('subtema.home', [
            'posts' => $posts,
            'subt' => $subt
        ]);
    }

    public function save(Request $request){
        $request->validate([
            'nombre' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'tema_id' => ['required', 'alpha_num'],
            'own_post' => ['nullable', 'alpha_num'],
            ]
        );

        $nombre = $request->get('nombre');
        $desc = $request->get('desc');
        $tema_id = $request->get('tema_id');
        $own_post = $request->get('own_post');

        $subtema = new Subtema();

        if($subtema){
            $subtema->nombre = $nombre;
            $subtema->descr = $desc;
            $subtema->tema_id = $tema_id;
            $subtema->post_propio = $own_post;
            $subtema->save();

            return back()->with('exito', 'Subtema creado');
        }

        return back()->with('error', 'Error al crear el Subtema');

    }
}
