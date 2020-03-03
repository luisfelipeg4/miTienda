<form action="{{url('/productos/'.$producto->id)}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PATCH')}}
    @include('productos.form', ['type'=>'editar'])
    
</form>