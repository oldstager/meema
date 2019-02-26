<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model {

	public function comments() {
		
		return $this->hasMany('App\User');
	
	}	


}
