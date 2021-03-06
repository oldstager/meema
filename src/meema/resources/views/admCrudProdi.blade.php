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
                    <a href="/admin/prodi/tambah" class="btn btn-primary">Tambah Program Studi Baru</a>
                    <a href="/admin/prodi/showPaginate" class="btn btn-primary">Tampilkan Daftar Program Studi - Paginasi</a>
                    <br/>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Prodi</th>
                                <th>Nama Prodi</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prodis as $prodi)
                            <tr>
                                <td>{{ $prodi->kode_prodi }}</td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td>
                                    <a href="/admin/prodi/edit/{{ $prodi->kode_prodi }}" class="btn btn-warning">Edit</a>
                                    <a href="/admin/prodi/hapus/{{ $prodi->kode_prodi }}" class="btn btn-danger">Hapus</a>
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

