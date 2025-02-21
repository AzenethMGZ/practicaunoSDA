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
        <input type="text" id="email" class="fadeIn second @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Correo">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <input type="password" id="password" class="fadeIn third @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Contraseña">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <div class="form-group">
              <label for="captcha">Verificación de seguridad</label>
              <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
              @if ($errors->has('g-recaptcha-response'))
                <span style="color: red;">{{ $errors->first('g-recaptcha-response') }}</span>
              @endif
            </div>
            <input type="submit" class="fadeIn fourth" value="Registrar" id="submitButton">
      </form>
  
    </div>
  </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=6LeaSc0qAAAAAK-nmfnXhsGu4QgUyh3Abg_X9ZEB"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeaSc0qAAAAAK-nmfnXhsGu4QgUyh3Abg_X9ZEB', {action: 'submit'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
</script>

@endsection
