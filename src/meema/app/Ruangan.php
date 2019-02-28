<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model {

	protected $primaryKey = 'kode_ruangan';
	protected $keyType = 'string';
	protected $fillable = ['kode_ruangan','nama_ruangan'];

	public function notulensi() {
		
		return $this->hasOne('App\Notulensi', 'kode_ruangan');
	
	}

}
