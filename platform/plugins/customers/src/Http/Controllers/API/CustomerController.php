<?php

namespace Botble\Customers\Http\Controllers\API;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Customers\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
class CustomerController extends BaseController
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected $user;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->respondWithError($validator->errors(), 400);
        }

        $credentials = $request->only(['email', 'password']);


        if (!$token = auth('api')->attempt($credentials)) {
            return $this->respondWithError("Unauthorized", 401);
        }

        // Customers::where('email', $request->email)->update(array(
        //     'remember_token' => $token
        // ));
        return $this->respondWithToken($token);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return $this->respondWithError($validator->errors(), 422);
        }

        $customer = new Customers([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer->save();

        $token = JWTAuth::fromUser($customer);

        return response()->json(compact('customer', 'token'), 201);
    }

    public function logout(Request $request, BaseHttpResponse $response)
    {
        $request->user()->token()->revoke();

        return $response->setMessage(__('You have been successfully logged out!'));
    }

    public function attendance (Request $request, BaseHttpResponse $response) {
        // $user = JWTAuth::toUser("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2N1c3RvbWVyL2xvZ2luIiwiaWF0IjoxNjgyNDQ0MDk2LCJleHAiOjE2OTEwODQwOTYsIm5iZiI6MTY4MjQ0NDA5NiwianRpIjoiSldSTU5iWWFaTWR0MDM3aiIsInN1YiI6IjEyIiwicHJ2IjoiODE2ZGJlY2UwMzY3MDE1ODE0NjQwZmZjMTU5MjhkYzAxOWRlOGZhYyJ9.98SvhRMc79PMlM0yZC2nT5sfnktpYO6OG2xO7TcSrPU");
        $user = auth()->user();
        if ($user) {
            
        } else {
            return response()->json([
                "error" => true,
                "data" => "This user does not exist"
            ]);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "error" => false,
            "data" => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    protected function respondWithError($message, $type = 404)
    {
        return response()->json([
            "error" => true,
            "message" => $message,
            "type" => $type
        ]);
    }
}
