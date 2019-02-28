<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotulensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulensis', function (Blueprint $table) {
		$table->increments('id');
		$table->string('id_notulensi', 10)->unique;
		$table->string('nama_rapat', 100);
		$table->string('nidn', 50);
		$table->string('kode_rapat', 10);
		$table->string('kode_prodi', 10);
		$table->string('kode_ruangan', 10);
		$table->date('tanggal_rapat');
		$table->datetime('waktu_mulai');
		$table->datetime('waktu_selesai');
		$table->text('hasil_rapat');
		$table->text('arsip');
		$table->timestamps();

		$table->foreign('nidn')
			->references('nidn')->on('users')
	      		->onDelete('cascade');
		$table->foreign('kode_rapat')
			->references('kode_rapat')->on('rapats')
	      		->onDelete('cascade');
		$table->foreign('kode_prodi')
			->references('kode_prodi')->on('prodis')
	      		->onDelete('cascade');
		$table->foreign('kode_ruangan')
			->references('kode_ruangan')->on('ruangans')
	      		->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notulensis');
    }
}
