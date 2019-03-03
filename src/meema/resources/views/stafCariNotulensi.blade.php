@extends('layouts.staf')

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

		    <a href="/staf/notulensi/showPaginate" class="btn btn-primary">Tampilkan daftar notulensi - paginasi</a>
		    <a href="/staf" class="btn btn-primary">Tampilkan semua notulensi</a>
                    <br/>
		    <br/>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mencari notulen berdasarkan pemimpin rapat</div>

		<div class="card-body">








                    <form method="POST" action="/staf/notulensi/cari/nidn">
                        @csrf

			<div class="form-group row">
				<label for="nidn" class="col-md-4 col-form-label text-md-right">Pilih pemimpin rapat</label>

				<div class="col-md-6">

					<select name="nidn" class="form-control" >

					    @foreach ($users as $user)
				            <option value={{ $user->nidn }}>{{ $user->name }}</option>
					    @endforeach

				        </select>

				</div>
			</div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Cari pemimpin rapat">
                        </div>
 
                    </form>

		</div>
		</div>
	</div>
	</div>
	</div>

<br/>
<br/>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mencari notulen berdasarkan tanggal rapat</div>

		<div class="card-body">



                    <form method="POST" action="/staf/notulensi/cari/tanggal_rapat">
                        @csrf

			<div class="form-group row">
				<label for="tanggal_rapat" class="col-md-4 col-form-label text-md-right">Tanggal Rapat</label>

				<div class="col-md-6">

					<br />
					Dari Tanggal:

					<input id="tanggal_rapat_awal" type="date" class="form-control{{ $errors->has('tanggal_rapat_awal') ? ' is-invalid' : '' }}" name="tanggal_rapat_awal" value="{{ old('tanggal_rapat_awal') }}" required autofocus>

					<br />
					Sampai Tanggal:

					<input id="tanggal_rapat_akhir" type="date" class="form-control{{ $errors->has('tanggal_rapat_akhir') ? ' is-invalid' : '' }}" name="tanggal_rapat_akhir" value="{{ old('tanggal_rapat_akhir') }}" required autofocus>

				        @if ($errors->has('tanggal_rapat_awal'))
				        <span class="invalid-feedback" role="alert">
			         	       <strong>{{ $errors->first('tanggal_rapat_awal') }}</strong>
				         </span>
				        @endif
				        @if ($errors->has('tanggal_rapat_akhir'))
				        <span class="invalid-feedback" role="alert">
			         	       <strong>{{ $errors->first('tanggal_rapat_akhir') }}</strong>
				         </span>
				        @endif

				</div>
			</div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Cari tanggal rapat">
                        </div>
 
                    </form>

		</div>
		</div>
	</div>
	</div>
	</div>

<br/>
<br/>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mencari notulen berdasarkan jenis rapat</div>

		<div class="card-body">



                    <form method="POST" action="/staf/notulensi/cari/kode_rapat">
                        @csrf

			<div class="form-group row">
				<label for="nidn" class="col-md-4 col-form-label text-md-right">Jenis Rapat</label>

				<div class="col-md-6">

					<select name="kode_rapat" class="form-control" >

					    @foreach ($rapats as $rapat)
				            <option value={{ $rapat->kode_rapat }}>{{ $rapat->nama_rapat }}</option>
					    @endforeach

				        </select>

				</div>
			</div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Cari jenis rapat">
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
