<?php

namespace App\Services;
use App\Interfaces\AuthRepositoryInterface;
class AuthService
{
    /**
     * Create a new class instance.
     */

    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }
        public function register(array $data)
    {
        return $this->authRepo->register($data);
    }

    public function login(array $credentials)
    {
        return $this->authRepo->login($credentials);
    }
}
