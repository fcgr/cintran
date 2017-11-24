<?php namespace cintran\Helpers;

class FileTransferHelper{
	
	private static $_fileDir = 'C:\workspace\cintranweb\files';
	
	public static function criarArquivoCad($dados){

		$nomeArquivo = self::$_fileDir . '\\' . date('YmdHis') . '.cad';

		$arquivo = fopen($nomeArquivo, 'w+');
		fwrite($arquivo, "{$dados['id']}|{$dados['entrada']}|{$dados['saida']}");
		fclose($arquivo);

	}

}