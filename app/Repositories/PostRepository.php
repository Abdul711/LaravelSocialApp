<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $userId;
    public function __construct()
    {
        $this->userId=Auth::user()->id;
    }
    public function getPost(){
      return Post::get();      
    }
    public function registerPost(array $data){}
}
