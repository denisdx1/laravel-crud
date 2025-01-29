<!-- resources/views/pacientes/index.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Lista de Pacientes</h2>

    <div class="d-flex mb-3" style="gap: 10px;">
        <!-- Botón Agregar Paciente -->
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            Agregar Paciente
        </a>

        <!-- Filtro de estado -->
<form action="{{ route('pacientes.index') }}" method="GET">
    <div class="input-group">
        <label class="input-group-text" for="estadoSelect">Filtrar por estado:</label>
        <select name="estado" id="estadoSelect" class="form-select" onchange="this.form.submit()">
            <option value=""  {{ ($estado === '')  ? 'selected' : '' }}>Todos</option>
            <option value="1" {{ ($estado === '1') ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ ($estado === '0') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pacientes as $paciente)
            <tr>
                <td>{{ $paciente->dni }}</td>
                <td>{{ $paciente->nombre }}</td>
                <td>{{ $paciente->apellido }}</td>
                <!-- Aquí mostramos "Activo" o "Inactivo" -->
                <td>{{ $paciente->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <!-- Editar -->
                    <a href="{{ route('pacientes.edit', $paciente->dni) }}" class="btn btn-warning">
                        Editar
                    </a>
                    <!-- Activar/Inactivar -->
                    <form action="{{ route('pacientes.destroy', $paciente->dni) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        @if ($paciente->estado == 1)
                            <button type="submit" class="btn btn-danger">Inactivar</button>
                        @else
                            <button type="submit" class="btn btn-success">Activar</button>
                        @endif
                    </form>
                    <!-- (Opcional) Botón "View" historial, etc. -->
                     <!-- NUEVO: Botón "View" para ver el historial -->
                    <a href="{{ route('pacientes.verHistorial', $paciente->dni) }}" class="btn btn-info">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Enlaces de paginación -->
    {{ $pacientes->links('pagination::bootstrap-5') }}
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
