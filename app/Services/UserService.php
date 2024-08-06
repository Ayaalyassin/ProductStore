<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{

    public function register ($request)
    {
        try {

            DB::beginTransaction();
            $num_Code = sprintf("%06d", mt_rand(1, 999999));
            User::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => $request->password,
                'remember_token' => Str::random(60),
                'code'           =>$num_Code
            ]);

        } catch (\Exception $ex) {
            DB::rollback();
            throw new HttpResponseException(response()->json("Please try again later"));
        }

    }

    public function login($request)
    {
        try {

            $credentials = $request->only(['email', 'password']);
            $token = JWTAuth::attempt($credentials);

            if (!$token)
                throw new HttpResponseException(response()->json("Unauthorized",401));

            $user =auth()->user();
            $user->token = $token;

            return $user;

        } catch (\Exception $ex) {
            throw new HttpResponseException(response()->json("Please try again later"));
        }

    }
}
