<?php
//
session_start();
//
header("Cache-Control: no-cache, must-revalidate", true);
header("Pragma: no-cache", true);

//$db = $_REQUEST["db"];
$valor_get = explode(",",$_GET["valor"]);
$_REQUEST["db"] = $valor_get[2];

//
require_once "util/database/include/config_bd.inc.php";
require_once "util/database/class/ControleBDFactory.class.php";

//
$href = "history.back()";

//codigo, tipo, tempo_status, veiculo



/*
$tempo_codigo = $_GET["codigo"];
$tempo_valor = $_GET["tempo"];
$tempo_tipo = $_GET["tipo"];
$veiculo = $_GET["veiculo"];
$trecho = $_GET["trecho"];
$modalidade = $_GET["modalidade"];
$acao = $_GET["acao"];
*/

$tempo_codigo = $valor_get[0];
$tempo_tipo = $valor_get[1];
if ($valor_get[2] == "E") $acao = "OFICIAL";
elseif ($valor_get[2] == "O")  $acao = "EXCEDENTE";
elseif ($valor_get[2] == "add")  $acao = "ADD_TEMPO";
elseif ($valor_get[2] == "T")  $acao = "EXTODOS";
elseif ($valor_get[2] == "obs")  $acao = "MUDA_OBS";
$veiculo = $valor_get[3];
$trecho = $_GET["trecho"];
$largada_valor = $_GET["largada"];
$chegada_valor = $_GET["chegada"];
$id_tempo = $_GET["id_tempo"];
$txt_obs = $_GET["txt_obs"];
$sinal_largada = ($largada_valor[0]=="-" && $largada_valor[1]==0) ? "-" : "";
$sinal_chegada = ($chegada_valor[0]=="-" && $chegada_valor[1]==0) ? "-" : "";


//
switch (strtoupper($acao)) {
	case "EXCEDENTE":
		$alert = "alert('ERRO:\\n\\nFalha ao desoficializar tempo')";
		$sql = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_codigo = $tempo_codigo";
		break;
		
	case "EXTODOS":
		$sql = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_tipo = '$tempo_tipo' AND c03_codigo = $veiculo AND c02_codigo = $trecho";
		$alert = "alert('ERRO:\\n\\nFalha ao desoficializar tempos - $sql')";
		break;
	
	case "OFICIAL":
		$alert = "alert('ERRO:\\n\\nFalha ao oficializar tempo')";
		$sql[] = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_tipo = '$tempo_tipo' AND c03_codigo = $veiculo AND c02_codigo = $trecho";
		$sql[] = "UPDATE t01_tempos SET c01_status = 'O' WHERE c01_codigo = $tempo_codigo";
		break;
	
	case "HABILITAR":
		$alert = "alert('ERRO:\\n\\nFalha ao habilitar penalizações automáticas')";
		$sql = "UPDATE t05_trechomodalidade SET c05_status = 'P' WHERE c02_codigo = $trecho AND c10_codigo = $modalidade";
		break;
	
	case "DESABILITAR":
		$alert = "alert('ERRO:\\n\\nFalha ao desabilitar penalizações automáticas')";
		$sql = "UPDATE t05_trechomodalidade SET c05_status = 'N' WHERE c02_codigo = $trecho AND c10_codigo = $modalidade";
		break;
	
	case "ADD_TEMPO":
		$parte_decimal_largada = end(explode('.', $largada_valor));
		$parte_decimal_chegada = end(explode('.', $chegada_valor));
		
		if ($largada_valor && $chegada_valor) $where = "c01_tipo = 'L' OR c01_tipo = 'C'";
		if ($largada_valor && !$chegada_valor) $where = "c01_tipo = 'L'";
		if (!$largada_valor && $chegada_valor) $where = "c01_tipo = 'C'";
		
		$sql[] = "UPDATE t01_tempos SET c01_status = 'E' WHERE ($where) AND c03_codigo = $veiculo AND c02_codigo = $trecho";
		
		//$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo) VALUES (CONCAT('$sinal',(TIME_TO_SEC('$tempo_valor')), '.', $parte_decimal), '$tempo_tipo', 'O', $veiculo, $trecho)";
		
		if ($largada_valor) $sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal_largada',(TIME_TO_SEC('$largada_valor')), '.', '$parte_decimal_largada'), 'L', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
		if ($chegada_valor) $sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal_chegada',(TIME_TO_SEC('$chegada_valor')), '.', '$parte_decimal_chegada'), 'C', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
		
		break;
	
	case "MUDA_OBS":
		$alert = "alert('ERRO:\\n\\nFalha ao mudar a observacao')";
		$sql = "UPDATE t01_tempos SET c01_obs = '$txt_obs' WHERE c01_codigo = $id_tempo";
		break;

	}
//
if (ControleBDFactory::getControlador(DB_DRIVER)->executa($sql)) {
  $alert = "alert('CONFIRMAÇÃO:\\n\\nRegistro alterado ou inserido com sucesso. Para que a visualização da linha fique correta perante seu status, caso este tenha mudado, torna-se necessário recarregar a página.')";
  //$href = "location.href = 'ssl.php?trecho=$trecho&modalidade=$modalidade'";
}
//printf("<script>$alert</script>");
printf("<script>parent.refresh();</script>");

//

//print_r($sql);


?>