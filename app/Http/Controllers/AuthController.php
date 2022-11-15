<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Membuat method register
    # fitur register
    public function register(Request $request) 
    {
        # Membuat validasi dan menangkap data
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if ($validation->fails()) {
            $data = [
                'message' => 'Validation fails',
                'status code' => 401,
            ];
        } else {
            $dataUser = [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ];
            $user = User::create($dataUser);
    
            $data = [
                'message' => 'Registration user success',
                'data' =>$user,
                'status code' => 201,
            ];         
                    # Mengembalikan response data (json) dan status kode
        return response()->json($data, $data['status code']);
        }

        # Mengembalikan response data (json) dan status kode
        return response()->json($data, $data['status code']);
    }

    # Membuat method login
    public function login(Request $request){
        # Menangkap inputan user
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        # mengambil data user
        $user = User::where('email', $input['email'])->first();

        $isLoginSuccessfully = ($input['email'] == $user->email && Hash::check($input['password'], $user->password));

        if ($isLoginSuccessfully) {
            # Membuat token
            $token = $user->createToken('auth_token');
            $data = [
                'message' => 'login successfully',
                'token' => $token->plainTextToken,
                'status code' => 200,
            ];

                # Mengembalikan response data (json) dan status kode
                return response()->json($data, $data['status code']);
        } else {
            $data = [
                'message' => 'Username or password is wrong',
                'status code' => 401,
            ];
                # Mengembalikan reponse data (json) dan status kode
                return response()->json($data, $data['status code']);
        }

    }
}
