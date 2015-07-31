<?

//

set_time_limit(0);



//print_r("prova=".$id_prova);



//

header("Content-type: text/html; charset=utf-8",true);

header("Cache-Control: no-cache, must-revalidate",true);

header("Pragma: no-cache",true);



//

require_once"util/gerador_linhas.php";

require_once"util/sql.php";

require_once"util/database/include/config_bd.inc.php";

require_once"util/database/class/ControleBDFactory.class.php";

$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<?

//

$flt_inicio=microtime(1);



$int_id_ss=(int)$_REQUEST["trecho"];

$int_id_cat=(int)$_REQUEST["categoria"];

$int_id_mod=(int)$_REQUEST["modalidade"];

$arr_vcl=(array)$_REQUEST["veiculo"];

$str_hdr_rpt=$_REQUEST["txt_cabecalho"];

$mod = $_REQUEST["mod"];



$ss_geral=(int)$_REQUEST["ss_geral"];



//sqls

$penais_sql = geraSqlPenal($int_id_ss, $int_id_cat, $int_id_mod);



$arr_penais = criaArray ($penais_sql);

$lista_penais = geraDados ($arr_penais);

$lista = geraDados ($arr_penais);



function geraDados ($arr_comp) {



	global $pos_cat;

	$retorno = '';

	$arr_retorno = array();



	for ($i=0;$i<count($arr_comp);$i++) {



		$arr_retorno[$i] = array();

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		

		//

		$piloto = nomeComp($arr_comp[$i]['piloto']);

		$navegador = nomeComp($arr_comp[$i]['navegador']);

		$navegador2 = nomeComp($arr_comp[$i]['navegador2']);		

		$tripulacao = '<div class="trip" id="div">';

		$tripulacao .= "<b>".$piloto."</b><br>";

		$tripulacao .= "<b>".$navegador."</b><br>";

		$tripulacao .= "<b>".$navegador2."</b>";

		$tripulacao .= $arr_comp[$i]["modelo"];

		$tripulacao .= '</div>';

		array_push($arr_retorno[$i],$tripulacao);



		//

		if ($arr_comp[$i]["c01_tipo"]=="P") $tipo="Manual";

		if ($arr_comp[$i]["c01_tipo"]=="PT") $tipo="GPS";

		

		array_push($arr_retorno[$i], $tipo);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["c02_codigo"]);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["P"]);		

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["motivo"]);



	}



	return $arr_retorno;



}



if ($_GET["print"]==1) 	echo "<link href=\"css/relatorio_print.css\" rel=\"stylesheet\" type=\"text/css\" />";

else					echo "<link href=\"css/relatorio_video.css\" rel=\"stylesheet\" type=\"text/css\" />";



?>



<title></title>



<!--script defer type="text/javascript" src="js/pngfix.js"></script//-->



</head>



<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#000000">



<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="100%">







<?

//$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);

//$cat_txt = $cat[0]["c13_descricao"];

//if ($cat_txt=="") $cat_txt = "Todos/Overall";



$numero_trecho = $int_id_ss;

if ($sss[0]) $numero_trecho = $sss[0];



//$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);



//$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

//$trecho_txt1 = utf8_encode($tre[0]["c02_nome"]." - Penaliza&ccedil;&otilde;es");
$trecho_txt1 = utf8_encode("PENALIDADES / PENALTIES");

//$dist_esp = $tre[0]["c02_distancia"];

//$desloc1 = $tre[0]["c02_desl_ini"];

//$desloc2 = $tre[0]["c02_desl_fin"];

//if ($tre[0]["c02_status"]=="F") 	$status = "<br>Resultados Oficiais/Official Results";

//else 								$status .= "<br>Resultados Extra-Oficiais/Provisional Results";

$txt_especifico = date("D M j G:i:s T Y");

//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";

//$txt_especifico .= "".$status;

//$txt_especifico .= "<br>Categoria/Category: ".$cat_txt;

echo printHeader($numero_trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato, ($k+1)."/".$pag, $status);





?>



<tr>

  <td height="60" colspan="2" valign="top">



	<!-- ////////////////////////////////////////////////////////////////////////////// //-->

<table cellpadding="5" cellspacing="0" class="tb1">

<?



// campos do cabecalho

$campos_header_ss = array();

array_push($campos_header_ss,"No");

array_push($campos_header_ss,"Piloto / Navegador");

array_push($campos_header_ss,"Tipo");

array_push($campos_header_ss,"Especial");

array_push($campos_header_ss,"Penalidade");

array_push($campos_header_ss,"Motivo");



//retorno dos classificados

echo printTableHeader($campos_header_ss);





echo geraLinhaHtml2 ($lista, 1, "", $campos_header_ss, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);



?>

</table> 

  </td>

</tr>

<?= $footer ?>

</table>

</table>

</body>

</html>