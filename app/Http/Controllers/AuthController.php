<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        session()->flash('message', 'E-mail ou senha inválidos.');

        return back();
    }

    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);


            session()->flash('success', 'Usuário registrado com sucesso!');

            return redirect()->route('acesso')->with('success', 'Usuário registrado com sucesso!');
        } catch (\Exception $e) {
            // Se ocorrer um erro, exiba uma mensagem de erro
            session()->flash('error', 'Ocorreu um erro ao registrar o usuário: ' . $e->getMessage());

            // Redirecione de volta para a página de registro
            return redirect()->route('registro');
        }

    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
