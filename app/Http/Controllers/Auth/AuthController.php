<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Cliente');

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'Usuario Cadastrado' => $user,
            'Token de Acesso' => $token,
            'Tipo do Token' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Algo de errado não esta certo o_O'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'Mensagem' => 'Olá '.$user->name.', seja bem-vindo!',
            'Nome' => $user->name,
            'E-mail' => $user->email,
            'Id do Usuario' => $user->id,
            'Token de Acesso' => $token,
            'Tipo do Token' => 'Bearer',
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Você realizou o logout com sucesso e o token foi deletado com sucesso!'
        ];
    }
}
