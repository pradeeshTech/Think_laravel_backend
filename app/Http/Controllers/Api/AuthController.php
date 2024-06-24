<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {

            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Email & Password does not match with our record.',
                    'token' => "",
                ], 200);
            }

            $user = User::where('email', $request->email)->first();

             if(empty($user)) {
                return response()->json([
                    'status' => "failure",
                    'message' => "You are not authorized to access the mobile. Please contact your Administrator"
                ], 400);
            }

            $access_token = $this->generateToken($user);
            return response()->json([
                'status' => "success",
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'access_token' => $access_token
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failure',
                'message' => $th->getMessage(),
                'token' => ""
            ], 500);
        }
    }

    protected function generateToken($user)
    {

        $payload = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            // 'user_role' => $user->org_role,
            // 'client_id' => $user->client_id,
            // 'is_onboarded' => $user->is_onboarded,
            'active' => $user->active,
            'exp' => time() + 3600 * 3, //# Hours
        ];

        $secret_token = env('APP_KEY');
        // dd($secret_token);

        return JWT::encode($payload, $secret_token, 'HS256');
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
