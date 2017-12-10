<?php

namespace cintran\Http\Controllers;

use Auth;
use Request;

class LoginController extends Controller{
    
    public function login(){
        $credenciais = Request::only('email', 'password');

        if(Auth::attempt($credenciais)){
            return "Usuario " . Auth::user()->name . " logado com sucesso";
        }

        return "As credenciais nao sao válidas";
    }
}
