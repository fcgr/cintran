<?php namespace cintran\Helpers;

class FileTransferHelper{
	
	private static $_fileDirSaida = '/var/www/html/cintranweb/out_php/';
	private static $_fileDirEntrada = '/var/www/html/cintranweb/in_php/';
	
	public static function criarArquivoCad($dados){

		$nomeArquivo = self::$_fileDirSaida .  date('YmdHis') . '.cad';

		$arquivo = fopen($nomeArquivo, 'w+');
		fwrite($arquivo, "{$dados['id']}|{$dados['entrada']}|{$dados['saida']}");
		fclose($arquivo);

	}

}
