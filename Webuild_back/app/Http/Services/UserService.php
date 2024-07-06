<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService{
    public function createUser(array $data):User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'national_id' => $data['national_id'],
            'mobile' => $data['mobile'],
            'type' => $data['type'],
            'address' => $data['address'],
            'age' => $data['age'],
        ]);
    }
}
