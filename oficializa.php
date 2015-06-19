<?php
//
session_start();
//
header("Cache-Control: no-cache, must-revalidate", true);
header("Pragma: no-cache", true);

//$db = $_REQUEST["db"];
$valor_get = explode(",",$_GET["valor"]);
//$_REQUEST["db"] = $valor_get[2];

//
require_once "util/database/include/config_bd.inc.php";
require_once "util/database/class/ControleBDFactory.class.php";

//
$href = "history.back()";

$tempo_codigo = $valor_get[0];
$tempo_tipo = $valor_get[1];
if ($valor_get[2] == "E") $acao = "OFICIAL";
elseif ($valor_get[2] == "O")  $acao = "EXCEDENTE";
elseif ($valor_get[2] == "add")  $acao = "ADD_TEMPO";
elseif ($valor_get[2] == "T")  $acao = "EXTODOS";
elseif ($valor_get[2] == "obs")  $acao = "MUDA_OBS";
$veiculo = $valor_get[3];
$trecho = $_GET["trecho"];
$tempo_valor = $_GET["tempo"];
$id_tempo = $_GET["id_tempo"];
$txt_obs = $_GET["txt_obs"];
$sinal = ($tempo_valor[0]=="-" && $tempo_valor[1]==0) ? "-" : "";
//print_r("<script>alert(".$tempo_valor.");</script>");
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
		$parte_decimal = end(explode('.', $tempo_valor));
		$parte_decimal = str_pad($parte_decimal, 2, '0', STR_PAD_RIGHT);
		$parte_decimal = $parte_decimal*1;
		$parte_decimal = ($parte_decimal<10) ? 0 : $parte_decimal;
		$sql[] = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_tipo = '$tempo_tipo' AND c03_codigo = $veiculo AND c02_codigo = $trecho";
		//$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal',(TIME_TO_SEC('$tempo_valor')), '.', $parte_decimal), '$tempo_tipo', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
		$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal',(TIME_TO_SEC('$tempo_valor')), '.','$parte_decimal'), '$tempo_tipo', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
		$testt = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal',(TIME_TO_SEC('$tempo_valor')), '.','$parte_decimal'), '$tempo_tipo', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
		break;

	case "MUDA_OBS":
		$alert = "alert('ERRO:\\n\\nFalha ao mudar a observacao')";
		$sql = "UPDATE t01_tempos SET c01_obs = '$txt_obs' WHERE c01_codigo = $id_tempo";
		break;

	}
//
if (ControleBDFactory::getControlador(DB_DRIVER)->executa($sql)) {
  $alert = "alert('CONFIRMAÇÃO:\\n\\nRegistro alterado ou inserido com sucesso. Para que a visualização da linha fique correta perante seu status, caso este tenha mudado, torna-se necessário recarregar a página. Tempo: $parte_decimal')";
  //$alert = 'alert("'.$testt.'")';
}

printf("<script>$alert</script>");
?>