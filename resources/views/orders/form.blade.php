<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>{{$type=='create'? 'Crear Orden': ''}}</title>
</head>

<body>

    <div class="py-4">
        <div class="card">
            <div class="card-header"><label id="name_product" id="product_name"> <b> Producto : </b>{{$product->name ?? ''}} </label></div>
            <div class="card-body">

                <label id="name_product" id="product_description"> <b>Descripción : </b> {{$product->description ?? ''}} </label><br>
                @if(isset($product->photo))
                <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                @endif</div>
            <div class="card-footer"><label id="name_product" id="product_name"> <b> Precio : </b>COP $ {{$product->price ?? ''}} </label></div>
        </div>
    </div>
    <div>
        <input class="form-control" type="hidden" name="product_id" id="product_id" value="{{$product->id ?? ''}}">
    </div>
    <h4>Información del cliente:</h4>


    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nombre: </label>
        <div class="col-sm-10">
            <input  class="form-control" type="text"  name="customer_name" id="customer_name" value="">
        </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Correo: </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="customer_email" id="customer_email" value="">
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Teléfono : </label>
        <div class="col-sm-10">
            <input class="form-control" type="number" name="customer_mobile" id="customer_mobile" value="">
        </div>
    </div>

    <div class="center">
        <a class="btn btn-secondary" href="{{url('/')}}">Regresar</a>
        <input class="btn btn-primary" type="submit" value="{{$type=='create'? 'Crear Orden': ''}}"></button>
    </div>
</body>


</html>