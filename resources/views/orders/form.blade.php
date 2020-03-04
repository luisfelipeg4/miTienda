<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>{{$type=='create'? 'Agregar Producto': 'Modificar Producto'}}</title>
</head>

<body>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nombre: </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="name" id="name" value="{{$product->name ?? ''}}">
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Email: </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="description" id="description" value="{{$product->description ?? ''}}">
        </div>
    </div>

    <div class="form-group row">
        <label for="price" class="col-sm-2 col-form-label">Telefono:</label>
        <div class="col-sm-10">
            <input class="form-control" type="number" min="1" step="any" name="price" id="price" value="{{$product->price ?? ''}}" />
        </div>

    </div>
    @if(isset($product->photo))
    <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
    @endif

    <div class="form-group row">
        <label for="price" class="col-sm-2 col-form-label">Foto:</label>
        <div class="col-sm-10">
            <input class="form-control" type="file" name="photo" id="photo" value="{{$product->photo ?? ''}}">
        </div>
    </div>

    <a class="btn btn-secondary" href="{{url('products')}}">Regresar</a>

    <input class="btn btn-primary" type="submit" value="{{$type=='create'? 'Agregar': 'Modificar'}}"></button>
</body>


</html>