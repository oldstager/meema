<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notulensi;

class StafController extends Controller {

	public function __construct() {
		$this->middleware('auth');    
		$this->middleware('staf');
	}

	public function index() {

		$notulensis = Notulensi::with('prodi')
			->with('ruangan')
			->with('user')
			->with('rapat')
			->get();
		return view('stafHome', ['notulensis' => $notulensis]);

	}

	public function showPaginate() {

		$notulensis = Notulensi::with('prodi')
			->with('ruangan')
			->with('user')
			->with('rapat')
			->paginate(2);
		return view('stafShowPaginate', ['notulensis' => $notulensis]);

	}

	public function printDaftar() {

		$notulensis = Notulensi::with('prodi')
			->with('ruangan')
			->with('user')
			->with('rapat')
			->get();
		return view('stafLaporanDaftarNotulensi', ['notulensis' => $notulensis]);

	}

}
