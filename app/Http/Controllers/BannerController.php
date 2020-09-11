<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banner = Banner::all();
        return $banner;
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
        if (!$request->input('title') || !$request->hasFile('image')){
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);

        }

        // Subir una image
        $input = $request->all();


        $file = $request->file('image');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/imgs/banners/', $name);
        $input['img'] = '/imgs/banners/' . $name;

        $banner = Banner::create($input);
        return response()->json(['status' => 'ok', 'data' => $banner]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $banner = Banner::find($id);
        if ($banner){
            return response()->json(['status' => 'failed', 'msg' => 'No existe banner con este id']);
        }
        return response()->json(['status' => 'ok', 'data' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        //

        $banner = Banner::find($id);
        if (!$banner){
            return response()->json(['status' => 'failed', 'msg' => 'No existe banner con este id']);
        }

        $title = $request->input('title');
        $imagen = $request->file('image');

        $bandera = false;

        if ($title !== null && $title !== '') {
            $banner->title = $title;
            $bandera = true;
        }

        if ($request->hasFile('image')){
            // Eliminar la imagen antigua
            $imgPath = public_path().$banner->img;
            if (@getimagesize($imgPath)){
                unlink($imgPath);
            }

            // Subir una image
            $path = time() . $imagen->getClientOriginalName();
            $imagen->move(public_path() . '/imgs/banners/', $path);
            $banner->img = '/imgs/banners/'. $path;
            
            $bandera = true;
        }

        if ($bandera) {
            $banner->save();
            return response()->json(['status' => 'ok', 'data' => $banner]);
        }
        return response()->json(['status' => 'failed', 'msg' => 'No se ha podido modificado el banner']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe banner con este id']);
        }
        $banner->delete();
        return response()->json(['status' => 'ok', 'msg' => 'Se ha eliminado correctamente']);
    }
}
