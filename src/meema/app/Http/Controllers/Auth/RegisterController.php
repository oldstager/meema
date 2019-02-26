<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Prodi;

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
    public function __construct() {

	$this->middleware('guest');


    }

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
