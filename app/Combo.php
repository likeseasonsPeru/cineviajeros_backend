<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    //
    protected $fillable = ['title', 'img', 'description', 'precio', 'comision', 'legal', 'order'];
}
