<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Exceptions\signupException;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginInputFormReqest;
use App\Exceptions\RequestValidationException;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    //@desc     Signup New User
    //@route    POST api/register
    //@access   Public
    public function register(SignupRequest $request)
    {
        try {
            //create user
            $user =  User::create([
                'email' => $request->email,
                'fname' => $request->sname,
                'sname' => $request->fname,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            //return success response is succesfully created
            return response()->json(["status" => true, "message" => "Account created succesffully", "data" => new UserResource($user)], 200);
        } catch (Exception $e) {
            //throw exception idf error
            throw new signupException();
        }
    }


    //@desc     User Login
    //@route    POST api/login
    //@access   Public
    public function login(LoginInputFormReqest $request)
    {
        //Search user whose email is supplied 
        $user = User::where("email", $request->email)->first();

        //If user is not found throw exception
        if (!$user) throw new RequestValidationException("Invalid account credentials provided");

        //Hash the login password and compare with what is in database, iof does not match throw exception
        if (!Hash::check($request->password, $user->password)) throw new RequestValidationException("Invalid account credentials provided");

        //return Login success response with token
        return response()->json([
            "status" => true,
            "data" => new AuthResource($user),
            "message" => "Login successful"
        ]);
    }

    //@desc     User Login
    //@route    POST api/login
    //@access   Private
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            "message" => "Logout Successfully"
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
