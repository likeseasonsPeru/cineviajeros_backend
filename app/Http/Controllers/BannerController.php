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
        $banner = Banner::all()->sortBy("order");
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
        if (!$request->hasFile('image')){
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);

        }

        // Subir una image
        $input = $request->all();


        $file = $request->file('image');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/imgs/banners/', $name);
        $input['img'] = '/imgs/banners/' . $name;
        
        // order
        $count = Banner::all()->count();
        $input['order'] = $count + 1;

        // Valid extension
        $valid_ext = array('png', 'jpeg', 'jpg');
        // Image compression 
        $location = public_path().'/imgs/banners/'.$name;
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        
        if(in_array($file_extension,$valid_ext)){
            // Compress Image
            $this->compressImage($location,$location);
        }

        $banner = Banner::create($input);
        return response()->json(['status' => 'ok',  'data' => $banner]);
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
        if (!$banner){
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
        $description = $request->input('description');
        $url_trailer = $request->input('url_trailer');
        $url_compra = $request->input('url_compra');
        $url = $request->input('url');
        $actived = $request->input('actived');

        $bandera = true;

        $banner->title = $title;
        $banner->description = $description;
        $banner->url_trailer = $url_trailer;
        $banner->url_compra = $url_compra;
        $banner->url = $url;

        if ($actived !== null && $actived !== '') {
            $banner->actived = $actived;
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

            // Valid extension
            $valid_ext = array('png', 'jpeg', 'jpg');
            // Image compression 
            $location = public_path().'/imgs/banners/'.$path;
            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
            
            if(in_array($file_extension,$valid_ext)){
                // Compress Image
                $this->compressImage($location,$location);
            }
            
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

    function compressImage($source, $destination)
    {

        $quality = 75;
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source);
            $quality = 90;
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
