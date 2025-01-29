<?php
use App\Http\Controllers\PacienteController;

// Rutas del CRUD
Route::resource('pacientes', PacienteController::class);

// Ruta para ver el historial de un paciente en particular
Route::get('pacientes/{dni}/historial', 
    [PacienteController::class, 'verHistorial']
)->name('pacientes.verHistorial');
