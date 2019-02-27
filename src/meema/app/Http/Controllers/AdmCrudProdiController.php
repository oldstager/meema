<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prodi;

class AdmCrudProdiController extends Controller {

	public function __construct() {

		$this->middleware('auth');
		$this->middleware('admin');

	}

	public function index() {

	    	$prodis = Prodi::all();
		return view('admCrudProdi', ['prodis' => $prodis]);

	}

	public function tambah() {

		return view('admCrudProdiTambah');

	}

	public function simpan(Request $request) {

	    	$this->validate($request,[
    			'kode_prodi' => ['required', 'string', 'max:10'],
    			'nama_prodi' => ['required', 'string', 'max:50']
	    	]);
 
	        Prodi::create([
    			'kode_prodi' => $request->kode_prodi,
    			'nama_prodi' => $request->nama_prodi
	    	]);
 
	    	return redirect('/admin/prodi');		

	}

	public function edit($kode_prodi) {
	     
		$prodi = Prodi::find($kode_prodi);
		return view('admCrudProdiEdit', ['prodi' => $prodi]);

	}


	public function update($kode_prodi, Request $request) {

 	    	$this->validate($request,[
    			'kode_prodi' => ['required', 'string', 'max:10'],
    			'nama_prodi' => ['required', 'string', 'max:50']
	    	]);
 
		$prodi = Prodi::find($kode_prodi);
		$prodi->kode_prodi = $request->kode_prodi;
		$prodi->nama_prodi = $request->nama_prodi;
		$prodi->save();

		return redirect('/admin/prodi');

	}

	public function hapus($kode_prodi) {

		$prodi = Prodi::find($kode_prodi);
		$prodi->delete();

		return redirect('/admin/prodi');
	
	}

	
}
