<!-- resources/views/pacientes/edit.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Editar Paciente</h2>

    <form action="{{ route('pacientes.update', $paciente->dni) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                   value="{{ old('nombre', $paciente->nombre) }}"
                   class="form-control" required>
            @error('nombre')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido"
                   value="{{ old('apellido', $paciente->apellido) }}"
                   class="form-control" required>
            @error('apellido')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para editar la descripción del historial -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Historial</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3">
                {{ old('descripcion', $paciente->historiales->first() ? $paciente->historiales->first()->descripcion : '') }}
            </textarea>
            @error('descripcion')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Regresar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
