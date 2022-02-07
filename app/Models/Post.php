<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['subtema_id', 'titulo', 'descr', 'user_id', 'bloqueado', 'cerrado', 'edited_by'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subtema(){
        return $this->belongsTo(Subtema::class);
    }

    public function editedby(){
        return $this->belongsTo('App\Models\User', 'edited_by', 'id');
    }
}
