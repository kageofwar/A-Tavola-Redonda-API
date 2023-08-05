<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Cookie;

class AuthController extends Controller
{
    public function cadastrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //$user->assignRole('Cliente');
        //$user->assignRole('Admin');

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Algo de errado não esta certo o_O'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        Cookie::queue('token', $token, 4320);

        return response()->json([
            'mensagem' => 'Olá '.$user->name.', seja bem-vindo!',
            'nome' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id,
            'token' => $token,
            'type' => 'Bearer',
        ])->cookie('token', $token, 4320);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Você realizou o logout com sucesso e o token foi deletado com sucesso!'
        ];
    }
}
