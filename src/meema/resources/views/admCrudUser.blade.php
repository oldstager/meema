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
                    <a href="/admin/user/tambah" class="btn btn-primary">Tambah Dosen - Karyawan Baru</a>
                    <a href="/admin/user/showPaginate" class="btn btn-primary">Tampilkan Daftar Dosen/Karyawan - Paginasi</a>
                    <br/>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
			    <tr>
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>Telp</th>
                                <th>E-mail</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nidn}}</td>
				<td>{{ $user->name}}</td>
                                <td>{{ $user->prodi->nama_prodi}}</td>
                                <td>{{ $user->jk}}</td>
                                <td>{{ $user->jabatan}}</td>
                                <td>{{ $user->no_telp}}</td>
                                <td>{{ $user->email}}</td>
                                <td>{{ $user->password}}</td>
                                <td>{{ $user->role}}</td>
                                <td>
                                    <a href="/admin/user/edit/{{ $user->nidn }}" class="btn btn-warning">Edit</a>
                                    <a href="/admin/user/hapus/{{ $user->nidn }}" class="btn btn-danger">Hapus</a>
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
