<?php

namespace App\Http\Controllers;

use App\Pelicula;
use App\Combo;
use App\Promotion;
use Illuminate\Http\Request;

class ExtraRoutesController extends Controller
{
    public function promotion(){
        $promotions = Promotion::paginate(3);
        return $promotions;
    }

    public function peliculas(){
        $peliculas = Pelicula::paginate(3);
        return $peliculas;
    }

    public function combo(){
        $combos = Combo::paginate(3);
        return $combos;
    }
}
