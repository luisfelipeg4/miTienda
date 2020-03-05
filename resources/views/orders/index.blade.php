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

        <h1>Lista de ordenes</h1>

        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>id</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>
                        <img src="{{ asset('storage').'/'.$order->photo}}" alt="" width="100">{{$order->name}}
                    </td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->customer_email}}</td>
                    <td>{{$order->status}}</td>
                    <td>
                        <div class="form-group row">
                            @if($order->status == 'CREATED')
                            <a href="{{url('orders/'.$order->id)}}" class="btn btn-secondary m-2">Ver Resumen </a>
                            @endif
                            @if($order->status == 'REJECTED')
                            <!-- <a href="{{url('products/'.$order->id.'/edit')}}" class="btn btn-secondary m-2">Editar</a> -->
                            <p>Reintentar</p>
                            @endif
                            <!-- <form method="post" action="{{url('products/'.$order->id)}}">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button class="btn btn-primary m-2" type="submit" onclick="return confirm('Desea borrar el producto {{$order->name}}');">Borrar</button>
                            </form> -->
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    @include('footer')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>