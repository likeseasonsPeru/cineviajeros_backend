<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $fillable = ['title','description','url_trailer', 'img', 'url_compra', 'actived'];
}
