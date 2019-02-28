<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapat extends Model {

	protected $primaryKey = 'kode_rapat';
	protected $keyType = 'string';
	protected $fillable = ['kode_rapat','nama_rapat'];

	public function notulensis() {
		
		return $this->hasMany('App\Notulensi', 'kode_rapat');

	}

}
