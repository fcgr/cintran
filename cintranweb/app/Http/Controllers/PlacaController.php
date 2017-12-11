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

		if(Placa::validarDirecao( [ $dados['id'], $dados['esquerda'], $dados['frente'], $dados['direita'],
									$dados['desquerda'], $dados['dtras'], $dados['ddireita'] ] )){
			$placa = Placa::create($dados);
			FileTransferHelper::criarArquivoCad($dados);
			$mensagem = "Placa cadastrada com sucesso!";
			$tipo = "success";
			$placa->atualizarDependencias($dados);
			
		}else{
			$mensagem = "Falha ao analisar dependencias. Favor verificar se existe repetição ou auto dependência";
			$tipo = "danger";
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
		$mensagem = "";
		$tipo = "";
		if(!$placa){
			return redirect()->action('PlacaController@listar', ["mensagem" =>"Placa {$id} não encontra!", "tipo" => "danger"]);
		}
		if(Placa::validarDirecao( [ $dados['id'], $dados['esquerda'], $dados['frente'], $dados['direita'],
			$dados['desquerda'], $dados['dtras'], $dados['ddireita'] ] ) ){
			
			$placa->update($dados);
			FileTransferHelper::criarArquivoCad($dados);
			$mensagem = "Placa cadastrada com sucesso!";
			$tipo = "success";
			$placa->atualizarDependencias($dados);

		}else{
			$mensagem = "Falha ao analisar dependencias. Favor verificar se existe repetição ou autodependência";
			$tipo = "danger";
		}		

		return redirect()->action('PlacaController@listar', ["mensagem" =>$mensagem, "tipo" => $tipo ]);
	}

	public function excluir($id){
		$placa = Placa::find($id);
		$placa->delete();

		return redirect()->action('PlacaController@listar', ["mensagem"=>"Placa removida com sucesso!"]);
	}
}
