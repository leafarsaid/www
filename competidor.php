<?
//
set_time_limit(0);

//
header("Content-type: text/html; charset=iso-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

ini_set("simplexml_load_file", 1);
ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
ini_set("max_execution_time", 0);
ini_set("allow_url_fopen", 1);
ini_set("memory_limit", "10000M");

//
require_once"util/objDB.php";
require_once "util/gerador_linhas.php";
require_once "util/sql.php";

$veiculo = $_REQUEST['veiculo'];

$strBaseURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$exp = explode('/', $strBaseURL);
array_pop($exp);
$strBaseURL = implode('/', $exp);

//--------------------------------------------------------------------------
foreach ($arr_ss AS $x) $lista_array[$x] = criaArray(setor($veiculo, $x));

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Tabela de dados a serem exibidos
$i = 0;
$lista = array();
foreach ($lista_array as $v) {

	//SETOR
	$lista[$i] = array();
	array_push($lista[$i],substr($v['setor'],0,$length_str));

	//TEMPO Saída cidade
	array_push($lista[$i],substr($v['ch1'],0,$length_str));

	//Penalização controle saída cidade
	array_push($lista[$i],substr($v['penalidade_ch1'],0,$length_str));	

	//largada
	array_push($lista[$i],substr($v['largada'],0,$length_str));	

	//chegada
	array_push($lista[$i],substr($v['chegada'],0,$length_str));	

	//tempo
	array_push($lista[$i],substr($v['tempo'],0,$length_str));	

	//TEMPO Entrada cidade
	array_push($lista[$i],substr($v['ch2'],0,$length_str));

	//Penalização controle entrada cidade
	array_push($lista[$i],substr($v['penalidade_ch2'],0,$length_str));	

	//Penalização especial
	array_push($lista[$i],substr($v['penalidade'],0,$length_str));	

	//Penalização total
	array_push($lista[$i],substr($v['penalidade_total'],0,$length_str));	

	//tempo total
	array_push($lista[$i],substr($v['tempoTotal'],0,$length_str));	
	
	
	$i++;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// campos do cabecalho da tabela
$campos_header_ss = array();
array_push($campos_header_ss,"Setor");
array_push($campos_header_ss,"CH saída");
array_push($campos_header_ss,"Penal. saída");
array_push($campos_header_ss,"Largada");
array_push($campos_header_ss,"Chegada");
array_push($campos_header_ss,"Tempo");
array_push($campos_header_ss,"CH entrada");
array_push($campos_header_ss,"Penal. entrada");
array_push($campos_header_ss,"Penalidade SS");
array_push($campos_header_ss,"Penalidade total");
array_push($campos_header_ss,"Tempo Total");

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php if ($_REQUEST['tv']>=1){ ?>
			<meta http-equiv="refresh" content="<?php echo $_REQUEST['tv']; ?>">
		<?php } ?>
		<link href="css/relatorio_print.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery.min.js"></script>
		<?php if ($_REQUEST['tv']>=1){ ?>
			<script>
			$(document).ready(function(){
				$("html, body").scrollTop(150);
				setTimeout(function () {
					$("html, body").scrollTop(150);
					$("html, body").animate({ scrollTop: $(document).height() }, <?php echo $_REQUEST['tv']; ?>000);
				}, 5000);
			});
			</script>
		<?php } ?>
				<title></title>
	</head>

	<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">
		<? echo printHeader(
					geraTxtPag("geral",$_REQUEST["trechos"], $numero_trecho),
					geraTxtTimestamp($int_id_cat, $_REQUEST["modalidade"], $_REQUEST["mod"], $_REQUEST["oficial"]), $_REQUEST["fim"]); ?>
		<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">
			<tr>
				<td height="60" colspan="0" valign="top">
					<!-- ////////////////////////////////////////////////////////////////////////////// //-->
					<table cellpadding="2" cellspacing="0" class="tb1">
					<?
						echo printTableHeader($campos_header_ss);
						echo geraLinhaHtml ($lista);
					?>
					</table>
				</td>
			</tr>
		</table>
		<? echo geraFooter($_REQUEST["categoria"], $_REQUEST["modalidade"], $_REQUEST["mod"]); ?>
	</body>

</html>