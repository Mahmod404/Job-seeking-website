<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserValidationRequest;
use Illuminate\Validation\ValidationException;

class RegisterController extends BaseController
{
    use ApiResponseTrait;


    public function login(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validations->fails()) {
            return $this->apiResponse(400, 'validation error', $validations->errors());
        }
        // $credentials = $request->only('email', 'password');
        $User = User::where('email', $request->email)->first();

        if (!$User || !Hash::check($request->password, $User->password)) {
            return $this->apiResponse(400, 'validation error', 'your email or password wrong');
        }

        $token = $User->createToken('Token')->plainTextToken;
        $return = ['User' => $User, 'access_token' => $token];
        return $this->apiResponse(200, "User login successfully ", null, $return);

        // if (!empty($request->getErrors())) {
        //     return $this->apiResponse(400, 'validation error', $request->getErrors());
        //     // return response()->json($request->getErrors(), 406);
        // }
        // // $request = $request->request()->all();
        // // dd($request->request()->email);
        // if(Auth::attempt(['email' => $request->request()->email, 'password' => $request->request()->password])){
        //     $User = Auth::user();
        //     $token = $User->createToken('Token')->plainTextToken;
        //     $return=['User' => $User,'access_token' => $token];
        //         return $this->apiResponse(200,"User login successfully ",null,$return);

        //     // return $this->sendResponse($success, 'User login successfully.');
        // }
        // else{
        //     return $this->apiResponse(400, 'validation error', 'your email or password wrong');
        // }
    }
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->apiResponse(200, "successfully ");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->apiResponse(400, "error ");
        }
    }

    public function register(Request $request)
    {
        try {
            //code...

            $validations = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|min:5|max:50|email|unique:users,email',
                'password' => 'required|min:6|max:30',
                'national_id' => 'required',
                'mobile' => 'required',
                'age' => 'required',
                'address' => 'required',
                'type' => 'required',
            ]);

            if ($validations->fails()) {
                return $this->apiResponse(400, 'validation error', $validations->errors());
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id,
                'mobile' => $request->mobile,
                'type' => $request->type,
                'address' => $request->address,
                'age' => $request->age,
            ]);
            $return = ['User' => $user, 'access_token' => $user->createToken('MyToken')->plainTextToken];
            return $this->apiResponse(200, 'Successfully', null, $return);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->apiResponse(400, 'error', $th->getMessage());
        }
    }
}