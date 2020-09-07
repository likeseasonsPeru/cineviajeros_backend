<?php

namespace App\Http\Controllers;

use App\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $combo = Combo::all();
        return $combo;
        //Esta funcion devuel todas las tareas que tenemos en la bd
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

        if (!$request->input('img') || !$request->input('title') || !$request->input('description') || !$request->input('precio') || !$request->input('comision'))
		{
			// NO estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['status'=>'failed','msg'=>'Faltan datos necesarios para la creacion']);
		}
        $combo = Combo::create($request->all());
        return response()->json(['status'=>'ok','data'=>$combo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    /* public function show(Combo $combo)
    {
        $combo = Combo::findOrFail()
        //

    } */
    public function show($id)
    {
        $combo = Combo::find($id);
        if (!$combo) {
            // se devuelve un mensaje de no encontrado 
            return response()->json(['status' => 'failed', 'msg' => 'No existe combo con este id']);
        } 
        // Devolvemos si se encontro
        return response()->json(['status'=>'ok','data'=>$combo]);
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request /* Combo $combo */)
    {
        //
        $combo = Combo::find($id);


        if (!$combo) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe combo con este id']);
        } 

        $img = $request->input('img');
        $title = $request->input('title');
        $description = $request->input('description');
        $precio = $request->input('precio');
        $comision = $request->input('comision');
        

        $bandera = false;

        if ($img !== null && $img !== '') {
            $combo->img = $img;
            $bandera = true;
        }
        if ($title !== null && $title !== '') {
            $combo->title = $title;
            $bandera = true;
        }
        if ($description !== null && $description !== '') {
            $combo->description = $description;
            $bandera = true;
        }
        if ($precio !== null && $precio !== '') {
            $combo->precio = $precio;
            $bandera = true;
        }   
        if ($comision !== null && $comision !== '') {
            $combo->comision = $comision;
            $bandera = true;
        }         

        if ($bandera){
            $combo->save();
            return response()->json(['status'=>'ok','data'=>$combo]);
        }else {
            // Devolvemos un código 304 Not Modified.
            return response()->json(['status'=>'failed','msg'=>'No se ha podido modificado el combo']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Combo  $combo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $combo = Combo::find($id);
        if (!$combo) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe combo con este id']);
        } 
        $combo->delete();
        return response()->json(['status'=>'ok','msg'=>'Se ha eliminado correctamente']);
    }
}
