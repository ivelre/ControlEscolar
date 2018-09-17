<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Clase;
use App\Models\Kardex;

class ExcelController extends Controller
{
	public function index(){
		return view('private.admin.excel.index'):
	}
}
