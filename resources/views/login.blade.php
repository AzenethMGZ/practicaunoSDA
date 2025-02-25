@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
    <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
  
      <!-- Icon -->
      <div class="fadeIn first">
        <img src="perfil.png" id="icon" alt="User Icon" style="width: 200px" />
      </div>
  
      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <input type="text" id="email" class="fadeIn second @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Correo" required>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <input type="password" id="password" class="fadeIn third @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Contraseña" required>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @if ($errors->has('g-recaptcha-response'))
                <span style="color: red;">{{ $errors->first('g-recaptcha-response') }}</span>
                @endif
            <input type="submit" class="fadeIn fourth" value="Entrar" id="submitButton">
      </form>
      No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a>
      </div>
    </div>
  </div>
</div>


@endsection
