<?php

namespace App\Http\Controllers;

use App\Enum\UserStatus;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(){
        // Display Login File
        return view ("login");
    }
    public function signup(){
        return view("signup");
    }
     public function logined(LoginRequest $request)
    {
        
        $user = $this->authService->login($request->validated());

        if (!$user) {
         return redirect()->back()->with('error', 'Invalid credentials.');
        }
       if ($user && $user->status === UserStatus::Blocked) {
    return redirect()->back()->with('error', 'Your Account Is Blocked By Admin');
}
        
        return redirect(url('/'));
    }
        public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return redirect(url('login'));
    }
    public function logout(){
        if($this->authService->logout()){
          return redirect(url('login'));
        }
    }

}
