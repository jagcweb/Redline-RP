<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['user_id', 'receptor_id', ' asunto', ' mensaje', 'leido'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function receptor(){
        return $this->belongsTo('App\Models\User', 'receptor_id', 'id');
    }
}
