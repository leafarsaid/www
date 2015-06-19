<?
/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraDadosGeral($arr_comp, $iFIM) {
	$arr_retorno = array();

	$pos_cat = array();
	global $arr_ss;

	for ($i = 0; $i < count($arr_comp); $i++) {
		$arr_retorno[$i] = array();
		$cat = $arr_comp[$i]["categoria"];

		//POS
		$stat = $arr_comp[$i]["_status"];
		$txt_pos = $stat;
		$txt_pos_cat = $stat;
		if (($arr_comp[$i]["tempo"] != "* * *") && ($stat == "N")) {
			$pos_cat[$cat][0]++;
			$txt_pos_cat = $pos_cat[$cat][0];
			$txt_pos = ($i + 1);
		}
		else {
			$txt_pos = ($stat == "N") ? (($iFIM) ? "DNF" : "NC") : $stat;
			$txt_pos_cat = $txt_pos;
		}
		array_push($arr_retorno[$i],$txt_pos);

		//COMPETIDOR
		array_push($arr_retorno[$i],$arr_comp[$i]["numeral"]);
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["tripulacao"]));
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["modelo"]));
		array_push($arr_retorno[$i],$arr_comp[$i]["licenca"]);
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["equipe"]));

		//POS(CAT)
		array_push($arr_retorno[$i],"(".$txt_pos_cat.")".$arr_comp[$i]["categoria"]);

		//
		if ($_REQUEST['trecho']==0) $length_str = 10;
		else $length_str = 8;

		//TEMPOS DE CADA SS
		foreach ($arr_ss as $x) {
			$strTempo = ($stat == "D") ? "* * *" : $arr_comp[$i]["ss".$x];
			array_push($arr_retorno[$i],$strTempo);
		}

		//TEMPOS
		if (($arr_comp[$i]["tempo"] != "* * *") && ($stat <> "D")) {
			
			$dia = 86400;
			for($y=1;$y<15;$y++) {
				if ($arr_comp[$i]["tempoTotal"] >= ($y * $dia) && $arr_comp[$i]["tempoTotal"] < (($y+1) * $dia)){
					$dias = $y;
				}
			}
			$dias_em_horas = $dias * 24;
			$total = secToTime($arr_comp[$i]["tempoTotal"]);
			
			$total_txt = intval(substr($total,0,2)) + $dias_em_horas;
			$total_txt .= ":";
			$total_txt .= substr($total,3,$length_str-3);
					
			array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]); 		//tempo sem penalidades
			array_push($arr_retorno[$i],($stat == "N") ? $arr_comp[$i]["penais"] : "* * *");	//total de penalidades
			array_push($arr_retorno[$i],$arr_comp[$i]["bonus"]);	//total de bonus
			array_push($arr_retorno[$i],$total_txt);	//tempo total
			array_push($arr_retorno[$i],($i != 0) ? substr(secToTime($arr_comp[$i]["tempoTotal"]-$arr_comp[0]["tempoTotal"]),0,$length_str) : "*"); //dif. lider
		}
		else
		{
			array_push($arr_retorno[$i],"* * *");	//tempo sem penalidades
			array_push($arr_retorno[$i],"* * *");	//total de penalidades
			array_push($arr_retorno[$i],"* * *");	//total de bonus
			array_push($arr_retorno[$i],"* * *");	//tempo total
			array_push($arr_retorno[$i],"* * *");	//dif. lider
		}
	}
	return $arr_retorno;
}

/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraDadosSS($arr_comp, $iFIM) {
	$arr_retorno = array();
	$pos_cat = array();

	for ($i = 0; $i < count($arr_comp); $i++) {
		$arr_retorno[$i] = array();
		$cat = $arr_comp[$i]["categoria"];

		//POS
		$stat = $arr_comp[$i]["_status"];
		$txt_pos = $stat;
		$txt_pos_cat = $stat;
		if (($arr_comp[$i]["tempo"] != 0) && ($stat == "N")) {
			$pos_cat[$cat][0]++;
			$txt_pos_cat = $pos_cat[$cat][0];
			$txt_pos = ($i + 1);
		}
		elseif ($stat == "N") {
			//Se não chegou e tem largada = NC
			//Se não chegou e não tem largada= NL
			$txt_pos = ($arr_comp[$i]["L"] != 99999) ? (($iFIM) ? "DNF" : "NC") : (($iFIM) ? "DNS" : "NL");
			$txt_pos_cat = $txt_pos;
		}

		array_push($arr_retorno[$i],$txt_pos);

		//COMPETIDOR
		array_push($arr_retorno[$i],$arr_comp[$i]["numeral"]);
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["tripulacao"]));
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["modelo"]));
		array_push($arr_retorno[$i],$arr_comp[$i]["licenca"]);
		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["equipe"]));

		//POS(CAT)
		array_push($arr_retorno[$i],"(".$txt_pos_cat.")".$arr_comp[$i]["categoria"]);

		//HORA DE LARGADA E CHEGADA
		array_push($arr_retorno[$i],$arr_comp[$i]["largada"]);		//largada
		array_push($arr_retorno[$i],$arr_comp[$i]["chegada"]);		//chegada

		//TEMPOS
		if (($arr_comp[$i]["tempo"] != 0) && ($stat <> "D")) {
			if ($_REQUEST['trecho']==0) $length_str = 10;
			else $length_str = 8;
			array_push($arr_retorno[$i],substr(secToTime($arr_comp[$i]["tempo"]),0,$length_str));		//tempo sem penalidades
			array_push($arr_retorno[$i],($stat == "N") ? $arr_comp[$i]["penais"] : "* * *");	//penalidades
			array_push($arr_retorno[$i],$arr_comp[$i]["bonus"]);	//bonus
			array_push($arr_retorno[$i],substr(secToTime($arr_comp[$i]["tempoTotal"]),0,$length_str));	//tempo total
			array_push($arr_retorno[$i],($i != 0) ? substr(secToTime($arr_comp[$i]["tempoTotal"]-$arr_comp[0]["tempoTotal"]),0,$length_str) : "*"); //dif. lider total
			array_push($arr_retorno[$i],($i != 0) ? substr(secToTime($arr_comp[$i]["tempo"]-$arr_comp[0]["tempo"]),0,$length_str) : "*"); //dif. lider bruto
		}
		else
		{
			array_push($arr_retorno[$i],"* * *");	//tempo sem penalidades
			array_push($arr_retorno[$i],"* * *");	//penalidades
			array_push($arr_retorno[$i],"* * *");	//bonus
			array_push($arr_retorno[$i],"* * *");	//tempo total
			array_push($arr_retorno[$i],"* * *");	//dif. lider
			array_push($arr_retorno[$i],"* * *");	//dif. lider bruto
		}
	}
	return $arr_retorno;
}

/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraDadosPenal($arr_comp) {
	$arr_retorno = array();
	for ($i = 0; $i < count($arr_comp); $i++) {
		$arr_retorno[$i] = array();

		//NO
		array_push($arr_retorno[$i], $arr_comp[$i]['numeral']);

		//TRIPULACAO
		$tripulacao = '<div class="trip" id="div"><b>'.nomeComp($arr_comp[$i]['tripulacao']).'</b><br>';
		if (strlen($arr_comp[$i]['modelo']) > 0) $tripulacao .= $arr_comp[$i]['modelo'];
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);

		//Especial
		array_push($arr_retorno[$i],$arr_comp[$i]['trecho']);

		// MANUAL OU GPS
		if ($arr_comp[$i]['tipo']=="P") $tipo = "Manual";
		elseif ($arr_comp[$i]['tipo']=="PT") $tipo = "GPS";
		elseif ($arr_comp[$i]['tipo']=="A") $tipo = "Bonus";
		array_push($arr_retorno[$i], $tipo);

		//tempo de penal
		array_push($arr_retorno[$i],substr($arr_comp[$i]['P'],0,8));

		//motivo
		array_push($arr_retorno[$i],'<div class="trip" id="div">'.htmlspecialchars($arr_comp[$i]['motivo']).'</div>');
	}
	return $arr_retorno;
}

/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraDadosAbandonos($arr_comp) {
	$arr_retorno = array();
	for ($i = 0; $i < count($arr_comp); $i++) {
		$arr_retorno[$i] = array();

		//Especial
		array_push($arr_retorno[$i],$arr_comp[$i]['trecho']);

		//NO
		array_push($arr_retorno[$i], $arr_comp[$i]['numeral']);

		//TRIPULACAO
		$tripulacao = '<div class="trip" id="div"><b>'.nomeComp($arr_comp[$i]['tripulacao']).'</b><br>';
		if (strlen($arr_comp[$i]['modelo']) > 0) $tripulacao .= $arr_comp[$i]['modelo'];
		$tripulacao .= '</div>';
		array_push($arr_retorno[$i],$tripulacao);

		//EQUIPE
		array_push($arr_retorno[$i], $arr_comp[$i]['equipe']);

		//motivo
		array_push($arr_retorno[$i],'<div class="trip" id="div">'.$arr_comp[$i]['motivo'].'</div>');
	}
	return $arr_retorno;
}
?>