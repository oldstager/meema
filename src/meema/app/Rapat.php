<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapat extends Model {

	protected $primaryKey = 'kode_rapat';
	protected $keyType = 'string';
	protected $fillable = ['kode_rapat','nama_rapat'];

	public function notulensi() {
		
		return $this->hasOne('App\Notulensi', 'kode_rapat');

	}

}
