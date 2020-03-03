<h1>Lista de productos</h1>

@if(Session::has('Mensaje')){{
    Session::get('Mensaje')
}}

@endif

<a href="{{url('productos/create')}}">Agregar Producto</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>id</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Descripcion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr>
                <td>{{$producto->id}}</td>
                <td>
                    <img src="{{ asset('storage').'/'.$producto->Foto}}" alt="" width="200">
                </td>
                <td>{{$producto->Nombre}}</td>
                <td>{{$producto->Descripcion}}</td>
                <td>
                <a href="{{url('productos/'.$producto->id.'/edit')}}">Editar</a>    
                
                <form method="post" action="{{url('productos/'.$producto->id)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit" onclick="return confirm('Desea borrar el producto $producto->Nombre');">Borrar</button>
                </form>
            </td>
            </tr>
        @endforeach
    </tbody>
    
</table>