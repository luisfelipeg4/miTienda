<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos["products"] = products::all();
        return view('products.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');
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
        // $datosProducto = $request->all();
        try {
            
            $datosProducto = $request->except('_token');
            if ($request->file('photo')) {
                $datosProducto['photo'] = $request->file('photo')->store('public/uploads');
                $datosProducto['photo'] = str_replace("public/uploads", "uploads", $datosProducto['photo']);
            }

            $datosProducto['created_at'] =  new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) );
            products::insert($datosProducto);
            return redirect('products')->with('Mensaje', 'Producto agregado correctamente');
        } catch (\Throwable $th) {
            return redirect('products/create')->with('MensajeError', 'Hubo un error al crear el producto ');
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = products::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $datosProducto = $request->except(['_token', '_method']);

        if ($request->file('photo')) {
            $producto = products::findOrFail($id);
            Storage::delete('public/' . $producto->photo);
            $datosProducto['photo'] = $request->file('photo')->store('public/uploads');
            $datosProducto['photo'] = str_replace("public/uploads", "uploads", $datosProducto['photo']);
        }
        products::where('id', '=', $id)->update($datosProducto);
        $producto = products::findOrFail($id);

        return redirect('products')->with('Mensaje', 'Producto modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $producto = products::findOrFail($id);

        if (Storage::delete('public/' . $producto->photo)) {
            products::destroy($id);
        }
        return redirect('products')->with('Mensaje', 'Producto eliminado con éxito');
    }
}
