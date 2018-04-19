<?php

namespace App\Http\Controllers;

use App\Medico;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MedicoController extends Controller
{

    public function index() {
        return son_response()->make(Medico::all());
    }

    public function show($id) {
        if(!($medico = Medico::find($id))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        return son_response()->make($medico);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'nome' => 'required', 
            'especialidade_id' => 'required', 
            'turno' => 'required'
        ]);
        $medico = Medico::create($request->all());
        return son_response()->make($medico, 201);
    }

    public function update(Request $request, $id) {
        if(!($medico = Medico::find($id))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        $this->validate($request, [
            // 'id' => 'required'
        ]);
        $medico->fill($request->all());
        $medico->save();
        return son_response()->make($medico, 200);
    }

    public function destroy($id) {
        if(!($medico = Medico::find($id))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        $medico->delete();
        return son_response()->make("", 204);
    }

}
