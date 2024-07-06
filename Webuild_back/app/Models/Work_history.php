<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_history extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'job_id',
        'title',
        'description',
        'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}