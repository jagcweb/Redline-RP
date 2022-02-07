<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Tema extends Model
{
    protected $table = 'temas';
    protected $fillable = ['nombre'];

    public function subtemas()
    {
        return $this->hasMany(Subtema::class);
    }
}
