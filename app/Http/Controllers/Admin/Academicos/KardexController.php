<?php

namespace App\Http\Controllers\Admin\Academicos;

use App\Models\Kardex;
use App\Models\Estudiante;
use App\Models\Reticula;
use App\Models\Periodo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Kardex\IndexRequest;

class KardexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $estudiante = Estudiante::find($request->estudiante);
        return view('private.admin.academicos.kardex.index',[
            'estudiante' => $estudiante
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('private.admin.academicos.kardex.cargarCalificaciones',['estudiantes' => Estudiante::all(),'periodos' => Periodo::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        foreach ($input as $key => $calificacion) {
            $kardex = Kardex::where('estudiante_id',$calificacion['estudiante_id'])->where('asignatura_id',$calificacion['asignatura_id'])->first();
            if(!$kardex)
                $kardex = new Kardex;

            $kardex -> estudiante_id = $calificacion['estudiante_id'];
            $kardex -> asignatura_id = $calificacion['asignatura_id'];
            $kardex -> oportunidad_id = $calificacion['oportunidad_id'];
            $kardex -> semestre = $calificacion['semestre'];
            $kardex -> periodo_id = $calificacion['periodo_id'];
            $kardex -> calificacion = $calificacion['calificacion'];

            $kardex -> save();
        }
        return 'Terminado';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function show($kardex)
    {
        return response()->json(Estudiante::
            select('estudiantes.id as estudiante_id','matricula','nombre','apaterno','amaterno','semestre','estado_estudiante','especialidad','plan_especialidad_id')
            ->join('datos_generales','datos_generales.id','estudiantes.dato_general_id')->join('estados_estudiantes','estados_estudiantes.id','estudiantes.estado_estudiante_id')->join('especialidades','especialidades.id','estudiantes.especialidad_id')->where('matricula',$kardex)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function getCalificaciones($estudiante_id)
    {
        return response()->json(Reticula::join('asignaturas','asignaturas.id','reticulas.asignatura_id')
            ->join('kardexs','kardexs.asignatura_id','asignaturas.id')
            ->where('estudiante_id',$estudiante_id)
            ->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function getReticulaPlan($plan_especialidad_id)
    {
        return response()->json(Reticula::join('asignaturas','asignaturas.id','reticulas.asignatura_id')
            //->join('kardexs','kardexs.asignatura_id','asignaturas.id')
            ->where('plan_especialidad_id',$plan_especialidad_id)
            //->where('estudiante_id',$estudiante_id)
            ->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function edit(Kardex $kardex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kardex $kardex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kardex $kardex)
    {
        //
    }
}
