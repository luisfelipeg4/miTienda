<?php

namespace App\Http\Controllers;

use App\Orders;
use App\vr;
use Illuminate\Http\Request;


use DB;
use Dnetix\Redirection\PlacetoPay;

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
            ->join('products', function ($join) {
                $join->on('orders.product_id', '=', 'products.id');
            })
            ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo')
            ->get();
        // print_r($datos);
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
            $datosOrden = $request->except('_token');

            $datosOrden['status'] = 'CREATED';
            $datosOrden['created_at'] =  new \DateTime('now',  new \DateTimeZone('America/Bogota'));
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
        $order = DB::table('orders')
        ->join('products', function ($join) {
            $join->on('orders.product_id', '=', 'products.id');
        })
        ->where('orders.id', '=', $id)
        ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo')
        ->get()[0];

        if($order->status=='CREATED'&& $order->requestId!='' ){
            $requestInformation = $this->requestInformation($order->requestId);
            if($requestInformation){
                Orders::where('id', $id)->update(array(
                    'status' => 'PAYED'
                ));
            }else{
                Orders::where('id', $id)->update(array(
                    'status' => 'REJECTED'
                ));
            }
        }
        $order = DB::table('orders')
        ->join('products', function ($join) {
            $join->on('orders.product_id', '=', 'products.id');
        })
        ->where('orders.id', '=', $id)
        ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo')
        ->get()[0];

       
        return view('orders.summary',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        try {
            $order = DB::table('orders')
                ->join('products', function ($join) {
                    $join->on('orders.product_id', '=', 'products.id');
                })
                ->where('orders.id', '=', $id)
                ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo')
                ->get()[0];
            $requestPlaceToPay = $this->createRequest($order);
            $servicePlaceToplay = $this->createServicePlaceToPay();

            $responsePlaceToPay = $servicePlaceToplay->request($requestPlaceToPay);
            if ($responsePlaceToPay->isSuccessful()) {
                // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
                Orders::where('id', $id)->update(array(
                    'requestId' => $responsePlaceToPay->requestId(),
                    'processUrl' => $responsePlaceToPay->processUrl()
                ));
                header("Location: " . $responsePlaceToPay->processUrl());
                exit;
            } else {
                $responsePlaceToPay->status()->message();
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        var_dump($requestPlaceToPay);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }


    public function createRequest($order)
    {
        $myOrder = $order;
        $request = [
            'payment' => [
                'reference' => $myOrder->id,
                'description' => 'Pago de ' . $myOrder->name . ' (' . $myOrder->description . ' )',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $myOrder->price,
                ],
                "payer" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ],
                "buyer" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ],
                "shipping" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ]
            ],
            'expiration' => date('c', strtotime('+1 days')),
            'returnUrl' => 'http://localhost:8000/orders/'.$order->id,
            'cancelUrl' => 'http://localhost:8000/orders/'.$order->id,
            'ipAddress' => '127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT']
        ];

        return $request;
    }
    public function createServicePlaceToPay()
    {
        // Creating a random reference for the test
        $secretKey = '024h1IlD';
        $login = "6dd490faf9cb87a9862245da41170ff2";
        $placetopay = new PlacetoPay([
            'login' => $login,
            'tranKey' => $secretKey,
            'url' => 'https://test.placetopay.com/redirection',
            'rest' => [
                'timeout' => 30, // (optional) 15 by default
                'connect_timeout' => 5, // (optional) 5 by default
            ]
        ]);
        return $placetopay;
    }
    public function requestInformation($requestId){

        $servicePlaceToplay = $this->createServicePlaceToPay();
        $response = $servicePlaceToplay->query($requestId);
        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                // The payment has been approved
                return $response->toArray();
            }
        } else {
            // There was some error with the connection so check the message
            return ($response->status()->message() . "\n");
        }
    }
}
