<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';
    
    protected $fillable = [
    	'anios','periodo','reconocimiento_oficial','dges','fecha_reconocimiento'
    ];

    public $timestamps = false;

    public function clases(){
    	return $this->hasMany('App\Models\Clase','periodo_id');
    }

    public function estudiantes(){
    	return $this->hasMany('App\Models\Estudiante','periodo_id');
    }

    public function fechas_examenes(){
    	return $this->hasMany('App\Models\FechaExamen','periodo_id');
    }

    public function kardexs(){
        return $this->hasMany('App\Models\Kardex','periodo_id');
    }
}
