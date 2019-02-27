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
                    <a href="/admin/rapat/tambah" class="btn btn-primary">Tambah Jenis Rapat Baru</a>
                    <br/>
                    <br/>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Jenis Rapat</th>
                                <th>Nama Jenis Rapat</th>
                                <th>Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rapats as $rapat)
                            <tr>
                                <td>{{ $rapat->kode_rapat}}</td>
                                <td>{{ $rapat->nama_rapat}}</td>
                                <td>
                                    <a href="/admin/rapat/edit/{{ $rapat->kode_rapat}}" class="btn btn-warning">Edit</a>
                                    <a href="/admin/rapat/hapus/{{ $rapat->kode_rapat}}" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
		    </table>
		   {{ $rapats->links() }}
                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

