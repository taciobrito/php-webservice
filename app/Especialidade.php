<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model {

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'especialidade', 'descricao',
    ];

    public function medico() {
        return $this->hasMany('App\Medico');
    }

    
}
