<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJop extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'job_id',
        'employer_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function employer()
    {
        return $this->belongsTo(User::class);
    }
    public function Rating() {

        $Rating= Rating::where([['job_id', $this->job_id],['user_id', $this->user_id]])->avg('rating');
        if ($Rating) {
        return $Rating;
        }
        return false ;

    }
}
