<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        
        $estado = $request->input('estado');
    
        
        $query = Paciente::query();
    
        
        if ($estado === '1') {
            $query->where('estado', 1);
        }
        
        elseif ($estado === '0') {
            $query->where('estado', 0);
        }
        
        $pacientes = $query->orderBy('dni', 'asc')
                       ->paginate(5)
                       ->withQueryString();
    
        
        return view('pacientes.index', compact('pacientes', 'estado'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
{
    
    $request->validate([
        'dni' => 'required|unique:pacientes,dni',
        'nombre' => 'required',
        'apellido' => 'required',
        'descripcion' => 'nullable|string',
    ]);

    
    $paciente = Paciente::create([
        'dni' => $request->dni,
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'estado' => 1, 
    ]);

    
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
    
    $paciente = Paciente::with('historiales')->findOrFail($dni);

    return view('pacientes.historial', compact('paciente'));
}


public function edit($dni)
{
    
    $paciente = Paciente::with('historiales')->findOrFail($dni);

    return view('pacientes.edit', compact('paciente'));
}

public function update(Request $request, $dni)
{
    
    $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        
    ]);

    
    $paciente = Paciente::findOrFail($dni);
    $paciente->update($request->only('nombre', 'apellido'));

    
    if ($request->filled('descripcion')) {
        
        $historial = $paciente->historiales->first();

        if ($historial) {
            
            $historial->update([
                'descripcion' => $request->descripcion
            ]);
        } else {
            
            $paciente->historiales()->create([
                'descripcion' => $request->descripcion
            ]);
        }
    } else {
        
        
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
        
        $paciente = Paciente::findOrFail($dni);
        $paciente->estado = ($paciente->estado == 1) ? 0 : 1;
        $paciente->save();

        return redirect()->route('pacientes.index')
                         ->with('success','Estado del paciente cambiado.');
    }
}