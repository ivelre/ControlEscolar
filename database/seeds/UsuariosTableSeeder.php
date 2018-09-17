<?php

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\PlanEspecialidad;
class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(App\Models\Usuario::class,150)->create()->each(function(App\Models\Usuario $usuario){
            if($usuario->rol_id == 2){
                $especialidad_id        = rand(1,18);
                $planes_especialidades  = PlanEspecialidad::where('especialidad_id',$especialidad_id)->get();
                $plan_especialidad_id   = rand(1,count($planes_especialidades));

                factory(App\Models\Estudiante::class,1)->create([
                    'dato_general_id'       => $usuario->id,
                    'especialidad_id'       => $especialidad_id,
                    'usuario_id'            => $usuario->id,
                    'plan_especialidad_id'  => $plan_especialidad_id
                ]);
            }
            if($usuario->rol_id == 3){
                factory(App\Models\Docente::class,1)->create([
                    'dato_general_id'   => $usuario->id,
                    'usuario_id'        => $usuario->id
                ]);
            }
        });

        Usuario::create([
        	'email'    => 'admin@appsamx.com',
        	'password' => bcrypt('Appsa2016'),
            'rol_id'   => 1
        ]);
    }
}
