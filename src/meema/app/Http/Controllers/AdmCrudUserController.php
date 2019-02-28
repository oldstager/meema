<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Prodi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AdmCrudUserController extends Controller {

	public function __construct() {

		$this->middleware('auth');
		$this->middleware('admin');

	}

	public function index() {

		//$users = User::all();
		$users = User::with('prodi')->get();
		return view('admCrudUser', ['users' => $users]);

	}

	public function tambah() {

		$prodis = Prodi::all();
		return view('admCrudUserTambah', compact('prodis', $prodis));

	}

	public function simpan(Request $request) {

		$prodis = Prodi::all();

		$valProdi = 'in:';

		foreach ($prodis as $prodi) {
			$valProdi .= $prodi->kode_prodi . ',';
		}

		$valProdi = substr($valProdi, 0, -1);

	    	$this->validate($request,[
	            'nidn' => ['required', 'string', 'max:50'],
        	    'kode_prodi' => ['required', trim($valProdi)],
	            'name' => ['required', 'string', 'max:255'],
	            'jk' => ['required', 'in:wanita,pria'],
	            'jabatan' => ['required', 'string', 'max:50'],
	            'no_telp' => ['required', 'string', 'max:15'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'min:6', 'confirmed'],
	            'role' => ['required', 'in:admin,staf']
	    	]);
 
		User::create([


	            'nidn' => $request->nidn,
	            'kode_prodi' => $request->kode_prodi,
	            'name' => $request->name,
	            'jk' => $request->jk,
	            'jabatan' => $request->jabatan,
	            'no_telp' => $request->no_telp,
	            'email' => $request->email,
	            'password' => Hash::make($request->password),
	            'role' => $request->role

	    	]);
 
	    	return redirect('/admin/user');

	}

	public function edit($nidn) {
	     
		$user = User::find($nidn);
		return view('admCrudUserEdit', ['user' => $user]);

	}


	public function update($nidn, Request $request) {

		$this->validate($request,[
	            'nidn' => ['required', 'string', 'max:50'],
        	    'kode_prodi' => ['required', trim($valProdi)],
	            'name' => ['required', 'string', 'max:255'],
	            'jk' => ['required', 'in:wanita,pria'],
	            'jabatan' => ['required', 'string', 'max:50'],
	            'no_telp' => ['required', 'string', 'max:15'],
	            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
	            'password' => ['required', 'string', 'min:6', 'confirmed'],
	            'role' => ['required', 'in:admin,staf']
	    	]);
 
		$user = User::find($nidn);
	        $user->nidn = $request->nidn;
	        $user->kode_prodi = $request->kode_prodi;
	        $user->name = $request->name;
	        $user->jk = $reqeust->jk;
	        $user->jabatan = $request->jabatan;
	        $user->no_telp = $request->no_telp;
	        $user->email = $request->email;
	        $user->password = Hash::make($request->password);
	        $user->role = $request->role;

		$user->save();

		return redirect('/admin/user');

	}

	public function hapus($nidn) {

		$user = User::find($nidn);
		$user ->delete();

		return redirect('/admin/user');
	
	}

	public function showPaginate() {

		$users = User::with('prodi')->paginate(2);
		return view('admCrudUserShowPaginate', ['users' => $users]);

	}
	
}
