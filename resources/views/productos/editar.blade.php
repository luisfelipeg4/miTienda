
<form action="{{url('/productos/'.$producto->id)}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
{{method_field('PATCH')}}
    <label for="Nombre">Nombre</label>
    <input type="text" name="Nombre" id="Nombre" value="{{$producto->Nombre}}">
    <br/>
    <label for="Descripcion">Descripcion</label>
    <input type="text" name="Descripcion" id="Descripcion" value="{{$producto->Descripcion}}">
    <br/>
    <label for="Foto">Foto</label>
    <input type="image" name="Foto" id="Foto" value="">
    <br/>

    <input type="submit" value="Editar">

</form>