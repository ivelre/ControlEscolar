<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table = 'kardexs';
    
    protected $fillable = [
    	'estudiante_id','asignatura_id','oportunidad_id','semestre','periodo_id','calificacion'
    ];

    public $timestamps = false;

    public function estudiante(){
    	return $this->belongsTo('App\Models\Estudiante','estudiante_id');
    }

    public function asignatura(){
    	return $this->belongsTo('App\Models\Asignatura','asignatura_id');
    }

    public function oportunidad(){
    	return $this->belongsTo('App\Models\Oportunidad','oportunidad_id');
    }

    public function periodo(){
    	return $this->belongsTo('App\Models\Periodo','periodo_id');
    }

    static function getCalificacionAlumno($asignatura_id,$estudiante_id){
        return \DB::table('kardexs')
                ->where('asignatura_id',$asignatura_id)
                ->where('estudiante_id',$estudiante_id)
                ->first();
    }
}
