<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    //
    protected $fillable = ['title', 'description', 'duration', 'img', 'precio_min', 'comision', 'url_trailer', 'url_compra', 'type_public', 'category'];

    public function horario(){
        return $this->hasOne('App/Horario');
    }
}
