<?php

namespace App\Http\Controllers;

use App\Http\Requests\ratingRequest;
use App\Models\AppliedJop;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $applied_jobs = AppliedJop::where([
            ['employer_id', $user->id],
            ['status', 'accepted'],
        ])->get();
        return response()->json([
            'AcceptedJobs' => $applied_jobs,
        ],200);
    }
    public function show($id)
    {
        $user = Auth::user();
        $applied_job = AppliedJop::where([
            ['id', $id],
            ['employer_id', $user->id],
            ['status', 'accepted'],
        ])->first();
        if($applied_job){
            return response()->json([
                'message' => 'job found',
                'AcceptedJobs' => $applied_job,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'job not found',
            ], 200);
        }
    }
    public function storeRating($Rating, $id)
    {
        $user = Auth::user();
        $applied_job = AppliedJop::where([
            ['id', $id],
            ['employer_id', $user->id],
            ['status', 'accepted'],
        ])->first();
        if($applied_job){
            $worker_rating = Rating::where([
                ['user_id', $applied_job->user_id],
                ['job_id', $applied_job->job_id],
            ])->first();
            if ($worker_rating) {
                $worker_rating->update(['rating' => $Rating]);
                return response()->json([
                    'status' => 200,
                    'message' => 'updata done',
                ], 200);
            } else {
                $rating = Rating::create([
                    'user_id' => $applied_job->user_id,
                    'job_id' => $applied_job->job_id,
                    'rating' => $Rating,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'done',
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'not found',
            ], 200);
        }

    }
    public function showWorkerRating()
    {
        $user = Auth::user();
        $avgStar = Rating::where('user_id', $user->id)->avg('rating');

        if($avgStar){
            return response()->json([
                'rating' => $avgStar,
            ], 200);
        }else{
            return response()->json([
                'rating' => 0,
            ], 200);
        }
    }
}
