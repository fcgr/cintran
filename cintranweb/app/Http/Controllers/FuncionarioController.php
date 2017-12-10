<?php

namespace cintran\Http\Controllers;

use Request;
use cintran\User;

class FuncionarioController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return view('funcionario.listagem')->withUsuarios($usuarios);
    }

    public function editar($id){
		$funcionario = User::find($id);
		return view('auth.register')->withUsuario($funcionario);
	}

	public function atualizar($id){
		$funcionario = User::find($id);
		$dados = Request::all();
		$funcionario->update($dados);

		return redirect()->action('FuncionarioController@index');
	}

	public function excluir($id){
		$funcionario = User::find($id);
		$funcionario->delete();

		return redirect()->action('FuncionarioController@index');
	}
}
