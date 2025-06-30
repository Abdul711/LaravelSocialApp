<?php

namespace App\Http\Controllers;

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

        return redirect(url('/'));
    }
        public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return redirect(url('login'));
    }
}
