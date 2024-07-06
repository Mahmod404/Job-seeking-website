<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Rating;
use App\Models\AppliedJop;
use App\Models\Work_history;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;

class ApplyJopController extends Controller
{
     use ApiResponseTrait ;
    public function showUser($id)
    {

        $job = Job::find($id);
        $user_id = $job->user_id;
        $user = User::find($user_id);

        if ($job) {
            return response()->json([
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'no job found'
            ], 200);
        }
    }
    public function apply($id)
    {
        $user = Auth::user();
        $job = Job::where([['id', $id],['status', 'available']])->first();

        if ($job) {
            $applied_jop_before = AppliedJop::where([['user_id', $user->id],['job_id', $job->id]])->first();
            if (!$applied_jop_before) {
                $applied_jop = AppliedJop::create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                    'employer_id' => $job->user_id,
                    'status' => 'pending',
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Job Applied',
                    'applied_jop' => $applied_jop
                ], 200);
            } else {
                return response()->json([
                    'status' => 403,
                    'message' => 'Job applied before',
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Job Not Found',
            ], 200);
        }
    }
    public function allRequests()
    {
        $applied_jops = AppliedJop::where('user_id', auth()->user()->id)->with(['user','employer','job'])->get();
        return $this->apiResponse(200,"successfully ",null,$applied_jops);

    }
    public function showEmployerApplications()
    {
        $applied_jops = AppliedJop::where([['employer_id', auth()->user()->id],['status' ,'accepted']])->orWhere([['employer_id', auth()->user()->id],['status' ,'pending']])->with(['user','employer','job'])->get();

        foreach ($applied_jops as $applied_jop) {
        // if ($applied_jop->status == 'accepted') {
            $Rating= Rating::where([['job_id', $applied_jop->job_id],['user_id', $applied_jop->user_id]])->avg('rating');
            $applied_jop->Rating =  $Rating;
        // }
        }
        return $this->apiResponse(200,"successfully ",null,$applied_jops);

    }
    public function showApplication($id)
    {
        $user = Auth::user();
        $applied_jop = AppliedJop::where([
            ['id', $id],
            ['employer_id', $user->id],
        ])->first();
        if ($applied_jop) {
            $worker = User::where('id', $applied_jop->user_id)->first();
            return response()->json([
                'status' => '200',
                'job application' => $applied_jop,
                'worker' => $worker,
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'Not Found'
            ]);
        }
    }
    public function applicationAccept($id)
    {
        $user = Auth::user();
        $applied_jop = AppliedJop::where([['id', $id],['employer_id', $user->id]])->first();
        if ($applied_jop) {
            $worker_id = $applied_jop->user_id;
            $worker = User::where('id', $worker_id)->first();

            $job_id = $applied_jop->job_id;
            $job = Job::find($job_id);

            $applied_jop->update([
                'status' => 'accepted'
            ]);
            $job->update([
                'status' => 'unavailable'
            ]);
            $applied_jop->save();
            $job->save();

            // $Work_history = Work_history::create([
            //     'user_id' => $worker_id,
            //     'job_id' => $job->id,
            //     'title' => $job->title,
            //     'description' => $job->description,
            //     'date' => now(),
            // ]);
            return response()->json([
                'status' => '200',
                'message' => 'Job application accepted.',
                'worker' => $worker,
                'job' => $job
            ], 200);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'Job application not found'
            ]);
        }
    }
    public function applicationReject($id)
    {
        $user = Auth::user();
        $applied_jop = AppliedJop::where([
            ['id', $id],
            ['employer_id', $user->id],
        ])->first();
        if ($applied_jop) {
            $applied_jop->update([
                'status' => 'rejected'
            ]);
            $applied_jop->save();
            return response()->json([
                'status' => '200',
                'message' => 'Job application rejected.',
            ], 200);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'Job application not found'
            ]);
        }
    }
    public function workerAcceptedApplications()
    {
        $user = Auth::user();
        $applied_jop = AppliedJop::where([
            ['user_id', $user->id],
            ['status', 'accepted'],
        ])->get();
        return response()->json([
            'status' => '200',
            'Accepted Applications' => $applied_jop,
        ], 200);
    }
    public function applicationdelete($id)
    {
        $applied_jop = AppliedJop::where('id', $id)->first();
        if ($applied_jop) {
            $applied_jop->delete();
            return $this->apiResponse(200,"successfully ");
        }
        return $this->apiResponse(400,"error ");
    }

}