<?php

namespace App\Http\Controllers;

use File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUploadImageRequest;
use PhpParser\Node\Scalar\MagicConst\File as MagicConstFile;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $users = User::where('type', 'worker')->get();
        return $this->apiResponse(200, "successfully", null, $users);
    }
    public function find()
    {
        $users = User::where([['type', 'worker'], ['criminal_record_status', 'pending']])->get();
        return $this->apiResponse(200, "successfully", null, $users);
    }
    public function post_AI(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->status == 0) {
            $user->update([
                'criminal_record_status' => "rejected"
            ]);
            return $this->apiResponse(200, "rejected successfully", null, $user);
        } elseif ($request->status == 1) {
            $user->update([
                'criminal_record_status' => "approved"
            ]);
            return $this->apiResponse(200, "accepted successfully", null, $user);
        } else {
            return $this->apiResponse(200, "fail", null);
        }
    }

    public function store(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user = User::find($id);
            $image = $request->image;

            if ($user->image) {
                unlink(public_path($user->image));
            }
            $imagePath = time() . rand() . '.' . $image->extension();
            $image->move(public_path('upload'), $imagePath);
            // return 'upload/'.$imagePath;
            $user->update([
                'image' => 'upload/' . $imagePath,
            ]);
            return $this->apiResponse(200, "Uploaded image successfully");
        } catch (\Throwable $th) {
            return $this->apiResponse(400, "Uploaded image error", $th->getMessage());
        }
    }

    public function storeRecord(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user = User::find($id);
            $criminal_record = $request->criminal_record;

            // if ($user->criminal_record) {
            //     unlink(public_path($user->criminal_record));
            // }
            $criminal_recordPath = time() . rand() . '.' . $criminal_record->extension();
            $criminal_record->move(public_path('upload'), $criminal_recordPath);

            $user->update([
                'criminal_record' => 'upload/' . $criminal_recordPath,
            ]);
            return $this->apiResponse(200, "Uploaded criminal record successfully");
        } catch (\Throwable $th) {
            return $this->apiResponse(400, "Uploaded criminal record error", $th->getMessage());
        }
    }

    public function update(UserRequest $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'age' => $request->age,
            'address' => $request->address,
            'profession' => $request->profession,
            'skills' => $request->skills,
        ]);
        return response()->json([
            'status' => '200',
            'message' => 'User Updated Successfully',
        ], 200);
    }
}