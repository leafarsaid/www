<?

$arr = criaArray("SELECT c02_codigo, c02_nome FROM t02_trecho WHERE c02_status='I' AND c02_aparece_no_relatorio=1");
foreach ($arr AS $item){
	$arr_ss[] = $item['c02_codigo'];
	$arr_especiais[] = $item['c02_nome'];
}

/*	if (isset($_REQUEST["trechos"])) {
		$arr_ss = explode(",",$_REQUEST["trechos"]);
		$trecho_inicial = $arr_ss[0];
		$trecho_final = end($arr_ss);
	}
	else {
		$arr = criaArray("SELECT MIN(c02_codigo) AS mintrecho, MAX(c02_codigo) AS maxtrecho FROM t02_trecho WHERE c02_status='I'");
		$trecho_inicial = $arr[0]["mintrecho"];
		$trecho_final = isset($_REQUEST["trecho"]) ? ($_REQUEST["trecho"]) : $arr[0]["maxtrecho"];
		
		//----------------------------------------------------------------------------------------------------------------------
		//by Jair - colocar nas variáveis os trechos iniciais de cada prova (no caso de existir mais de uma prova por evento)
		$maxtrecho_prova1 = 8;
		$maxtrecho_prova2 = 13;
		//----------------------------------------------------------------------------------------------------------------------
		
		if ($_REQUEST["prova"] == 1) 
			$trecho_final = min($trecho_final, $maxtrecho_prova1);
		elseif ($_REQUEST["prova"] == 2) {
			$trecho_inicial = $maxtrecho_prova1 + 1;
			$trecho_final = min($trecho_final, $maxtrecho_prova2);
		}
		
		$str_ss = strval($trecho_inicial);
		for ($i = $trecho_inicial + 1; $i <= $trecho_final; $i++)
			$str_ss .= ",".$i;
			
		$arr_ss = explode(",",$str_ss);	
	}
*/
?>