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
                    <a href="/admin/prodi/" class="btn btn-primary">Tampilkan Program Studi</a>
                    <br/>
		    <br/>


                   <form method="post" action="/admin/prodi/simpan">
 
                        {{ csrf_field() }}
 
                        <div class="form-group">
                            <label>Kode Program Studi</label>
                            <input type="text" name="kode_prodi" class="form-control" placeholder="Kode Program Studi">
 
                            @if($errors->has('kode_prodi'))
                                <div class="text-danger">
                                    {{ $errors->first('kode_prodi')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <label>Nama Program Studi</label>
                            <textarea name="nama_prodi" class="form-control" placeholder="Nama Program Studi"></textarea>
 
                             @if($errors->has('nama_prodi'))
                                <div class="text-danger">
                                    {{ $errors->first('nama_prodi')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Simpan">
                        </div>
 
                    </form>




                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

