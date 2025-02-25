@extends('layouts.app')

@section('title', 'Verifycode')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
  
      <!-- Icon -->
      <div class="fadeIn first">
        <h3>Ingrese el codigo de verificación de Session</h3>
      </div>
      <!-- Verifiar Codigo -->
      <form method="POST" action="{{ route('verifysession', ['id' => $id]) }}"">
    @csrf
    <input type="text" id="codi" name="code" class="fadeIn second" value="{{ old('code') }}" maxlength="6" placeholder="Código" />
    <div class="form-group">
      <label for="captcha">Verificación de seguridad</label>
      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
      @if ($errors->has('g-recaptcha-response'))
        <span style="color: red;">{{ $errors->first('g-recaptcha-response') }}</span>
      @endif
    </div>
    <input type="submit" class="fadeIn fourth" value="Enviar">
</form>
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
<style>
    #codi {
        width: 300px; 
        height: 45px;
        text-align: center;
        font-size: 20px;
        border: 2px solid #ccc;
        border-radius: 5px;
        letter-spacing: 10px;
    }

    #codi:focus {
        border-color: #5fbae9;
        outline: none;
    }

    #codi.invalid {
        border-color: red;
    }
</style>

@endsection
