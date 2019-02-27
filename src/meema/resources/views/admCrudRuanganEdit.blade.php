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
                    <a href="/admin/ruangan/" class="btn btn-primary">Tampilkan Ruangan</a>
                    <br/>
		    <br/>



                    <form method="post" action="/admin/ruangan/update/{{ $ruangan->kode_ruangan}}">
 
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
 
                        <div class="form-group">
                            <label>Kode Ruangan</label>
                            <input type="text" name="kode_ruangan" class="form-control" placeholder="Kode Ruangan" value=" {{ $ruangan->kode_ruangan}}">
 
                            @if($errors->has('kode_ruangan'))
                                <div class="text-danger">
                                    {{ $errors->first('kode_ruangan')}}
                                </div>
                            @endif
 
                        </div>
 
                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <textarea name="nama_ruangan" class="form-control" placeholder="Nama Ruangan"> {{ $ruangan->nama_ruangan}} </textarea>
 
                             @if($errors->has('nama_ruangan'))
                                <div class="text-danger">
                                    {{ $errors->first('nama_ruangan')}}
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

