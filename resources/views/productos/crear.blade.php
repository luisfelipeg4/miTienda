<h1>Formulario de productos</h1>

<form action="{{url('/productos')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <label for="Nombre">Nombre</label>
    <input type="text" name="Nombre" id="Nombre" value="">
    <br/>
    <label for="Descripcion">Descripcion</label>
    <input type="text" name="Descripcion" id="Descripcion" value="">
    <br/>
    <label for="Foto">Foto</label>
    <input type="image" name="Foto" id="Foto" value="">
    <br/>

    <input type="submit" value="Agregar">

</form>