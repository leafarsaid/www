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
require_once "util/especiais.php";

// obtendo parametros da querystring
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat= ($_REQUEST["subcategoria"]) ? (int)$_REQUEST["subcategoria"] : (int)$_REQUEST["categoria"];
if (isset($trecho_final)) $numero_trecho = $trecho_final;
else if ($int_id_ss) $numero_trecho = $int_id_ss;

$strBaseURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$exp = explode('/', $strBaseURL);
array_pop($exp);
$strBaseURL = implode('/', $exp);

function timetosecc($time){
	$frag = explode(":",$time);
	$sec = $frag[0]*3600+$frag[1]*60+$frag[2];
	if ($frag[3] > 0) $sec .= ".".$frag[3];
	return $sec * 1;
}

function sectotimee($sec){
	$frag = explode(".",$sec);
	$t = $frag[0];
  	$time = sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
  	if ($frag[1] > 0) $time .= ".".$frag[1];
  	return $time;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// populando a lista de valores
$xml_src = $strBaseURL."/geralXML.php?".$_SERVER['QUERY_STRING'];
$xml = simplexml_load_file($xml_src);
$lista_array = array();
for ($i = 0; $i < count($xml); $i++) {
	
	$linha_xml = $xml->veiculo[$i]->attributes();
	
	//transformando em segundos
	foreach ($arr_ss as $ss){
		if (timetosecc($linha_xml["ss".$ss]) > 0){
			$ss_sec[$ss]['valor'] = timetosecc($linha_xml["ss".$ss]);
		}	
	}
	
	//agrupando
	for ($s = 0; $s < count($ss_sec); $s++){
		if ($s % 2 != 0){
			$dupla_ss[$s]['valor'] = $ss_sec[$s]['valor'] + $ss_sec[$s+1]['valor'];
			$dupla_ss[$s]['ss'] = $s;
		}
	}
	
		
	//encontrando melhor dupla
	foreach ($dupla_ss as $item){
		if (!isset($melhor) || $item['valor'] < $melhor['valor']){
			$melhor = $item;
		}
	}
	
	if (timetosecc($linha_xml["ss".$ss]) > 0){
		$key_aux = $melhor['valor'];
	} else{
		$key_aux = $melhor['valor']+1000000+$i;
	}	
	
	//echo $key_aux." ";
	
	foreach($linha_xml as $key => $value) {
		$lista_array[$key_aux][$key] = (string)$value;
	}

	$lista_array[$key_aux]["melhor"] = $melhor['ss'];
	if (timetosecc($linha_xml["ss".$ss]) > 0){
		$lista_array[$key_aux]["melhor_valor"] = $melhor['valor'];
	} else{
		$lista_array[$key_aux]["melhor_valor"] = "* * *";
	}
}

ksort($lista_array);
/* 
echo "<pre>";
 var_dump($lista_array);
echo "</pre>";
 */

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// Tabelão de dados a serem exibidos
$i = 0;
$lista = array();

foreach ($lista_array as $v) {
	
	if (!isset($tempo_lider)) $tempo_lider = $v['melhor_valor'];

	//POS
	$lista[$i] = array();
	array_push($lista[$i], "<b>".$v['pos']."</b>");

	//NO
	array_push($lista[$i], $v['numeral']);

	//TRIPULACAO
	$tripulacao = '<div class="trip" id="div"><b>'.nomeComp($v['tripulacao']).'</b><br>';
	if (strlen($v['modelo']) > 0) $tripulacao .= $v['modelo']."<br>";
	$tripulacao .= '</div>';
	array_push($lista[$i], $tripulacao);

	//LICENCA FIM
	if (isset($_REQUEST["fim"])) array_push($lista[$i], $v['licenca']);

	//EQUIPE
	array_push($lista[$i], '<div class="trip" id="div">'.nomeComp($v['equipe']).'</div>');

	//POS(CAT)
	if (!isset($_REQUEST["categoria"])) array_push($lista[$i], $v['categoria']);

	//TEMPOS DE CADA SS
	if ($numero_trecho == 0) $length_str = 10;
	else $length_str = 10;
	foreach ($arr_ss as $x) {
		if ($x == $v['melhor'] || $x-1 == $v['melhor']){
			array_push($lista[$i],"<b>".substr($v['ss'.$x],3,$length_str)."</b>");
		} else{
			array_push($lista[$i],substr($v['ss'.$x],3,$length_str));
		}
	}
	
	
	if ($v['melhor_valor'] > 0){
		$tempoo = sectotimee($v['melhor_valor']);
	} else{
		$tempoo = ($v['melhor_valor']);
	}

	//TEMPO	BRUTO
	array_push($lista[$i], '<b>'.substr($tempoo,3,$length_str)."</b>");

	//PENAIS - BONUS
	$str_penais_bonus = '<div style="color:red">'.substr($v['penalidade'],3,$length_str)."</div>";
	$str_penais_bonus .= '<div style="color:blue"><br>'.substr($v['bonus'],3,$length_str)."</div>";
	array_push($lista[$i], $str_penais_bonus);
	
	$totall_sec = ($v['melhor_valor'] + timetosecc($v['penalidade']) - timetosecc($v['bonus']));
	if ($totall_sec > 0) {
		$totall = sectotimee($totall_sec);
	} else{
		$totall = "* * *";
	}

	$difff = $totall_sec-$tempo_lider;
	if ($difff < 0){
		$difff = "* * *";
	} else{
		$difff = sectotimee($difff);
	}
	
	//TEMPO TOTAL - DIF. LIDER
	$str_tempo_total = '<div style="font-size:14px"><b>'.substr($totall,3,$length_str)."</b></div>";
	$str_tempo_total .='<br>'.substr($difff,3,$length_str);
	array_push($lista[$i], $str_tempo_total);
	$i++;
}

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------
// campos do cabecalho da tabela
$campos_header_ss = array();
array_push($campos_header_ss,"POS");
array_push($campos_header_ss,"NO");
array_push($campos_header_ss,'<div class="trip" id="div">PILOTO/NAVEGADOR</div>');
if (isset($_REQUEST["fim"])) array_push($campos_header_ss,"FIM No.");
array_push($campos_header_ss,'<div class="trip" id="div">EQUIPE</div>');
if (!isset($_REQUEST["categoria"])) array_push($campos_header_ss,"(POS)CAT");

foreach ($arr_especiais as $key => $value) {
	array_push($campos_header_ss, $value);
}

array_push($campos_header_ss,'TEMPO');
array_push($campos_header_ss,'<div style="color:red">Penal</div><div style="color:blue"><br>Bonus</div>');
array_push($campos_header_ss,'TOTAL<div style="font-size:10px"><br>Dif. Lider</div>');

//--------------------------------------------------------------------------
//--------------------------------------------------------------------------

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