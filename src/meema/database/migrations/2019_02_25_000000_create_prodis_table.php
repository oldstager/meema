<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdisTable extends Migration
{
	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */

	public function up() {
		
		Schema::create('prodis', function (Blueprint $table) {
			
			$table->increments('id');
			$table->string('kode_prodi', 10)->unique();
			$table->string('nama_prodi', 50);
			$table->timestamps();

		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodis');
    }
}
