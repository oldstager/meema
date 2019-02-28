<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notulensi;

use App\Prodi;
use App\User;
use App\Ruangan;
use App\Rapat;

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

	public function tambah() {

		$prodis = Prodi::all();
		$users = User::all();
		$ruangans = Ruangan::all();
		$rapats = Rapat::all();
		
		return view('admCrudNotulensiTambah')->with(compact('prodis', 'users', 'ruangans', 'rapats'));

	}


}
