<?php

namespace App\Http\Controllers;

use App\Claimed;
use Illuminate\Http\Request;
use Lcobucci\JWT\Claim;

class ClaimedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $claim = Claimed::all();
        return $claim;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
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
        if (!$request->input('names') || !$request->input('surnames') || !$request->input('type_document') || !$request->input('n_document')){
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        $input = $request->all();
        $claim = Claimed::create($input);
        return response()->json(['status' => 'ok', 'data' => $claim]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Claimed  $claimed
     * @return \Illuminate\Http\Response
     */
    public function show(Claimed $claimed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Claimed  $claimed
     * @return \Illuminate\Http\Response
     */
    public function edit(Claimed $claimed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Claimed  $claimed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Claimed $claimed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Claimed  $claimed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Claimed $claimed)
    {
        //
    }
}
