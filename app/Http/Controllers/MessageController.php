<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){
        $request->validate([
            'receptor_id' => ['required', 'string'],
            'asunto' => ['required', 'string'],
            'mensaje' => ['required', 'string'],
            ]
        );

        $receptor_id = \Crypt::decryptString($request->get('receptor_id'));
        $asunto = $request->get('asunto');
        $mensaje = $request->get('mensaje');

        $message = new Message();

        if($message){

            $message->receptor_id = $receptor_id;
            $message->user_id = \Auth::user()->id;
            $message->asunto = $asunto;
            $message->mensaje = $mensaje;
            $message->save();

            $notificacion = new Notificacion();

            if($notificacion){
                $notificacion->user_id = $receptor_id;
                $notificacion->text = 'Un usuario te ha enviado un mensaje';
                $notificacion->type = $post;
                $notificacion->type_id = $message->id;
                $notificacion->save();
            }

            return back()->with('exito', 'Mensaje enviado!');
        }

        return back()->with('error', 'Error al enviar el mensaje.');


    }

    public function get(){

        $messages = Message::where('receptor_id', \Auth::user()->id)->orderBy('id', 'desc')->get();

        $messages_sended = Message::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();


        return view('message.home', [
            'messages' => $messages,
            'messages_sended' => $messages_sended
        ]);


    }

    public function getMessage($id){

        $id = \Crypt::decryptString($id);

        $message = Message::find($id);

        if($message->receptor_id == \Auth::user()->id){
            $message->leido = 1;
            $message->update();
        }


        return view('message.detail', [
            'message' => $message,
        ]);


    }

}
