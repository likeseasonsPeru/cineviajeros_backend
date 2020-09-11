<?php

namespace App\Http\Controllers;

use App\subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subscription = subscriptions::all();
        return $subscription;
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
        if (!$request->input('email')){
            return response()->json(['status' => 'failed', 'msg' => 'Faltan datos necesarios para la creacion']);
        }

        $subscription = subscriptions::create($request->all());
        return response()->json(['status' => 'ok', 'data' => $subscription]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $subscription = subscriptions::find($id);
        if (!$subscription) {
            return response()->json(['status' => 'failed', 'msg' => 'No existe subscripcion con este id']);
        }
        return response()->json(['status' => 'ok', 'data' => $subscription]);
    }

}
