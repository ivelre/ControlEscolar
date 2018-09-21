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
		<div class="col s10 offset-s1">

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
	</div>

@endsection

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
	function sendFile(table){
		var data = new FormData();
		var imagefile = document.querySelector('#file');
		data.append("model", table);
		data.append("excel", imagefile.files[0]);
		data.append("_token", '{{ csrf_token() }}');
		axios.post('{{ route('excel.import') }}',data, {headers: {'Content-Type': 'multipart/form-data'}})
    .then(function (response) {
        console.log(response);
    })
    .catch(function (response) {
        console.log(response.response);
    });
	}

	function retrieveFile(model) {
		const url = '{{ route('excel.export') }}'
		window.location = url + '?model=' + model
	}
</script>
@endsection