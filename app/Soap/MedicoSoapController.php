<?php

namespace App\Soap;

use Zend\Config\Config;
use Zend\Config\Writer\Xml;
use Illuminate\Contracts\Support\Arrayable;
use App\Medico;
use App\Types\MedicoType;
// use Illuminate\Http\Request;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class MedicoSoapController
{

    /**
    * @return String
    */
    public function listAll() {
        return $this->getXML(Medico::all());
    }

    // public function show($id) {
    //     if(!($medico = Medico::find($id))){
    //         throw new ModelNotFoundException("Médico requisitado não existe");
    //     }
    //     return son_response()->make($medico);
    // }

    /**
     * @param \App\Types\MedicoType $type
     * @return string
     **/
    public function create(MedicoType $type) {
        $data = [
            'nome' => $type->nome,
            'especialidade_id' => $type->especialidade_id,
            'turno' => $type->turno,
        ];

        $medico = Medico::create($data);
        return $this->getXML($medico);
    }

    // public function update(Request $request, $id) {
    //     if(!($medico = Medico::find($id))){
    //         throw new ModelNotFoundException("Médico requisitado não existe");
    //     }
    //     $this->validate($request, [
    //         // 'id' => 'required'
    //     ]);
    //     $medico->fill($request->all());
    //     $medico->save();
    //     return son_response()->make($medico, 200);
    // }

    // public function destroy($id) {
    //     if(!($medico = Medico::find($id))){
    //         throw new ModelNotFoundException("Médico requisitado não existe");
    //     }
    //     $medico->delete();
    //     return son_response()->make("", 204);
    // }

    protected function getXML($data) {
        if ($data instanceof Arrayable){
            $data = $data->toArray();
        }
        $config = new Config(['result' => $data], true);
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }

}
