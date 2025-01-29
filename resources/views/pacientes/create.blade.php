<!-- resources/views/pacientes/create.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Agregar Paciente</h2>

    <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" name="dni" id="dni" class="form-control" required>
            @error('dni')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
            @error('apellido')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- NUEVO: Campo para descripción de historial -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción Historial</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
            @error('descripcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Regresar</a>
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
