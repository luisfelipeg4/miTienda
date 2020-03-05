<?php

namespace App\Http\Controllers;

use App\Orders;
use App\vr;
use Illuminate\Http\Request;

use DB;
class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos["orders"] = DB::table('orders')
        ->join('products', function($join)
        {
            $join->on('orders.product_id', '=', 'products.id');
        })
        ->get();
        return view('orders.index', $datos);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $datosOrden= $request->except('_token');
            
            $datosOrden['status']='CREATED';
            $datosOrden['created_at'] =  new \DateTime( 'now',  new \DateTimeZone( 'America/Bogota' ) );
            Orders::insert($datosOrden);
            return redirect('orders')->with('Mensaje', 'Orden creada correctamente');
        } catch (\Throwable $th) {
            // var_dump($request,$th) ;
            // return redirect('orders')->with('MensajeError', 'Hubo un error correctamente'.$th);
        }
    }

    /**
     * Display the specified resource.
     *
  * @param  \App\products  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $datos["orders"]= DB::table('orders')
        ->join('products', function($join)
        {
            $join->on('orders.product_id', '=', 'products.id');
        })
        ->where('orders.product_id', '=', $id)
        ->get();
        return view('orders.summary', $datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vr  $vr
     * @return \Illuminate\Http\Response
     */
    public function edit(vr $vr)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vr  $vr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vr  $vr
     * @return \Illuminate\Http\Response
     */
    public function destroy(vr $vr)
    {
        //
    }
}
