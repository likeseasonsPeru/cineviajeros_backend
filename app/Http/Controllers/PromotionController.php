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
        if (
            !$request->input('title') || !$request->input('description') || !$request->input('precio')
            || !$request->hasFile('image') || !$request->input('url') || !$request->input('legal')
        ) {
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        // Subir una image
        $input = $request->all();


        $file = $request->file('image');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/imgs/promociones/', $name);
        $input['img'] = '/imgs/promociones/' . $name;

        $promotion = Promotion::create($input);
        return response()->json(['status' => 'ok', 'data' => $promotion]);
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
        if (!$promotion) {
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

        if (!$promotion) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe promocion con este id']);
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $precio = $request->input('precio');
        $img = $request->input('img');
        $url = $request->input('url');
        $comision = $request->input('comision');
        $legal = $request->input('legal');
        $imagen = $request->file('image');

        $bandera = false;

        if ($title !== null && $title !== '') {
            $promotion->title = $title;
            $bandera = true;
        }
        if ($description !== null && $description !== '') {
            $promotion->description = $description;
            $bandera = true;
        }
        if ($precio !== null && $precio !== '') {
            $promotion->precio = $precio;
            $bandera = true;
        }
        if ($img !== null && $img !== '') {
            $promotion->img = $img;
            $bandera = true;
        }
        if ($url !== null && $url !== '') {
            $promotion->url = $url;
            $bandera = true;
        }
        if ($legal !== null && $legal !== '') {
            $promotion->legal = $legal;
            $bandera = true;
        }
        if ($comision !== null && $comision !== '') {
            $promotion->comision = $comision;
            $bandera = true;
        }
        if ($request->hasFile('image')) {
            // Eliminar la imagen antigua
            $imgPath = public_path() . $promotion->img;
            if (@getimagesize($imgPath)) {
                unlink($imgPath);
            }

            // Subir una image
            $path = time() . $imagen->getClientOriginalName();
            $imagen->move(public_path() . '/imgs/promociones/', $path);
            $promotion->img = '/imgs/promociones/' . $path;

            $bandera = true;
        }

        if ($bandera) {
            $promotion->save();
            return response()->json(['status' => 'ok', 'data' => $promotion]);
        }
        return response()->json(['status' => 'failed', 'msg' => 'No se ha podido modificado el promocion']);
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
        if (!$promotion) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe promocion con este id']);
        }

        $imgPath = public_path() . $promotion->img;
        if (@getimagesize($imgPath)) {
            unlink($imgPath);
        }

        $promotion->delete();
        return response()->json(['status' => 'ok', 'msg' => 'Se ha eliminado correctamente']);
    }
}
