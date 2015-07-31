<?

require_once "util/database/include/config_bd.inc.php";
require_once "util/database/class/ControleBDFactory.class.php";

/*
	-----------------------------------------------------------------------------
    funcoes para gerar linhas de relatorios
	----------------------------------------------------------------------------- 
*/
function printHeader($txt_pag, $txt_timestamp, $iFIM) {
	global $prova;

	$parametros = criaArray ("SELECT * FROM t11_prova"); 
	$nome_rally = "<b>".$parametros[0]["c11_titulo"]."</b>";	
	$nome_rally .= ($iFIM) ? 
						"<font size='1'><br><b>IMN: 801/05, 810/05, 811/05, 812/05, 813/05</b></font><br>" : 
						"<br/><b>".$parametros[0]["c11_subtitulo"]."</b>";
	//if ($prova) $nome_rally .= "<br>Prova ".$prova;
	
	$header .= sprintf("%s\n","  <table border=\"0\" width=\"100%\" cellpadding=5 cellspacing=0>");
	$header .= sprintf("%s\n","   <tr class=\"bg_header\">");
	
	$header .= sprintf("%s\n","    <td align=\"left\" valign=\"top\">");
	$header .= sprintf("%s\n","     <img src=\"imagens/sertoes2014.jpg\" border=0 valign=\"center\" align=\"absmiddle\"/>");
	$header .= sprintf("%s\n","    </td>");
	
	$header .= sprintf("%s\n","    <td align=\"left\" valign=\"top\" style=\"font-family: Arial Narrow;\">");
	//if (isset($_REQUEST["titulo"])) $txt_cab .= "<br>".$_REQUEST["titulo"];
	$header .= sprintf("%s<br>%s\n",$nome_rally, $txt_pag);
	$header .= sprintf("%s\n","    </td>");
	
	$header .= sprintf("%s\n","    <td align=\"left\" valign=\"top\" style=\"font-family: Arial Narrow;\">");
	$header .= sprintf("%s\n",$txt_timestamp);
	$header .= sprintf("%s\n","    </td>");
	
	$header .= sprintf("%s\n","    <td align=\"right\" valign=\"top\">");
	//$header .= sprintf("%s\n","     <img src=\"imagens/patr3.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/patr1.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/patr2.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/balada.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/goias.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/patr6.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	//$header .= sprintf("%s\n","     <img src=\"imagens/patr4.jpg\" border=0 align=\"absmiddle\"/>");
	$header .= sprintf("%s\n","    </td>");
	
	$header .= sprintf("%s\n","   </tr>");
	$header .= sprintf("%s\n","  </table>");
	return $header;
}

/**
*
*
*/
function nomeComp($nome_original) {
	$nome_pil = explode(" ",$nome_original);
	$num_palavras = count($nome_pil);			
	$nome = "";
	
	for ($j = 0; $j < $num_palavras; $j++) {
		$nome.= ltrim($nome_pil[$j])." ";
	}
	
	return ltrim(strtoupper($nome));
}

/**
*
*
*/
function xml2array ( $xmlObject, $out = array ()){
	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

	return $out;
}

/**
* secs transformed into hh:mm:ss.00
*
*/
function secToTimesecToTime($sec) {
	if ($sec > 0) {
		$hh = str_pad(round($sec/3600), 2, "0", STR_PAD_LEFT);
		$mm = str_pad(round(($sec/3600-$hh)*60), 2, "0", STR_PAD_LEFT);
		$ss = str_pad(round(($sec)-($hh*3600)-($mm*60)), 2, "0", STR_PAD_LEFT);
		if ($ss == 0) $ss="00.00";
		
		$time = $hh.":".$mm.":".$ss;
		
	} else {
		$time = "* * *";
	}
	return $time;
}

/**
*
*
*/
function secToTime($time){
	$dec = round(($time - intval($time))*10);
	if(is_numeric($time)) {
		$value = array(
		"years" => 0, "days" => 0, "hours" => 0,
		"minutes" => 0, "seconds" => 0);
	
		//
		if($time >= 31556926) {
			$value["years"] = floor($time/31556926);
			$time = ($time%31556926);
		}
		
		//
		if($time >= 86400) {
			$value["days"] = floor($time/86400);
			$time = ($time%86400);
		}

		//
		if($time >= 3600) {
			$value["hours"] = floor($time/3600);
			$time = ($time%3600);
		}

		if($time >= 60) {
			$value["minutes"] = floor($time/60);
			$time = ($time%60);
		}
		$value["seconds"] = floor($time);

		$texto = str_pad($value["hours"], 2, "0", STR_PAD_LEFT);
		$texto .= ":";
		$texto .= str_pad($value["minutes"], 2, "0", STR_PAD_LEFT);
		$texto .= ":";
		$texto .= str_pad($value["seconds"], 2, "0", STR_PAD_LEFT);
		$texto .= ".";
		$texto .= str_pad($dec, 2, "0", STR_PAD_RIGHT);

    	return $texto;
	}
	else return (bool) FALSE;
}

/**
*
*
*/
function printTableHeader($arr) {
	$header = sprintf("%s\n","  <tr class=\"td1\">");
	for ($i = 0; $i < count($arr); $i++) {
		$header .= sprintf("    <td class=\"cells\">%s</td>\n",$arr[$i]);
	}
	$header .= sprintf("%s\n","</tr>");
	return $header;
}

/**
*
*
*/
function concat() {
	$vars = func_get_args();
	$array = array();
	foreach ($vars as $var) {
		if (is_array($var)) {
			foreach ($var as $val) {$array[]=$val;}
		} else {
			$array[]=$var;
	   }
	}
	return $array;
}

/**
*  Esta função faz as consultas no banco de dados!
*
*/
function criaArray ($sql) {
	global $obj_res;
	$obj_ctrl = ControleBDFactory::getControlador(DB_DRIVER);
	$arr_retorno = array();
	
	if($obj_res=$obj_ctrl->executa($sql)) {			
		while($arr_comp = $obj_res->getLinha("assoc")){
			$arr_retorno[count($arr_retorno)] = $arr_comp;
		}
	}
	
	return $arr_retorno;
}

/**
*
*
*/
function geraLinhaXML ($nome, $arr_comp, $arr_header) {
	$retorno = '';
	$linha = '';
	for ($i = 0; $i < count($arr_comp); $i++) {
		$linha = sprintf("<");
		$linha .= sprintf("%s",$nome);
		for ($j = 0; $j < count($arr_header); $j++) 
			$linha .= sprintf(" %s=\"%s\"",$arr_header[$j],utf8_encode($arr_comp[$i][$j]));
		$linha .= sprintf(" />");
		$retorno .= sprintf("%s\n\r",$linha);
	}
	return $retorno;
}

/**
*
*
*/
function geraLinhaHtml ($arr_comp) {
	$retorno = '';
	
	for ($i = 0; $i < count($arr_comp); $i++) {
		$linha = "<tr";
		
		if($arr_comp[$i][0]=="D") $linha .= ' class="tr_pen" ';
		else {
			if ($arr_comp[$i][0]=="NC") {
				if($i%2==0) $linha .= ' class="tr2"';
				else $linha .= ' class="tr2_alt"';
			} else {
				if($i%2==0) $linha .= ' class="tr1"';
				else $linha .= ' class="tr1_alt"';
			}
		}
			
		$linha .= " >";

		for ($j = 0; $j < count($arr_comp[$i]); $j++) {
			$linha .= '<td class="cells">';
			$linha .= ltrim(rtrim($arr_comp[$i][$j]));
			$linha .= '</td>';
		}
		$linha .= '</tr>';
		$retorno .= sprintf("%s\n",$linha);
	}
	return $retorno;
}

/**
*
*
*/
function geraLinhaHtml2 ($arr_comp) {
	$retorno = '';
	$span = array();
	
	$cor = "";
	$cor1 = ' class="tr1"';
	$cor2 = ' class="tr1_alt"';
		
	
	for ($i = 0; $i < count($arr_comp); $i++) {
		$linha = "<tr";
		
		//define a cor da linha		
		if ($arr_comp[$i][1] == $arr_comp[$i-1][1]) {
			$cor = ($cor == $cor1) ? $cor1 : $cor2;
		}
		else {
			$cor = ($cor == $cor1) ? $cor2 : $cor1;
		}
		$linha .= $cor;
		$linha .= " >";

		//
		for ($j = 0; $j < count($arr_comp[$i]); $j++) {
			if ($arr_comp[$i][$j] == $arr_comp[$i-1][$j]) {
				$linha .= '<td class="cells">';
				if ($j>1) $linha .= ltrim(rtrim($arr_comp[$i][$j]));
				$linha .= '</td>';
				$span[$i][$j]++;
			}
			else {
				$linha .= '<td class="cells">';
				$linha .= ltrim(rtrim($arr_comp[$i][$j]));
				$linha .= '</td>';
				$span[$i][$j]=0;
			}
		}
		$linha .= '</tr>';
		
		//separa a tabela caso troque o n[umero do competidor
		if ($arr_comp[$i][0] <> $arr_comp[$i+1][0]) $linha .= '<tr class="td1" style="height:1px; overflow=hidden; border-bottom:double 4px #333;"><td colspan="6"></td/></tr>';
		
		$retorno .= sprintf("%s\n",$linha);
	}
	return $retorno;
}

/**
*
*
*/
function geraFooter($iCat, $iMod, $strMod) {
	$footer = "";
	$footer .= sprintf("%s\n","<table border=0 width=\"100%\">");
	$footer .= sprintf("%s\n","<tr class=\"bg_header\">");
	
	$footer .= sprintf("%s\n","<td align=\"left\">");
	$footer .= sprintf("%s\n","     <img src=\"imagens/patr3.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/patr1.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/patr2.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/balada.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/goias.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/patr6.jpg\" border=0 align=\"absmiddle\"/>&nbsp;");
	$footer .= sprintf("%s\n","     <img src=\"imagens/patr4.jpg\" border=0 align=\"absmiddle\"/>");
	
	$footer .= sprintf("%s\n"," </td><td align=\"right\">");
	$footer .= ($_REQUEST['db']=='1' || $_REQUEST['db']=='local1') ? 
					sprintf("%s   ","<img src=\"imagens/ass_dunas_cba_chrono.png\" width=300 border=0 align=\"absmiddle\"/>") : 
					sprintf("%s   ","<img src=\"imagens/ass_dunas_fim_chrono.png\" width=300 border=0 align=\"absmiddle\"/>");
	$footer .= sprintf("%s\n","</td></tr></table>");
	return $footer;
}

/**
*
*
*/
function geraTxtPag($sPag, $sTrechos, $iTrecho) {
	$tre = criaArray ("SELECT * FROM t02_trecho WHERE c02_codigo=".$iTrecho);
	$dist_esp_tot = $tre[0]["c02_distancia"] + $tre[0]["c02_desl_ini"] + $tre[0]["c02_desl_fin"];

	$txt_Pag = ($sPag == "geral") ? (($sTrechos) ? "RESULTADOS ACUMULADOS ": "ACUMULADO AT&Eacute; ") : "";
	$txt_Pag .= $tre[0]["c02_nome"].": ".$tre[0]["c02_origem"]." - ".$tre[0]["c02_destino"]." (".$dist_esp_tot."km)";
	
	return $txt_Pag;
}

/**
*
*
*/
function geraTxtTimestamp($iCat, $iMod, $strMod, $iOficial) {
	$txt_especifico = date("d/m/Y  -  H:i:s");
	$txt_especifico .= ($iOficial) ? "<br>Resultados Oficiais" : "<br>Resultados Extra-Oficiais";

	if ($iCat) {
		$temp = criaArray("SELECT c13_descricao AS descricao FROM t13_categoria WHERE c13_codigo=".$iCat);
		$txt_especifico .= "<br><font size='4'><b>Categoria: ".$temp[0]["descricao"]."</b></font>";
	}
	elseif ($iMod) {
		$temp = criaArray ("SELECT c10_descricao AS descricao FROM t10_modalidade WHERE c10_codigo=".$_REQUEST["modalidade"]);
		$txt_especifico .= "<br><font size='4'><b>Categoria: ".$temp[0]["descricao"]."</b></font>";
	}
	elseif ($strMod) {
		if ($strMod == "M") $txt_especifico .= "<br><font size='4'><b>MOTOS/QUADS</b></font>";
		elseif ($strMod == "C") $txt_especifico .= "<br><font size='4'><b>CARROS/CAMINHOES</b></font>";
	}
	
	return $txt_especifico;
}

?>