<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\Http\Requests\AuthRequest;
//use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
//use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Random;

use Symfony\Component\HttpFoundation\Response;
//use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

use App\Mail\EmailUser;
use App\Mail\verifyemail;

use Illuminate\Support\Facades\Mail;
use App\Events\SendMessageToClientEvent;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\VerifiesEmails;


class AuthUserController extends Controller
{
    //use GeneralTrait;
    //public function register (AuthRequest $request)
    public function register (Request $request)
    {
        try {

            DB::beginTransaction();
            $num_Code = sprintf("%06d", mt_rand(1, 999999));
            $user=User::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => $request->password,
                'remember_token' => Str::random(60),
                'code'           =>$num_Code
            ]);
            //send code to user email
           //Notification::send($user, new CodeUserNotification($user));
           //Mail::to($user->email)->send(new EmailUser($user->code));
           //$user->sendEmailVerificationNotification();

            DB::commit();
            //return $this->returnSuccessMessage('Registering successfully');
            /*$verification_code=Str::random(30);
            $user->remember_token=$verification_code;
            $user->save();
            $subject="please verify your email address.";*/
            /*Mail::send('email.verify',['name'=>$user->name,'verification_code'=>$verification_code],
                 function($mail) use ($user->email,$user->name,$subject){
                    $ma
                 }
                );*/
                //Mail::to($user->email)->send(new verifyemail($user->name,$user->email,$verification_code));
            return response()->json('Registering successfully');
           // return response()->json('please check your email to complete your registeration');

        } catch (\Exception $ex) {
            DB::rollback();
            //return $this->returnError("", "Please try again later");
            return response()->json("Please try again later");
        }

    }

    //public function login(LoginRequest $request)
    public function login(Request $request)
    {
        try {


            $credentials = $request->only(['email', 'password']);
            $token = JWTAuth::attempt($credentials);

            if (!$token)
                //return $this->returnError('E001', 'Unauthorized');
                return response()->json("Unauthorized");

            $user =auth()->user();
            $user->token = $token;

            //return $this->returnData('user', $user);
            return response()->json($user);


        } catch (\Exception $ex) {
            //return $this->returnError("", "Please try again later");
            return response()->json("Please try again later");
        }

    }

    public function me()
    {
        //return $this->returnData('user', auth()->user());
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
                //return $this->returnSuccessMessage('Logged out successfully');
                return response()->json('Logged out successfully');
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                //return $this->returnError('', 'some thing went wrongs');
                return response()->json('some thing went wrongs');
            }
        } else {
            //return $this->returnError('', 'some thing went wrongs');
            return response()->json('some thing went wrongs');
        }
    }

    public function setcode(Request $request)
    {
        $this->validate($request,[
            'code'=>'required|string',
            'email'=>'email'
        ]);

        $code=$request->code;
        $user=User::where('email','=',$request->email)->first();
        if($code == $user->code)
        {
            $user->active="true";
            $user->save();
            //return $this->returnSuccessMessage('true');
            return response()->json('true');
        }
        //return  $this->returnError('', 'false');
        return response()->json('false');
    }

    /*public function sendEmail(Request $request)
    {
        $this->validate($request,[
           'email'=>'required|email',
        ]);
        $response=$this->broker()->sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT)
        {
            return response()->json("password reset link sent");
        }
        else{
            return response()->json("unable to send reset link");
        }
    }

    protected function broker()
    {
        return Password::broker();
    }


    public function reset(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|confirmed',
            'token'=>'reqired|string'
        ]);
        $response=$this->broker()->reset($request->only('email','password','password_confirmation','token'),
         function ($user,$password)
         {
            $user->password=bcrypt($password);
            $user->save();
         }

        );

        if($response==Password::PASSWORD_RESET)
        {
            return response()->json("password reset successfully");
        }
        else{
            return response()->json("unable to reset password");
        }
    }*/



    /*public function forgotpassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);
        $code=mt_rand(0,99999);
        $user=User::where('email','=',$request->email)->first();

        $user->code=$code;
        $user->save();

        Mail::to($user->email)->send(new EmailUser($user->code));

        return response()->json(['message'=>trans('passwords.sent')],200);

    }

    public function CodeCheck(Request $request)
    {
        $request->validate([
            'code'=>'required|string|exists:users,code'
        ]);

        $passwordResrt=User::firstWhere('code',$);
    }*/

    /*public function try_websocket()
    {
        event(new SendMessageToClientEvent());
        return response()->json('try-websocket');
    }*/

    /*public function sendVerificationEmail(Request $request)
    {

        if($request->user()->hasVerifiedEmail())
        {
            return response()->json(
                [
                    'message'=>'Already Verified'
                ]
            );
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(
            [
                'message'=>'verification link sent'
            ]
        );

    }*/

    /*public function verify(EmailVerificationRequest $request)
    {
        if($request->user()->hasVerifiedEmail())
        {
            return response()->json(
                [
                    'message'=>'Already Verified'
                ]
            );
        }
        if($request->user()->hasVerifiedEmail())
        {
            event(new Verified($request->user()));
        }

    }*/


    /*public function verifyUser($verification_code)
    {
        $check=User::where('remember_token',$verification_code)->first();
        if(!is_null($check))
        {
            if($check->is_verified==1){
               return response()->json([
                    'success'=>true,
                    'message'=>'Account already verified'
               ]);
            }

            $check->update(['is_verified'=>1]);

            return response()->json([
               'success'=>true,
                'message'=>'you have successfully verified your email address'
            ]);
        }

        return response()->json([
            'success'=>false,
             'error'=>'verification code is invalid'
         ]);



    }*/



    public function sendVerifyMail($email)
    {
        if(auth()->user())
        {
            $user=User::where('email',$email)->first();
            if($user)
            {
                $random=Str::random(40);
                $domain=URL::to('/');
                $url=$domain.'/verify-mail/'.$random;

                $data['url']=$url;
                $data['email']=$email;
                $data['title']="Email verification";
                $data['body']="please click here to below to verify your mail ";

                Mail::send('verifyMail',['data'=>$data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $user->remember_token=$random;
                $user->save();

                return response()->json('Mail send successfully');

            }
            else
            {
                 return response()->json('user is not found');
            }
        }
        else
        {
            return response()->json('user is not Authentication');
        }
    }

    public function verificationMail($token)
    {
        $user=User::where('remember_token',$token)->first();
        if($user)
        {
            $datetime=Carbon::now()->format('Y-m-d H:i:s');
            //$user=User::find($user['id']);
            //$user->remember_token='';
            $user->is_verified=1;
            $user->email_verified_at=$datetime;
            $user->save();

            return "<h1>Email verified successfully</h1>";
        }
        else
        {
            return view('404');
        }
    }
}
