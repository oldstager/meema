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
                    <a href="/admin/rapat/" class="btn btn-primary">Tampilkan Jenis Rapat</a>
                    <br/>
		    <br/>



                    <form method="post" action="/admin/rapat/update/{{ $rapat->kode_rapat}}">
 
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
 
                        <div class="form-group">
                            <label>Kode Jenis Rapat</label>
                            <input type="text" name="kode_rapat" class="form-control" placeholder="Kode Rapat" value=" {{ $rapat->kode_rapat}}">
 
                            @if($errors->has('kode_rapat'))
                                <div class="text-danger">
                                    {{ $errors->first('kode_rapat')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <label>Nama Jenis Rapat</label>
                            <textarea name="nama_rapat" class="form-control" placeholder="Nama Jenis Rapat"> {{ $rapat->nama_rapat}} </textarea>
 
                             @if($errors->has('nama_rapat'))
                                <div class="text-danger">
                                    {{ $errors->first('nama_rapat')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
 
                    </form>






                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

