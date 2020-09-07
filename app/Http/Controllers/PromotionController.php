<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $promotion = Promotion::all();
        return $promotion;
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
        if (!$request->input('title') || !$request->input('description') || !$request->input('precio') 
            || !$request->input('img') || !$request->input('url'))
		{
			// NO estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['status'=>'failed','msg'=>'Faltan datos necesarios para la creacion']);
		}
        $promotion = Promotion::create($request->all());
        return response()->json(['status'=>'ok','data'=>$promotion]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $promotion = Promotion::find($id);
        if (!$promotion){
            return response()->json(['status' => 'failed', 'msg' => 'No existe promocion con este id']);
        }
        return response()->json(['status' => 'ok', 'data' => $promotion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        $promotion = Promotion::find($id);

        if (!$promotion){
            return response()->json(['status' => 'failed', 'msg' => 'No existe promocion con este id']);
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $precio = $request->input('precio');
        $img = $request->input('img');
        $url = $request->input('url');
        $comision = $request->input('comision');

        $bandera = false;

        if ($title !== null && $title !== ''){
            $promotion->title = $title;
            $bandera = true;
        }
        if ($description !== null && $description !== ''){
            $promotion->description = $description;
            $bandera = true;
        }
        if ($precio !== null && $precio !== ''){
            $promotion->precio = $precio;
            $bandera = true;
        }
        if ($img !== null && $img !== ''){
            $promotion->img = $img;
            $bandera = true;
        }
        if ($url !== null && $url !== ''){
            $promotion->url = $url;
            $bandera = true;
        }
        if ($comision !== null && $comision !== ''){
            $promotion->comision = $comision;
            $bandera = true;
        }

        if ($bandera){
            $promotion->save();
            return response()->json(['status'=>'ok','data'=>$promotion]);
        }
        return response()->json(['status'=>'failed','msg'=>'No se ha podido modificado el promocion']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $promotion = Promotion::find($id);
        if (!$promotion){
            return response()->json(['status' => 'failed', 'msg' => 'No existe promocion con este id']);
        }
        $promotion->delete();
        return response()->json(['status'=>'ok','msg'=>'Se ha eliminado correctamente']);
    }
}
