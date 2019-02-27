<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruangan;

class AdmCrudRuanganController extends Controller {

	public function __construct() {

		$this->middleware('auth');
		$this->middleware('admin');

	}

	public function index() {

	    	$ruangans = Ruangan::all();
		return view('admCrudRuangan', ['ruangans' => $ruangans]);

	}

	public function tambah() {

		return view('admCrudRuanganTambah');

	}

	public function simpan(Request $request) {

	    	$this->validate($request,[
    			'kode_ruangan' => ['required', 'string', 'max:10'],
    			'nama_ruangan' => ['required', 'string', 'max:50']
	    	]);
 
	        Ruangan::create([
    			'kode_ruangan' => $request->kode_ruangan,
    			'nama_ruangan' => $request->nama_ruangan
	    	]);
 
	    	return redirect('/admin/ruangan');

	}

	public function edit($kode_ruangan) {
	     
		$ruangan = Ruangan::find($kode_ruangan);
		return view('admCrudRuanganEdit', ['ruangan' => $ruangan]);

	}


	public function update($kode_ruangan, Request $request) {

 	    	$this->validate($request,[
    			'kode_ruangan' => ['required', 'string', 'max:10'],
    			'nama_ruangan' => ['required', 'string', 'max:50']
	    	]);
 
		$ruangan = Ruangan::find($kode_ruangan);
		$ruangan->kode_ruangan = $request->kode_ruangan;
		$ruangan->nama_ruangan = $request->nama_ruangan;
		$ruangan->save();

		return redirect('/admin/ruangan');

	}

	public function hapus($kode_ruangan) {

		$ruangan = Ruangan::find($kode_ruangan);
		$ruangan->delete();

		return redirect('/admin/ruangan');
	
	}

	public function showPaginate() {

		$ruangans = Ruangan::paginate(2);
		return view('admCrudRuanganShowPaginate', ['ruangans' => $ruangans]);

	}
	
}
