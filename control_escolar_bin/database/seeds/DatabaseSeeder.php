<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(NacionalidadesTableSeeder::class);
        
        /*$this->call(RolesUsuariosTableSeeder::class);
        $this->call(TiposDocumentosEstudiantesTableSeeder::class);
        $this->call(EstadosEstudiantesTableSeeder::class);
        $this->call(EstadosCivilesTableSeeder::class);
        $this->call(InstitutosProcedenciasTableSeeder::class);
        $this->call(MediosEnteradosTableSeeder::class);
        $this->call(ModalidadesEspecialidadesTableSeeder::class);
        $this->call(ModalidadesEstudiantesTableSeeder::class);
        
        $this->call(NivelesAcademicosTableSeeder::class);
        $this->call(TiposPlanesEspecialidadesTableSeeder::class);
        //$this->call(TiposPlanesReticulasTableSeeder::class);
        $this->call(EspecialidadesTableSeeder::class);
        $this->call(PlanesEspecialidadesTableSeeder::class);
        $this->call(EstadosTitulacionesTableSeeder::class);
        $this->call(DatosGeneralesTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);
        $this->call(TitulosTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(EmpresasTableSeeder::class);
        $this->call(EstudiantesTrabajosTableSeeder::class);
        $this->call(EstudiantesInstitutosTableSeeder::class);
        $this->call(AsignaturasTableSeeder::class);
        $this->call(ReticulasTableSeeder::class);
        $this->call(TiposExamenesTableSeeder::class);
        $this->call(FechasExamenesTableSeeder::class);
        $this->call(RequisitosReticulasTableSeeder::class);
        $this->call(ClasesTableSeeder::class);
        $this->call(DiasTableSeeder::class);
        $this->call(OportunidadesTableSeeder::class);
        $this->call(GruposKardexTableSeeder::class);*/
    }
}
