<?php

namespace App\Services;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\ModalidadEstudiante;
use App\Models\EstadoEstudiante;
use App\Models\Asignatura;
use App\Models\NivelAcademico;
use App\Models\TipoPlanEspecialidad;
use App\Models\Especialidad;
use App\Models\Oportunidad;
use App\Models\TipoExamen;
use App\Models\Titulo;
use App\Models\Estudiante;
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
        }
    }
}