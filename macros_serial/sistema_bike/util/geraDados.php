<?





function geraDados ($arr_comp) {

	$retorno = '';

	$arr_retorno = array();

	global $pos_cat;

	global $int_id_ss;

	global $arr_ss;

	global $campeonato;

	global $col_stat;



	for ($i=0;$i<count($arr_comp);$i++) {

		$arr_retorno[$i] = array();

		$cat_num = $arr_comp[$i]["c13_codigo"];

		/////////////////////////////

		$stat = $arr_comp[$i][$col_stat];

		//

		if ($arr_comp[$i]["total_geral"]!="* * *") { 

			if ($stat=="N") $txt_pos = ( $i+1 );	

		}

		else {

			$txt_pos = "NC";

		}

		if ($stat=="NC") $txt_pos = "NC";

		if ($stat=="D") $txt_pos = "D";

		//			

		array_push($arr_retorno[$i],$txt_pos);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["c03_numero"]);

		

		

		$piloto = nomeComp($arr_comp[$i]["piloto_geral"]);

		$navegador = nomeComp($arr_comp[$i]["navegador_geral"]);

		$navegador2 = nomeComp($arr_comp[$i]["navegador2_geral"]);



		//

		array_push($arr_retorno[$i],$piloto);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["piloto_origem"]);

		

		//

		array_push($arr_retorno[$i],$navegador);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["navegador_origem"]);

		

		//

		array_push($arr_retorno[$i],$navegador2);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["navegador2_origem"]);

		

		//

		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["modelo_geral"]));
		//

		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["equipe_geral"]));
		//

		array_push($arr_retorno[$i],htmlspecialchars($arr_comp[$i]["c10_codigo"]));

		

		

		// se não é desclassificado

		if ($arr_comp[$i][$col_stat]!='D') {



		//

		if ($arr_comp[$i]["total_geral"]!="* * *") 

		$txt_pos = $pos_cat[$cat_num][0]+1;

		else 

		$txt_pos = 'NC';			

		$pos_cat[$cat_num][0] ++;

		array_push($arr_retorno[$i],"(".$txt_pos.")".$arr_comp[$i]["categoria"]);



		$status = $arr_comp[$i][$col_stat];



		//

		for ($k=0;$k<=12;$k++) {

			$txt_ss = "ss".$k;

			if (in_array($k, $arr_ss)) {

				array_push($arr_retorno[$i],$arr_comp[$i][$txt_ss]);

			}

		}

				

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["tempo"]);

		

		//

		array_push($arr_retorno[$i],$arr_comp[$i]["P_geral"]);



		//

		array_push($arr_retorno[$i],$arr_comp[$i]["bonus_geral"]);


		//

		array_push($arr_retorno[$i],$arr_comp[$i]["total_geral"]);



		//

		$l = $i-1;

		if ($l<0) $l=0;

		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {

			if ($status == 'D') array_push($arr_retorno[$i],"");

			else array_push($arr_retorno[$i],substr(secToTime($arr_comp[$i]["total_num"]-$arr_comp[$l]["total_num"]),0,10));
			//else array_push($arr_retorno[$i],secToTime($arr_comp[$i]["total_num"]-$arr_comp[$l]["total_num"]));

			
		}

		else {

			array_push($arr_retorno[$i],' ');

		}



		//

		if ($arr_comp[$i]["total_geral"]!="* * *" && $arr_comp[$i][$col_stat]!='NC') {

			if ($status == 'D') array_push($arr_retorno[$i],"");

			else {
			     $valor_diff = $arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"];
                 if ($valor_diff>=86400 && $valor_diff<172800) {
                    $txt_dias = "1d ";
                 }
                 elseif ($valor_diff>=172800) {
                    $txt_dias = "2d ";
                 }
                 else $txt_dias = "";
                 
			     array_push($arr_retorno[$i],$txt_dias.substr(secToTime($valor_diff),0,10));
				 //array_push($arr_retorno[$i],$txt_dias.secToTime($valor_diff));
			}

			//selse array_push($arr_retorno[$i],(secToTime($arr_comp[$i]["total_num"]-$arr_comp[0]["total_num"])));

		}

		else {

			array_push($arr_retorno[$i],' ');

		}



		} // se não é desclassificado



		else { // se é desclassificado

			array_push($arr_retorno[$i],$arr_comp[$i]["categoria"]);

			for ($k=0;$k<=10;$k++) {

				if (in_array($k, $arr_ss)) array_push($arr_retorno[$i],"* * *");

			}

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");

			array_push($arr_retorno[$i],"* * *");



			if ($status == 'D' && !$prova) {

				array_push($arr_retorno[$i],"* * *");

				array_push($arr_retorno[$i],"* * *");			

			}

		}

	}

	return $arr_retorno;

}



?>