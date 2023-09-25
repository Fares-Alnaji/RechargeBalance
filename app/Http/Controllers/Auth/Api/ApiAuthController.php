<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserForgetPasswordEmail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            // dd($validator->fails());
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->balance = $request->input('balance');
            $admin->active = $request->input('active');
            $admin->password = Hash::make($request->input('password'));
            $isSaved = $admin->save();
            return response()->json(
                ['status' => $isSaved, 'message' => $isSaved ? 'Registered Successfully' : 'Registration Failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function personalLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $admin = Admin::where('email', '=', $request->input('email'))->first();
            if (Hash::check($request->input('password'), $admin->password)) {
                $token = $admin->createToken('admin-Api');
                $admin->setAttribute('token', $token->accessToken);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Login in successfully',
                        'data' => $admin
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Wrong Password, try again!'],
                    Response::HTTP_BAD_REQUEST
                );
            };
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function passwordGrantLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            try {
                $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '6',
                    'client_secret' => 'rYXfsas5tRZ4St09GTDh2JBgkRuOUBowgqpzG8Oq',
                    'username' => $request->input('email'),
                    'password' => $request->input('password'),
                ]);
                $user = User::where('email', '=', $request->input('email'))->first();
                $jsonResponse = $response->json();
                $user->setAttribute('token', $jsonResponse['access_token']);
                return response()->json(
                    ['message' => 'Login successful' , 'object' => $user],
                    Response::HTTP_OK
                );
            } catch (\Throwable $th) {
                return response()->json(
                    ['status' => false , 'message' => $th->getMessage()],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => 'Wrong Password, try again!'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        // return auth('user-api')->user()->token();
        $token = $request->user('user-api')->token();
        $revoked = $token->revoke();
        return response()->json(
            ['status' => $revoked, 'message' => $revoked ? 'Logged out Successfully' : 'Logout Failed!'],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
