<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('header')
</head>

<body>

    <div class="container">
        <form action="{{url('/orders/'.$order->id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PATCH')}}
            <h4 class="text-center py-3"> Resumen de Compra</h4>
            <!-- <form action="{{url('/orders')}}" method="post" enctype="multipart/form-data"> -->

            <div class="py-4">
                <div class="card">

                    <div class="card-header"><label id="product_name" id="product_name"> <b> Producto : </b>{{$order->name ?? ''}} </label></div>
                    <div class="card-body">

                        <label id="product_description" id="product_description"> <b>Descripción : </b> {{$order->description ?? ''}} </label><br>
                        <div class="row">
                            <div class="column col-sm-6">
                                @if(isset($order->photo))
                                <img src="{{ asset('storage').'/'.$order->photo}}" alt="" width="100">
                                @endif

                            </div>
                            <div class="column col-sm-6 right-align">

                                @if($order->status =='PAYED')
                                <label id="product_description" id="product_description"> <b>Estado : </b> PAGADA</label>
                                <img src="{{ asset('storage').'/PAYED.png'}}" alt="" width="100">
                                @endif
                                @if($order->status =='REJECTED')
                                <label><b>Estado : </b> Rechazada</label>
                                <img src="{{ asset('storage').'/REJECTED.png'}}" alt="" width="100">
                                @endif
                              
                            </div>


                        </div>
                    </div>
                    <div class="card-footer"><label id="product_price" id="product_price"> <b> Precio : </b>COP $ {{$order->price ?? ''}} </label></div>
                </div>
            </div>
            <div>
                <input class="form-control" type="hidden" name="product_id" id="product_id" value="{{$order->product_id ?? ''}}">
            </div>
            <h4>Información del cliente:</h4>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col-sm-10">
                    <input disabled class="form-control" type="text" name="customer_name" id="customer_name" value="{{$order->customer_name??''}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Correo: </label>
                <div class="col-sm-10">
                    <input disabled class="form-control" type="text" name="customer_email" id="customer_email" value="{{$order->customer_email??''}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Teléfono : </label>
                <div class="col-sm-10">
                    <input disabled class="form-control" type="number" name="customer_mobile" id="customer_mobile" value="{{$order->customer_mobile??''}}">
                </div>
            </div>

            <div class="center">
                <a class="btn btn-secondary" href="{{url('/orders')}}">Regresar</a>

                @if($order->status =='CREATED')
                <input class="btn btn-primary" type="submit" value="Pagar"></button>
                @endif
                @if($order->status =='REJECTED')
                <input class="btn btn-primary" type="submit" value="Reintentar"></button>
                @endif
                @if($order->status =='PENDING')
                <input class="btn btn-primary" type="submit" value="Reintentar"></button>
                @endif
            </div>

        </form>
    </div>

    @include('footer')

</body>



</html>