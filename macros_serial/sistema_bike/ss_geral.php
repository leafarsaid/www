<?

//
set_time_limit(0);

//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
$prova=(int)$_REQUEST["prova"];

		if ($prova==2) $col_stat = "c03_status2";
		else $col_stat = "c03_status";

//
require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);
require_once"util/especiais.php";

if (!$_REQUEST["num_linhas"]) $_REQUEST["num_linhas"]=2000;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?
if ($_GET["tv"]==1) {

$_GET["print"]=1;
?>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<meta http-equiv="refresh" content="60">
<SCRIPT language=JavaScript1.2>

//change 1 to another integer to alter the scroll speed. Greater is faster
var speed=1
var currentpos=0,alt=1,curpos1=0,curpos2=-1
function initialize(){
startit()
}
function scrollwindow(){
if (document.all &&
!document.getElementById)
temp=document.body.scrollTop
else
temp=window.pageYOffset
if (alt==0)
alt=2
else
alt=1
if (alt==0)
curpos1=temp
else
curpos2=temp
if (curpos1!=curpos2){
if (document.all)
currentpos=document.body.scrollTop+speed
else
currentpos=window.pageYOffset+speed
window.scroll(0,currentpos)
}
else{
currentpos=0
window.scroll(0,currentpos)
}
}
function startit(){
setInterval("scrollwindow()",50)
}
window.onload=initialize
</SCRIPT>
<?
  }
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

function retorna_footer($footer) {
	$linha = "<!-- ////////////////////////////////////////////////////////////////////////////// //-->";
	$linha .= "</td>";
	$linha .= "</tr>";
	$linha .= $footer;
	
	return $linha;
}

//
$flt_inicio=microtime(1);
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$arr_vcl=(array)$_REQUEST["veiculo"];
$str_hdr_rpt=$_REQUEST["txt_cabecalho"];
$campeonato=$_REQUEST["campeonato"];

$relatorio_ss_geral = 1;

$ss_geral=(int)$_REQUEST["ss_geral"];


////
//$init = criaArray ("SELECT * FROM t02_trecho ORDER BY c02_codigo");
//for ($j=0;$j<8;$j++) { 
//	if ($init[$j]["c02_codigo"]==($j+1) && $init[$j]["c02_status"]!="NI") $int_id_ss=($j+1); 
//}

	//if ($int_id_ss=="") $int_id_ss=5;
	//$arr_ss=explode(",","1,2");




$ss_geral=(int)$_REQUEST["ss_geral"];

//sqls
//$ss_sql = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, 1);
//$ss_sql2 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, 0);
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
if ($num_linhas) {
	$pag = count($lista_ss)/$num_linhas;
	if (($pag - (int)$pag) == 0) 	$pag = (int)$pag;
	else 							$pag = (int)$pag+1;
} else $pag = 1;



//$geral_sql = geraSqlGeral($int_id_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, 1);
//$geral_sql2 = geraSqlGeral($int_id_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, 0);
$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1,0,0);
$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0,0,0);
$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1,1,0);
$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1,0,1);
$arr_classif_geral = criaArray ($geral_sql);
$arr_nao_classif_geral = criaArray ($geral_sql2);
$arr_nc_geral = criaArray ($geral_sql3);
$arr_desclassif_geral = criaArray ($geral_sql4);
$array_todos_geral = concat ($arr_classif_geral,$arr_nao_classif_geral,$arr_nc_geral,$arr_desclassif_geral);
$lista_geral = geraDadosGeral ($array_todos_geral);

//print_r($lista_ss);
///phpinfo();

$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));

function geraDados ($arr_comp) {
	$retorno = '';
	$arr_retorno = array();
	
	global $pos_cat;
	global $int_id_ss;
	global $col_stat;

	for ($i=0;$i<count($arr_comp);$i++) {
		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];
		
		
		/////////////////////////////
		$stat = $arr_comp[$i][$col_stat];
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") { 
			$txt_pos = ( $i+1 );
		}
		else {
			$txt_pos = "NC";
		}
		if ($stat=="NC") $txt_pos = "NC";
		if ($stat=="D") $txt_pos = "D";
		//
		/*
		if ($stat > 0 && $stat < 100) {
			if ($stat >= $int_id_ss) $txt_pos = "D";
		} 
		if ($stat < 0) {
			if (($stat*(-1)) <= $int_id_ss) $txt_pos = "D";
		} 
		if ($stat == 99) {
			$txt_pos = "NC";
		}
		*/
		//$txt_pos = $stat;
		//			
		array_push($arr_retorno[$i],$txt_pos);
		////////////////////////////

		//
		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		$piloto = nomeComp($arr_comp[$i]["piloto"]);
		$navegador = nomeComp($arr_comp[$i]["navegador"]);
		$navegador2 = nomeComp($arr_comp[$i]["navegador2"]);
		
		$tripulacao = '<div class="trip" id="div">';
		if ($arr_comp[$i]["piloto"]!="") $tripulacao .= "<b>".$piloto."</b><br>";
		if ($arr_comp[$i]["navegador"]!="") $tripulacao .= "<b>".$navegador."</b><br>";
		if ($arr_comp[$i]["navegador2"]!="") $tripulacao .= "<b>".$navegador2."</b><br>";
		$tripulacao .= $arr_comp[$i]["equipe"];
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
	
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") 
		$txt_pos = $pos_cat[$cat_num][0]+1;
		else 
		$txt_pos = 'NC';			
		$pos_cat[$cat_num][0] ++;		
		array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);

		//
		//array_push($arr_retorno[$i],substr($arr_comp[$i]["tempo"],-8,-1));
		array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);
		
		//
		//array_push($arr_retorno[$i],substr($arr_comp[$i]["P"],-8,-1));
		array_push($arr_retorno[$i],$arr_comp[$i]["P"]);

		//
		//array_push($arr_retorno[$i],substr($arr_comp[$i]["total"],-8,-1));
		array_push($arr_retorno[$i],$arr_comp[$i]["total"]);

		//
		//array_push($arr_retorno[$i],substr($arr_comp[$i]["dif1"],-8,-1));
		array_push($arr_retorno[$i],$arr_comp[$i]["dif1"]);

	}
	return $arr_retorno;
}
$pos_cat2 = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));

function geraDadosGeral ($arr_comp) {
	$retorno = '';
	$arr_retorno = array();
		
	global $pos_cat2;	
	global $int_id_ss;
	global $col_stat;

	for ($i=0;$i<count($arr_comp);$i++) {
		$arr_retorno[$i] = array();

$cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////
		$stat = $arr_comp[$i][$col_stat];
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") { 
			$txt_pos = ( $i+1 );
		}
		else {
			$txt_pos = "NC";
		}
		if ($stat=="NC") $txt_pos = "NC";
		if ($stat=="D") $txt_pos = "D";
		//
		/*
		if ($stat > 0 && $stat < 100) {
			if ($stat >= $int_id_ss) $txt_pos = "D";
		} 
		if ($stat < 0) {
			if (($stat*(-1)) <= $int_id_ss) $txt_pos = "D";
		} 
		if ($stat == 99) {
			$txt_pos = "NC";
		}
		*/
		//			
		array_push($arr_retorno[$i],$txt_pos);
		////////////////////////////

		//
		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
		$piloto = nomeComp($arr_comp[$i]["piloto_geral"]);
		$navegador = nomeComp($arr_comp[$i]["navegador_geral"]);
		$navegador2 = nomeComp($arr_comp[$i]["navegador2_geral"]);
		
		$tripulacao = '<div class="trip" id="div">';
		if ($arr_comp[$i]["piloto_geral"]!="") $tripulacao .= "<b>".$piloto."</b><br>";
		if ($arr_comp[$i]["navegador_geral"]!="") $tripulacao .= "<b>".$navegador."</b><br>";
		if ($arr_comp[$i]["navegador2_geral"]!="") $tripulacao .= "<b>".$navegador2."</b><br>";
		$tripulacao .= $arr_comp[$i]["equipe_geral"];
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);
		// TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE TRIPULANTE
	
		
				//
		$tripulacao_origem = $arr_comp[$i]["piloto_origem"];
		if ($arr_comp[$i]["navegador_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador_origem"];
		if ($arr_comp[$i]["navegador2_origem"]!="") $tripulacao_origem .= "<br>".$arr_comp[$i]["navegador2_origem"];		
		array_push($arr_retorno[$i],$tripulacao_origem);
		
		
		// se não é desclassificado
		if ($arr_comp[$i]["c03_status"]!='D') {
			
		//
		if ($arr_comp[$i]["total_geral"]!="* * *") 
		$txt_pos = $pos_cat2[$cat_num][0]+1;
		else 
		$txt_pos = 'NC';			
		$pos_cat2[$cat_num][0] ++;		
		array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);	
		
		$status = $arr_comp[$i]["c03_status"];	
		//
		if ($status == 'D') array_push($arr_retorno[$i],"*");
				else array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);
		
		//
		if ($status == 'D') array_push($arr_retorno[$i],"*");
				else array_push($arr_retorno[$i],substr($arr_comp[$i]["P_geral"],-8,-1));

		//
		if ($status == 'D') array_push($arr_retorno[$i],"*");
				else array_push($arr_retorno[$i],$arr_comp[$i]["total_geral"]);

		//
		$l = $i-1;
		if ($l<0) $l=0;
		
		if ($arr_comp[$i]["total_geral"]!="* * *"){
		   array_push($arr_retorno[$i],secToTime($arr_comp[$i]["total_num"]-$arr_comp[$l]["total_num"]));

		   array_push($arr_retorno[$i],secToTime($arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"]));
		}
		
        else {
		   array_push($arr_retorno[$i],"* * *");

		   array_push($arr_retorno[$i],"* * *");
		}
		
		} // se não é desclassificado
		else { // se é desclassificado
			array_push($arr_retorno[$i],$arr_comp[$i]["categoria"]);
			array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
			array_push($arr_retorno[$i],"* * *");
		}

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
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center" width="800">

<?
/*
$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$categoria);
$cat_txt = $cat[0]["c13_descricao"];

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$int_id_ss);

$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$tre[0]["c02_distancia"]."km";
$desloc1 = $tre[0]["c02_desl_ini"];
$dist_esp = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];
$desloc2 = $tre[0]["c02_desl_fin"];
$txt_especifico = date("D M j G:i:s T Y");
$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results";
$txt_especifico .= "<br>Categoria/Category: ".$cat_txt;
*/


$cat = criaArray ("SELECT * FROM t13_categoria WHERE c13_codigo=".$int_id_cat);
$cat_txt = $cat[0]["c13_descricao"];
if ($cat_txt=="") {
	if ($mod=="C") 	$cat_txt = "Carros/Caminh&otilde;es";
	elseif ($mod=="M") $cat_txt = "Motos/Quadric&iacute;clos";
	elseif ($modalidade==1) $cat_txt = "Carros";
	elseif ($modalidade==2) $cat_txt = "Caminh&otilde;es";
	elseif ($modalidade==3) $cat_txt = "Motos";
	elseif ($modalidade==4) $cat_txt = "Quadric&iacute;clos";
	else $cat_txt = "Todos/Overall";
}

$numero_trecho = $int_id_ss;
if ($sss[0]) $numero_trecho = $sss[0];

$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$numero_trecho);

$trecho_txt1 = $tre[0]["c02_nome"];
$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];
//$trecho_txt1 = $tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." - ".$dist_esp_tot."km";
$dist_esp = $tre[0]["c02_distancia"];
$desloc1 = $tre[0]["c02_desl_ini"];
$desloc2 = $tre[0]["c02_desl_fin"];
if ($_REQUEST["oficial"]==1)  	$status = "<br>Resultados Oficiais/Official Results";
else 								$status .= "<br>Resultados Extra-Oficiais/Provisional Results";
$txt_especifico = date("D M j G:i:s T Y");
//$txt_especifico .= "<br><br>Resultados Acumulados/Overall Results - Motos/Bikes";
$txt_especifico .= "".$status;
$txt_especifico .= "<br>Categoria/Category: ".$cat_txt;






//echo printHeader($trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato);

// dados da especial
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL  
$campos_header_ss = array();
array_push($campos_header_ss,"Pos");
array_push($campos_header_ss,"No");
array_push($campos_header_ss,"Piloto/Navegador<br><i>Driver/Co-Driver</i>");
array_push($campos_header_ss,"(Pos)Cat");
array_push($campos_header_ss,"Tempo_s/Pen<br><i>Scratch_Time</i>");
array_push($campos_header_ss,"Penal.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><i>Penalty</i>");
array_push($campos_header_ss,"Tempo_Total&nbsp;&nbsp;&nbsp;<br><i>Total_Time</i>");
array_push($campos_header_ss,"Dif.Ant.<br><i>Diff_Prev</i>");
// ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL ESPECIAL  


//dados da geral
// GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL 
$campos_header_geral = array();
array_push($campos_header_geral,"Pos");
array_push($campos_header_geral,"No");
array_push($campos_header_geral,"Piloto/Navegador<br><i>Driver/Co-Driver</i>");
array_push($campos_header_geral,"Nat<br><i>Nat</i>");
array_push($campos_header_geral,"(Pos)Cat");
array_push($campos_header_geral,"Tempo_s/Pen<br><i>Scratch_Time</i>");
array_push($campos_header_geral,"Penal.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><i>Penalty</i>");
array_push($campos_header_geral,"Tempo_Total&nbsp;&nbsp;&nbsp;<br><i>Total_Time</i>");
array_push($campos_header_geral,"Dif.Ant.<br><i>Diff_Prev&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>");
array_push($campos_header_geral,"Dif.L&iacute;der&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><i>Diff_1st</i>");
//GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL GERAL 





/////////////////////////////////////////////////////////////////////
///////////////////////////////////////
///////////


if ($_REQUEST["num_linhas"]) {
	$lista_chunk_ss = array_chunk($lista_ss, $_REQUEST["num_linhas"]);
	$lista_chunk_geral = array_chunk($lista_geral, $_REQUEST["num_linhas"]);	
	
	for ($k=0;$k<count($lista_chunk_ss);$k++) {
		//ho printHeader($header_txt, $report_date, $_GET["print"],0);
		echo printHeader($numero_trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato, ($k+1)."/".$pag, $status);
			
		echo "<tr>";
		echo "<td valign=\"top\">";
		
		// especial
		echo "<span class=\"td1\">&nbsp;Stage Results&nbsp;</span>";
		echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"tb1\">";
		echo printTableHeader($campos_header_ss);
		$report_date = $report_date."<br>".$k."/".count($lista_chunk_ss);
		//echo geraLinhaHtml ($lista_chunk_ss[$k], 1, "", $campos_header_ss, $header_txt, $report_date, $print, "X");
		//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)
		echo geraLinhaHtml ($lista_chunk_ss[$k], 1, "", $campos_header_ss, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);
		echo "</table>";
		
		echo "</td><td valign=\"top\" style=\"border-left-width:2px; border-left-color:#000000; border-left-style:double;\">";
		
		// geral
		echo "<span class=\"td1\">&nbsp;Overall Results&nbsp;</span>";
		echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"tb1\">";
		echo printTableHeader($campos_header_geral);
		//echo geraLinhaHtml ($lista_chunk_geral[$k], 1, "", $campos_header_geral, $header_txt, $report_date, $print, "X");
		//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)
		echo geraLinhaHtml ($lista_chunk_geral[$k], 1, "", $campos_header_ss, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);
		echo "</table>";
		
		echo "</td></tr>";	
		
		echo retorna_footer($footer);
		echo "<tr class=\"separador\"><td colspan=\"2\" height=\"60\"></td></tr>";	
		echo "<tr style=\"page-break-before: always\"><td colspan=\"2\"></td></tr>";
	}
	
} else {
	//ho printHeader($header_txt, $report_date, $_GET["print"],0);
	echo printHeader($numero_trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, '', $campeonato, $pag, $status);
		
	echo "<tr>";
	echo "<td valign=\"top\">";
	
	// especial
	echo "<span class=\"td1\">&nbsp;Stage Results&nbsp;</span>";
	echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"tb1\">";
	echo printTableHeader($campos_header_ss);
	//echo geraLinhaHtml ($lista_ss, 1, "", $campos_header_ss, $header_txt, $report_date, $print);
	//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)
	echo geraLinhaHtml ($lista_chunk_ss, 1, "", $campos_header_ss, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);
	echo "</table>";
	
	echo "</td><td valign=\"top\" style=\"border-left-width:2px; border-left-color:#000000; border-left-style:double;\">";
	
	// geral
	echo "<span class=\"th1\">&nbsp;Overall Results&nbsp;</span>";
	echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"tb1\">";
	echo printTableHeader($campos_header_geral);
	//echo geraLinhaHtml ($lista_geral, 1, "", $campos_header_geral, $header_txt, $report_date, $print);
	//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)
	echo geraLinhaHtml ($lista_chunk_geral, 1, "", $campos_header_geral, $print, "X", $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);
	echo "</table>";
	
	echo "</td></tr>";	
	
	echo retorna_footer($footer);
	echo "<tr class=\"separador\"><td colspan=\"2\" height=\"60\"></td></tr>";	
}





//echo retorna_footer($footer);
	

?>

</table>
</table>
</body>
</html>