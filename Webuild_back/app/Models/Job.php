<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'salary',
        'location',
        'user_id',
        'status',
    ];
    //protected $with = ['users'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Rating()
    {
        return $this->hasOne(Rating::class);
    }
}
