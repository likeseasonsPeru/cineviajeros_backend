<?php

namespace App\Http\Controllers;

use App\Pelicula;
use App\Combo;
use App\Horario;
use App\Promotion;
use Illuminate\Http\Request;

class ExtraRoutesController extends Controller
{
    public function promotion(){
        $promotions = Promotion::paginate(3);
        return $promotions;
    }

    public function peliculas(){
        $peliculas = Pelicula::where('category', '!=', 'inactive')->with('horario')->paginate(3);
        return $peliculas;
    }

    public function combo(){
        $combos = Combo::paginate(3);
        return $combos;
    }

    public function horariosByPelicula($id){
        $horarios = Horario::where('pelicula_id', $id)->get();
        return $horarios;
    }

    public function peliculasByCategoria($category){
        $peliculas = Pelicula::where('category', $category)->get();
        return $peliculas;
    }
}
