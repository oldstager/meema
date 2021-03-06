<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notulensi;
use App\User;
use App\Rapat;

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

	public function cetak($id_notulensi) {

		$notulensi = Notulensi::with('prodi')
			->with('ruangan')
			->with('user')
			->with('rapat')
			->find($id_notulensi);;
		return view('stafCetakNotulensi', ['notulensi' => $notulensi]);

	}

	public function cari() {

		$users = User::all();
		$rapats = Rapat::all();
		
		return view('stafCariNotulensi')->with(compact('users', 'rapats'));

	}



	public function cariNidn(Request $request) {

	    	$this->validate($request,[
    			'nidn' => ['required', 'string', 'max:50'],
	    	]);

		$notulensis = Notulensi::where('nidn', $request->nidn)->get();

		return view('stafHasilCari', ['notulensis' => $notulensis]);

	}


	public function cariTanggalRapat(Request $request) {

	    	$this->validate($request,[
    			'tanggal_rapat_awal' => ['required', 'date'],
    			'tanggal_rapat_akhir' => ['required', 'date'],
	    	]);

		$notulensis = Notulensi::whereBetween('tanggal_rapat', [$request->tanggal_rapat_awal, $request->tanggal_rapat_akhir])->get();

		return view('stafHasilCari', ['notulensis' => $notulensis]);

	}

	public function cariKodeRapat(Request $request) {

	    	$this->validate($request,[
    			'kode_rapat' => ['required', 'string', 'max:10'],
	    	]);

		$notulensis = Notulensi::where('kode_rapat', $request->kode_rapat)->get();

		return view('stafHasilCari', ['notulensis' => $notulensis]);

	}


}
