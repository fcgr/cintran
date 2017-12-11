<?php namespace cintran\Http\Controllers;

use DB;
use Request;
use cintran\Entities\Placa;
use cintran\Entities\Dependencia;
use cintran\Helpers\FileTransferHelper;
use cintran\Http\Requests\PlacasRequest;

class PlacaController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function listar($mensagem=null){
		$mensagem = Request::get('mensagem');
		$tipo = Request::get('tipo');
		$placas = Placa::all();
		return view('placa.listagem')->with(["placas" => $placas, "msg" => $mensagem, "tipo" => $tipo]);
	}

	public function novo(){
		return view('placa.formulario')->withPlacas( Placa::allParaDependencias()  );
	}

	public function cadastrar(PlacasRequest $request){
		$dados = $request->all();		
		$mensagem = "Placa repetida nas direções";
		$tipo = "danger";

		if(Placa::validarDirecao( [ $dados['id'], $dados['esquerda'], $dados['frente'], $dados['direita'] ] )){
			Placa::create($dados);
			FileTransferHelper::criarArquivoCad($dados);
			$mensagem = "Placa cadastrada com sucesso!";
			$tipo = "success";
		}


		if($dados['desquerda']){
			$placa = Placa::find($dados['desquerda']);
			$placa->direita = $dados['id'];
			$placa->save();
		}

		if($dados['dtras']){
			$placa = Placa::find($dados['dtras']);
			$placa->frente = $dados['id'];
			$placa->save();
		}

		if($dados['ddireita']){
			$placa = Placa::find($dados['ddireita']);
			$placa->esquerda = $dados['id'];
			$placa->save();
		}

		return redirect()->action('PlacaController@listar', ["mensagem" => $mensagem, "tipo" => $tipo]);

	}

	public function editar($id){
		$placa = Placa::find($id);
		$placas = Placa::allParaDependencias();
		return view('placa.formulario')->with(["placa" => $placa, "placas" => $placas]);

	}

	public function atualizar($id){
		$placa = Placa::find($id);
		$dados = Request::all();
		$placa->update($dados);

		return redirect()->action('PlacaController@listar', ["mensagem" =>"Placa {$id} alterada com sucesso!"]);
	}

	public function excluir($id){
		$placa = Placa::find($id);
		$placa->delete();

		return redirect()->action('PlacaController@listar', ["mensagem"=>"Placa removida com sucesso!"]);
	}
}
