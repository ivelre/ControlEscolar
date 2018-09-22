<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use \Illuminate\Http\UploadedFile;
class ExcelImporterTest extends TestCase
{
    use RefreshDatabase;
    private $filePath = __DIR__.'/../files/';

    private function import($file, $model) {
        $user = factory(\App\Models\Usuario::class)->create();
        $file = new UploadedFile($this->filePath.$file, true);
        
        $response = $this->withSession(['usuario' => $user])
                        ->post('admin/excel/import?model='.$model, ['excel' => $file]);

        return $response;
    }

    public function testImportTitulos()
    {
        $response = $this->import('titulos.xlsx', 'titulos');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 4
        ]);

        $this->assertDatabaseHas('titulos',['titulo' => 'SIN TITULO']);
        $this->assertDatabaseHas('titulos',['titulo' => 'LICENCIATURA']);
        $this->assertDatabaseHas('titulos',['titulo' => 'MAESTRIA']);
        $this->assertDatabaseHas('titulos',['titulo' => 'DOCTORADO']);
    }

    public function testImportOportunidades()
    {
        $response = $this->import('oportunidades.xlsx', 'oportunidades');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 5
        ]);
        
        $this->assertDatabaseHas('oportunidades',[
            'oportunidad' => 'Normal',
            'oportunidad' => 'Repetición',
            'oportunidad' => 'Especial',
            'oportunidad' => 'Ninguna',
            'oportunidad' => 'N/A',
        ]);
    }

    public function testImportTiposPlanesEspecialidades()
    {
        $response = $this->import('tiposPlanesEspecialidades.xlsx', 'tiposPlanesEspecialidades');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 5
        ]);

        $this->assertDatabaseHas('tipos_planes_especialidades',['tipo_plan_especialidad' => 'Bimestral']);
        $this->assertDatabaseHas('tipos_planes_especialidades',['tipo_plan_especialidad' => 'Trimestral']);
        $this->assertDatabaseHas('tipos_planes_especialidades',['tipo_plan_especialidad' => 'Cuatrimestral']);
        $this->assertDatabaseHas('tipos_planes_especialidades',['tipo_plan_especialidad' => 'Anual']);
    }

    public function testImportNivelesAcademicos()
    {
        $response = $this->import('nivelesAcademicos.xlsx', 'nivelesAcademicos');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 4
        ]);

        $this->assertDatabaseHas('niveles_academicos',['nivel_academico' => 'Licenciatura']);
        $this->assertDatabaseHas('niveles_academicos',['nivel_academico' => 'Maestría']);
        $this->assertDatabaseHas('niveles_academicos',['nivel_academico' => 'Doctorado']);
        $this->assertDatabaseHas('niveles_academicos',['nivel_academico' => 'Tecnico']);
    }

    public function testImportEstadosEstudiantes()
    {
        $response = $this->import('estadosEstudiantes.xlsx', 'estadosEstudiantes');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 5
        ]);
        $this->assertDatabaseHas('estados_estudiantes',['estado_estudiante' => 'Egresado']);
        $this->assertDatabaseHas('estados_estudiantes',['estado_estudiante' => 'Inscrito']);
        $this->assertDatabaseHas('estados_estudiantes',['estado_estudiante' => 'Reinscrito']);
        $this->assertDatabaseHas('estados_estudiantes',['estado_estudiante' => 'Baja definitiva']);
        $this->assertDatabaseHas('estados_estudiantes',['estado_estudiante' => 'Adeudo']);
    }

    public function testImportTiposExamenes()
    {
        $response = $this->import('tiposExamenes.xlsx', 'tiposExamenes');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 4
        ]);

        $this->assertDatabaseHas('tipos_examenes',['tipo_examen' => 'Ordinario']);
        $this->assertDatabaseHas('tipos_examenes',['tipo_examen' => 'Extraordinario']);
        $this->assertDatabaseHas('tipos_examenes',['tipo_examen' => 'Especial']);
        $this->assertDatabaseHas('tipos_examenes',['tipo_examen' => 'Ordinario LC31']);
    }

    public function testImportModalidadesEstudiantes()
    {
        $response = $this->import('modalidadesEstudiantes.xlsx', 'modalidadesEstudiantes');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 8
        ]);

        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'SABATINO']);
        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'MATUTINO']);
        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'MIXTO']);
        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'SABATINO']);
        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'JUEVES']);
        $this->assertDatabaseHas('modalidades_estudiantes',['modalidad_estudiante' => 'VIERNES']);
    }

    public function testImportAsignaturas()
    {
        $response = $this->import('asignaturas.xlsx', 'asignaturas');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 1200
        ]);

        $this->assertDatabaseHas('asignaturas',[
            'codigo' => 'LC30417',
            'asignatura' => 'Costos Históricos',
            'creditos' => 8
        ]);

        $this->assertDatabaseHas('asignaturas',[
            'codigo' => 'MA0309',
            'asignatura' => 'DESARROLLO ORGANIZACIONAL',
            'creditos' => 0
        ]);
    }

    public function testImportEspecialidades()
    {
        $this->seed('NivelesAcademicosTableSeeder');
        $this->seed('TiposPlanesEspecialidadesTableSeeder');
        $this->seed('ModalidadesEspecialidadesTableSeeder');

        $response = $this->import('especialidades.xlsx', 'especialidades');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 40
        ]);
        
        $this->assertDatabaseHas('especialidades',['clave' => 'LD', 'modalidad_id' => 1]);
        $this->assertDatabaseHas('especialidades',['clave' => 'MC','modalidad_id' => 1]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LPE', 'modalidad_id' => 1, 'nivel_academico_id' => 3]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LAN', 'modalidad_id' => 2]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LN2', 'modalidad_id' => 2]);
        $this->assertDatabaseHas('especialidades',['clave' => 'MAA', 'modalidad_id' => 1]);

        $this->assertDatabaseHas('especialidades',['clave' => 'LF', 'tipo_plan_especialidad_id' => 3]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LPN', 'tipo_plan_especialidad_id' => 2, 'nivel_academico_id' => 2]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LII', 'tipo_plan_especialidad_id' => 1]);

        $this->assertDatabaseHas('especialidades',['clave' => 'LC', 'nivel_academico_id' => 1]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LP', 'nivel_academico_id' => 2]);
        $this->assertDatabaseHas('especialidades',['clave' => 'LD3', 'nivel_academico_id' => 1]);
    }

    public function testImportEspecialidadeseError()
    {
        $this->seed('NivelesAcademicosTableSeeder');
        $this->seed('TiposPlanesEspecialidadesTableSeeder');
        $this->seed('ModalidadesEspecialidadesTableSeeder');

        $response = $this->import('especialidades_error.xlsx', 'especialidades');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 5,
            'imported' => 5
        ]);
    }

    /**
     * Remove the leading dash to test it.
     * Warning: It will take too much time.
     */
    public function _testImportEspecialidadeseLarge()
    {
        $this->seed('NivelesAcademicosTableSeeder');
        $this->seed('TiposPlanesEspecialidadesTableSeeder');
        $this->seed('ModalidadesEspecialidadesTableSeeder');

        $response = $this->import('especialidades_large.xlsx', 'especialidades');
        $response->assertOk();
        $response->assertJsonFragment([
            'errorCount' => 0,
            'imported' => 21160
        ]);        
    }
}