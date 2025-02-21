@extends('layouts.app')

@section('title', 'Verifycode')

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
  
      <!-- Icon -->
      <div class="fadeIn first">
        <h3>Ingrese el codigo de verificación</h3>
      </div>
      <!-- Verifiar Codigo -->
      <form method="POST" action="{{ route('verifycode', ['id' => $id]) }}">
    @csrf
    <input type="text" id="codi" name="code" class="fadeIn second" value="{{ old('code') }}" maxlength="6" placeholder="Código" />
    <input type="submit" class="fadeIn fourth" value="Enviar">
</form>
    </div>
</div>

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
