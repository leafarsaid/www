<html><head></head><body><pre>
<?php

// bibliotecas
require_once "../util/database/include/config_bd.inc.php";
require_once "../util/database/class/ControleBDFactory.class.php";

// criando objetos
$obj_controle = ControleBDFactory::getControlador(DB_DRIVER);

// caminho dos arquivos
//$caminho = 'penal_ss1.csv';
$caminho = 'prologo1.csv';
$caminho_log_velho = 'log_' . @strtolower($caminho);

if (@is_file($caminho)) {
	// abrindo arquivos
	$arquivo = @fopen($caminho, 'r');
	
	// lendo linha por linha do arquivo
	while ($linha = @fgets($arquivo, 256)) {		
			$arr_linha = explode(";",$linha);
			
			// instrução sql
			$trecho = $arr_linha[0];
			$competidor = $arr_linha[1];
			$arr_tempo = explode(":",$arr_linha[2]);
			$tempo = $arr_tempo[0] * 3600;
			$tempo += $arr_tempo[1] * 60;
			$tempo += $arr_tempo[2];
			$arr_tempo2 = explode(":",$arr_linha[3]);
			$tempo2 = $arr_tempo2[0] * 3600;
			$tempo2 += $arr_tempo2[1] * 60;
			$tempo2 += $arr_tempo2[2];	
			
			print_r("trecho: ".trecho."<br>");
			print_r("competidor: ".competidor."<br>");
			print_r("tempo: ".$tempo."<br>");			
			
			$sql = array();
			$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo) VALUES ($tempo, 'L', getTempoStatus($competidor, $trecho, 'L'), getCodigoVeiculo($competidor), $trecho)";
			$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo) VALUES ($tempo2, 'C', getTempoStatus($competidor, $trecho, 'C'), getCodigoVeiculo($competidor), $trecho)";		
			
			
			// insere o registro no banco
			$obj_controle->executa($sql);
			
		
	}
	
	// fechando os arquivos
	@fclose($arquivo);
	
	
	// gerando cópia do arquivo
	$arquivo_log_velho = @fopen($caminho_log_velho, 'a+');
	@fwrite($arquivo_log_velho, @file_get_contents($caminho) . "\r\n");
	print_r(@file_get_contents($caminho));
	@fclose($arquivo_log_velho);
	
	// excluindo 
	@unlink($caminho);
}

?></pre></body></html>
