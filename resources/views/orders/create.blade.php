<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('header')
</head>

<body>

    <div class="container">
    
    @if(Session::has('MensajeError')){{
    Session::get('MensajeError')
}}
            @endif
    <h4 class="text-center py-3"> Producto a comprar</h4>
    <form action="{{url('/orders')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        @include('orders.form', ['type'=>'create'])
    </form>
    </div>
    @include('footer')
</body>

</html>