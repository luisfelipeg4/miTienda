<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos["productos"] = Productos::paginate(5);
        return view('productos.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('productos.crear');
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

        $datosProducto = $request->except('_token');
        if ($request->file('Foto')) {
            $datosProducto['Foto'] = $request->file('Foto')->store('public/uploads');
            $datosProducto['Foto'] = str_replace("public/uploads", "uploads", $datosProducto['Foto']);
        }
        $data['created_at'] = new \DateTime();
        Productos::insert($datosProducto);
        return redirect('productos')->with('Mensaje', 'Producto agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $producto = Productos::findOrFail($id);

        return view('productos.editar', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $datosProducto = $request->except(['_token', '_method']);

        if ($request->file('Foto')) {
            $producto = Productos::findOrFail($id);
            Storage::delete('public/' . $producto->Foto);
            $datosProducto['Foto'] = $request->file('Foto')->store('public/uploads');
            $datosProducto['Foto'] = str_replace("public/uploads", "uploads", $datosProducto['Foto']);
        }
        Productos::where('id', '=', $id)->update($datosProducto);
        $producto = Productos::findOrFail($id);

        return redirect('productos')->with('Mensaje', 'Producto modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Productos  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $producto = Productos::findOrFail($id);

        if (Storage::delete('public/' . $producto->Foto)) {
            Productos::destroy($id);
        }
        return redirect('productos')->with('Mensaje', 'Producto eliminado con éxito');
    }
}
