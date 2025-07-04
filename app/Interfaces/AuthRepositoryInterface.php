<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function register(array $data);   // No body
    public function login(array $credentials); // No body
    public function logout();
}