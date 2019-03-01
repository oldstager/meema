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

	public function simpan(Request $request) {

		$prodis = Prodi::all();
		$valProdi = 'in:';
		foreach ($prodis as $prodi) {
			$valProdi .= $prodi->kode_prodi . ',';
		}
		$valProdi = substr($valProdi, 0, -1);

		$rapats = Rapat::all();
		$valRapat = 'in:';
		foreach ($rapats as $rapat) {
			$valRapat .= $rapat->kode_rapat . ',';
		}
		$valRapat = substr($valRapat, 0, -1);

		$ruangans = Ruangan::all();
		$valRuangan = 'in:';
		foreach ($ruangans as $ruangan) {
			$valRuangan .= $ruangan->kode_ruangan . ',';
		}
		$valRuangan = substr($valRuangan, 0, -1);

		$users = User::all();
		$valUser = 'in:';
		foreach ($users as $user) {
			$valUser .= $user->nidn . ',';
		}
		$valUser = substr($valUser, 0, -1);

		$this->validate($request,[

			'id_notulensi'=> ['required', 'string', 'max:10'],
			'nama_rapat'=> ['required', 'string', 'max:100'],
			'nidn' => ['required', trim($valUser)],
			'kode_rapat' => ['required', trim($valRapat)],
			'kode_prodi' => ['required', trim($valProdi)],
			'kode_ruangan' => ['required', trim($valRuangan)],
			'tanggal_rapat'=> 'required',
			'waktu_mulai'=> 'required',
			'waktu_selesai'=> 'required',
			'hasil_rapat'=> 'required',
			'arsip' => 'required',
			'arsip.*' => 'mimes:doc,pdf,docx,zip,png,jpg,xls,ppt'

		]);

 	        if($request->hasfile('arsip')) {

			$dataFile = "";
			foreach($request->file('arsip') as $ar) {

				$namaFile = $ar->getClientOriginalName();
				$ar->move(public_path().'/files/', $namaFile);  
				$dataFile .= $namaFile . "*";

			}

			$dataFile = substr($dataFile, 0, -1);
		
		}


		Notulensi::create([

			'id_notulensi'=> $request->id_notulensi,
			'nama_rapat'=> $request->nama_rapat,
			'nidn' => $request->nidn,
			'kode_rapat' => $request->kode_rapat,
			'kode_prodi' => $request->kode_prodi,
			'kode_ruangan' => $request->kode_ruangan,
			'tanggal_rapat'=> $request->tanggal_rapat,
			'waktu_mulai'=> $request->waktu_mulai,
			'waktu_selesai'=> $request->waktu_selesai,
			'hasil_rapat'=> $request->hasil_rapat,
			'arsip' => $dataFile

	    	]);
 
	    	return redirect('/admin/notulensi');

	}

	public function hapus($id_notulensi) {

		$notulensi = Notulensi::find($id_notulensi);

		if ($notulensi == null) {

			return redirect('/admin/notulensi');

		} else {
			$arArsip = explode('*', $notulensi->arsip);

			foreach($arArsip as $delFile) {

				$namaFile = public_path() . '/files/' . $delFile;
				unlink($namaFile);

			}

			$notulensi->delete();
			return redirect('/admin/notulensi');

		}
	}

}
