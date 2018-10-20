<?php

namespace App\Services\Excel;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\ModalidadEstudiante;
use App\Models\EstadoCivil;
use App\Models\EstadoEstudiante;
use App\Models\Asignatura;
use App\Models\NivelAcademico;
use App\Models\TipoPlanEspecialidad;
use App\Models\Especialidad;
use App\Models\Oportunidad;
use App\Models\TipoExamen;
use App\Models\Titulo;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\Periodo;

class FastExcelExporter
{
    public function export(string $model)
    {
        switch($model){
            case 'titulos':                     return (new FastExcel(Titulo::all()))->download($model.'.xlsx');

            case 'tiposPlanesEspecialidades':   return (new FastExcel(TipoPlanEspecialidad::all()))->download($model.'.xlsx');

            case 'tiposExamenes':               return (new FastExcel(TipoExamen::all()))->download($model.'.xlsx');

            case 'oportunidades':               return (new FastExcel(Oportunidad::all()))->download($model.'.xlsx');

            case 'nivelesAcademicos':           return (new FastExcel(NivelAcademico::all()))->download($model.'.xlsx');

            case 'modalidadesEstudiantes':      return (new FastExcel(ModalidadEstudiante::all()))->download($model.'.xlsx');

            case 'estadosEstudiantes':          return (new FastExcel(EstadoEstudiante::all()))->download($model.'.xlsx');

            case 'asignaturas':                 return (new FastExcel(Asignatura::all()))->download($model.'.xlsx');

            case 'especialidades':              return (new FastExcel(Especialidad::all()))->download($model.'.xlsx');

            case 'estudiantes':                 return (new FastExcel(Estudiante::all()))->download($model.'.xlsx');

            case 'periodos':                    return (new FastExcel(Periodo::all()))->download($model.'.xlsx');

            case 'estadosCiviles':             return (new FastExcel(EstadoCivil::all()))->download($model.'.xlsx');

            case 'docentes':
            return (new FastExcel(Docente::with(['dato_general', 'usuario'])->get()))->download("$model.xlsx", function ($docente) {
                return [
                    'id' => $docente->id,
                    'codigo' => $docente->codigo,
                    'rfc' => $docente->rfc,
                    'titulo_id' => $docente->titulo_id,

                    'curp' => $docente->dato_general->curp,
                    'nombre' => $docente->dato_general->nombre,
                    'apaterno' => $docente->dato_general->apaterno,
                    'amaterno' => $docente->dato_general->amaterno,
                    'fecha_nacimiento' => $docente->dato_general->fecha_nacimiento,
                    'calle_numero' => $docente->dato_general->calle_numero,
                    'colonia' => $docente->dato_general->colonia,
                    'codigo_postal' => $docente->dato_general->codigo_postal,
                    'localidad_id' => $docente->dato_general->localidad_id,
                    'telefono_casa' => $docente->dato_general->telefono_casa,
                    'telefono_personal' => $docente->dato_general->telefono_personal,
                    'estado_civil_id' => $docente->dato_general->estado_civil_id,
                    'sexo' => $docente->dato_general->sexo,
                    'fecha_registro' => $docente->dato_general->fecha_registro,
                    'nacionalidad_id' => $docente->dato_general->nacionalidad_id,

                    'email' => $docente->usuario->email,
                    'password' => $docente->usuario->password,
                ];
            });            
        }
    }
}