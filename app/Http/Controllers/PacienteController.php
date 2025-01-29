<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        // Obtén el valor del filtro 'estado' desde la URL (GET).
        // Puede ser "1", "0", o "" (si no se envía nada).
        $estado = $request->input('estado');
    
        // Construimos la consulta base
        $query = Paciente::query();
    
        // Si se selecciona "1" => activo
        if ($estado === '1') {
            $query->where('estado', 1);
        }
        // Si se selecciona "0" => inactivo
        elseif ($estado === '0') {
            $query->where('estado', 0);
        }
        // Si está vacío o 'todos', no filtramos.
        // Quedarán todos los pacientes.
    
        // Ejecutamos la consulta
        $pacientes = $query->orderBy('dni', 'asc')->paginate(5);
    
        // Retornamos la vista con la lista de pacientes
        // y le pasamos la variable $estado para destacar la opción elegida
        return view('pacientes.index', compact('pacientes', 'estado'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
{
    // Validamos los campos
    $request->validate([
        'dni' => 'required|unique:pacientes,dni',
        'nombre' => 'required',
        'apellido' => 'required',
        'descripcion' => 'nullable|string',
    ]);

    // 1) Crear Paciente
    $paciente = Paciente::create([
        'dni' => $request->dni,
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'estado' => 1, // lo dejamos activo por defecto (1)
    ]);

    // 2) Crear un registro de historial SOLO si hay descripción
    if ($request->filled('descripcion')) {
        $paciente->historiales()->create([
            'descripcion' => $request->descripcion
        ]);
    }

    return redirect()->route('pacientes.index')
                     ->with('success','Paciente creado correctamente.');
}

public function verHistorial($dni)
{
    // Carga el paciente con todos sus historiales
    $paciente = Paciente::with('historiales')->findOrFail($dni);

    return view('pacientes.historial', compact('paciente'));
}


public function edit($dni)
{
    // Cargamos el paciente con sus historiales
    $paciente = Paciente::with('historiales')->findOrFail($dni);

    return view('pacientes.edit', compact('paciente'));
}

public function update(Request $request, $dni)
{
    // Validar campos base del paciente
    $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        // Agrega si deseas validar 'descripcion'...
    ]);

    // 1) Actualizar datos del paciente
    $paciente = Paciente::findOrFail($dni);
    $paciente->update($request->only('nombre', 'apellido'));

    // 2) Actualizar o crear la descripción en historiales
    // Si el formulario trae 'descripcion', actualizamos:
    if ($request->filled('descripcion')) {
        // Toma el primer historial (asumiendo solo uno)
        $historial = $paciente->historiales->first();

        if ($historial) {
            // Si ya existe, lo actualizamos
            $historial->update([
                'descripcion' => $request->descripcion
            ]);
        } else {
            // Si no existe, lo creamos
            $paciente->historiales()->create([
                'descripcion' => $request->descripcion
            ]);
        }
    } else {
        // Si no vino descripción en el form y quieres dejarlo vacío,
        // podrías borrar el historial o establecerlo en nulo, según tu lógica.
        // Ejemplo:
        
        $historial = $paciente->historiales->first();
        if ($historial) {
            $historial->update(['descripcion' => null]);
        }
        
    }

    return redirect()->route('pacientes.index')
                     ->with('success','Paciente y su historial han sido actualizados.');
}


    public function destroy($dni)
    {
        // Si quieres "toggle":
        $paciente = Paciente::findOrFail($dni);
        $paciente->estado = ($paciente->estado == 1) ? 0 : 1;
        $paciente->save();

        return redirect()->route('pacientes.index')
                         ->with('success','Estado del paciente cambiado.');
    }
}