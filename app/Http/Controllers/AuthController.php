<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //muestra la vista de login
    public function showLoginForm()
    {
        return view('auth.login');
    }


//Procesa los datos del formulario de login
    public function login(Request $request)
    {
        //validar los datos del formulario
        $credentials = $request->validate([
            'nombre_usuario' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = [
            'nombre_usuario' => $credentials['nombre_usuario'],
            'password' => $credentials['password'],
        ];

        //intentar iniciar sesión con los datos validados
        if (Auth::attempt($credentials)) {
            //si la autenticación es exitosa, redirigir al usuario a la página de inicio
            $request->session()->regenerate();
            //return back()->with('success', 'Inicio de sesión exitoso');
            //return redirect()->intended('home');
            return redirect()->route('principal')->with('Inicio de sesión exitoso');
        }

        //si la autenticación falla, redirigir de nuevo al formulario de login con un mensaje de error
        return back()->withErrors([
            'nombre_usuario' => 'Las credenciales no son correctas',
        ])->onlyInput('nombre_usuario');
    }

    public function create()
    {
        return view('auth.registro');
    }

    // Guarda el nuevo usuario y redirige al dashboard
    public function store(Request $request)
{
    // 1. Validar los datos ingresados
    $request->validate([
        'nombre_usuario' => 'required|unique:usuario,nombre_usuario',
        'password' => 'required|min:4',
    ]);

    // 2. Crear el nuevo usuario encriptando la contraseña con Bcrypt
    User::create([
        'nombre_usuario' => $request->nombre_usuario,
        'password' => Hash::make($request->password),
    ]);

    // 3. Redirigir a la vista principal con mensaje de éxito
    return redirect()->route('principal')->with('success', 'Usuario registrado con éxito.');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}



