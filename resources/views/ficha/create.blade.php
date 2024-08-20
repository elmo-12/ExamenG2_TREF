<!-- resources/views/fichas/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ficha</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container {
            margin-top: 50px;
        }
        .total {
            text-align: end;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Crear Ficha</h1>

        <!-- Formulario para buscar cliente por DNI -->
        <form id="search-client-form">
            @csrf
            <div class="form-group">
                <label for="dni">DNI del Cliente:</label>
                <input type="text" id="dni" name="dni" class="form-control" required>
                <button type="submit" id="search-client" class="btn btn-secondary mt-2">Buscar Cliente</button>
            </div>
        </form>

        <!-- Información del cliente -->
        <div id="client-info" class="mt-4">
            <div class="form-group">
                <label for="cliente_nombre">Nombre:</label>
                <input type="text" id="cliente_nombre" name="cliente_nombre" class="form-control" readonly placeholder="nombre">
            </div>
            <div class="form-group">
                <label for="cliente_direccion">Dirección:</label>
                <input type="text" id="cliente_direccion" name="cliente_direccion" class="form-control" readonly placeholder="descripcion">
            </div>
        </div>
        
        <div class="form-group mt-4">
            <label for="video">Seleccionar Video:</label>
            <select id="video" name="video" class="form-control">
                <option value="">Selecciona un video</option>
                @foreach($videos as $video)
                    <option value="{{ $video->id_video }}">{{ $video->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <div>
                <label for="">Precio Alquiler: </label>
                <input type="text" id="precio_alquiler" name="precio_alquiler" disabled>
            </div>
            <div>
                <label for="">Cantidad: </label>
                <input type="text" id="cantidad" name="cantidad">
            </div>
            <button id="agregar-detalle">AGREGAR</button>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Cod Video</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody id="detalle-ficha-body">
                    <!-- Aquí se agregarán las filas dinámicamente -->
                </tbody>
            </table>
        </div>

        <div>
            <p class="total">TOTAL: <input type="text" id="total" placeholder="total" disabled></p>
        </div>

        <form id="ficha-form" method="POST" action="{{ route('ficha.store') }}">
            @csrf
            <input type="hidden" id="cliente_id" name="cliente_id">
            <input type="hidden" id="total_value" name="total">
            <!-- Otros campos para detalles de la ficha -->
            <button type="submit" class="btn btn-primary mt-4">Guardar Ficha</button>
        </form>

        <script>
            $(document).ready(function() {
                var detalles = [];

                // Buscar cliente por DNI
                $('#search-client-form').on('submit', function(event) {
                    event.preventDefault();
                    
                    var dni = $('#dni').val();
                    
                    $.ajax({
                        url: '{{ route('ficha.searchClient') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            dni: dni
                        },
                        success: function(response) {
                            if (response) {
                                $('#cliente_nombre').val(response.nombres);
                                $('#cliente_direccion').val(response.direccion);
                                $('#cliente_id').val(response.id_cliente); // Guardar ID del cliente
                            } else {
                                alert('Cliente no encontrado');
                            }
                        }
                    });
                });

                // Obtener el precio del video seleccionado
                $('#video').on('change', function() {
                    var videoId = $(this).val();

                    if (videoId) {
                        $.ajax({
                            url: '{{ route('ficha.getVideoPrice') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                video_id: videoId
                            },
                            success: function(response) {
                                if (response.precio) {
                                    $('#precio_alquiler').val(response.precio);
                                } else {
                                    $('#precio_alquiler').val('');
                                }
                            }
                        });
                    } else {
                        $('#precio_alquiler').val('');
                    }
                });

                // Agregar detalle a la tabla
                $('#agregar-detalle').on('click', function() {
                    var videoId = $('#video').val();
                    var descripcion = $('#video option:selected').text();
                    var precio = $('#precio_alquiler').val();
                    var cantidad = $('#cantidad').val();
                    var importe = (precio * cantidad).toFixed(2);

                    if (videoId && cantidad && precio) {
                        detalles.push({
                            id_video: videoId,
                            precio: precio,
                            cantidad: cantidad
                        });

                        $('#detalle-ficha-body').append(`
                            <tr>
                                <td>${videoId}</td>
                                <td>${descripcion}</td>
                                <td>${cantidad}</td>
                                <td>${precio}</td>
                                <td>${importe}</td>
                            </tr>
                        `);

                        // Actualizar total
                        var total = detalles.reduce((sum, detalle) => sum + (detalle.precio * detalle.cantidad), 0);
                        $('#total').val(total.toFixed(2));

                        // Limpiar campos
                        $('#video').val('');
                        $('#precio_alquiler').val('');
                        $('#cantidad').val('');
                    } else {
                        alert('Completa todos los campos antes de agregar');
                    }
                });

                // Enviar datos del formulario
                $('#ficha-form').on('submit', function(event) {
                    event.preventDefault();

                    var clienteId = $('#cliente_id').val();
                    var total = $('#total').val();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cliente_id: Number(clienteId),
                            total: Number(total),
                            detalles: detalles
                        },
                        success: function(response) {
                            console.log(response)
                        }
                    });
                });
            });
        </script>
    </div>
</body>
</html>