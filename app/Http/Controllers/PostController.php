<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller{

    public function save(Request $request){
        $request->validate([
            'subtema_id' => ['required', 'string'],
            'titulo' => ['required', 'string'],
            'desc' => ['required'],
            'block' => ['nullable', 'alpha_num'],
            'own_reply' => ['nullable', 'alpha_num'],
            ]
        );

        $subtema_id = \Crypt::decryptString($request->get('subtema_id'));
        $titulo = $request->get('titulo');
        $desc = $request->get('desc');
        $block = $request->get('block');
        $own_reply = $request->get('own_reply');

        $post = new Post();

        if($post){

            $post->subtema_id = $subtema_id;
            $post->user_id = \Auth::user()->id;
            $post->titulo = $titulo;
            $post->descr = $desc;
            $post->bloqueado = $block;
            $post->respuesta_propia = $own_reply;
            $post->save();

            return back()->with('exito', 'Post creado.');
        }

        return back()->with('error', 'Error al crear el post.');


    }

    public function get($tema, $subtema, $id){

        $post = Post::find($id);

        if(!\Auth::user() && $post->subtema->post_propio || \Auth::user()->id != $post->user_id && $post->subtema->post_propio && \Auth::user()->getRoleNames()[0] != "admin" && \Auth::user()->getRoleNames()[0] != "mod"){
            return back();
        }

        $comments = Comment::where('post_id', $post->id)->orderBy('id', 'asc')->get();


        return view('post.home', [
            'post' => $post,
            'comments' => $comments
        ]);


    }

    public function update($id, Request $request){

        $id = \Crypt::decryptString($id);

        $post = Post::find($id);

        $request->validate([
            'titulo' => ['required', 'string'],
            'desc' => ['required'],
            ]
        );

        $titulo = $request->get('titulo');
        $desc = $request->get('desc');

        if($post){
            $post->titulo = $titulo;
            $post->descr = $desc;
            $post->edited_by = \Auth::user()->id;
            $post->updated_at = \Carbon\Carbon::now();
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
            $post->comments->delete();
            //$post->delete();

            return back()->with('exito', 'Post borrado.');
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

}
