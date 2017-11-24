<?php namespace cintran\Http\Controllers;

use DB;
use Request;
use cintran\Entities\Placa;
use cintran\Entities\Dependencia;
use cintran\Helpers\FIleTransferHelper;

class PlacaController extends Controller
{
	
	public function listar(){
		$placas = Placa::all();
		return view('placa.listagem')->withPlacas($placas);
	}

	public function cadastrar(){
		return view('placa.formulario');
	}

	public function adicionar(){
		$dados = Request::all();		
		$id = $dados['id'];
		$entradas =  explode(';', $dados['entrada']);
		$saidas = explode(';', $dados['saida']);

		Placa::create($dados);

		foreach ($entradas as $e) {
			Dependencia::create(['placa' => $id, 'depende_de' => $e]);
		}

		foreach ($saidas as $s) {
			Dependencia::create(['placa' => $s, 'depende_de' => $id]);
		}

		FIleTransferHelper::criarArquivoCad($dados);

		return redirect()->action('PlacaController@listar');

	}

	public function detalhes($id){
		$placa = Placa::find($id);
		return view('placa.detalhes')->withPlaca($placa);
	}
}