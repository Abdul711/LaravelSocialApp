<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    // Eager-load relationships (none in this case)
    protected $with = ["user"];

    // Append accessor to JSON
    protected $appends = ['postperiod'];

    // Accessor
    public function getPostPeriodAttribute()
    {
        $created = $this->created_at;
        $now = now();

        $diffInMinutes = ceil($created->diffInMinutes($now));
          
        if ($diffInMinutes < 60) {
            return $diffInMinutes . 'min';
        }

        $diffInHours = ceil($created->diffInHours($now));
        if ($diffInHours < 24) {
            return $diffInHours . ' hr';
        }

        $diffInDays = ceil($created->diffInDays($now));
        return $diffInDays . 'd';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
