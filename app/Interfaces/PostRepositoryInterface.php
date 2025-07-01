<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getPost();
    public function registerPost(array $data);
}
