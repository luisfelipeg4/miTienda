<div>
    {{$type=='crear'? 'Agregar Producto': 'Modificar Producto'}}
    <br/>

<label for="Nombre">Nombre</label>
    <input type="text" name="Nombre" id="Nombre" value="{{$producto->Nombre ?? ''}}">
    <br/>
    <label for="Descripcion">Descripcion</label>
    <input type="text" name="Descripcion" id="Descripcion" value="{{$producto->Descripcion ?? ''}}">
    <br/>
    <label for="Foto">Foto</label>
    @if(isset($producto->Foto))
        <img src="{{ asset('storage').'/'.$producto->Foto}}" alt="" width="200">
    @endif
        <input type="file" name="Foto" id="Foto" value="{{$producto->Foto ?? ''}}">
    <br/>
    <a href="{{url('productos')}}">Regresar</a>

<input type="submit" value="{{$type=='crear'? 'Agregar': 'Modificar'}}">

</div>