<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Str;

class UserRepository
{
    public function create($request,$num_Code)
    {
        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => $request->password,
            'remember_token' => Str::random(60),
            'code'           =>$num_Code
        ]);
    }

}
