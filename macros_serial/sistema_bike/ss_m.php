<?



//

set_time_limit(0);



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

$ss_sql = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0, 1, '');
$ss_sql2 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0, 1, '');
$ss_sql3 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0, 1, '');
$ss_sql4 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1, 1, '');
$ss_sql5 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0, 0, '');
$ss_sql6 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0, 0, '');
$ss_sql7 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0, 0, '');
$ss_sql8 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1, 0, '');



$arr_1 = criaArray ($ss_sql);
$arr_2 = criaArray ($ss_sql2);
$arr_3 = criaArray ($ss_sql3);
$arr_4 = criaArray ($ss_sql4);
$arr_5 = criaArray ($ss_sql5);
$arr_6 = criaArray ($ss_sql6);
$arr_7 = criaArray ($ss_sql7);
$arr_8 = criaArray ($ss_sql8);

$array_todos_ss = concat ($arr_1, $arr_2, $arr_3, $arr_4, $arr_5, $arr_6, $arr_7, $arr_8);

$lista_ss = geraDados ($array_todos_ss);

$lista = geraDados ($array_todos_ss);



//print_r($ss_sql);

///phpinfo();



$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));



//var_dump($pos_cat);

function geraDados ($arr_comp) {



	/*global $pos_cat;

	$retorno = '';

	$arr_retorno = array();*/
	
	
	
	
	
	
	$retorno = '';

	$arr_retorno = array();

	global $pos_cat;

	global $int_id_ss;

	global $arr_ss;

	global $campeonato;

	global $col_stat;
	
for ($y=0;$y<50;$y++) $pos_cat[$y][0]=1;



	for ($i=0;$i<count($arr_comp);$i++) {



		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];		

		//if ($pos_cat[$cat_num][$i]==0) $pos_cat[$cat_num] = 1;
		
		



		//
		//if ($arr_comp[$i]["forfete"]==1) {
		//	array_push($arr_retorno[$i],'NC');
		//}
		//else
		if ($arr_comp[$i]["total"]!="* * *" && $arr_comp[$i]["C"]!="* * *") {

			array_push($arr_retorno[$i],($arr_comp[$i]["c03_status"]=="D")?"D":($i+1));

		}

		else array_push($arr_retorno[$i],'NC');



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		

		//

		$piloto = nomeComp($arr_comp[$i]['piloto']);

		$navegador = nomeComp($arr_comp[$i]['navegador']);

		$navegador2 = nomeComp($arr_comp[$i]['navegador2']);

		//

		$tripulacao = '<div class="trip" id="div">';

		$tripulacao .= "<b>".$piloto."</b><br>";

		$tripulacao .= "<b>".$navegador."</b><br>";

		$tripulacao .= "<b>".$navegador2."</b>";

		$tripulacao .= $arr_comp[$i]["modelo"]."<br />";
		$tripulacao .= $arr_comp[$i]["equipe"];

		$tripulacao .= '</div>';



		array_push($arr_retorno[$i],$tripulacao);



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["tripulacao_origem"]);

		//array_push($arr_retorno[$i],$arr_comp[$i]["modalidade"]);

		



		//

		if ($arr_comp[$i]["total"]!="* * *") {
			$pos = $pos_cat[$cat_num][0];
		}
		else {
			$pos = 'NC';
		}
		$pos_cat[$cat_num][0] ++;
//$pos = '';

		//

		array_push($arr_retorno[$i],"(".$pos.")".$arr_comp[$i]["categoria"]);

		//

		//array_push($arr_retorno[$i],1);



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["CH"]);



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["L"]);





		//

		$reacao = ($arr_comp[$i]["R"]<0) ? "<font color='red'>" : "";

		$reacao .= $arr_comp[$i]["R"];

		$reacao .= ($arr_comp[$i]["R"]<0) ? "</font>" : "";

		//array_push($arr_retorno[$i],$reacao);



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["I1"]);		



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["I2"]);		



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["C"]);

		//array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);



		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["P"]);		

		

		//

		//array_push($arr_retorno[$i],$arr_comp[$i]["A"]);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["total"]);



		//

		//array_push($arr_retorno[$i],round($arr_comp[$i]["velocidade"],2));



		//

		array_push($arr_retorno[$i],substr($arr_comp[$i]["dif1"],-8));
		//array_push($arr_retorno[$i],$arr_comp[$i]["dif1"]);



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



$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);



$cat_txt = $cat[0]["c13_descricao"];



if ($cat_txt=="") {



	if ($mod=="C") 	$cat_txt = "Carros/Caminh&otilde;es";

	elseif ($mod=="M") $cat_txt = "Motos/Quadric&iacute;clos - Bikes and Quads";

	elseif ($modalidade==1) $cat_txt = "Carros";

	elseif ($modalidade==2) $cat_txt = "Caminh&otilde;es";

	elseif ($modalidade==3) $cat_txt = "Motos - Bikes";

	elseif ($modalidade==4) $cat_txt = "Quadric&iacute;clos - Quads";



	else $cat_txt = "Todos/Overall";



}



$numero_trecho = $int_id_ss;



if ($sss[0]) $numero_trecho = $sss[0];







$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);







$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];



$trecho_txt1 = $tre[0]["c02_nome"]." - ".utf8_encode($tre[0]["c02_origem"])." - ".utf8_encode($tre[0]["c02_destino"])." - ".$dist_esp_tot."km";



$dist_esp = $tre[0]["c02_distancia"];



$desloc1 = $tre[0]["c02_desl_ini"];



$desloc2 = $tre[0]["c02_desl_fin"];



//if ($tre[0]["c02_status"]=="F") 	$status = "<br>Resultados Oficiais/Official Results";

//else 								$status .= "<br>Resultados Extra-Oficiais/Provisional Results";



if ($tre[0]["c02_status"]=="F") 	$status = "<br>Resultados Oficiais";

else 								$status .= "<br>Resultados Extra-Oficiais";



$txt_especifico = date("D M j G:i:s T Y");



//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";



$txt_especifico .= "".$status;



//$txt_especifico .= "<br>Categoria/Category: ".$cat_txt;

$txt_especifico .= "<br><font size='4'><b>Categoria: ".$cat_txt."</b></font>";



echo printHeader($numero_trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato, ($k+1)."/".$pag, $status);



			



?>



<tr>



  <td height="60" colspan="2" valign="top">











	<!-- ////////////////////////////////////////////////////////////////////////////// //-->



<table cellpadding="5" cellspacing="0" class="tb1">



<?







// campos do cabecalho



$campos_header_ss = array();

//Pos, No, Nome, Nat, (Pos) Cat, Tempo, Penal, Bonus, Tempo Total, Vel. Media, Dif 1º

array_push($campos_header_ss,"Pos");

array_push($campos_header_ss,"No");

array_push($campos_header_ss,"Piloto / Navegador");

//array_push($campos_header_ss,"Nat");

//array_push($campos_header_ss,"Mod");

array_push($campos_header_ss,"(Pos)Cat");

//array_push($campos_header_ss,"Cat<br />Pos");

//array_push($campos_header_ss,"Gr<br />pos");

//array_push($campos_header_ss,"CH");

//array_push($campos_header_ss,"Largada");

//array_push($campos_header_ss,"T.R.");

//array_push($campos_header_ss,"Parcial<br />1");

//array_push($campos_header_ss,"Parcial<br />2");

//array_push($campos_header_ss,"Chegada");

//array_push($campos_header_ss,"Tempo");

//array_push($campos_header_ss,"Penal.");

//array_push($campos_header_ss,"Bonus");

array_push($campos_header_ss,"Total");

//array_push($campos_header_ss,"Vel.(km/h)");

array_push($campos_header_ss,"Dif 1o.");



//retorno dos classificados



echo printTableHeader($campos_header_ss);







//echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $header_txt, $report_date, $print);



echo geraLinhaHtml ($lista, 1, "", $campos_header_ss, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);











?>



</table>



    <!-- ///////////////////////////



    <?= $ss_sql ?>



    /////////////////////////////////////////////////// //-->



    



    



    



    



    <!-- ///////////////////////////



    <?= $ss_sql2 ?>



    /////////////////////////////////////////////////// //-->











  </td>



</tr>







//<?= $footer ?>



//</table>











//</table>



//</body>



//</html>



