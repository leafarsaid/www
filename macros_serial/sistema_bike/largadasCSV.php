<?
//
set_time_limit(0);
//
header("Content-type: text/csv; charset=utf-8",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
require_once"util/gerador_linhas.php";
require_once"util/sql.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

//
if (isset($_REQUEST['trecho'])) $trecho=$_REQUEST['trecho'];
if (isset($_REQUEST['dia'])) $trecho=$_REQUEST['dia'];

//
$flt_inicio=microtime(1);
//$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_ss=(int)$trecho;
$int_id_cat=(int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$arr_vcl=(array)$_REQUEST["veiculo"];
$str_hdr_rpt=$_REQUEST["txt_cabecalho"];
$mod = $_REQUEST["mod"];

$ss_geral=(int)$_REQUEST["ss_geral"];

//
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

$texto = "";
for ($i=0;$i<count($array_todos_ss);$i++) {	
	$texto .= sprintf("%s;%s;%s\r\n",$dia,$array_todos_ss[$i]["c03_codigo"],$array_todos_ss[$i]["L"]);
}
echo $texto;
?>