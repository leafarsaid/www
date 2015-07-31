<?

header("Content-type: text/xml; charset=utf-8",true);

header("Cache-Control: no-cache, must-revalidate",true);

header("Pragma: no-cache",true);

printf("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\r");

/* session_start();



if ($_SESSION['logado']>3 || $_SESSION['logado']==null) {	

	header("Content-type: text/html; charset=ISO-8859-1",true);	

	header("Cache-Control: no-cache, must-revalidate",true);	

	header("Pragma: no-cache",true);	

	exit("<script>document.location=\"auth.php?uri=".$_SERVER['SCRIPT_URI']."?".$_SERVER['QUERY_STRING']."\"</script>");

}*/



$prova=(int)$_REQUEST["prova"];

	if ($prova==2) $col_stat = "c03_status2";

	else $col_stat = "c03_status";

//
$int_id_ss=(int)$_REQUEST["trecho"];
if (isset($_REQUEST["dia"])) {
	$int_id_ss=(int)$_REQUEST["dia"];
	$trecho=(int)$_REQUEST["dia"];
}

require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);
require_once"util/especiais.php";
require_once"util/geraDados.php";
$rel_geral=1;

//

$flt_inicio=microtime(1);



$int_id_cat=(int)$_REQUEST["categoria"];

$int_id_mod=(int)$_REQUEST["modalidade"];

$arr_vcl=(array)$_REQUEST["veiculo"];

$str_hdr_rpt=$_REQUEST["txt_cabecalho"];

$campeonato = $_REQUEST["campeonato"];

$mod = $_REQUEST["mod"];

////

$init = criaArray ("SELECT * FROM t02_trecho ORDER BY c02_codigo");

for ($j=0;$j<12;$j++) { 

	if ($init[$j]["c02_codigo"]==($j+1) && $init[$j]["c02_status"]!="NI") $int_id_ss=($j+1); 

}	



$ss_geral=(int)$_REQUEST["ss_geral"];



//sqls geraSqlGeral($int_ss_fim, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $classi)

$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0);
$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0);
$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0);
$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 1, 0);
$geral_sql5 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1);


/*$geral_sql = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0);
$geral_sql2 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0);
$geral_sql3 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0);
$geral_sql4 = geraSqlGeral($int_id_ss, $arr_ss, $prova, $arr_vcl, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1);*/

$arr_classif = criaArray ($geral_sql);



$arr_nao_classif = criaArray ($geral_sql2);

$arr_nc = criaArray ($geral_sql3);

$arr_nc2 = criaArray ($geral_sql4);

$arr_desclassif = criaArray ($geral_sql5);

//$array_todos0 = concat ($arr_classif,$arr_nao_classif);

$array_todos = concat ($arr_classif,$arr_nao_classif,$arr_nc,$arr_nc2,$arr_desclassif);



$lista = geraDados ($array_todos);



/*if ($num_linhas) {

	$pag = count($lista)/$num_linhas;

	if (($pag - (int)$pag) == 0) 	$pag = (int)$pag;

	else 							$pag = (int)$pag+1;

} else $pag = 1;*/

$pos_cat = array(array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1),array(1));



$texto = sprintf("<geral>\n\r");

/*

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

*/

if ($int_id_ss) $numero_trecho = $int_id_ss;

//else $numero_trecho = 2;

if ($sss) $numero_trecho = $sss;

if (isset($_REQUEST["dia"])) $numero_trecho=(int)$_REQUEST["dia"];

// campos do cabecalho

$campos_header_ss = array();



array_push($campos_header_ss,"colocacao");

array_push($campos_header_ss,"numeral");

array_push($campos_header_ss,"piloto");

array_push($campos_header_ss,"origem_piloto");

array_push($campos_header_ss,"navegador");

array_push($campos_header_ss,"origem_navegador");

array_push($campos_header_ss,"navegador2");

array_push($campos_header_ss,"origem_navegador2");

array_push($campos_header_ss,"modelo");
array_push($campos_header_ss,"equipe");
array_push($campos_header_ss,"modalidade");

array_push($campos_header_ss,"categoria");



if (in_array("0", $arr_ss)) array_push($campos_header_ss,"prologo");

if (in_array("1", $arr_ss)) array_push($campos_header_ss,"ss1");

if (in_array("2", $arr_ss)) array_push($campos_header_ss,"ss2");

if (in_array("3", $arr_ss)) array_push($campos_header_ss,"ss3");

if (in_array("4", $arr_ss)) array_push($campos_header_ss,"ss4");

if (in_array("5", $arr_ss)) array_push($campos_header_ss,"ss5");

if (in_array("6", $arr_ss)) array_push($campos_header_ss,"ss6");

if (in_array("7", $arr_ss)) array_push($campos_header_ss,"ss7");

if (in_array("8", $arr_ss)) array_push($campos_header_ss,"ss8");

if (in_array("9", $arr_ss)) array_push($campos_header_ss,"ss9");

if (in_array("10", $arr_ss)) array_push($campos_header_ss,"ss10");

if (in_array("11", $arr_ss)) array_push($campos_header_ss,"ss11");

if (in_array("12", $arr_ss)) array_push($campos_header_ss,"ss12");



array_push($campos_header_ss,"tempo");

array_push($campos_header_ss,"penalidade");

array_push($campos_header_ss,"bonus");

array_push($campos_header_ss,"total");

array_push($campos_header_ss,"diferenca_anterior");

array_push($campos_header_ss,"diferenca_lider");



//echo printTableHeader($campos_header_ss);

//print_r("campeonato=".$campeonato);

//echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $header_txt, $report_date, $print, $campeonato);

//ho geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico)



//echo geraLinhaHtml ($lista, 1, $_GET["num_linhas"], $campos_header_ss, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status);

$texto .= geraLinhaXml ("veiculo",$lista, $campos_header_ss);

      

$texto .= sprintf("</geral>\n\r");

$texto = str_replace("\" \"","\"\"",$texto);

$texto = str_replace(" \"","\"",$texto);

echo $texto;

?>