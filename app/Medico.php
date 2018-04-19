<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model {

    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'especialidade_id', 'turno'
    ];

    public function especialidades() {
        return $this->belongsTo('App\Especialidade');
    }

    
}