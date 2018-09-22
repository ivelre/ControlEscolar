@extends('private.admin.layouts.scaffold')

@section('title')
	UNICEBA - Estudiantes
@endsection

@section('content')
	<div class="row">
		<div class="row blue hide-on-small-only">
			<nav> 
		    <div class="nav-wrapper blue">
		      <div class="col s11 offset-s1">
		        <a href="{{route('admin.menu')}}" class="breadcrumb">Menú</a>
		        <a href="{{route('excel')}}" class="breadcrumb">Importar - Exportar</a>
		      </div>
		    </div>
		  </nav>
		</div>

		<div class="row blue white-text">
			<div class="hide-on-med-and-up">
				<br>
			</div>
			<div class="col s10 offset-s1">
					<h5>Importar / exportar</h5>				
			</div>
			<div class="col s10 offset-s1 m5 offset-m1">
					<p>Importación y exportación de información</p>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col s4 offset-s1">

			<div class="section" id="academicos">
				<h5>Académicos</h5>
			</div>
			<div class="divider"></div>

			<div class="section" id="academicos">
				<h5>Escolares</h5>
				<p>Asignaturas 
					<i class="material-icons pointer" onclick="sendFile('asignaturas')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('asignaturas')">arrow_downward</i>
				</p>
				<p>Especialidades 
					<i class="material-icons pointer" onclick="sendFile('especialidades')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('especialidades')">arrow_downward</i>
				</p>
				<p>Planes especialidad
					<i class="material-icons pointer" onclick="sendFile(9)">arrow_upward</i>
					<i class="material-icons pointer">arrow_downward</i>
				</p>
			</div>
			<div class="divider"></div>

			<div class="section" id="academicos">
				<h5>Configuración</h5>
				<p>Estados de estudiante 
					<i class="material-icons pointer" onclick="sendFile('estadosEstudiantes')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('estadosEstudiantes')">arrow_downward</i>
				</p>
				<p>Títulos de profesor 
					<i class="material-icons pointer" onclick="sendFile('titulos')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('titulos')">arrow_downward</i>
				</p>
				<p>Tipos de exámenes 
					<i class="material-icons pointer" onclick="sendFile('tiposExamenes')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('tiposExamenes')">arrow_downward</i>
				</p>
				<p>Oportunidades de clase 
					<i class="material-icons pointer" onclick="sendFile('oportunidades')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('oportunidades')">arrow_downward</i>
				</p>
				<p>Niveles y grados 
					<i class="material-icons pointer" onclick="sendFile('nivelesAcademicos')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('nivelesAcademicos')">arrow_downward</i>
				</p>
				<p>Modalidad estudiantes 
					<i class="material-icons pointer" onclick="sendFile('modalidadesEstudiantes')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('modalidadesEstudiantes')">arrow_downward</i>
				</p>
				<p>Tipos plan especialidad 
					<i class="material-icons pointer" onclick="sendFile('tiposPlanesEspecialidades')">arrow_upward</i>
					<i class="material-icons pointer" onclick="retrieveFile('tiposPlanesEspecialidades')">arrow_downward</i>
				</p>
			</div>
			<form action="#">
		    <div class="file-field input-field">
		      <div class="btn">
		        <span>File</span>
		        <input type="file" id="file" accept=".xlsx, .xls, .csv"
						>
		      </div>
		      <div class="file-path-wrapper">
		        <input class="file-path validate" type="text" >
		      </div>
		    </div>
		  </form>
			<div class="divider"></div>

		</div>
		<div id="results" class="col s5">
			<div v-if="show">
				<div class="card-panel teal lighten-2">
					<b class="white-text">Importados: @{{ imported }}</b>
				</div>
				<div class="card-panel red darken-4">
					<b class="white-text">Errores: @{{ errorCount }}</b>
				</div>
				<div v-if="errors.length > 50"class="card-panel yellow darken-3">
					<b class="white-text">
						Al parecer hubo varios errores dentro del archivo. 
						Abre la consola (F12) para ver una lista detallada de todos ellos.
					</b>
				</div>
				<table v-if="errors.length" class="striped">
					<thead>
						<tr>
							<th>Fila #</th>
							<th>Mensaje</th>
						</tr>
					</thead>

					<tbody>
						<tr v-for="error in errors.slice(0,51)">
							<td>@{{ error.row }}</td>
							<td>@{{ error.message }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div v-if="loading" class="progress">
      			<div class="indeterminate"></div>
  			</div>
		</div>
	</div>

@endsection

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script>
let vue = new Vue({
	el: '#results',
	data: {
		errors:[],
		imported: 0,
		errorCount: 0,
		show: false,
		loading: false
	}
})
</script>
<script>
	function sendFile(table){
		if(vue.loading){
			Materialize.toast('Espera a que la solicitud actual termine', 4000)
			return
		}
		vue.show = false
		vue.loading = true
		var data = new FormData();
		var imagefile = document.querySelector('#file');
		data.append("model", table);
		data.append("excel", imagefile.files[0]);
		data.append("_token", '{{ csrf_token() }}');
		
		axios.post('{{ route('excel.import') }}', data, {
			headers: {'Content-Type': 'multipart/form-data'},
			onUploadProgress: progressEvent => console.log(progressEvent.loaded)
		})
		.then(res => {
			console.log(res.data)
			vue.show = true
			vue.loading = false
			vue.imported = res.data.imported
			vue.errorCount = res.data.errorCount
			vue.errors = res.data.errors
		})
		.catch(err => {
			console.log(err.response)
			vue.show = true
			vue.loading = false
		});
	}

	function retrieveFile(model) {
		const url = '{{ route('excel.export') }}'
		window.location = url + '?model=' + model
	}
</script>
@endsection