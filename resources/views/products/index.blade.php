<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    
</head>

<body>
@include('header')

    <div class="container">

        <h1>Lista de productos</h1>


        <a class="btn btn-primary" href="{{url('products/create')}}">Agregar Producto</a>

        @if(Session::has('Mensaje')){{
    Session::get('Mensaje')
}}
        @endif
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>id</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>
                        <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->price}}</td>
                    <td>
                        <div class="form-group row">
                            <a href="{{url('products/'.$product->id.'/edit')}}" class="btn btn-secondary m-2">Editar</a>

                            <form method="post" action="{{url('products/'.$product->id)}}">

                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button class="btn btn-primary m-2" type="submit" onclick="return confirm('Desea borrar el producto {{$product->name}}');">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    @include('footer')
    </body>

</html>