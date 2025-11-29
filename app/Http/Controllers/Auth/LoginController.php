<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Facades\Permission;

class LoginController extends Controller
{
    // define interface property
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function index()
    {
        return view('pages.auth.login');
    }

    public function store(StoreLoginRequest $request)
    {
        $credentials = $request->validated();

        if ($this->authRepository->login($credentials)) {
            // jika dia rolenya admin
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            // jika dia rolenya user
                return redirect()->route('home');

        }

        return redirect()->route('login')->withErrors(['email' => 'Email or password is incorrect.']);
    }


    // function logout
    public function logout(){
        $this->authRepository->logout();
        return redirect()->route('login');
    }
}
