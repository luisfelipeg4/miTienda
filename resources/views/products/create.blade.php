<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>

<body>

    <div class="container">

    <h1>Agregar Producto</h1>

    <form action="{{url('/products')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        @include('products.form', ['type'=>'create'])


    </form>


    </div>
</body>

</html>