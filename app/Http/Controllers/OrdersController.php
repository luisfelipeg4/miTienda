<?php

namespace App\Http\Controllers;

use App\Orders;
use App\vr;
use Illuminate\Http\Request;


use DB;
use Dnetix\Redirection\PlacetoPay;
use Exception;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Expr\Print_;

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
        } catch (Exception $e) {
            return redirect('orders/create/'.$datosOrden['product_id'])->with('MensajeError', 'Hubo un error al crear el producto');
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
        $order = $this->getOrder($id);

        if (($order->status == 'CREATED' || $order->status == 'PENDING') && $order->requestId != '') {
            $requestInformation = $this->requestInformation($order->requestId);
            if ($requestInformation->status() == "APPROVED") {
                Orders::where('id', $id)->update(array(
                    'status' => 'PAYED'
                ));
            } else if ($requestInformation->status()  == "PENDING") {
                Orders::where('id', $id)->update(array(
                    'status' => 'PENDING'
                ));
            } else {
                Orders::where('id', $id)->update(array(
                    'status' => 'REJECTED'
                ));
            }
        }
        $order = $this->getOrder($id);

        return view('orders.summary', compact('order'));
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
            $order = $this->getOrder($id);
            $requestPlaceToPay = $this->createRequest($order);
            $servicePlaceToplay = $this->createServicePlaceToPay();
            $responsePlaceToPay = $servicePlaceToplay->request($requestPlaceToPay);
            if ($responsePlaceToPay->isSuccessful()) {
                // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
                Orders::where('id', $id)->update(array(
                    'status' => 'PENDING',
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
    }


    /**
     * Crear base de pago para placeToPay
     * @return request
     */
    public function createRequest($myOrder)
    {
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
            'returnUrl' => env('APP_URL') . "/orders/" . $myOrder->id,
            'cancelUrl' => env('APP_URL') . '/orders/' . $myOrder->id,
            'ipAddress' => env('HTTP_CLIENT_IP'),
            'userAgent' => $_SERVER['HTTP_USER_AGENT']
        ];

        return $request;
    }
    /**
     * Crear una instancia del Servicio de Place to play
     * @return servico 
     */
    public function createServicePlaceToPay()
    {
        $placetopay = new PlacetoPay([
            'login' => env('SOAP_LOGIN'),
            'tranKey' => env('SOAP_TRANKEY'),
            'url' => env('SOAP_URL_REDIRECTION'),
            'rest' => [
                'timeout' => 30, // (optional) 15 by default
                'connect_timeout' => 5, // (optional) 5 by default
            ]
        ]);
        return $placetopay;
    }
    /**
     * Obtiene informacion de una transaccion en placeToPay
     * @param requestId codigo unico de transaccion de PlaceToPay
     */
    public function requestInformation($requestId)
    {
        $servicePlaceToplay = $this->createServicePlaceToPay();
        $response = $servicePlaceToplay->query($requestId);

        if ($response->isSuccessful()) {
            return $response->status();
        } else {
            // There was some error with the connection so check the message
            return ($response->status()->message() . "\n");
        }
    }
    /**
     * Obtiene un solo registro de orden en la base de datos
     * @param id codigo unico de la orden
     */
    public function getOrder($id)
    {
        return DB::table('orders')
            ->join('products', function ($join) {
                $join->on('orders.product_id', '=', 'products.id');
            })
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo')
            ->get()[0];
    }
}
