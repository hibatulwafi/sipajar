<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class NativeLoginController extends Controller 
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest:login')->except('logout');
    }

    public function username()
    {
            return 'user_email';
    }
    protected function guard()
    {
        return Auth::guard('login');
    }

    public function loginform()
    {   
        return view('auth.login');
    }

}
