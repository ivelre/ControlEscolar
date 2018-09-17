@extends('private.admin.layouts.scaffold')

@section('title')
	Cargar calificaciones
@endsection

@section('content')

	<div class="row" id="v-app">
		<div class="col s10 offset-s1">

			<div class="section">
		  	<h4>Carga de calificaciones</h4>
		  	<div class="divider"></div>
			</div>
			<h5><a class="valign-wrapper" href="{{route('estudiantes.index')}}"><i class="material-icons">arrow_back</i> Regresar</a></h5>
			<br>

            <div class="row">
                <div class="col s12">
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix">textsms</i>
                      <input type="text" id="autocomplete-input" class="autocomplete">
                      <label for="autocomplete-input">Autocomplete</label>
                    </div>
                  </div>
                </div>
              </div>
	
			<div class="section">
				<p>No. de Matrícula: @{{ estudiante.matricula }}</p>
        <p>Semestre: @{{ estudiante.semestre }}</p>
        <p>Nombre: @{{ estudiante.nombre }} @{{ estudiante.apaterno }} @{{ estudiante.amaterno }}</p>
				<p>Estado: @{{ estudiante.estado_estudiante }}</p>
				<p>Especialida: @{{ estudiante.especialidad }}</p>
			</div>

			<table id="table_kardex" class="display highlight" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Semestre</th>
                <th>Asignatura</th>
                <th>Periodo</th>
                <th>Cafilicación</th>
                {{-- <th>créditos</th> --}}
            </tr>
        </thead>
        <tfoot>
            <tr v-for="asignatura in reticula">
                <td>@{{asignatura.codigo}}</td>
                <td>@{{asignatura.semestre}}</td>
                <td>@{{asignatura.asignatura}}</td>
                <td><select :id="'periodo_' + asignatura.asignatura_id">
                  @foreach ($periodos as $periodo)
                    <option value="{{$periodo -> id}}">{{$periodo -> periodo}}</option>
                  @endforeach
                </select></td>
                <td><input type="number" min="0" max="10" :value="asignatura.calificacion" :id="'calificacion_' + asignatura.asignatura_id"></td>
                {{-- <td>@{{asignatura.creditos}}</td> --}}
            </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
    <br>
    <button onclick="saveKardex()" class="waves-effect waves-light btn blue"><i class="material-icons left">send</i>Guardar</button>
		</div>
	</div>
@endsection

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
	<script type="text/javascript">
    var app = new Vue({
      el: '#v-app',
      data: {
        estudiante: {},
        reticula: {}
      }
    })
    var data = {}
    @foreach ($estudiantes as $estudiante)
        data['{{$estudiante -> matricula}}'] = null
    @endforeach
    $(document).ready(function(){
     $('input.autocomplete').autocomplete({
            data: data,
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(val) {
              // Callback function when value is autcompleted.
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
          });
     $('input.autocomplete').change(function(event) {
       //app.getEstudiante($('input.autocomplete').val())
       axios.get('/controlescolar/admin/academicos/kardex/' + $('input.autocomplete').val()).then(function (response) {
          app.estudiante = response.data
          app.$forceUpdate()
          axios.get('/controlescolar/admin/academicos/kardex/reticula/' + app.estudiante.plan_especialidad_id).then(function (response) {
            app.reticula = response.data
            app.$forceUpdate()
            $('select').material_select();
              axios.get('/controlescolar/admin/academicos/kardex/calificaciones/' + app.estudiante.estudiante_id).then(function (response) {
              for(i = 0; i < response.data.length; i++){
                $('#calificacion_' + response.data[i].asignatura_id).val(response.data[i].calificacion)
              }
            })
          })
        })
     });
    })

    function saveKardex(){
      if(app.reticula.length){
        var calificaciones = []
        msg = false
        for(i = 0; i < app.reticula.length; i++){
          calificaciones[i] = {}
          if(!$('#calificacion_' + app.reticula[i].asignatura_id).val())
            msg = true
          calificaciones[i].estudiante_id = app.estudiante.estudiante_id
          calificaciones[i].asignatura_id = app.reticula[i].asignatura_id
          calificaciones[i].oportunidad_id = 4
          calificaciones[i].semestre = null
          calificaciones[i].periodo_id = $('#periodo_' + app.reticula[i].asignatura_id).val()
          calificaciones[i].calificacion = $('#calificacion_' + app.reticula[i].asignatura_id).val()
        }
        if(msg)
          alert('Faltan calificaciones por cargar.')
        else{
          axios.post('/controlescolar/admin/academicos/kardex',calificaciones).then(function (response) {
            alert(response.data)
          })
        }
      }else{
        alert('Seleccione un alumno para continuar.')
      }
    }
  </script>
@endsection
