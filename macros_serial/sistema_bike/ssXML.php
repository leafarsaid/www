<?



//

set_time_limit(0);



//

header("Content-type: text/xml; charset=utf-8",true);

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



//sqls
/*
$ss_sql = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 0, '');

$ss_sql2 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 0, 0, 0, '');

$ss_sql3 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 1, 0, '');

$ss_sql4 = geraSqlSS($int_id_ss, $int_id_cat, $int_id_mod, $campeonato, $mod, 1, 0, 1, '');



$arr_classif_ss = criaArray ($ss_sql);

$arr_nao_classif_ss = criaArray ($ss_sql2);

$arr_nc_ss = criaArray ($ss_sql3);

$arr_desclassif_ss = criaArray ($ss_sql4);

$array_todos_ss = concat ($arr_classif_ss, $arr_nao_classif_ss, $arr_nc_ss, $arr_desclassif_ss);

$lista_ss = geraDados ($array_todos_ss);

$lista = geraDados ($array_todos_ss);
*/

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

function geraDados ($arr_comp) {



	global $pos_cat;

	$retorno = '';

	$arr_retorno = array();
	
$pos_cat[10][0]=1;
$pos_cat[11][0]=1;
$pos_cat[12][0]=1;
$pos_cat[13][0]=1;
$pos_cat[14][0]=1;
$pos_cat[15][0]=1;
$pos_cat[16][0]=1;
$pos_cat[17][0]=1;
$pos_cat[20][0]=1;
$pos_cat[21][0]=1;
$pos_cat[22][0]=1;
$pos_cat[30][0]=1;
$pos_cat[31][0]=1;
$pos_cat[32][0]=1;
$pos_cat[33][0]=1;
$pos_cat[34][0]=1;
$pos_cat[35][0]=1;
$pos_cat[36][0]=1;
$pos_cat[40][0]=1;
$pos_cat[41][0]=1;



	for ($i=0;$i<count($arr_comp);$i++) {



		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];		

		//if ($pos_cat[$cat_num][$i]==0) $pos_cat[$cat_num] = 1;



		//

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

		$tripulacao .= $arr_comp[$i]["modelo"];

		$tripulacao .= '</div>';



		array_push($arr_retorno[$i],$piloto);

		array_push($arr_retorno[$i],$navegador);

		array_push($arr_retorno[$i],$navegador2);

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["tripulacao_origem"]);

		

		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["modelo"]));
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["equipe"]));
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["c10_codigo"]));





		//array_push($arr_retorno[$i],$arr_comp[$i]["modalidade"]);

		



		//

		if ($arr_comp[$i]["total"]!="* * *") 

		$pos = $pos_cat[$cat_num][0];

		else 

		$pos = 'NC';

		$pos_cat[$cat_num][0] ++;

//$pos = '';

		//

		array_push($arr_retorno[$i],"(".$pos.")".$arr_comp[$i]["categoria"]);

		//

		

		//

		$reacao = ($arr_comp[$i]["R"]<0) ? "<font color='red'>" : "";

		$reacao .= $arr_comp[$i]["R"];

		$reacao .= ($arr_comp[$i]["R"]<0) ? "</font>" : "";

		array_push($arr_retorno[$i],$reacao);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["L"]);	
		
		
		//

		array_push($arr_retorno[$i],$arr_comp[$i]["I1"]);		



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["I2"]);		



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["P"]);		

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["A"]);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["total"]);



		//

		array_push($arr_retorno[$i],round($arr_comp[$i]["velocidade"],2));



		//

		array_push($arr_retorno[$i],substr($arr_comp[$i]["dif1"],-8));



	}



	return $arr_retorno;



}









/*$texto = sprintf("<\?xml version=\"1.0\" encoding=\"utf-8\"\?>\n\r");*/

$texto = sprintf("<especial dia=\"%s\">\n\r",$trecho);



// campos do cabecalho



$campos_header_ss = array();

array_push($campos_header_ss,"colocacao");

array_push($campos_header_ss,"numeral");

array_push($campos_header_ss,"piloto");

array_push($campos_header_ss,"navegador");

array_push($campos_header_ss,"navegador2");

array_push($campos_header_ss,"origem");

array_push($campos_header_ss,"modelo");
array_push($campos_header_ss,"equipe");
array_push($campos_header_ss,"modalidade");

array_push($campos_header_ss,"categoria");

array_push($campos_header_ss,"ch");

array_push($campos_header_ss,"largada");

array_push($campos_header_ss,"parcial");

array_push($campos_header_ss,"parcial2");

array_push($campos_header_ss,"chegada");

array_push($campos_header_ss,"tempo");
array_push($campos_header_ss,"penalidade");
array_push($campos_header_ss,"bonus");

array_push($campos_header_ss,"total");

array_push($campos_header_ss,"velocidade");

array_push($campos_header_ss,"diferenca_lider");



$texto .= geraLinhaXml ("veiculo",$lista, $campos_header_ss);

      

$texto .= sprintf("</especial>\n\r");

$texto = str_replace("\" \"","\"\"",$texto);

$texto = str_replace(" \"","\"",$texto);

echo $texto;







?>

