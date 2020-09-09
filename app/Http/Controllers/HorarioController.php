<?php

namespace App\Http\Controllers;

use App\Horario;
use App\Pelicula;
use Exception;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $horario = Horario::all();
        return $horario;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!$request->input('day') || !$request->input('fecha') || !$request->input('num_funciones') || !$request->input('hora') || !$request->input('precio') || !$request->input('pelicula_id') || !$request->input('pelicula_id') || !$request->input('idioma')) {
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        $pelicula = Pelicula::find($request->input('pelicula_id'));
        if (!$pelicula) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe pelicula con este id']);
        }

        $horario = Horario::create($request->all());
        return response()->json(['status' => 'ok', 'data' => $horario]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $horario = Horario::find($id);
        if (!$horario) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe horario con este id']);
        }
        return response()->json(['status' => 'ok', 'data' => $horario]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe horario con este id']);
        }

        $day = $request->input('day');
        $fecha = $request->input('fecha');
        $num_funciones = $request->input('num_funciones');
        $hora = $request->input('hora');
        $precio = $request->input('precio');
        $pelicula_id = $request->input('pelicula_id');
        $idioma = $request->input('idioma');


        $pelicula = Pelicula::find($pelicula_id);
        if ($pelicula_id && !$pelicula) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe pelicula con este id']);
        }


        $bandera = false;

        if ($day !== null && $day !== '') {
            $horario->day = $day;
            $bandera = true;
        }
        if ($fecha !== null && $fecha !== '') {
            $horario->fecha = $fecha;
            $bandera = true;
        }
        if ($num_funciones !== null && $num_funciones !== '') {
            $horario->num_funciones = $num_funciones;
            $bandera = true;
        }
        if ($hora !== null && $hora !== '') {
            $horario->hora = $hora;
            $bandera = true;
        }
        if ($precio !== null && $precio !== '') {
            $horario->precio = $precio;
            $bandera = true;
        }
        if ($pelicula_id !== null && $pelicula_id !== '') {
            $horario->pelicula_id = $pelicula_id;
            $bandera = true;
        }
        if ($idioma !== null && $idioma !== '') {
            $horario->idioma = $idioma;
            $bandera = true;
        }


        if ($bandera) {
            try {
                $horario->save();
                return response()->json(['status' => 'ok', 'data' => $horario]);
            } catch (Exception $e) {
                return response()->json(['status' => 'failed', 'msg' => 'Ya hay un horario asigando a esta pelicula']);
            }
        }

        return response()->json(['status' => 'failed', 'msg' => 'No se ha podido modificado el horario']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $horario = Horario::find($id);
        if (!$horario) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe horario con este id']);
        }
        $horario->delete();
        return response()->json(['status' => 'ok', 'msg' => 'Se ha eliminado correctamente']);
    }
}
