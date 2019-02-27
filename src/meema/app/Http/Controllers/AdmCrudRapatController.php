<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rapat;

class AdmCrudRapatController extends Controller {

	public function __construct() {

		$this->middleware('auth');
		$this->middleware('admin');

	}

	public function index() {

	    	$rapats = Rapat::all();
		return view('admCrudRapat', ['rapats' => $rapats]);

	}

	public function tambah() {

		return view('admCrudRapatTambah');

	}

	public function simpan(Request $request) {

	    	$this->validate($request,[
    			'kode_rapat' => ['required', 'string', 'max:10'],
    			'nama_rapat' => ['required', 'string', 'max:50']
	    	]);
 
	        Rapat::create([
    			'kode_rapat' => $request->kode_rapat,
    			'nama_rapat' => $request->nama_rapat
	    	]);
 
	    	return redirect('/admin/rapat');

	}

	public function edit($kode_rapat) {
	     
		$rapat = Rapat::find($kode_rapat);
		return view('admCrudRapatEdit', ['rapat' => $rapat]);

	}


	public function update($kode_rapat, Request $request) {

 	    	$this->validate($request,[
    			'kode_rapat' => ['required', 'string', 'max:10'],
    			'nama_rapat' => ['required', 'string', 'max:50']
	    	]);
 
		$rapat = Rapat::find($kode_rapat);
		$rapat->kode_rapat = $request->kode_rapat;
		$rapat->nama_rapat = $request->nama_rapat;
		$rapat->save();

		return redirect('/admin/rapat');

	}

	public function hapus($kode_rapat) {

		$rapat= Rapat::find($kode_rapat);
		$rapat->delete();

		return redirect('/admin/rapat');
	
	}

	public function showPaginate() {

		$rapats = Rapat::paginate(2);
		return view('admCrudRapatShowPaginate', ['rapats' => $rapats]);

	}
	
}
