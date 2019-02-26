# Laravel-based Meetings Management Software

## Tentang Software

### Tujuan Software

Software ini digunakan untuk mengelola notulensi rapat pada suatu perguruan tinggi. Ada 2 peran disitu:

1. Admnistrator: mempunyai wewenang penah untuk mengelola semua data
2. Staf: mempunyai wewenang penuh pada beberapa fasilitas saja.

**Administrator** mempunyai hak akses untuk semua data back-end maupun mengelola rapat:

* Mengisi berbagai rincian back-end: user, prodi, ruangan, notulensi, presensi
* Mengisi hasil rapat: teks, foto, dokumen
* Mencetak hasil rapat

**Staf** mempunyai hak akses untuk:

* Menampilkan rincian rapat
* Mencari rapat
* Mencetak hasil rapat 

### Peranti Pengembangan yang Digunakan

* Laravel 5.7
* PHP 7.3.2
* MariaDB 10.1.38

### Rancangan Basis Data

Diagram E-R

![ERD](images/erd.jpg)

Tipe Data

![Tipe Data](images/field-type.jpg)

Buat *database* di MariaDB dan sesuaikan hak aksesnya di **.env**. Database yang dibuat harus menggunakan *utf8mb4_unicode_ci* charset.

## Instalasi Laravel dan Memulai Pembuatan Software

Untuk instalasi Laravel, diperlukan [Composer](https://getcomposer.org). Install Composer terlebih dahulu, setelah itu:

```bash
$ composer global require laravel/installer
```

Jika menggunakan Linux, hasilnya akan berada di $HOME/.config/composer/vendor. Masukkan direktori bin disitu ke $PATH. Setelah itu kita bisa menggunakan Laravel. Buat aplikasi baru Laravel di direktori bebas:

```bash
$ laravel new notulensi
```

Perintah di atas akan membuat aplikasi Laravel di direktori **$current_directory/notulensi**. 

## Membuat Rerangka Otentikasi User

Laravel secara default menyediakan fasilitas untuk CRUD users. Meskipun demikian, tidak ada role untuk fasilitas native Laravel tersebut. Bagian ini akan membahas cara menggunakan role pada Laravel dengan mengubah fasilitas native tersebut.

Untuk awal, Laravel sudah menyediakan migrasi untuk membuat users pada migrations:

```bash
$ ls -la database/migrations/
total 16
drwxr-xr-x 2 bpdp bpdp 4096 Feb 25 11:14 ./
drwxr-xr-x 5 bpdp bpdp 4096 Feb 25 11:14 ../
-rw-r--r-- 1 bpdp bpdp  810 Feb 25 11:14 2014_10_12_000000_create_users_table.php
-rw-r--r-- 1 bpdp bpdp  683 Feb 25 11:14 2014_10_12_100000_create_password_resets_table.php
$
```

File **2014_10_12_000000_create_users_table.php** akan kita edit supaya bisa menampung data pegawai serta role. Pada method **up**, edit:

```php
public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nidn', 50)->unique();
            $table->string('kode_prodi', 10);
            $table->string('name');
            $table->string('jk', 6);
            $table->string('jabatan', 50);
            $table->string('no_telp', 15);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();
            $table->timestamps();
        });
    }
```

Sebelum proses migrasi, harus diperiksa terlebih dahulu apakah penggunaan MariaDB mengakibatkan ada beberapa perubahan atau tidak. Laravel mengubah charset menjadi utf8mb4 mulai Laravel 5.4. Perubahan ini mengakibatkan beberapa penyesuaian. MariaDB yang digunakan adalah MariaDB versi 10.1.38. Versi ini memerlukan penyesuaian (semua versi dibawah 10.2.2 harus disesuaikan). Jika tidak dilakukan penyesuaian, mungkin pada saat melakukan migrasi akan muncul error:

```bash
PDOException::("SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes")
```

Error di atas terjadi misalnya pada saat menggunakan make:auth saat melakukan migrasi (php artisan migrate). Untuk memperbaiki ini ada file yang harus diedit. Saat melakukan migrasi, Laravel harus diberitahu default panjang string yang dihasilkan oleh migrasi. Edit file **app/Providers/AppServiceProvider.php** dengan menetapkan default panjang string:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// penambahan baris 1:
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
/**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	// penambahan baris 2:
        Schema::defaultStringLength(191);
    }
}
```

Setelah itu migrate dengan menggunakan perintah berikut di *root directory* dari software:

```bash
$ php artisan migrate
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
$
```

Setelah menyiapkan model untuk user dan role, generate scaffolding untuk otentikasi:

```bash
$ php artisan make:auth
Authentication scaffolding generated successfully.
$
```

Setelah itu, edit file **resources/views/auth/register.blade.php** untuk menyertakan field-field baru tersebut:

```html
@extends('layouts.app')
@section('content')
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
            <option value="prodi1">Program Studi 1</option>
            <option value="prodi2">Program Studi 2</option>
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
```

Untuk membuat supaya isian-isian tersebut merupakan hasil input, Ubah *fillable* pada **app/User.php**:

```php
protected $fillable = [
        'nidn', 'kode_prodi', 'name', 'jk', 'jabatan', 'no_telp', 'email', 'password', 'role',
    ];
```

Edit controller **app/Http/Controllers/Auth/RegisterController.php**. Perhatikan pada *validator* dan *create*, bagian tersebut diubah untuk semua field-field baru.

```php
<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
use RegistersUsers;
/**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
/**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nidn' => ['required', 'string', 'max:50'],
            'kode_prodi' => ['required', 'in:prodi1,prodi2'],
            'name' => ['required', 'string', 'max:255'],
            'jk' => ['required', 'in:wanita,pria'],
            'jabatan' => ['required', 'string', 'max:50'],
            'no_telp' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,staf'],
        ]);
    }
/**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nidn' => $data['nidn'],
            'kode_prodi' => $data['kode_prodi'],
            'name' => $data['name'],
            'jk' => $data['jk'],
            'jabatan' => $data['jabatan'],
            'no_telp' => $data['no_telp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
```

Untuk mencoba hasilnya:

```bash
$ php artisan serve
```

Setelah itu akses ke http://localhost:8000/, Coba register dan setelah itu logout kemudian login. Setelah berhasil, kita akan membuat supaya setelah login, masing-masing role bisa berada pada halaman yang dibuat untuk role tersebut. Untuk keperluan itu, diperlukan *middleware* yang akan menyaring *request* yang masuk ke aplikasi. Perintah *php artisan make:auth* yang sudah dikerjakan sebenarnya merupakan bagian dari *middleware*. Kita akan membuat *middleware* untuk memproses akses ke aplikasi, jika masuk sebagai admin, maka akan menampilkan halaman admin, jika staf, maka akan menampilkan halaman staf.

```bash
$ php artisan make:middleware Admin
$ php artisan make:middleware Staf
```

Setelah itu kita edit file **Admin.php** dan **Staf.php** di **app/Http/Middleware/**:

__Admin.php__

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    if (Auth::check() && Auth::user()->role == 'admin') {
		    return $next($request);
	    }
	    elseif (Auth::check() && Auth::user()->role == 'staf') {
		    return redirect('/staf');
	    }
	    else {
		    return redirect('/login');
	    }
    }
}
```

__Staf.php__

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Auth

class Staf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    if (Auth::check() && Auth::user()->role == 'staf') {
		    return $next($request);
	    }
	    elseif (Auth::check() && Auth::user()->role == 'admin') {
		    return redirect('/admin');
	    }
	    else {
		    return redirect('/login');
	    }
    }
}
```

Middleware yang sudah dibuat harus didaftarkan terlebih dahulu di **app/Http/Kernel.php**:

```php
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
	// Tambahan:
	'admin' => 'App\Http\Middleware\Admin',
	'staf' => 'App\Http\Middleware\Staf',
	// sampai disini tambahan
    ];
```

Setelah itu, kita harus mengatur halaman yang akan ditampilkan masing-masing role tersebut setelah login. Edit **app/Http/Controllers/Auth/LoginController.php**:

```php
    // baris ini dihapus:
    // protected $redirectTo = '/home';
    // diganti dengan:
	protected function redirectTo( ) {
		if (Auth::check() && Auth::user()->role == 'admin') {
			//return redirect('/admin');
 			$this->redirectTo = '/admin';
        		return $this->redirectTo;
		}
		elseif (Auth::check() && Auth::user()->role == 'staf') {
			//return redirect('/staf');
 			$this->redirectTo = '/staf';
        		return $this->redirectTo;

		}
		else {
			//return redirect('/login');
 			$this->redirectTo = '/login';
        		return $this->redirectTo;
		}
	}
```

Untuk memproses *redirect* tersebut, ada beberapa hal yang perlu kita siapkan:

* Membuat view (dan layout) untuk masing-masing role
* Membuat controller untuk masing-masing route (/admin dan /staf)
* Mengaktifkan routing untuk controller.

Untuk menyiapkan tampilan, layout harus kita buat terlebih dahulu. Layout ini nantinya akan digunakan oleh view. Masuk ke direktori **resources/views/layouts**, kemudian buat 2 file berikut untuk halaman admin dan halaman staf:

__admin.blade.php__

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Administrator Dashboard') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Home') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} - {{Auth::user()->role }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
	    @yield('content')
	</main>

	<div class="links">
		<a href="/prodi">Program Studi</a>
	</div>

    </div>
</body>
</html>
```

__staf.blade.php__

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Staff Dashboard') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Home') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} - {{Auth::user()->role }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
	    @yield('content')
	</main>

	<div class="links">
		<a href="/search">Search Rapat</a>
	</div>

    </div>
</body>
</html>
```

**Views** lebih sederhana karena hanya mendefinisikan isi. Buat 2 file untuk *greetings* saat admin dan staf berhasil login. Views tersebut berada pada **resources/views/**.

__adminHome.blade.php__

```html
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

		    Selamat datang administrator!

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

__stafHome.blade.php__

```html
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

		    Selamat datang staf!

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

Setelah layout dan view kita buat, kita harus mendefinisikan controller yang nantinya akan digunakan untuk redirect setelah berhasil login: **AdminController** untuk halaman admin (/admin), serta **StafController** untuk halaman staf (/staf). Hasil dari perintah dibawah ini akan berada di **app/Http/Controllers/**.

```bash
$ php artisan make:controller AdminController
Controller created successfully.
$ php artisan make:controller StafController
Controller created successfully.
$
```

__AdminController.php__

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function __construct() {
		$this->middleware('auth');    
		$this->middleware('admin');
	}

	public function index() {
		return view('adminHome');
	}

}
```

__StafController.php__

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StafController extends Controller {

	public function __construct() {
		$this->middleware('auth');    
		$this->middleware('staf');
	}

	public function index() {
		return view('stafHome');
	}

}
```

Setelah controller didefinisikan, routing harus didefinisikan. Edit file **routes/web.php**:

```php
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index');
Route::get('/staf', 'StafController@index');
```

Setelah itu, aktifkan aplikasi dan coba login dengan menggunakan 2 role tersebut. Masing-masing akan masuk ke halaman sesuai role dan jika belum login atau login tidak sesuai dengan role, maka akan masuk ke halaman login (/login) atau home sesuai role (/home).

## Relasi Antar Tabel dengan Eloquent ORM

Untuk relasi antar tabel, kita akan mendefinisikan relasi antara pegawai dengan prodi. Satu prodi mempunyai banyak pegawai, sementara itu satu pegawai hanya menjadi satu prodi saja. Relasi akan kita buat pada model serta akan ditampilkan pada saat register user baru (dropdown nama prodi berasal dari model / tabel prodi.

### Buat Model dan Migrasi

Tabel didefinisikan melalui model, untuk keperluan ini kita akan membuat model Prodi yang dipetakan ke tabel **prodis**.

```bash
$ php artisan make:model Prodi --migration
Model created successfully.
Created Migration: 2019_02_26_025920_create_prodis_table
$ 
```

Edit file hasil migrasi (**database/migrations/2019_02_26_025920_create_prodis_table.php**) pada method **up**:

```php
	public function up() {
		
		Schema::create('prodis', function (Blueprint $table) {
			
			$table->increments('id');
			$table->string('kode_prodi', 10)->unique();
			$table->string('nama_prodi', 50);
			$table->timestamps();

		});
	}
```

Migrasikan:

```bash
$ php artisan migrate
Migrating: 2019_02_26_025920_create_prodis_table
Migrated:  2019_02_26_025920_create_prodis_table
$
```

Setelah pembuatan berbagai model tersebut, model yang ada harus kita atur ulang. Pengaturan ini diperlukan karena adanya relasi antar tabel. Tabel prodi harus dibuat terlebih dahulu sehingga **database/migrations/** harus diatur lagi dengan penamaan berikut ini:

```bash
$ ls -la database/migrations/
total 20
drwxr-xr-x 2 bpdp bpdp 4096 Feb 26 11:23 ./
drwxr-xr-x 5 bpdp bpdp 4096 Feb 26 06:30 ../
-rw-r--r-- 1 bpdp bpdp  628 Feb 26 10:59 2019_02_25_000000_create_prodis_table.php
-rw-r--r-- 1 bpdp bpdp 1166 Feb 26 11:00 2019_02_25_000001_create_users_table.php
-rw-r--r-- 1 bpdp bpdp  683 Feb 26 06:30 2019_02_25_000002_create_password_resets_table.php
$
```

Tabel users - method **up** harus diubah menjadi:

```php
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nidn', 50)->unique();
            $table->string('kode_prodi', 10);
            $table->string('name');
            $table->string('jk', 6);
            $table->string('jabatan', 50);
            $table->string('no_telp', 15);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();
	    $table->timestamps();

		$table->foreign('kode_prodi')
			->references('kode_prodi')
			->on('prodis')
			->onDelete('cascade');

        });
    }
```

Setelah itu migrasikan mulai dari awal:

```bash
$ php artisan migrate:fresh
Dropped all tables successfully.
Migration table created successfully.
Migrating: 2019_02_25_000000_create_prodis_table
Migrated:  2019_02_25_000000_create_prodis_table
Migrating: 2019_02_25_000001_create_users_table
Migrated:  2019_02_25_000001_create_users_table
Migrating: 2019_02_25_000002_create_password_resets_table
Migrated:  2019_02_25_000002_create_password_resets_table
$
```

Isikan 2 data prodi berikut ini melalui PHPMyAdmin atau MariaDB client:

```sql
INSERT INTO `prodis` (`id`, `kode_prodi`, `nama_prodi`, `created_at`, `updated_at`) VALUES
(3, 'teknik-001', 'Teknik Informatika', NULL, NULL),
(4, 'teknik-002', 'Teknik Mesin', NULL, NULL);
```

Saat register, data prodi akan dimasukkan dari database. Untuk keperluan itu, ada beberapa perbaikan:

* Menyesuaikan controller **app/Controllers/Auth/RegisterController.php** pada bagian validator dan query data program studi untuk dikirim ke view
* Mengubah view **resources/views/auth/register.blade.php** supaya menampilkan error yang muncul serta mengambil data dari controller

Untuk mengetahui nama method / function yang harus dibuat untuk dikirimkan ke view, gunakan **php artisan route:list**. Setelah mengetahui nama method / function, buat function showRegistrationForm (sesuai keluaran route:list).

__RegisterController.php__ 

```php
    public function showRegistrationForm() {

	    $prodis = Prodi::all();
	    return view('auth.register', compact('prodis', $prodis));

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
   
	$prodis = Prodi::all();

	$valProdi = 'in:';

	foreach ($prodis as $prodi) {
		$valProdi .= $prodi->kode_prodi . ',';
	}

	$valProdi = substr($valProdi, 0, -1);

	// hasil akhir: 
	// in:teknik-001,teknik002
 
        return Validator::make($data, [
            'nidn' => ['required', 'string', 'max:50'],
            'kode_prodi' => ['required', trim($valProdi)],
            'name' => ['required', 'string', 'max:255'],
            'jk' => ['required', 'in:wanita,pria'],
            'jabatan' => ['required', 'string', 'max:50'],
            'no_telp' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,staf'],
        ]);
    }
```

__resources/views/auth/register.blade.php__

Perhatikan bagian awal untuk menampilkan semua error yang mungkin terjadi serta bagian untuk mengambil isi **$prodis**.

```html
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
```

Setelah ini, coba aktifkan aplikasi dan akses */register*.


