@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <div class="fadeIn first">
                  <img src="perfil.png" id="icon" alt="User Icon" style="width: 200px" />
                </div>
                <!-- Login Form -->
                <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                    <!-- Campo Nombre -->
                    <input type="text" id="name" class="fadeIn second @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Nombre">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- Campo Correo -->
                    <input type="text" id="email" class="fadeIn second @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Correo">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- Campo Contraseña -->
                    <input type="password" id="password" class="fadeIn third @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Contraseña">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- Campo Confirmar Contraseña -->
                    <input type="password" id="confirm-password" class="fadeIn third @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Confirmar Contraseña">
                    <span id="password-error" class="error-message"></span>
                    <!-- Confirmar reCAPTCHA -->
                    <div class="form-group">
                      <label for="captcha">Verificación de seguridad</label>
                      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                      @if ($errors->has('g-recaptcha-response'))
                        <span style="color: red;">{{ $errors->first('g-recaptcha-response') }}</span>
                      @endif
                    </div>
                    
                    <input type="submit" class="fadeIn fourth" value="Registrar" id="submitButton">
                </form>
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
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
document.getElementById("confirm-password").addEventListener("input", function() {
    let password = document.getElementById("password").value;
    let confirmPassword = this.value;
    let errorMessage = document.getElementById("password-error");

    if (password !== confirmPassword) {
        this.classList.add("error"); // Poner borde rojo
        errorMessage.textContent = "Las contraseñas no coinciden.";
    } else {
        this.classList.remove("error"); // Quitar borde rojo
        errorMessage.textContent = "";
    }
});

// Evitar el envío del formulario si las contraseñas no coinciden
document.getElementById("submitButton").addEventListener("submit", function(event) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let errorMessage = document.getElementById("password-error");

    if (password !== confirmPassword) {
        event.preventDefault();
        document.getElementById("confirm-password").classList.add("error");
        errorMessage.textContent = "Las contraseñas no coinciden.";
    }
});
</script>
@endsection
