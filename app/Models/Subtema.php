<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Subtema extends Model
{
    protected $table = 'subtemas';
    protected $fillable = ['nombre', 'descr', 'tema_id'];

    public function tema(){
        return $this->belongsTo(Tema::class);
    }
}
