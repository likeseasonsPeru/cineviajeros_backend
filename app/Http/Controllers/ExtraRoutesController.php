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


        $category = $data['category'];
        if ($category === 'hoy') {
            $date = $this->formatFecha(date("Y-m-d"));
            $peliculas = Pelicula::where('category', 'inactive')->whereHas("horario", function($h) use($date) {
                $h->where('horarios.fecha', $date);
            });
        } else {
            $peliculas = Pelicula::where('category', $category)->with("horario");
        }

        return $peliculas->paginate(3);
       /*  return $this->formatFecha($date); */
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

    function formatFecha($date)
    {
        $dateExplode = explode("-", $date);
        $dateFormated = $dateExplode[2] . "/" . $dateExplode[1] . "/" . $dateExplode[0];
        return $dateFormated;
    }
}


