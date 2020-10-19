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

        if (!$request->input('title') || !$request->input('description') || !$request->input('precio')  || !$request->hasFile('image') || !$request->input('legal')) {
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        $input = $request->all();

        // Subir una image
        $file = $request->file('image');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/imgs/combos/', $name);
        $input['img'] = '/imgs/combos/' . $name;
        
        // Valid extension
        $valid_ext = array('png', 'jpeg', 'jpg');
        // Image compression 
        $location = public_path().'/imgs/combos/'.$name;
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        
        if(in_array($file_extension,$valid_ext)){
            // Compress Image
            $this->compressImage($location,$location);
        }

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
        $legal = $request->input('legal');


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
        if ($legal !== null && $legal !== '') {
            $combo->legal = $legal;
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
            $combo->img = '/imgs/combos/'. $path;


            // Valid extension
            $valid_ext = array('png', 'jpeg', 'jpg');
            // Image compression 
            $location = public_path().'/imgs/combos/'.$path;
            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
            
            if(in_array($file_extension,$valid_ext)){
                // Compress Image
                $this->compressImage($location,$location);
            }

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

    function compressImage($source, $destination)
    {

        $quality = 75;
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source);
            $quality = 50;
        }
        elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
            $quality = 90;
        }

        elseif ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($source);
            $quality = 90;
        }
        imagejpeg($image, $destination, $quality);
    }
    
    
}
