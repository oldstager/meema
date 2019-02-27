@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                <div class="card-body">
                    <a href="/admin/ruangan/tambah" class="btn btn-primary">Tambah Ruangan Baru</a>
                    <a href="/admin/ruangan/showPaginate" class="btn btn-primary">Tampilkan Daftar Ruangan - Paginasi</a>
                    <br/>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangans as $ruangan)
                            <tr>
                                <td>{{ $ruangan->kode_ruangan}}</td>
                                <td>{{ $ruangan->nama_ruangan}}</td>
                                <td>
                                    <a href="/admin/ruangan/edit/{{ $ruangan->kode_ruangan}}" class="btn btn-warning">Edit</a>
                                    <a href="/admin/ruangan/hapus/{{ $ruangan->kode_ruangan}}" class="btn btn-danger">Hapus</a>
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

