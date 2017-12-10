<?php namespace cintran\Helpers;

class FileTransferHelper{
	
	//private static $_fileDirSaida = '/var/www/html/cintranweb/out_php/';
	//private static $_fileDirEntrada = '/var/www/html/cintranweb/in_php/';

	private static $_fileDirSaida = 'C:\workspace\out_php\\';
	
	public static function criarArquivoCad($dados){

		$nomeArquivo = self::$_fileDirSaida .  date('YmdHis') . '.cad';

		$arquivo = fopen($nomeArquivo, 'w+');
		fwrite($arquivo, "{$dados['id']}|{$dados['esquerda']};{$dados['frente']};{$dados['direita']}|{$dados['desquerda']};{$dados['dtras']};{$dados['ddireita']}");
		fclose($arquivo);

	}

	public static function criarArquivoInc($dados){
		
		$nomeArquivo = self::$_fileDirSaida .  date('YmdHis') . '.inc';

		$arquivo = fopen($nomeArquivo, 'w+');
		fwrite($arquivo, "{$dados['placa_id']}|{$dados['tipo']}");
		fclose($arquivo);

	}

}
