<?

// funcoes para gerar linhas de relatorios
function printHeader($trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $print, $campeonato, $pag, $status) {
	global $sss;
	global $fim;
	global $dunas;
	global $etapa;
	global $abandono;
	global $prova;
	global $print;
	$txt_cab = "";
    
	$parametros = criaArray ("SELECT * FROM t11_prova"); 
	$nome_rally = "<b>".$parametros[0]["c11_titulo"]."</b>";	
	$nome_rally .= "<br /><b>".$parametros[0]["c11_subtitulo"]."</b>";       	
	//$nome_rally = "<b>Copa Peugeot</b>";	
	//$nome_rally .= "<br /><b>I Etapa - Bras&iacute;lia/DF</b>";
	if ($prova) $nome_rally .= "<br>Prova ".$prova;
	//$trecho_txt1 = utf8_decode($trecho_txt1);
	$txt_cab = $trecho_txt1;
	/*
	if ($trecho>0 && !$sss) {
		$txt_cab = "Resultados Acumulados - ".$trecho."a. Etapa/Stage ".$trecho."Overall Results (".$trecho_txt1.")</b><br>";
		$txt_cab .= "Desl. Inicial/Connection ".$desloc1."km - Especial/Special ".$dist_esp."km - Desl. Final/Connection ".$desloc2."km";
	}
	elseif ($sss) {
		$txt_cab = "<br>Resultados - ".$sss."a. Etapa/Stage ".$sss."Results (".$trecho_txt1.")</b><br>";
		$txt_cab .= "Desl. Inicial/Connection ".$desloc1."km - Especial/Special ".$dist_esp."km - Desl. Final/Connection ".$desloc2."km";
	}
	elseif ($trecho==0) $txt_cab = "<b>Pr&oacute;logo</b><br>";
	*/

	//$txt_cab .= $status;
	$uri = $_SERVER['REQUEST_URI'];
	$query = $_SERVER['QUERY_STRING'];
	if (strlen($query)>0) $txt_uri = $uri."&print=1";	
	else $txt_uri = $uri."?print=1";
	
	$header = sprintf("%s\n","  <tr class=\"bg_header\">");
	$header .= sprintf("%s\n","    <td height=\"70\" valign=\"top\" colspan=2>");
	$header .= sprintf("%s\n","    <table border=\"0\" width=\"100%\" cellpadding=0 cellspacing=0>");
	$header .= sprintf("%s\n","  		<tr class=\"bg_header\">");
	$header .= sprintf("%s\n","   			<td align=\"left\" valign=\"top\">");
	$header .= sprintf("%s\n","        <img src=\"../../../../peugeot.png\" border=0 />");
	//$header .= sprintf("&nbsp;&nbsp;\n");
	$header .= sprintf("%s\n","   			</td>");
	$header .= sprintf("%s\n","   			<td align=\"left\" valign=\"top\" style=\"font-family: Arial Narrow;\">");
	//if ($trecho != "X") 
	
	if (isset($_REQUEST['titulo'])) $txt_cab .= "<br />".$_REQUEST['titulo'];
	
	$header .= sprintf("                %s<br>%s\n",$nome_rally, $txt_cab);
	//else 				$header .= sprintf("                %s\n",$trecho_txt1);
	$header .= sprintf("%s\n","   			</td>");
	$header .= sprintf("%s\n","   			<td align=\"left\" valign=\"top\" style=\"font-family: Arial Narrow;\">");
	$header .= sprintf("                <b>%s</b> %s \n",$pag,$txt_especifico);
	if ($print!=1) $header .= sprintf("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='%s'><span class=\"style2\">printable</span><img src=\"imagens/print_version.gif\" border=\"0\" align=\"top\"></a>&nbsp;&nbsp;&nbsp;&nbsp;\n",$txt_uri);
	$header .= sprintf("%s\n","   			</td>");
	$header .= sprintf("%s\n","   			<td align=\"right\" valign=\"top\">");
	//$header .= sprintf("%s\n","        <img src=\"imagens/sertoes.png\" />");
	//$header .= sprintf("%s\n","<img src=\"imagens/petrobras.png\"  align=\"absmiddle\" />");
	//$header .= sprintf("%s\n","<img src=\"imagens/ceara.png\"  align=\"absmiddle\" />");
	$header .= sprintf("%s\n","   			</td>");
	$header .= sprintf("%s\n","   		</tr>");
	$header .= sprintf("%s\n","   	</table>");  
	$header .= sprintf("%s\n","     </td>");
	$header .= sprintf("%s\n","  </tr>");

	$serial_pg++;

	return $header;
}

function nomeComp($nome_original) {
		$nome_pil = explode(" ",$nome_original);
		if ($nome_pil[count($nome_pil)-1][0]=="(") {
			$num_palavras = count($nome_pil)-1;
			$nome = $nome_pil[count($nome_pil)-1];
		} elseif ($nome_pil[count($nome_pil)-2][0]=="(") {
			$num_palavras = count($nome_pil)-2;
			$nome = $nome_pil[count($nome_pil)-2]." ".$nome_pil[count($nome_pil)-1];
		} elseif ($nome_pil[count($nome_pil)-3][0]=="(")  {
			$num_palavras = count($nome_pil)-3;
			$nome = $nome_pil[count($nome_pil)-3]." ".$nome_pil[count($nome_pil)-1]." ".$nome_pil[count($nome_pil)-2]." ".$nome_pil[count($nome_pil)-1];		
		} else  {
			$num_palavras = count($nome_pil);			
			$nome = "";
		}
		for ($j=0;$j<$num_palavras;$j++) {
			$nome.= $nome_pil[$j]." ";
		}
		$nome = strtoupper($nome);
		//$nome .= ", ".$nome_pil[0];

		return $nome;
}

function apelidoComp($nome_original) {
		$nome_pil = explode(" ",$nome_original);
		if ($nome_pil[count($nome_pil)-1][0]=="(") {
			$nome = $nome_pil[count($nome_pil)-1];
		} elseif ($nome_pil[count($nome_pil)-2][0]=="(")  {
			$nome = $nome_pil[count($nome_pil)-2]." ".$nome_pil[count($nome_pil)-1];		
		} elseif ($nome_pil[count($nome_pil)-3][0]=="(")  {
			$nome = $nome_pil[count($nome_pil)-3]." ".$nome_pil[count($nome_pil)-2]." ".$nome_pil[count($nome_pil)-1];		
		} else  {
			$nome = $nome_pil[count($nome_pil)];
		}		
		return $nome;
}

function xml2array ( $xmlObject, $out = array () )
{
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

        return $out;
}

function secToTimesecToTime($sec) {
	if ($sec>0) {
		$hh = str_pad(round($sec/3600), 2, "0", STR_PAD_LEFT);
		$mm = str_pad(round(($sec/3600-$hh)*60), 2, "0", STR_PAD_LEFT);
		//$ss = str_pad(    round(($sec)-($hh*3600)-($mm*60),2)    , 5, "0", STR_PAD_LEFT);
		$ss = str_pad(    round(($sec)-($hh*3600)-($mm*60)), 2, "0", STR_PAD_LEFT);
		if ($ss==0) $ss="00.00";
		
		$time = $hh.":".$mm.":".$ss;
	} else {
		$time = "* * *";
	}
	return $time;
}

function secToTime($time){
	$dec = round(($time - intval($time))*10);
  if(is_numeric($time)){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
    }

    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
    }

    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
    }

    if($time >= 60){
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

    //return $texto;
	return $texto;
  }else{
    return (bool) FALSE;
  }
}

function printTableHeader($arr) {
	$header = sprintf("%s\n","  <tr class=\"td1\">");
	for ($i=0;$i<count($arr);$i++) {
	$header .= sprintf("    <td class=\"cells\">%s</td>\n",$arr[$i]);
	}
	$header .= sprintf("%s\n","</tr>");
	return $header;
}

$footer = sprintf("%s\n","  <tr>");
$footer .= sprintf("%s\n","<td height=\"60\" valign=\"middle\" class=\"bg_legendas\">&nbsp;<span class=\"style1\">");
//if ($fim || $dunas) 
//$footer .= sprintf("%s\n","<img src=\"imagens/petrobras.png\"  align=\"absmiddle\" />");
//$footer .= sprintf("%s\n","<img src=\"imagens/ceara.png\"  align=\"absmiddle\" />");
//$footer .= sprintf("%s\n","<img src=\"imagens/patrocinio.png\"  align=\"absmiddle\" />");
//$footer .= sprintf("%s\n","<img src=\"imagens/chronosat_preto.png\"  align=\"absmiddle\" />");//- live timing &copy; 2009 </span></td>");
$footer .= sprintf("%s\n","</span></td>");
$footer .= sprintf("%s\n","    <td height=\"60\" align=\"right\" valign=\"middle\" class=\"bg_legendas\" >");
	$footer .= sprintf("%s\n","<table border=0 width=\"100%\" height=\"60\">");
	$footer .= sprintf("%s\n","<tr style=\"font-size: 10px;\">");

if ($fim) {
	$footer .= sprintf("%s\n","<td align=\"left\" valign=\"top\">");
	$footer .= sprintf("%s\n","<b>Manifestation/Event:</b>Sertoes International Rally 2009<br><br><b>Date:</b><br><br><b>IMN N°:</b>");
	$footer .= sprintf("%s\n","</td>");
	$footer .= sprintf("%s\n","<td align=\"left\" valign=\"top\">");
	$footer .= sprintf("%s\n","<b>Clerk of the Course:</b><br><br><b>Date:</b><br><br><b>Signature:</b>");
	$footer .= sprintf("%s\n","</td>");
} else {
	$footer .= sprintf("%s\n","<td width=\"100\" align=\"left\" valign=\"top\">");
	$footer .= sprintf("%s\n","<b>Apurador(es):</b>");
	$footer .= sprintf("%s\n","</td>");
	$footer .= sprintf("%s\n","<td width=\"100\" align=\"left\" valign=\"top\">");
	$footer .= sprintf("%s\n","<b>Diretor(es) de Prova:</b>");
	$footer .= sprintf("%s\n","</td>");
	$footer .= sprintf("%s\n","<td width=\"100\" align=\"left\" valign=\"top\">");
	$footer .= sprintf("%s\n","<b>Comissário(s):</b>");
	$footer .= sprintf("%s\n","</td>");
}

	$footer .= sprintf("%s\n","<td width=\"300\" align=right>");
//$footer .= sprintf("<img src=\"imagens/fpm_preto.png\" alt=\"Federação Paulista de Motocilismo\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/fasp_preto.png\" alt=\"Federação Paulista de Automobilismo\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/dunas_preto.png\" align=\"middle\" />");
$footer .= sprintf("<img src=\"imagens/cba_preto.png\" alt=\"Confederação Brasileira de Automobilismo\" width=\"43\" height=\"37\" align=\"middle\" />");

//$footer .= sprintf("<img src=\"imagens/fim_preto.png\" alt=\"Federação Internacional de Motociclismo\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/cbm.png\" alt=\"Confederação Brasileira de Motociclismo\" align=\"middle\" />");
$footer .= sprintf("%s\n","<img src=\"imagens/chronosat_pq.png\"  align=\"absmiddle\" />");
//- live timing &copy; 2009 </span></td>");
//$footer .= sprintf("<img src=\"imagens/ricur_preto.png\" alt=\"Rally de Curitiba\" width=\"43\" height=\"17\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/codasur_preto.png\" alt=\"Confederación Deportiva Automovilística  Sudamericana\" width=\"35\" height=\"35\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/irc_preto.png\" alt=\"Intercontinental Rally Championship\" width=\"43\" height=\"43\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/fia_preto.png\" alt=\"Federation Internationale de l'Automobile\" width=\"43\" height=\"34\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/rcc_preto.png\" alt=\"Rally Clube de Curitiba\" width=\"43\" height=\"27\" align=\"middle\" />");
//$footer .= sprintf("<img src=\"imagens/fpra_preto.png\" alt=\"Federação Paranaense de Automobilismo\" width=\"55\" height=\"25\" align=\"middle\" />");

//}
	$footer .= sprintf("%s\n","</td>");
	$footer .= sprintf("%s\n","</tr>");
	$footer .= sprintf("%s\n","</table>");
$footer .= sprintf("</td>");
$footer .= sprintf("%s\n","  </tr>");

function concat() {
$vars=func_get_args();
$array=array();
foreach ($vars as $var) {
   if (is_array($var)) {
	  foreach ($var as $val) {$array[]=$val;}
   } else {
	  $array[]=$var;
   }
}
return $array;
}


function criaArray ($sql) {
	global $obj_res;
	global $obj_ctrl;
	$i=0;
	$arr_retorno = array();
	if($obj_res=$obj_ctrl->executa($sql)) {			
		while($arr_comp=$obj_res->getLinha("assoc")){
			$arr_retorno[$i] = $arr_comp;
			$i++;
		}
	}

	return $arr_retorno;
}


function geraLinhaXML ($nome, $arr_comp, $arr_header) {
	$retorno = '';
	$linha = '';
	for ($i=0;$i<count($arr_comp);$i++) {
		$linha = sprintf("<");
		$linha .= sprintf("%s",$nome);		
		for ($j=0;$j<count($arr_header);$j++) $linha .= sprintf(" %s=\"%s\"",$arr_header[$j],utf8_encode($arr_comp[$i][$j]));
		$linha .= sprintf(" />");

		$retorno .= sprintf("%s\n\r",$linha);
	}
	return $retorno;
}

	


function geraLinhaHtml ($arr_comp, $classi, $num_linhas, $arr_header, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status) {

	$retorno = '';
	global $footer;
	$num_pag = 2;
	//global $campeonato;
	$span = array();
	
	for ($i=0;$i<count($arr_comp);$i++) {
		$linha = "";
		if ($num_linhas!=0) {
			if ( $i%$num_linhas==0 && $i!=0) {
				$linha .= "</table></td></tr>";
			 	$linha .= $footer;
				$linha .= "<tr style=\"page-break-before: always\"><td colspan=\"2\"></td></tr>";
				$linha .= "<tr class=\"separador\"><td colspan=\"2\" height=\"60\"></td></tr>";
				//$linha .= printHeader($header_txt, $report_date, $print, $campeonato);
				$linha .= printHeader($trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $print, $campeonato, $num_pag."/".$pag, $status);
				$num_pag++;

				$linha .= "<tr><td colspan=\"2\"><table cellpadding=\"5\" cellspacing=\"0\" class=\"tb1\">";
			 	$linha .= printTableHeader($arr_header);
			}
		}
		$linha .= "<tr";
			if($arr_comp[$i][0]=="D") $linha .= ' class="tr_pen" ';
			else{
				if ($arr_comp[$i][0]=="NC") {

					if($i%2==0) $linha .= ' class="tr2"';

					else $linha .= ' class="tr2_alt"';

				} else {

					if($i%2==0) $linha .= ' class="tr1"';

					else $linha .= ' class="tr1_alt"';

				}

			}

//$linha .= " onClick =\"window.open ('relat_comp.php?veiculo=".$arr_comp[$i][1]."', 'comp', 'left=20, top=20, width=900, height=490, toolbar=0, resizable=0');\"";

				if ($arr_comp[$i][0]=="NC") {

					if($i%2==0) $linha .= " onMouseOver=\"this.className='tr3'\" onMouseOut=\"this.className='tr2'\"";

					else $linha .= " onMouseOver=\"this.className='tr3'\" onMouseOut=\"this.className='tr2_alt'\"";

				} else {

					if($i%2==0) $linha .= " onMouseOver=\"this.className='tr3'\" onMouseOut=\"this.className='tr1'\"";

					else $linha .= " onMouseOver=\"this.className='tr3'\" onMouseOut=\"this.className='tr1_alt'\"";

				}


		$linha .= " >";

		

		for ($j=0;$j<count($arr_comp[$i]);$j++) {
			$linha .= '<td class="cells">';
			$linha .= $arr_comp[$i][$j];
			$linha .= '</td>';
			
		}
		$linha .= '</tr>';
		$retorno .= sprintf("%s\n",$linha);
	}
	return $retorno;
}


function geraLinhaHtml2 ($arr_comp, $classi, $num_linhas, $arr_header, $print, $campeonato, $trecho, $trecho_txt1, $desloc1, $dist_esp, $desloc2, $txt_especifico, $pag, $status) {

	$retorno = '';
	global $footer;
	$num_pag = 2;
	//global $campeonato;
	$span = array();
	$cor = array();
	
	for ($i=0;$i<count($arr_comp);$i++) {
		$linha = "";
		$linha .= "<tr";
			
			$cor1 = ' class="tr1"';
			$cor2 = ' class="tr1_alt"';
			
			if ($arr_comp[$i][1]==$arr_comp[$i-1][1]) {
				if ($cor==$cor1) $cor=$cor1;
				else $cor=$cor2;
			}
			else {
				if ($cor==$cor1) $cor=$cor2;
				else $cor=$cor1;
			}
			
			$linha .= $cor;



		$linha .= " >";

		
		for ($j=0;$j<count($arr_comp[$i]);$j++) {
			if ($arr_comp[$i][$j]==$arr_comp[$i-1][$j]) {
				$linha .= '<td class="cells">';
				if ($j>1) $linha .= $arr_comp[$i][$j];
				$linha .= '</td>';
				$span[$i][$j]++;
			}
			else {
				$linha .= '<td class="cells">';
				$linha .= $arr_comp[$i][$j];
				$linha .= '</td>';
				$span[$i][$j]=0;
			}
		}
		if ($arr_comp[$i][0]<>$arr_comp[$i+1][0]) $linha .= '</tr><tr class="td1" style="height:1px; overflow=hidden; border-bottom:double 4px #333;"><td colspan="6"></td/></tr>';
		else $linha .= '</tr>';
		$retorno .= sprintf("%s\n",$linha);
	}
	return $retorno;
}
?>

