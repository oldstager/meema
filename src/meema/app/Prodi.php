<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model {

	protected $primaryKey = 'kode_prodi';
	protected $keyType = 'string';

	public function users() {
		
		return $this->hasMany('App\User', 'kode_prodi');
	
	}	


}
