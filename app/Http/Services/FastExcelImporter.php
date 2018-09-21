<?php

namespace App\Services;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\ModalidadEstudiante;
use App\Models\NivelAcademico;
use App\Models\TipoPlanEspecialidad;
use App\Models\Especialidad;
use App\Models\Oportunidad;
use App\Models\TipoExamen;
use App\Models\Titulo;
use App\Models\EstadoEstudiante;
use App\Models\Asignatura;
class FastExcelImporter
{
    public function import(string $model, $file)
    {
        switch($model)
        {
            case 'titulos':                     return $this->importTitulos($file);

            case 'tiposPlanesEspecialidades':   return $this->importTiposPlanesEspecialidades($file);

            case 'tiposExamenes':               return $this->importTiposExamenes($file);

            case 'oportunidades':               return $this->importOportunidades($file);

            case 'nivelesAcademicos':           return $this->importNivelesAcademicos($file);

            case 'modalidadesEstudiantes':      return $this->importModalidadesEstudiantes($file);

            case 'estadosEstudiantes':          return $this->importEstadosEstudiantes($file);

            case 'asignaturas':                 return $this->importAsignaturas($file);

            case 'especialidades':              return $this->importEspecialidades($file);
        }
    }

    private function importTitulos($file)
    {
        return $this->importFromFile($file, ['titulo', new Optional('descripcion')], Titulo::class);
    }

    private function importTiposPlanesEspecialidades($file) 
    {
        return $this->importFromFile($file, ['tipo_plan_especialidad', new Optional('descripcion')], TipoPlanEspecialidad::class);
    }

    private function importTiposExamenes($file)
    {
        return $this->importFromFile($file, ['tipo_examen', new Optional('descripcion')], TipoExamen::class);
    }

    private function importOportunidades($file)
    {
        return $this->importFromFile($file, ['oportunidad', new Optional('descripcion')], Oportunidad::class);
    }

    private function importNivelesAcademicos($file)
    {
        return $this->importFromFile($file, ['nivel_academico', new Optional('descripcion')], NivelAcademico::class);
    }

    private function importModalidadesEstudiantes($file)
    {
        return $this->importFromFile($file, ['modalidad_estudiante', new Optional('descripcion')], ModalidadEstudiante::class);
    }

    private function importEstadosEstudiantes($file)
    {
        return $this->importFromFile($file, ['estado_estudiante', new Optional('descripcion')], EstadoEstudiante::class);
    }

    private function importAsignaturas($file) 
    {
        return $this->importFromFile($file, ['codigo', 'asignatura', 'creditos'], Asignatura::class);
    }

    private function importEspecialidades($file)
    {
        return $this->importFromFile($file, [
            'clave', 
            'especialidad',
            'reconocimiento_oficial',
            'dges',
            'fecha_reconocimiento',
            new Optional('descripcion'),
            new Foreign('modalidad_id', 'modalidad_estudiante', ModalidadEstudiante::class, true),
            new Foreign('nivel_academico_id', 'nivel_academico', NivelAcademico::class, true),
            new Foreign('tipo_plan_especialidad_id', 'tipo_plan_especialidad', TipoPlanEspecialidad::class, true),
        ], Especialidad::class);
    }

    /**
     * Helper functions to abstract generic functionality.
     */
    private function getDataFromRow(array $line, array $fields, array &$cache)
    {
        $data = [];
        foreach($fields as $item) {
            if(is_string($item)) {
                $data[$item] = $line[$item] !== '' ? $line[$item] : null;
            } else if($item instanceof Optional) {
                $data[$item->getKey()] = $item->getValue($line);
            } else if($item instanceof Foreign) {
                $data[$item->getKey()] = $item->getValue($line, $cache);
            }
        }

        return $data;
    }

    private function importFromFile($file, array $fields, $class)
    {
        $cache = $errors = [];
        $row = $imported = 0;
        (new FastExcel)->import($file, function ($line) use($fields, $class, &$row, &$imported, &$errors, &$cache) {
            $row += 1;
            
            # Ignore empty rows
            if(!array_filter($line)) return;

            # Transform the row into a dictionary
            $data = $this->getDataFromRow($line, $fields, $cache);
            
            try { 
                # Save the row in the database
                $class::create($data); 
                $imported += 1;
            }
            catch(\Illuminate\Database\QueryException $e){
                array_push($errors, 'Error de integridad en la fila #'.$row.'. '.
                                    'Verifique columnas obligatorias, valores repetidos y/o llaves fóraneas');
            }
        });

        return [
            'errorCount' => sizeof($errors), 
            'errors' => $errors, 
            'imported' => $imported
        ];
    }
}