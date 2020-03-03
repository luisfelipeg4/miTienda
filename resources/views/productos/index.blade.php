<h1>Lista de productos</h1>

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
                <td>{{$producto->Foto}}</td>
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