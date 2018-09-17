<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    
    protected $fillable = [
        'dato_general_id','especialidad_id','estado_estudiante_id','matricula','semestre','grupo',',modalidad_id','medio_enterado_id','periodo_id','otros','usuario_id','plan_especialidad_id'
    ];

    public $timestamps = false;

    public function getSemestres() {
        $kardex = \DB::table('kardexs')
            ->select(
            'asignaturas.codigo',
            'asignaturas.asignatura',
            'kardexs.calificacion',
            'oportunidades.oportunidad',
            'reticulas.periodo_reticula',
            'periodos.periodo',
            'periodos.anio',
            'kardexs.estudiante_id'
            )
            ->join('asignaturas', 'asignaturas.id', '=', 'kardexs.asignatura_id')
            ->join('oportunidades', 'oportunidades.id', '=', 'kardexs.oportunidad_id')
            ->join('periodos', 'periodos.id', '=', 'kardexs.periodo_id')
            ->join('reticulas', 'reticulas.asignatura_id', '=', 'asignaturas.id')
            ->where('estudiante_id',$this->id)
            ->orderBy('periodo_reticula','asc')
            ->get();

        $semestres = [];
        foreach ($kardex as $k_item) {

            $materia = new \StdClass;
            $materia->clave = $k_item->codigo;
            $materia->nombre_asignatura = $k_item->asignatura;
            $materia->calificacion = (int)($k_item->calificacion);
            $materia->calificacion_letra = $this->num2let((int)($k_item->calificacion));
            $materia->observaciones = '';

            $materia->ciclo = $k_item -> periodo;
            // if(($k_item->periodo / 10) < 10) {
            //     $materia->ciclo = '0' . (int)($k_item->periodo / 10) . '/' . $k_item->periodo%10;
            // }else{
            //     $materia->ciclo = (int)($k_item->periodo / 10) . '/' . $k_item->periodo%10;
            // }

            $semestres[$this->nombreSemestre($k_item->periodo_reticula)][$k_item->codigo] = $materia;
        }

        return $semestres;
    }

    public function nombreSemestre($numero) {
        switch ($numero) {
            case 1: return 'Primer Semestre';
            case 2: return 'Segundo Semestre';
            case 3: return 'Tercer Semestre';
            case 4: return 'Cuarto Semestre';
            case 5: return 'Quinto Semestre';
            case 6: return 'Sexto Semestre';
            case 7: return 'Séptimo Semestre';
            case 8: return 'Octavo Semestre';
            case 9: return 'Noveno Semestre';
            case 10: return 'Décimo Semestre';
            default: return 'Semestre extra';
        }
    }

    public function num2let($numero) {
        switch ($numero) {
            case 1: return 'UNO';
            case 2: return 'DOS';
            case 3: return 'TRES';
            case 4: return 'CUATRO';
            case 5: return 'CINCO';
            case 6: return 'SEIS';
            case 7: return 'SIETE';
            case 8: return 'OCHO';
            case 9: return 'NUEVE';
            case 10: return 'DIEZ';
            default:
                return 'N/A';
        }
    }

    public function getDatosGenerales() {
        return $this->hasOne('\App\Models\DatoGeneral', 'id', 'dato_general_id');
    }

    public function getEspecialidad() {
        return $this->hasOne('\App\Models\Especialidad', 'id', 'especialidad_id');
    }

    // Relaciones
    public function empresa(){
        return $this->belongsToMany('App\Models\Empresa','estudiantes_trabajos','estudiante_id','empresa_id')
            ->withPivot('puesto');
    }

    public function documento_estudiante(){
    	return $this->belongsToMany('App\Models\TipoDocumentoEstudiante','documentos_estudiantes','estudiante_id','tipo_documento_id')
            ->withPivot('documento');
    }

    public function instituto_procedencia(){
        return $this->belongsToMany('App\Models\InstitutoProcedencia','procedencias_estudiantes','estudiante_id','instituto_id');
    }

    public function equivalencias(){
        return $this->hasMany('App\Models\Equivalencia','estudiante_id');
    }

    public function titulaciones(){
    	return $this->hasMany('App\Models\Titulacion','estudiante_id');
    }

    public function grupos(){
    	return $this->hasMany('App\Models\Grupo','estudiante_id');
    }

    public function kardexs(){
        return $this->hasMany('App\Models\Kardex','estudiante_id');
    }

    public function dato_general(){
    	return $this->belongsTo('App\Models\DatoGeneral','dato_general_id');
    }

	public function especialidad(){
    	return $this->belongsTo('App\Models\Especialidad','especialidad_id');
    }

    public function estado_estudiante(){
    	return $this->belongsTo('App\Models\EstadoEstudiante','estado_estudiante_id');
    }

    public function modalidad(){
    	return $this->belongsTo('App\Models\ModalidadEstudiante','modalidad_id');
    }

    public function medio_enterado(){
    	return $this->belongsTo('App\Models\MedioEnterado','medio_enterado_id');
    }

    public function periodo(){
    	return $this->belongsTo('App\Models\Periodo','periodo_id');
    }

    public function usuario(){
    	return $this->belongsTo('App\Models\Usuario','usuario_id');
    }

    public function plan_especialidad(){
        return $this->belongsTo('App\Models\PlanEspecialidad','plan_especialidad_id');
    }    

}
