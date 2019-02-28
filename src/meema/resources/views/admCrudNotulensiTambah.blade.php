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








@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="/admin/notulensi/simpan"  enctype="multipart/form-data">
                        @csrf


<div class="form-group row">
    <label for="nidn" class="col-md-4 col-form-label text-md-right">ID Notulensi</label>

    <div class="col-md-6">

        <input id="id_notulensi" type="text" class="form-control{{ $errors->has('id_notulensi') ? ' is-invalid' : '' }}" name="id_notulensi" value="{{ old('id_notulensi') }}" required autofocus>

        @if ($errors->has('id_notulensi'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_notulensi') }}</strong>
            </span>
        @endif

    </div>
</div>
<div class="form-group row">
    <label for="nama_rapat" class="col-md-4 col-form-label text-md-right">Nama Rapat</label>

    <div class="col-md-6">

        <input id="nama_rapat" type="text" class="form-control{{ $errors->has('nama_rapat') ? ' is-invalid' : '' }}" name="nama_rapat" value="{{ old('nama_rapat') }}" required autofocus>

        @if ($errors->has('nama_rapat'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nama_rapat') }}</strong>
            </span>
        @endif

    </div>
</div>


<div class="form-group row">
    <label for="midn" class="col-md-4 col-form-label text-md-right">Pemimpin Rapat</label>

    <div class="col-md-6">
	<select name="nidn" class="form-control" >

	@foreach ($users as $user)
            <option value={{ $user->nidn }}>{{ $user->name }}</option>
	@endforeach

        </select>
    </div>
</div>

<div class="form-group row">
    <label for="kode_rapat" class="col-md-4 col-form-label text-md-right">Jenis Rapat</label>

    <div class="col-md-6">
	<select name="kode_rapat" class="form-control" >

	@foreach ($rapats as $rapat)
            <option value={{ $rapat->kode_rapat }}>{{ $rapat->nama_rapat }}</option>
	@endforeach

        </select>
    </div>
</div>
<div class="form-group row">
    <label for="kode_prodi" class="col-md-4 col-form-label text-md-right">Program Studi</label>

    <div class="col-md-6">
	<select name="kode_prodi" class="form-control" >

	@foreach ($prodis as $prodi)
            <option value={{ $prodi->kode_prodi }}>{{ $prodi->nama_prodi }}</option>
	@endforeach

        </select>
    </div>
</div>
<div class="form-group row">
    <label for="kode_ruangan" class="col-md-4 col-form-label text-md-right">Ruangan</label>

    <div class="col-md-6">
	<select name="kode_ruangan" class="form-control" >

	@foreach ($ruangans as $ruangan)
            <option value={{ $ruangan->kode_ruangan }}>{{ $ruangan->nama_ruangan }}</option>
	@endforeach

        </select>
    </div>
</div>


                        <div class="form-group row">
                            <label for="tanggal_rapat" class="col-md-4 col-form-label text-md-right">Tanggal Rapat</label>

                            <div class="col-md-6">
                                <input id="tanggal_rapat" type="text" class="form-control{{ $errors->has('tanggal_rapat') ? ' is-invalid' : '' }}" name="tanggal_rapat" value="{{ old('tanggal_rapat') }}" required autofocus>

                                @if ($errors->has('tanggal_rapat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tanggal_rapat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


<div class="form-group row">
    <label for="waktu_mulai" class="col-md-4 col-form-label text-md-right">Waktu Mulai</label>

    <div class="col-md-6">

        <input id="waktu_mulai" type="text" class="form-control{{ $errors->has('waktu_mulai') ? ' is-invalid' : '' }}" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required autofocus>

        @if ($errors->has('waktu_mulai'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('waktu_mulai') }}</strong>
            </span>
        @endif

    </div>
</div>
<div class="form-group row">
    <label for="waktu_selesai" class="col-md-4 col-form-label text-md-right">Waktu Selesai</label>

    <div class="col-md-6">

        <input id="waktu_selesai" type="text" class="form-control{{ $errors->has('waktu_selesai') ? ' is-invalid' : '' }}" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required autofocus>

        @if ($errors->has('waktu_selesai'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('waktu_selesai') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="hasil_rapat" class="col-md-4 col-form-label text-md-right">Hasil Rapat</label>

    <div class="col-md-6">

        <textarea id="hasil_rapat" class="form-control{{ $errors->has('hasil_rapat') ? ' is-invalid' : '' }}" name="hasil_rapat" value="{{ old('hasil_rapat') }}" required autofocus></textarea>

        @if ($errors->has('hasil_rapat'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('hasil_rapat') }}</strong>
            </span>
        @endif

    </div>
</div>
<div class="form-group row">
    <label for="arsip" class="col-md-4 col-form-label text-md-right">Arsip</label>

    <div class="col-md-6">

      <input type="file" name="arsip[]" class="myfrm form-control">
      <input type="file" name="arsip[]" class="myfrm form-control">
      <input type="file" name="arsip[]" class="myfrm form-control">
      <input type="file" name="arsip[]" class="myfrm form-control">
      <input type="file" name="arsip[]" class="myfrm form-control">

        @if ($errors->has('arsip'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('arsip') }}</strong>
            </span>
        @endif

    </div>
</div>








                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah Notulensi') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






















                </div>
            </div>
        </div>
    </div>
</div>
@endsection
