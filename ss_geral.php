<?

//
set_time_limit(0);
//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

ini_set("simplexml_load_file", 1);
ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
ini_set("max_execution_time", 0);
ini_set("allow_url_fopen", 1);
ini_set("memory_limit", "10000M");

require_once"util/objDB.php";
require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/especiais.php";
require_once"util/geraDados.php";

//
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat = ($_REQUEST["subcategoria"]) ? (int)$_REQUEST["subcategoria"] : (int)$_REQUEST["categoria"];
if (isset($trecho_final)) $numero_trecho = $trecho_final;
else if ($int_id_ss) $numero_trecho = $int_id_ss;

$strBaseURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$exp = explode('/', $strBaseURL);
array_pop($exp);
$strBaseURL = implode('/', $exp);

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// populando a lista de valores de SS
$xml_src = $strBaseURL."/ssXML.php?".$_SERVER['QUERY_STRING'];
$xml = simplexml_load_file($xml_src);
$lista_array_ss = array();
for ($i = 0; $i < count($xml); $i++) {
	foreach($xml->veiculo[$i]->attributes() as $key => $value) {
		$lista_array_ss[$i][$key] = (string)$value;
	}
}

//--------------------------------------------------------------------------
// Tabelão de dados a serem exibidos (SS)
$i = 0;
$lista_ss = array();
foreach ($lista_array_ss as $v) {

	//POS
	$lista_ss[$i] = array();
	array_push($lista_ss[$i], "<b>".$v['pos']."</b>");

	//NO
	array_push($lista_ss[$i], $v['numeral']);

	//TRIPULACAO
	$tripulacao = '<div class="trip" id="div"><b>'.nomeComp($v['tripulacao']).'</b><br>';
	if (strlen($v['modelo']) > 0) $tripulacao .= $v['modelo'];
	$tripulacao .= '</div>';
	array_push($lista_ss[$i], $tripulacao);

	//POS(CAT)
	if (!isset($_REQUEST["categoria"])) array_push($lista_ss[$i], $v['categoria']);

	//TEMPO - DIF. LIDER
	$str_tempo_total = '<div style="font-size:14px"><b>'.substr($v['total'],0,8)."</b></div>";
	$str_tempo_total .='<br>'.substr($v['diferenca_lider'],0,8);
	array_push($lista_ss[$i], $str_tempo_total);
	$i++;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// populando a lista de valores
$xml_src = $strBaseURL."/geralXML.php?".$_SERVER['QUERY_STRING'];
$xml = simplexml_load_file($xml_src);
$lista_array_geral = array();
for ($i = 0; $i < count($xml); $i++) {
	foreach($xml->veiculo[$i]->attributes() as $key => $value) {
		$lista_array_geral[$i][$key] = (string)$value;
	}
}
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Tabelão de dados a serem exibidos (SS)
$i = 0;
$lista_geral = array();
foreach ($lista_array_geral as $v) {

	//POS
	$lista_geral[$i] = array();
	array_push($lista_geral[$i], "<b>".$v['pos']."</b>");

	//NO
	array_push($lista_geral[$i], $v['numeral']);

	//TRIPULACAO
	$tripulacao = '<div class="trip" id="div"><b>'.nomeComp($v['tripulacao']).'</b><br>';
	if (strlen($v['modelo']) > 0) $tripulacao .= $v['modelo'];
	$tripulacao .= '</div>';
	array_push($lista_geral[$i], $tripulacao);

	//POS(CAT)
	if (!isset($_REQUEST["categoria"])) array_push($lista_geral[$i], $v['categoria']);

	//TEMPO	BRUTO
	array_push($lista_geral[$i], '<b>'.substr($v['tempo'],0,8)."</b>");

	//PENAIS - BONUS
	$str_penais_bonus = '<div style="color:red">'.substr($v['penalidade'],0,8)."</div>";
	$str_penais_bonus .= '<div style="color:blue"><br>'.substr($v['bonus'],0,8)."</div>";
	array_push($lista_geral[$i], $str_penais_bonus);

	//TEMPO TOTAL - DIF. LIDER
	$str_tempo_total = '<div style="font-size:14px"><b>'.substr($v['total'],0,8)."</b></div>";
	$str_tempo_total .='<br>'.substr($v['diferenca_lider'],0,8);
	array_push($lista_geral[$i], $str_tempo_total);
	$i++;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL
$campos_header_ss = array();
array_push($campos_header_ss,"POS");
array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_ss,"(POS)CAT");
array_push($campos_header_ss,'TEMPO<div style="color:blue"><br>Dif. Lider</div>');
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL
$campos_header_geral = array();
array_push($campos_header_geral,"POS");
array_push($campos_header_geral,"NO");
array_push($campos_header_geral,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_geral,"(POS)CAT");
array_push($campos_header_geral,'TEMPO');
array_push($campos_header_geral,'<div style="color:red">Penal</div><div style="color:blue"><br>Bonus</div>');
array_push($campos_header_geral,'TOTAL<div style="font-size:10px"><br>Dif. Lider</div>');
//GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<title></title>
	</head>

	<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
		<? echo printHeader(
					"RESULTADOS PARCIAIS",
					geraTxtTimestamp($int_id_cat, $_REQUEST["modalidade"], $_REQUEST["mod"], $_REQUEST["oficial"]), $_REQUEST["fim"]); ?>
		<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ffffff" align="center" valign="top" width="100%">
			<tr valign="top">
				<td>
					<span class="td1">  <? echo geraTxtPag("", $_REQUEST["trechos"], $numero_trecho) ?>  </span>
					<table cellpadding="5" cellspacing="0" class="tb1">
						<?
							echo printTableHeader($campos_header_ss);
							echo geraLinhaHtml($lista_ss);
						?>
					</table>
				</td>
				<td>
					<span class="td1">  ACUMULADO AT&Eacute; A <? echo geraTxtPag("", $_REQUEST["trechos"], $numero_trecho) ?>  </span>
					<table cellpadding="5" cellspacing="0" class="tb1">
						<?
							echo printTableHeader($campos_header_geral);
							echo geraLinhaHtml($lista_geral);
						?>
					</table>
				</td>
			</tr>
		</table>
		<? echo geraFooter($_REQUEST["categoria"], $_REQUEST["modalidade"], $_REQUEST["mod"]); ?>
	</body>
</html>