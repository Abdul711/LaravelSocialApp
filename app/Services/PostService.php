<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;

class PostService
{
    /**
     * Create a new class instance.
     */
    protected $postRepo;
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo=$postRepo;
    }
    public function getPost(){
      return $this->postRepo->getPost();
    }

}
