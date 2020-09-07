<?php

namespace App\Http\Controllers;

use App\Pelicula;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $peliculas = Pelicula::all();
        return $peliculas;
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

        if (!$request->input('title') || !$request->input('description') || !$request->input('duration') 
            || !$request->input('img') || !$request->input('precio_min') || !$request->input('url_trailer') 
            || !$request->input('url_compra') || !$request->input('type_public') || !$request->input('category'))
		{
			// NO estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['status'=>'failed','msg'=>'Faltan datos necesarios para la creacion']);
		}
        $pelicula = Pelicula::create($request->all());
        return response()->json(['status'=>'ok','data'=>$pelicula]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pelicula = Pelicula::find($id);
        if (!$pelicula){
            return response()->json(['status' => 'failed', 'msg' => 'No existe pelicula con este id']);
        }
        return response()->json(['status'=>'ok','data'=>$pelicula]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        $pelicula = Pelicula::find($id);


        if (!$pelicula) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe pelicula con este id']);
        } 

        $title = $request->input('title');
        $description = $request->input('description');
        $duration = $request->input('duration');
        $img = $request->input('img');
        $precio_min = $request->input('precio_min');
        $comision = $request->input('comision');
        $url_trailer = $request->input('url_trailer');
        $url_compra = $request->input('url_compra');
        $type_public = $request->input('type_public');
        $category = $request->input('category');
        

        $bandera = false;

        if ($title !== null && $title !== '') {
            $pelicula->title = $title;
            $bandera = true;
        }
        if ($description !== null && $description !== '') {
            $pelicula->description = $description;
            $bandera = true;
        }
        if ($duration !== null && $duration !== '') {
            $pelicula->duration = $duration;
            $bandera = true;
        }
        if ($img !== null && $img !== '') {
            $pelicula->img = $img;
            $bandera = true;
        }
        if ($precio_min !== null && $precio_min !== '') {
            $pelicula->precio_min = $precio_min;
            $bandera = true;
        }   
        if ($comision !== null && $comision !== '') {
            $pelicula->comision = $comision;
            $bandera = true;
        }   
        if ($url_trailer !== null && $url_trailer !== '') {
            $pelicula->url_trailer = $url_trailer;
            $bandera = true;
        }
        if ($url_compra !== null && $url_compra !== '') {
            $pelicula->url_compra = $url_compra;
            $bandera = true;
        }
        if ($type_public !== null && $type_public !== '') {
            $pelicula->type_public = $type_public;
            $bandera = true;
        }
        if ($category !== null && $category !== '') {
            $pelicula->category = $category;
            $bandera = true;
        }      

        if ($bandera){
            $pelicula->save();
            return response()->json(['status'=>'ok','data'=>$pelicula]);
        }else {
            // Devolvemos un código 304 Not Modified.
            return response()->json(['status'=>'failed','msg'=>'No se ha podido modificado la pelicula']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pelicula = Pelicula::find($id);
        if (!$pelicula) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe pelicula con este id']);
        } 
        $pelicula->delete();
        return response()->json(['status'=>'ok','msg'=>'Se ha eliminado correctamente']);
    }
}
