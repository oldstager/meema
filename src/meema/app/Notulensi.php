<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{

	protected $primaryKey = 'id_notulensi';
	protected $keyType = 'string';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'id_notulensi', 'nama_rapat', 'nidn', 'kode_rapat', 'kode_prodi', 'kode_ruangan', 'tanggal_rapat', 'waktu_mulai', 'waktu_selesai', 'hasil_rapat', 'arsip'
	];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	protected $hidden = [
		'remember_token'
	]
	*/


	public function prodi()
	{
		return $this->belongsTo('App\Prodi', 'kode_prodi');
	}
	public function user()
	{
		return $this->belongsTo('App\User', 'nidn');
	}
	public function rapat()
	{
		return $this->belongsTo('App\Rapat', 'kode_rapat');
	}
	public function ruangan()
	{
		return $this->belongsTo('App\Ruangan', 'kode_ruangan');
	}

    
}
