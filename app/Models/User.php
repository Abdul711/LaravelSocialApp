<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
public function getRowNumber()
{
    $page = request()->get('page', 1);
    $perPage = request()->get('limit', config('backpack.crud.default_page_length', 25));
    static $i = 1;
    return (($page - 1) * $perPage) + $i++;
}
    protected $fillable = [
        'name',
        'email',
        'password',
        'pic'
    ];
     
 public function getPostCountAttribute()
{
    return $this->posts()->count();
}
public function getPicAttribute($value){
      if($value=="" || $value==Null ){
    
    return "placeholder.jpg";
      }else{
        return $value;
      }
  
}
public function getTitleAttribute($value){
   if($value=="" || $value ==null){
    return "Influencer";
   }else{
   return Str::ucfirst($value);
}
}
protected $appends = ['post_count','pic'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function posts()
{
    return $this->hasMany(Post::class);
}
}
