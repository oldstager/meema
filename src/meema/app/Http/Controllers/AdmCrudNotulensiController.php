<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notulensi;

class AdmCrudNotulensiController extends Controller {

	public function index() {

		$notulensis = Notulensi::with('prodi')
			->with('ruangan')
			->with('prodi')
			->with('user')
			->with('rapat')
			->get();
		return view('admCrudNotulensi', ['notulensis' => $notulensis]);

	}


}
