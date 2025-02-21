<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class vistasController extends Controller
{
    public function loginView()
    {
        return view('login');
    }
    public function registerView()
    {
        return view('register');
    }
    public function verifyView($id) {
        return view('verify', compact('id'));
    }
    public function inicioView()
    {
        return view('inicio');
    }
    public function verifysessionView($id)
    {
        return view('verifysession', compact('id'));
    }

}
