@extends('private.admin.layouts.scaffold')

@section('title')
	UNICEBA - Clases
@endsection

@section('content')
	<div class="row">
		<div class="row blue hide-on-small-only">
			<nav> 
		    <div class="nav-wrapper blue">
		      <div class="col s11 offset-s1">
		        <a href="{{route('admin.menu')}}" class="breadcrumb">Menú</a>
		        <a href="{{route('admin.menu')}}#academicos" class="breadcrumb">Académicos</a>
		        <a href="{{route('docentes.index')}}" class="breadcrumb">Clases</a>
		      </div>
		    </div>
		  </nav>
		</div>

		<div class="row blue white-text">
			<div class="hide-on-med-and-up">
				<br>
			</div>
			<div class="col s10 offset-s1">
					<h5>Clases</h5>				
			</div>
			<div class="col s10 offset-s1 m5 offset-m1">
					<p>Lista de clases por periodo.</p>
			</div>
			<div class="col m5 right-align hide-on-small-only">
					<a id="create_clase" href="{{route('clases.create')}}" class="waves-effect waves-light btn center-align blue darken-2"><i class="material-icons left">add</i>Nueva clase</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col s10 offset-s1">
			<br>
			<div class="section">
				<div class="input-field col s12 l4">
					<i class="material-icons prefix">access_time</i>
					<select id="periodo_id">
						@foreach($periodos as $periodo)
							@if($loop->last)
								<option value="{{ $periodo->id }}" selected>{{ $periodo->periodo }} ({{ $periodo->anio }})</option>
							@else
								<option value="{{ $periodo->id }}">{{ $periodo->periodo }} ({{ $periodo->anio }})</option>
							@endif
						@endforeach
					</select>
					<label>Período</label>
				</div>
				<div class="input-field col s12 l4">
					<i class="material-icons prefix">school</i>
					<select id="nivel_academico_id">
						@foreach($niveles_academicos as $nivel_academico)
							@if($loop->first)
								<option value="{{ $nivel_academico->id }}" selected>{{ $nivel_academico->nivel_academico }}</option>
							@else
								<option value="{{ $nivel_academico->id }}">{{ $nivel_academico->nivel_academico }}</option>
							@endif
						@endforeach
					</select>
					<label>Nivel académico</label>
				</div>
				<div class="input-field col s12 l4">
					<i class="material-icons prefix">account_balance</i>
					<select id="especialidad_id">
					</select>
					<label>Especialidad</label>
				</div>
			</div>
			<br>
		</div>
	</div>
	
	<div class="row">
		<div class="col s10 offset-s1">
			<table id="table_clases" class="display highlight" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Código asignatura</th>
                <th>Nombre</th>
                <th>Asignatura</th>
                <th>Docente</th>
                <th>Grupo</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Código asignatura</th>
                <th>Nombre</th>
                <th>Asignatura</th>
                <th>Docente</th>
                <th>Grupo</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
		</div>
	</div>

	<div class="fixed-action-btn hide-on-med-and-up">
    <a href="{{route('clases.create')}}" class="btn-floating btn-large blue darken-2">
      <i class="large material-icons">add</i>
    </a>
  </div>

@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('js/admin/academicos/clases.js') }}"></script>
@endsection