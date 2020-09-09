<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //
    protected $fillable = ['day', 'fecha', 'num_funciones', 'hora', 'precio', 'pelicula_id', 'idioma'];

    public function pelicula(){
        return $this->belongsTo('App\Pelicula');
    }
}
