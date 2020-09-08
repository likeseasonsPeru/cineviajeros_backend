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

        if (!$request->input('title') || !$request->input('description') || !$request->input('precio') || !$request->input('comision') || !$request->hasFile('image')) {
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        $input = $request->all();

        // Subir una image
        $file = $request->file('image');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/imgs/combos/', $name);
        $input['img'] = '/imgs/combos/' . $name;

        // Subir una image en data 64

        //get the base-64 from data
          /*   $base64_str = substr($input->image, strpos($input->image, ",")+1);
         //decode base64 string
         $image = base64_decode($base64_str);
         $png_url = "product-".time().".png";
         $path = public_path('img/designs/' . $png_url);
 */

        $combo = Combo::create($input);
        return response()->json(['status' => 'ok', 'data' => $combo]);
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
        return response()->json(['status' => 'ok', 'data' => $combo]);
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

        $title = $request->input('title');
        $description = $request->input('description');
        $precio = $request->input('precio');
        $comision = $request->input('comision');
        $imagen = $request->file('image');


        $bandera = false;

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

        if ($request->hasFile('image')) {

            // Eliminar la imagen antigua
            $imgPath = public_path().$combo->img;
            if (@getimagesize($imgPath)){
                unlink($imgPath);
            }

            // Subir una image
            $path = time() . $imagen->getClientOriginalName();
            $imagen->move(public_path() . '/imgs/combos/', $path);
            $combo->img = public_path() . '/imgs/combos/'. $path;

            $bandera = true;
        }

        if ($bandera) {
            $combo->save();
            return response()->json(['status' => 'ok', 'data' => $combo]);
        } else {
            // Devolvemos un código 304 Not Modified.
            return response()->json(['status' => 'failed', 'msg' => 'No se ha podido modificar el combo']);
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
        // Eliminar la imagen antigua
        $imgPath = public_path().$combo->img;
        if (@getimagesize($imgPath)){
            unlink($imgPath);
        }

        $combo->delete();
        return response()->json(['status' => 'ok', 'msg' => 'Se ha eliminado correctamente']);
    }
}
