<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\RegisterMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required']
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);

        try {
            //Mengisi variabel yang akan ditampilkan pada view mail
            $content = [
                'body' => $request->email,
            ];
            //Mengirim email ke emailtujuan@gmail.com
            Mail::to('ivanteens@gmail.com')->send(new RegisterMail($content));
        } catch (Exception $e) {
        }

        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if (!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401);

        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'message' => 'user Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $user->name = $updateData['name'];
        $user->email = $updateData['email'];

        if ($user->save()) {
            return response([
                'message' => 'Update user Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update user Failed',
            'data' => null
        ], 400);
    }
}
