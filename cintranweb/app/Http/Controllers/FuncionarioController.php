<?php

namespace cintran\Http\Controllers;

use Request;
use cintran\User;
use Illuminate\Support\Facades\Validator;

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

		if($this->validator($dados)){
			$this->update($funcionario, $dados);
		}

		return redirect()->action('FuncionarioController@index');
	}

	public function excluir($id){
		$funcionario = User::find($id);
		$funcionario->delete();

		return redirect()->action('FuncionarioController@index');
	}

	private function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);
	}
	
	private function update($user, $data){
		return $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gerente' => (isset($data['gerente']) ? 1 : 0)
        ]);
	}
}
