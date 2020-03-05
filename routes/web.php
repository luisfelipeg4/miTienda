<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/

use App\Products;

Route::get('/', function () {
    $datos["products"] = Products::paginate(5);
    return view('welcome',$datos);
});


Route::resource('products', 'ProductsController');
Route::resource('orders', 'OrdersController',array('except'=>array('create')));

Route::get('orders/create/{id?}', function ($id=null) {
    
    $product = products::findOrFail($id);

    return view('orders.create', compact('product'));
});


Route::get('/placetopay', function () {
    return view('placeToPay');
});

Route::get('/response', function ($request) {
    var_dump($request);
    return  view('welcome');
});

