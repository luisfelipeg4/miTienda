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
                        <img src="{{ asset('storage').'/'.$order->photo}}" alt="" width="50"> <b> Descripcion: </b>{{$order->name}}</b>
                    </td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->customer_email}}</td>
                    <td>
                        @if($order->status =='CREATED')PENDIENTE DE PAGO
                        @endif
                        @if($order->status =='REJECTED')
                        RECHAZADA
                        @endif
                        @if($order->status =='PAYED')
                       PAGADA
                        @endif
                        @if($order->status =='PENDING')
                       ESPERANDO AUTORIZACION
                        @endif
                    </td>
                    <td>
                        <div class="form-group row">

                            <a href="{{url('orders/'.$order->id)}}" class="btn btn-secondary m-2">Ver Resumen </a>

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