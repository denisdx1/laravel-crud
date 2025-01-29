<!-- resources/views/pacientes/historial.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial del Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Historial de {{ $paciente->nombre }} (DNI: {{ $paciente->dni }})</h2>

    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary mb-3">
        Regresar
    </a>

    @if ($paciente->historiales->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Historial</th>
                    <th>Descripción</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paciente->historiales as $historial)
                    <tr>
                        <td>{{ $historial->id }}</td>
                        <td>{{ $historial->descripcion }}</td>
                        <td>{{ $historial->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Este paciente no tiene historiales registrados.
        </div>
    @endif

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
