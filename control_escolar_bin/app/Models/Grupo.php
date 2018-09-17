<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    
    protected $fillable = [
    	'clase_id','estudiante_id','oportunidad_id'
    ];

    public $timestamps = false;

    public function clase(){
    	return $this->belongsTo('App\Models\Clase','clase_id');
    }

    public function estudiante(){
    	return $this->belongsTo('App\Models\Estudiante','estudiante_id');
    }

    public function oportunidad(){
    	return $this->belongsTo('App\Models\Oportunidad','oportunidad_id');
    }

    static function getAlumosGrupo($clase_id){
        return \DB::table('grupos')
            ->select('matricula','nombre','apaterno','amaterno','calificacion','estudiante_id')
            ->join('estudiantes','estudiantes.id','grupos.estudiante_id')
            ->join('datos_generales','datos_generales.id','estudiantes.dato_general_id')
            ->where('grupos.clase_id', $clase_id)
            ->get();
    }
}
