<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StafController extends Controller {

	public function __construct() {
		$this->middleware('auth');    
		$this->middleware('staf');
	}

	public function index() {
		return view('stafHome');
	}

}
