@extends('layouts.app')

@section('content')


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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf


<div class="form-group row">
    <label for="nidn" class="col-md-4 col-form-label text-md-right">NIDN</label>

    <div class="col-md-6">

        <input id="nidn" type="text" class="form-control{{ $errors->has('nidn') ? ' is-invalid' : '' }}" name="nidn" value="{{ old('nidn') }}" required autofocus>

        @if ($errors->has('nidn'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nidn') }}</strong>
            </span>
        @endif

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
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


<div class="form-group row">
    <label for="jk" class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label>

    <div class="col-md-6">
        <select name="jk" class="form-control" >
            <option value="wanita">Wanita</option>
            <option value="pria">Pria</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="jabatan" class="col-md-4 col-form-label text-md-right">Jabatan</label>

    <div class="col-md-6">

        <input id="jabatan" type="text" class="form-control{{ $errors->has('jabatan') ? ' is-invalid' : '' }}" name="jabatan" value="{{ old('jabatan') }}" required autofocus>

        @if ($errors->has('jabatan'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('jabatan') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="no_telp" class="col-md-4 col-form-label text-md-right">Nomor Telepon</label>

    <div class="col-md-6">

        <input id="no_telepon" type="text" class="form-control{{ $errors->has('no_telp') ? ' is-invalid' : '' }}" name="no_telp" value="{{ old('no_telp') }}" required autofocus>

        @if ($errors->has('no_telp'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('no_telp') }}</strong>
            </span>
        @endif

    </div>
</div>



                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


<div class="form-group row">
    <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

    <div class="col-md-6">
        <select name="role" class="form-control" >
            <option value="admin">Admin</option>
            <option value="staf">Staf</option>
        </select>
    </div>
</div>




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
