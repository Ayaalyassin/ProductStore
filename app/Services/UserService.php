<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function register ($request)
    {
        try {

            DB::beginTransaction();
            $num_Code = sprintf("%06d", mt_rand(1, 999999));
            $this->userRepository->create($request,$num_Code);

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
