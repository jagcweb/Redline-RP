<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notificaciones;

class CommentController extends Controller{

    public function save(Request $request){
        $request->validate([
            'post_id' => ['required', 'string'],
            'comment' => ['required']
            ]
        );

        $post_id = \Crypt::decryptString($request->get('post_id'));
        $comment = $request->get('comment');

        $comment_object = new Comment();

        if($comment_object){

            $comment_object->post_id = $post_id;
            $comment_object->user_id = \Auth::user()->id;
            $comment_object->comment = $comment;
            $comment_object->save();

            return back()->with('exito', 'Mensaje enviado.');
        }

        $post = Post::find($post_id);

        if($post && $comment->user_id != $post->user_id){
            $notificacion = new Notificacion();

            if($notificacion){
                $notificacion->user_id = $post->user_id;
                $notificacion->text = 'Un usuario ha comentado tu post';
                $notificacion->type = $post;
                $notificacion->type_id = $post->id;
                $notificacion->save();
            }

        }

        return back()->with('error', 'Error al enviar el mensaje.');


    }

    public function update(Request $request){
        $request->validate([
            'comment_id' => ['required', 'string'],
            'comment' => ['required']
            ]
        );

        $comment_id = \Crypt::decryptString($request->get('comment_id'));
        $comment = $request->get('comment');

        $comment_object = Comment::find($comment_id);

        if($comment_object){

            $comment_object->comment = $comment;
            $comment_object->updated_at = \Carbon\Carbon::now();
            $comment_object->update();

            return back()->with('exito', 'Mensaje editado.');
        }

        if($comment_object->user_id != \Auth::user()->id){
            $notificacion = new Notificacion();

            if($notificacion){
                $notificacion->user_id = $comment_object->user_id;
                $notificacion->text = 'Tu comentario ha sido editado';
                $notificacion->save();
            }

        }

        return back()->with('error', 'Error al editar el mensaje.');
    }


    public function delete(Request $request){
        $request->validate([
            'comment_id' => ['required', 'string']
            ]
        );

        $comment_id = \Crypt::decryptString($request->get('comment_id'));

        $comment_object = Comment::find($comment_id);

        if($comment_object){

            if($comment_object->user_id != \Auth::user()->id){
                $notificacion = new Notificacion();
    
                if($notificacion){
                    $notificacion->user_id = $comment_object->user_id;
                    $notificacion->text = 'Tu comentario ha sido borrado';
                    $notificacion->save();
                }
    
            }

            $comment_object->delete();

            return back()->with('exito', 'Mensaje borrado.');
        }

        return back()->with('error', 'Error al borrar el mensaje.');
    }

}
