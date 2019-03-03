@extends('layouts.laporan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b>Laporan Daftar Notulensi</b></div>
                <div class="card-body">
                    <br/>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
			    <tr>
                                <th>ID Notulensi</th>
                                <th>Nama Rapat</th>
                                <th>Pemimpin Rapat</th>
                                <th>Jenis Rapat</th>
                                <th>Program Studi</th>
                                <th>Ruangan</th>
                                <th>Tanggal</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th>Hasil Rapat</th>
                                <th>Arsip</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notulensis as $notulensi)
                            <tr>
                                <td>{{ $notulensi->id_notulensi}}</td>
				<td>{{ $notulensi->nama_rapat}}</td>
                                <td>{{ $notulensi->user->name}}</td>
                                <td>{{ $notulensi->rapat->nama_rapat}}</td>
                                <td>{{ $notulensi->prodi->nama_prodi}}</td>
                                <td>{{ $notulensi->ruangan->nama_ruangan}}</td>
                                <td>{{ $notulensi->tanggal_rapat}}</td>
                                <td>{{ $notulensi->waktu_mulai}}</td>
                                <td>{{ $notulensi->waktu_selesai}}</td>
                                <td>{{ $notulensi->hasil_rapat}}</td>
				<td>
				@php
				$arArsip = explode('*', $notulensi->arsip);
				foreach ($arArsip as $arsip) {
					echo '<a href="/files/' . $arsip . '">' . $arsip . '</a><br />';
				}
				@endphp
				</td>
				</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
