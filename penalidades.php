<?
//
set_time_limit(0);
header("Content-type: text/html; charset=utf-8",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/especiais.php";
require_once"util/geraDados.php";

//
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat= ($_REQUEST["subcategoria"]) ? (int)$_REQUEST["subcategoria"] : (int)$_REQUEST["categoria"];
if (isset($trecho_final)) $numero_trecho = $trecho_final;
else if ($int_id_ss) $numero_trecho = $int_id_ss;

//sqls
$arr_penais = criaArray(geraSqlPenal($_REQUEST["trecho"], $_REQUEST["categoria"], $_REQUEST["modalidade"], $_REQUEST["mod"]));
$lista = geraDadosPenal($arr_penais);

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo o que vai no header da página
$txt_pag = "RELACAO DE PENALIDADES<br>";
if (!$_REQUEST["trecho"]) $txt_pag .= "AT&Eacute; A ";
$txt_pag .= geraTxtPag("",$_REQUEST["trechos"], $numero_trecho);

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Definindo cabeçalho da tabela
$campos_header_ss = array();

array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
array_push($campos_header_ss,"ETAPA");
array_push($campos_header_ss,"TIPO");
array_push($campos_header_ss,"TEMPO");
array_push($campos_header_ss,'<div class="trip" id="div">MOTIVO</div>');
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
							$txt_pag,
							geraTxtTimestamp($int_id_cat, $_REQUEST["modalidade"], $_REQUEST["mod"], $_REQUEST["oficial"]), $_REQUEST["fim"]); ?>
		<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">
			<tr>
				<td height="60" colspan="2" valign="top">
				<!-- ////////////////////////////////////////////////////////////////////////////// //-->
					<table cellpadding="5" cellspacing="0" class="tb1">
						<?
							echo printTableHeader($campos_header_ss);
							echo geraLinhaHtml2($lista);
						?>
					</table> 
				</td>
			</tr>
		</table>
		<? echo geraFooter($_REQUEST["categoria"], $_REQUEST["modalidade"], $_REQUEST["mod"]); ?>
	</body>
</html>