<?php

namespace cintran\Http\Controllers;

use Request;
use cintran\Entities\Incidente;
use cintran\Entities\Placa;
use cintran\Http\Requests\IncidentesRequest;
use cintran\Helpers\FileTransferHelper;

class IncidenteController extends Controller{

    public function index(){
        $incidentes = Incidente::all();
        return view('incidente.listagem')->with(["incidentes" => $incidentes]); //, "msg" => $mensagem, "tipo" => $tipo]);
    }

    public function novo(){
        return view('incidente.formulario')->with([ "placas" => Placa::allParaDependencias() ] );
    }

	public function cadastrar(IncidentesRequest $request){
		$dados = $request->all();		
        
        Incidente::create($dados);
        FileTransferHelper::criarArquivoInc($dados);

		return redirect()->action('IncidenteController@index', ["mensagem" => "Incidente cadastrado com sucesso!"]);

    }

	public function editar($id){
		$incidente = Incidente::find($id);
		return view('incidente.formulario')->with(["incidente" => $incidente, "placas" => Placa::allParaDependencias()]);
	}

	public function atualizar($id){
		$incidente = Incidente::find($id);
        $dados = Request::all();
        $dados['resolvido'] = 0;
        if(isset($dados['resolvido']))
            $dados['resolvido'] = 1;

        $incidente->update($dados);
        
        if($dados['resolvido']){
            FileTransferHelper::criarArquivoInc(['placa_id' => $dados['placa_id'], 'tipo' => 0]);
        }

		return redirect()->action('IncidenteController@index', ["mensagem" =>"Incidente alterado com sucesso!"]);
	}

}
