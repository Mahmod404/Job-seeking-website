<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobUser;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    use ApiResponseTrait ;
    //
    public function index()
    {
        $jobs = Job::where('status', 'available')->get();
        return $this->apiResponse(200,"successfully ",null,$jobs);
    }
    public function EmployerJobs()
    {
        $user_jobs = Auth::user()->jobs;
        return $this->apiResponse(200,"successfully ",null,$user_jobs);
    }

    public function show($id)
    {
        $job = Job::find($id);
        if ($job) {
            return response()->json([
                'status' => '200',
                'job' => $job
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'Not Found'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'description' => 'required|min:3|max:300',
            'category' => 'required',
            'salary' => 'required',
            'location' => 'required',
            'status' => 'required',
        ]);

        if ($validations->fails()) {
            return $this->apiResponse(400, 'validation error', $validations->errors());
        }

        // return $request->user();
        // dd(Auth::user()->id);
        // $user = $request->user();
        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'salary' => $request->salary,
            'location' => $request->location,
            'status' => $request->status,
            'user_id' =>Auth::user()->id,
        ]);
        return $this->apiResponse(200, ' done ');
    }

    public function update(JobRequest $request, $id)
    {
        $user = Auth::user();
        $job = Job::find($id);
        if ($job) {
            if ($user->id == $job->user_id) {
                $job->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'category' => $request->category,
                    'salary' => $request->salary,
                    'location' => $request->location,
                ]);
                return response()->json([
                    'message' => 'Job Updated Successfully',
                    'job' => $job
                ]);
            } else {
                return response()->json([
                    'status' => '403',
                    'message' => 'Unauthorised',
                ]);
            }
        } else {
            return response()->json([
                'status' => '403',
                'message' => 'Job Not found',
            ]);
        }
    }

    public function destroy($id)
    {
        // return $id ;
        try {
            $job = Job::where([['id',$id],['user_id',Auth::user()->id]])->first();
            $job->delete();
            return $this->apiResponse(200, ' done ');
            } catch (\Throwable $th) {
            //throw $th;
            return $this->apiResponse(400, ' error ' , $th->getMessage());
        }

    }

    public function test($id)
    {
        $user = Auth::user();
        $usersJobs = $user->jobs;
        $job = Job::find($id);
        $user_job = $job->user;
            return response()->json([
                'user' => $user,
                'user2' => $user_job,
            ]);
    }
}
