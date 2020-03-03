<h1>Formulario de productos</h1>

<form action="{{url('/productos')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
@include('productos.form', ['type'=>'crear'])
    

</form>