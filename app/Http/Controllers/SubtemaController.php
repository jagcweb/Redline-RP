<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtema;
use App\Models\Post;
use App\Models\Tema;

class SubtemaController extends Controller{

    public function index($tema, $subtema)
    {
        $subt = Subtema::where('nombre', $subtema)
        ->whereHas(
            'tema', function($q) use($tema){
                $q->where('nombre', $tema);
            }
        )->first();

        $temas = Tema::orderBy('nombre', 'asc')->get();

        $posts = Post::where('subtema_id', $subt->id)->orderBy('updated_at', 'desc')->get();

        return view('subtema.home', [
            'posts' => $posts,
            'subt' => $subt,
            'temas' => $temas
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

    public function update(Request $request){
        
        $request->validate([
            'nombre' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'tema_id' => ['required', 'alpha_num'],
            'own_post' => ['nullable', 'alpha_num'],
            'id' => ['required', 'string']
            ]
        );

        $id = \Crypt::decryptString($request->get('id'));

        $nombre = $request->get('nombre');
        $desc = $request->get('desc');
        $tema_id = $request->get('tema_id');
        $own_post = $request->get('own_post');

        $subtema = Subtema::find($id);

        if($subtema){
            $subtema->nombre = $nombre;
            $subtema->descr = $desc;
            $subtema->tema_id = $tema_id;
            $subtema->post_propio = $own_post;
            $subtema->updated_at = \Carbon\Carbon::now();
            $subtema->update();

            return redirect()->route('subtema.index', ['tema' => $subtema->tema->nombre, 'subtema' => $subtema->nombre])->with('exito', 'Subtema editado');
        }

        return back()->with('error', 'Error al editado el Subtema');

    }
}
