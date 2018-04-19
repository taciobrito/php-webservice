<?php

namespace App\Http\Controllers;

use App\Medico;
use App\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EspecialidadeController extends Controller
{

    public function index($medicoId) {
        if(!(Medico::find($medicoId))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        return son_response()->make(Especialidade::whereHas('medico', 
            function($query) use ($medicoId) {
                $query->where('id', $medicoId);   
            })->get());
    }

    public function show($id, $medicoId) {
        if(!(Medico::find($medicoId))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        if(!($especialidade = Especialidade::find($id))){
            throw new ModelNotFoundException("Especialidade requisitada não existe");
        }
        $result = Especialidade::whereHas('medico', 
            function($query) use ($medicoId) {
                $query->where('id', $medicoId);   
            })->where('id', $id)->get()->first();
        return son_response()->make($result);
    }

    public function store(Request $request, $medicoId) {
        if(!(Medico::find($medicoId))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        $this->validate($request, [
            'especialidade' => 'required', 
        ]);
        $especialidade = Especialidade::create($request->all());
        Medico::find($medicoId)->update(['especialidade_id'=>$especialidade->id]);
        return son_response()->make($especialidade, 201);
    }

    public function update(Request $request, $id, $medicoId) {
        if(!(Medico::find($medicoId))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        if(!($especialidade = Especialidade::find($id))){
            throw new ModelNotFoundException("Especialidade requisitada não existe");
        }
        $this->validate($request, [
            'especialidade' => 'required'
        ]);
        $especialidade = Especialidade::whereHas('medico', 
            function($query) use ($medicoId) {
                $query->where('id', $medicoId);   
            })->where('id', $id)->get()->first();

        $especialidade->fill($request->all());
        $especialidade->save();
        return son_response()->make($especialidade, 200);
    }

    public function destroy($id, $medicoId) {
        if(!(Medico::find($medicoId))){
            throw new ModelNotFoundException("Médico requisitado não existe");
        }
        if(!(Especialidade::find($id))){
            throw new ModelNotFoundException("Especialidade requisitada não existe");
        }

        $especialidade = Especialidade::whereHas('medico', 
            function($query) use ($medicoId) {
                $query->where('id', $medicoId);   
            })->where('id', $id)->get()->first();

        $especialidade->delete();
        return son_response()->make("", 204);
    }

}
