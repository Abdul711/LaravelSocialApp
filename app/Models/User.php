<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enum\UserStatus;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CrudTrait;

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
        'pic',
        'role',
        'status',
        'title'
    ];

    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }
    public function getPicAttribute($value)
    {
        if ($value == "" || $value == Null) {

            return "placeholder.jpg";
        } else {
            return $value;
        }
    }
    public function getTitleAttribute($value)
    {
        if ($value == "" || $value == null) {
            return "Influencer";
        } else {
            return Str::ucfirst($value);
        }
    }
    protected $appends = ['post_count', 'pic'];
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
    protected $casts = [
    'status' => UserStatus::class,
];
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
    public function setPasswordAttribute($value)
    {
        // Skip if password field is empty (e.g., during update)
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    public function statusDropdownButton()
{
     
$statuses = UserStatus::values();

    $html = '<div class="dropdown">
        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Change Status
        </button>
        <ul class="dropdown-menu">';

    foreach ($statuses as $status) {
        $url = backpack_url("user/{$this->id}/set-status/{$status}");
        $html .= '<li><a class="dropdown-item" href="' . $url . '">' . ucfirst($status) . '</a></li>';
    }

    $html .= '</ul></div>';

    return $html;

   
}
    public function changeStatusDropdown()
    {
        $statuses = ['pending', 'approved', 'rejected', 'blocked'];
        $html = '<div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Change Status
        </button>
        <div class="dropdown-menu">';

        foreach ($statuses as $status) {
            $url = backpack_url("user/{$this->id}/set-status/{$status}");
            $html .= '<a class="dropdown-item" href="' . $url . '">' . ucfirst($status) . '</a>';
        }

        $html .= '</div></div>';

        return $html;
    }
    public function setPicAttribute($value)
    {
        if (request()->hasFile('pic')) {
            $file = request()->file('pic');

            // Format filename: UserName.extension
            $name = $this->attributes['name'] ?? 'user'; // fallback if name is missing
            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name); // clean the name
            $extension = $file->getClientOriginalExtension();
            $filename = $safeName . '.' . $extension;

            $destination = public_path('profilepic');

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            // Optionally delete old file
            if (!empty($this->attributes['pic'])) {
                $old = public_path($this->attributes['pic']);
                if (file_exists($old)) {
                    @unlink($old);
                }
            }

            // Move file
            $file->move($destination, $filename);

            // Save relative path in DB
            $this->attributes['pic'] =  $filename;
        }
    }
}
