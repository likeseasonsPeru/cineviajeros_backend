<?php

namespace App\Http\Controllers;

use App\Pelicula as Pelicula;
use App\Combo as Combo;
use App\Horario;
use App\Promotion as Promotion;
use App\Banner as Banner;
use Illuminate\Http\Request;

class ExtraRoutesController extends Controller
{
    public function promotion()
    {
        $promotions = Promotion::paginate(4);
        return $promotions;
    }

    public function peliculas()
    {
        $peliculas = Pelicula::where('category', '!=', 'inactive')->with('horario')->paginate(3);
        return $peliculas;
    }

    public function allpeliculas()
    {
        $peliculas = Pelicula::with('horario')->orderBy('order', 'DESC')->get();
        return $peliculas;
    }

    public function combo()
    {
        $combos = Combo::paginate(4);
        return $combos;
    }

    public function horariosByPelicula($id)
    {
        $horarios = Horario::where('pelicula_id', $id)->get();
        return $horarios;
    }

    public function peliculasByCategoria($category)
    {
        $peliculas = Pelicula::where('category', $category)->get();
        return $peliculas;
    }

    public function peliculasByFilter(Request $request)
    {
        $data = $request->json()->all();
        
        $category = null;
        $horario = null;
        $idioma = null;

        $category = $data['category'];
        $horario = $data['horario'];
        $idioma = $data['idioma'];
        if ($category === 'hoy') {
            $peliculas = Pelicula::where('category', '!=', 'inactive')->with(["horario" => function($h) use($idioma , $horario) {
                $h->where('horarios.idioma', $idioma);
                $h->where('horarios.fecha', $horario);
            }]);
        } else {
            $peliculas = Pelicula::where('category', $category)->whereHas("horario", function($h) use($idioma , $horario) {
                $h->where('horarios.idioma', $idioma);
                $h->where('horarios.fecha', $horario);
            });;
        }

        return $peliculas->paginate(3);
    }

    // Ordenar

    public function sortUpdatePeliculas(Request $request, $table)
    {
        $data = $request->json()->all();

        switch ($table) {
            case 'banners':
                $Class = new Banner;
                break;
            case 'peliculas':
                $Class = new Pelicula;
                break;
            case 'combos':
                $Class = new Combo;
                break;
            case 'promotions':
                $Class = new Promotion;
                break;
            default:
                return response()->json(['status' => 'error', 'msg' => 'No hay una opcion valida']);
        }

        foreach ($data as $d) {
            $Class::where('id', $d['id'])
                ->update(['order' => $d['order']]);
        }
        return response()->json(['status' => 'ok']);
    }

    public function orderTable($table)
    {
        switch ($table) {
            case 'banners':
                $datos = Banner::all();
                break;
            case 'peliculas':
                $datos = Pelicula::all();
                break;
            case 'combos':
                $datos = Combo::all();
                break;
            case 'promotions':
                $datos = Promotion::all();
                break;
            default:
                return response()->json(['status' => 'error', 'msg' => 'No hay una opcion valida']);
        }

        for ($i = 0; $i < count($datos); $i++) {
            $datos[$i]->order = $i + 1;
            $datos[$i]->save();
        }

        return response()->json(['status' => 'ok', 'data' => $datos]);
    }
}
