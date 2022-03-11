<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Subtema;


class PostController extends Controller{

    public function save(Request $request){
        $request->validate([
            'subtema_id' => ['required', 'string'],
            'titulo' => ['required', 'string'],
            'desc' => ['required'],
            'block' => ['nullable', 'alpha_num'],
            'own_reply' => ['nullable', 'alpha_num'],
            'hidden' => ['nullable', 'alpha_num'],
            ]
        );

        $subtema_id = \Crypt::decryptString($request->get('subtema_id'));
        $titulo = $request->get('titulo');
        $desc = $request->get('desc');
        $block = $request->get('block');
        $own_reply = $request->get('own_reply');
        $hidden = $request->get('hidden');

        $post = new Post();

        if($post){

            $post->subtema_id = $subtema_id;
            $post->user_id = \Auth::user()->id;
            $post->titulo = $titulo;
            $post->descr = $desc;
            $post->bloqueado = $block;
            $post->respuesta_propia = $own_reply;
            $post->oculto = $hidden;
            $post->save();

            return back()->with('exito', 'Post creado.');
        }

        return back()->with('error', 'Error al crear el post.');


    }

    public function get($tema, $subtema, $id){

        $post = Post::find($id);

        $comments = Comment::where('post_id', $post->id)->orderBy('id', 'asc')->get();

        $subtemas = Subtema::orderBy('nombre', 'asc')->get();


        return view('post.home', [
            'post' => $post,
            'comments' => $comments,
            'subtemas' => $subtemas,
        ]);


    }

    public function update($id, Request $request){

        $id = \Crypt::decryptString($id);

        $post = Post::find($id);

        $request->validate([
            'titulo' => ['required', 'string'],
            'desc' => ['required'],
            'block' => ['nullable', 'alpha_num'],
            'own_reply' => ['nullable', 'alpha_num'],
            'hidden' => ['nullable', 'alpha_num'],
            ]
        );

        $titulo = $request->get('titulo');
        $desc = $request->get('desc');
        $block = $request->get('block');
        $own_reply = $request->get('own_reply');
        $hidden = $request->get('hidden');

        if($post){
            $post->titulo = $titulo;
            $post->descr = $desc;
            $post->bloqueado = $block;
            $post->respuesta_propia = $own_reply;
            $post->oculto = $hidden;
            $post->update();

            return back()->with('exito', 'Post actualizado.');
        }

        return back()->with('error', 'Error al actualizar el post.');
    }

    public function delete(Request $request){

        $request->validate([
            'post_id' => ['required', 'string'],
            ]
        );

        $id = \Crypt::decryptString($request->get('post_id'));

        $post = Post::find($id);

        if($post){
            $tema = $post->subtema->tema->nombre;
            $subtema = $post->subtema->nombre;
            if(count($post->comments)>0){
                Comment::where('post_id', $post->id)->delete();
            }
            $post->delete();

            return redirect()->route('subtema.index', ['tema' => $tema, 'subtema' => $subtema])->with('exito', 'Post borrado.');
        }

        return back()->with('error', 'Error al borrar el post.');
    }

    public function close(Request $request){

        $request->validate([
            'post_id' => ['required', 'string'],
            ]
        );

        $id = \Crypt::decryptString($request->get('post_id'));

        $post = Post::find($id);

        if($post){
            $post->cerrado = 1;
            $post->updated_at = \Carbon\Carbon::now();
            $post->update();

            return back()->with('exito', 'Post cerrado.');
        }

        return back()->with('error', 'Error al cerrar el post.');
    }

    public function move(Request $request){
        $request->validate([
            'subtema_id' => ['required', 'alpha_num'],
            'post_id' => ['required', 'alpha_num']
            ]
        );

        $subtema_id = $request->get('subtema_id');
        $id = $request->get('post_id');

        $post = Post::find($id);

        if($post){

            $post->subtema_id = $subtema_id;
            $post->update();

            return redirect()->route('subtema.index', ['tema' => $post->subtema->tema->nombre, 'subtema' => $post->subtema->nombre  ])->with('exito', 'Post movido. Se te ha redireccionado al subtema que ahora contiene este post.');
        }

        return back()->with('error', 'Error al mover el post.');


    }

}
