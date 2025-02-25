<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\console;
use App\Mail\verifycode;
use App\Mail\verifysession;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\codigo;
class userController extends Controller
{
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe contener solo letras.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
    
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Correo NO valido, intente otro',
    
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => request('g-recaptcha-response'),
            'remoteip' => request()->ip(),
        ]);
        $responseBody = $response->json();
        // Verificar si la validación falló
        if (!$responseBody['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
        }
        // Generar código de 4 dígitos
        $code = rand(100000, 999999);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save(); 
        $codigo = new codigo();
        $codigo->codigo = $code;
        $codigo->user_id = $user->id;
        $codigo->save();

        // Enviar el código por correo
        Mail::to($request->email)->send(new verifycode($request->name, $code));
        $signedUrl = URL::signedRoute('verify.show', ['id' => $user->id], now()->addMinutes(10));
   
        return redirect($signedUrl);
    }

    public function verifycode(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|max:6',
        ]);
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => request('g-recaptcha-response'),
            'remoteip' => request()->ip(),
        ]);
        $responseBody = $response->json();
        // Verificar si la validación falló
        if (!$responseBody['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
        }
        $user = User::find($id);
        $code = codigo::where('user_id', $id)->first();
        if ($request->code != $code->codigo) {
            return response()->json(['message' => 'Código incorrecto.'], 400);
        }
        $user->status = 1;
        $user->save();
        return redirect()->route('login.show');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
         $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => request('g-recaptcha-response'),
            'remoteip' => request()->ip(),
        ]);

        $responseBody = $response->json();
        // Verificar si la validación falló
        if (!$responseBody['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
        }
    
        // Buscar usuario por email
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            // Verificar si la contraseña es correcta
            if (!\Hash::check($request->input('password'), $user->password)) {
                // Si la contraseña es incorrecta, devolvemos un error
                return back()->withErrors(['password' => 'Usuario y/o contraseña incorrectos']);
            }
        }
        if ($user->status == 0) {
            return back()->withErrors(['email' => 'Usuario y/o contraseña incorrectos']);
        }    

        $code = rand(100000, 999999);
        $codigo = new codigo();
        $codigo->codigo = $code;
        $codigo->user_id = $user->id;
        $codigo->save();
        Mail::to($request->email)->send(new verifysession($code));
        $signedUrl = URL::signedRoute('verifysession.show', ['id' => $user->id], now()->addMinutes(10));
   
        return redirect($signedUrl);

    }
    public function verifysession(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|max:6',
        ]);
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => request('g-recaptcha-response'),
            'remoteip' => request()->ip(),
        ]);
        $responseBody = $response->json();
        // Verificar si la validación falló
        if (!$responseBody['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'Error al validar el reCAPTCHA.']);
        }
        $code = Codigo::where('user_id', $id)
              ->where('codigo', $request->code) // Aquí agregas la condición AND
              ->first();
        if ($request->code != $code->codigo) {
            return response()->json(['message' => 'Código incorrecto.'], 400);
        }
        // Crear usuario
         // Recuperar al usuario por su id
        $user = User::where('id', $id)->first();
        // Iniciar sesión
        Auth::login($user);
        return redirect()->route('inicio.show');
    }
        
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
    }
}
