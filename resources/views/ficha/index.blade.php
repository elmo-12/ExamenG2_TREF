<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CREAR FICHA</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
                <!-- Formulario de filtro por fecha -->
        <form method="GET" action="{{ route('ficha.index') }}" class="mb-4">
            <div class="form-group">
                <label for="fecha">Filtrar por Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="{{ $fechaFiltro }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>
        <h1 class="mt-4">Listado de Fichas</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID Ficha</th>
                    <th>Fecha de Venta</th>
                    <th>DNI Cliente</th>
                    <th>Nombres</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fichas as $ficha)
                <tr>
                    <td>{{ $ficha->id_ficha }}</td>
                    <td>{{ $ficha->fecha_Venta }}</td>
                    <td>{{ $ficha->cliente->DNI }}</td>
                    <td>{{ $ficha->cliente->nombres }}</td>
                    <td>{{ $ficha->total }}</td>
                    <td><a href=""><button>Ver</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>