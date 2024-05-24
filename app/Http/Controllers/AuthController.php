<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employ;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'type_document' => 'required|string',
            'document' => 'required|numeric|unique:users,document',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sex' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|string',
            'password' => 'required',
        ]);

        try {
            $user = new User();
            $user->type_document = $request->type_document;
            $user->document = $request->document;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->rol = "admin";
            $user->sex = $request->sex;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'Users created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);


        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function userProfile()
    {
        try {
            $data = [];
            $user = JWTAuth::parseToken()->authenticate();

            $data['user'] = [
                'id' => $user->id,
                'type_document' => $user->type_document,
                'document' => $user->document,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'sex' => $user->sex,
                'address' => $user->address,
                'phone' => $user->phone,
                'email' => $user->email,
                'rol' => $user->rol
            ];

            if ($user->rol == 'admin') {
                $company = Company::where('user_id', $user->id)->first();
            } else {
                $employ = Employ::where('user_id', $user->id)->first();
                $company = Company::where('id', $employ->company_id)->first();
                return response()->json([$employ, $company]);
            }

            return response()->json([
                $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        return response()->json([
            'access_token' => $token,
            'user' => [
                'id' => $user->id,
                'type_document' => $user->type_document,
                'document' => $user->document,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'sex' => $user->sex,
                'address' => $user->address,
                'phone' => $user->phone,
                'email' => $user->email,
                'rol' => $user->rol
            ],
        ]);
    }
}
