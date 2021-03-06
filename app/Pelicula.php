<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    //
    protected $fillable = ['title', 'translate','description', 'duration', 'img', 'precio_min', 'comision', 'url_trailer', 'url_compra', 'type_public', 'category', 'order'];

    public function horario(){
        return $this->hasMany('App\Horario');
    }
}
