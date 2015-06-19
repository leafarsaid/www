<?
///----------------------------------------------------------------------------------------------------------------------------------

///----------------------------------------------------------------------------------------------------------------------------------

/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraSqlGeral2($arr_ss, $int_id_cat, $int_id_mod, $mod, $campeonato) {
	// define qual a coluna de categoria deve ser usada
	$col_categoria = ($_REQUEST['subcategoria'] || ($campeonato == "B")) ? "c13_codigo2" : "c13_codigo";
	
	$str_sql = 'SELECT DISTINCT ';
	$str_sql .= 'c03_numero AS numeral, ';
	$str_sql .= 'getTripulanteNome(c03_piloto) AS tripulacao, ';
	$str_sql .= 'getTripulanteOrigem(c03_piloto) AS origem, ';
	$str_sql .= 'getEquipeNome(c03_piloto) AS equipe, ';
	$str_sql .= 'getModeloNome(c03_piloto) AS modelo, ';
	$str_sql .= 'getPatrocinioNome(c03_piloto) AS licenca, ';
	$str_sql .= "c03_status AS _status, ";
	$str_sql .= "getCategoriaNome($col_categoria) AS categoria, ";
	$str_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
		
	//tempo de cada SS
	for ($f = 0; $f < count($arr_ss); $f++) {
		$str_sql .= "castTempo(calcTempoSemPena(c03_codigo,$arr_ss[$f],c10_codigo,6)) AS ss$arr_ss[$f], ";
	}
	
	//tempo bruto AS _tempo
	$str_sql .= "castTempo(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		$str_sql .= "+calcTempoSemPena(c03_codigo,$arr_ss[$f],c10_codigo,6)";
	$str_sql .= ") AS tempo, ";
		
	//penais AS _penais
	$str_sql .= "castTempo(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		$str_sql .= "+calcPenalidade(c03_codigo,$arr_ss[$f],c10_codigo)";
	$str_sql .= ") AS penais, ";
	
	//bonus AS _bonus
	$str_sql .= "castTempo(0";
	for ($f = 0; $f < count($arr_ss); $f++)
		$str_sql .= "+IFNULL(getTempo(c03_codigo,$arr_ss[$f],10),0)";
	$str_sql .= ") AS bonus, ";
	
	//tempo total = tempo bruto - penais + bonus AS _tempoTotal
	$str_sql .= "0";
	for ($f = 0; $f < count($arr_ss); $f++) {
		$str_sql .= "+IFNULL(calcTempo(c03_codigo,$arr_ss[$f],c10_codigo,6),999999)";
	}
	$str_sql .= " AS tempoTotal, ";
	
	//Largada na última especial - para desempate
	//quem larga primeiro na especial está na frente no caso de empate
	$str_sql .= "IFNULL(getTempo(c03_codigo,".$arr_ss[count($arr_ss)-1].",1),999999) AS L ";
	
	$str_sql .= "FROM t03_veiculo WHERE (c03_status <> 'O') ";
	
	if ($campeonato == "F") $str_sql.="AND (c13_codigo = 11 OR c13_codigo = 21) ";
	elseif ($campeonato == "B") $str_sql.="AND (c13_codigo2 > 0) ";
	
	if($int_id_cat) $str_sql.="AND ($col_categoria = $int_id_cat) ";
	elseif ($int_id_mod) $str_sql.="AND (c10_codigo = $int_id_mod) ";
	elseif ($mod == "M") $str_sql.="AND (c10_codigo = 1 OR c10_codigo = 2) ";
	elseif ($mod == "C") $str_sql.="AND (c10_codigo = 4 OR c10_codigo = 5) ";
	
	$str_sql.="ORDER BY _status, tempoTotal, L, numeral";
	
	return  $str_sql;
}
///----------------------------------------------------------------------------------------------------------------------------------
/**
*
*
*/
///----------------------------------------------------------------------------------------------------------------------------------
function geraSqlSS2($int_id_ss, $int_id_cat, $int_id_mod, $mod, $campeonato) {

	// define qual a coluna de categoria deve ser usada
	$col_categoria = ($_REQUEST['subcategoria'] || ($campeonato == "B")) ? "c13_codigo2" : "c13_codigo";
	
	$ss_sql  = 'SELECT ';
	$ss_sql .= "DISTINCT c03_numero AS numeral, ";
	$ss_sql .= "c03_status AS _status, ";
	$ss_sql .= 'getTripulanteNome(c03_piloto) AS tripulacao, ';
	$ss_sql .= 'getTripulanteOrigem(c03_piloto) AS origem, ';
	$ss_sql .= 'getEquipeNome(c03_piloto) AS equipe, ';
	$ss_sql .= 'getModeloNome(c03_piloto) AS modelo, ';
	$ss_sql .= 'getPatrocinioNome(c03_piloto) AS licenca, ';
	$ss_sql .= "getCategoriaNome($col_categoria) AS categoria, ";
	$ss_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',1),99999) AS L, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',2),99999) AS I1, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',3),99999) AS I2, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',4),99999) AS I3, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',5),99999) AS I4, ';
	$ss_sql .= 'IFNULL(getTempo(c03_codigo,'.$int_id_ss.',6),99999) AS C, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',1)) AS largada, ';
	$ss_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)) AS chegada, ';
	$ss_sql .= 'castTempo(getTempoTodos(c03_codigo,'.$int_id_ss.',10)) AS bonus, ';
	$ss_sql .= 'castTempo(calcPenalidade(c03_codigo,'.$int_id_ss.', c10_codigo)) AS penais, ';
	$ss_sql .= "IFNULL(calcTempoSemPena(c03_codigo,$int_id_ss,c10_codigo,6),0) AS tempo, ";
	$ss_sql .= "IFNULL(calcTempo(c03_codigo,$int_id_ss,c10_codigo,6),999999) AS tempoTotal ";
	
	$ss_sql .= "FROM t03_veiculo WHERE (c03_status <> 'O') ";
	
	if ($campeonato == "F") $ss_sql.="AND (c13_codigo = 11 OR c13_codigo = 21) ";
	elseif ($campeonato == "B") $ss_sql.="AND (c13_codigo2 > 0) ";
	
	if ($int_id_cat) $ss_sql.="AND ($col_categoria = $int_id_cat) ";
	elseif ($int_id_mod) $ss_sql.="AND (c10_codigo = $int_id_mod) ";
	elseif ($mod == "M") $ss_sql.="AND (c10_codigo = 1 OR c10_codigo = 2) ";
	elseif ($mod == "C") $ss_sql.="AND (c10_codigo = 4 OR c10_codigo = 5) ";
	
	$ss_sql.="ORDER BY _status, tempoTotal, tempo, C, I4, I3, I2, I1, L, numeral";
	return $ss_sql;
}

///----------------------------------------------------------------------------------------------------------------------------------
/**
*
*
*/
function geraSqlPenal($int_id_ss, $int_id_cat, $int_id_mod, $mod) {
	// define qual a coluna de categoria deve ser usada
	$col_categoria = ($_REQUEST['subcategoria']) ? "c13_codigo2" : "c13_codigo";
	$w_penal = "";
	
	if ($int_id_ss)  $w_penal.=" AND (t.c02_codigo=$int_id_ss)";
	if ($int_id_cat) $w_penal.=" AND (v.$col_categoria=$int_id_cat)";
	elseif ($int_id_mod) $w_penal.=" AND (v.c10_codigo=$int_id_mod)";
	elseif ($mod == "M") $w_penal.=" AND (v.c10_codigo=1 OR v.c10_codigo=2)";
	elseif ($mod == "C") $w_penal.=" AND (v.c10_codigo=4 OR v.c10_codigo=5)";

	$ss_penal = "SELECT
	 DISTINCT v.c03_numero AS numeral
	 ,v.c03_codigo
	 ,getTripulanteNome(c03_piloto) AS tripulacao
	 ,getEquipeNome(c03_piloto) AS equipe
	 ,castTempo(t.c01_valor) AS P
	 ,t.c02_codigo AS trecho
	 ,t.c01_tipo AS tipo
	 ,getModeloNome(v.c03_piloto) AS modelo
	 ,t.c01_obs AS motivo
	 FROM t03_veiculo as v, t01_tempos AS t 
	 WHERE (t.c03_codigo=v.c03_codigo)
	 $w_penal
	 AND (t.c01_tipo='P' OR t.c01_tipo='PT' OR t.c01_tipo='A')
	 AND v.c03_status <> 'O' 
	 ORDER BY v.c03_codigo, t.c02_codigo";
	 
	return $ss_penal;
}

///----------------------------------------------------------------------------------------------------------------------------------
/**
*
*
*/
function geraSqlAbandonos2($int_id_ss, $int_id_cat, $int_id_mod, $mod) {
// define qual a coluna de categoria deve ser usada
	$col_categoria = ($_REQUEST['subcategoria']) ? "c13_codigo2" : "c13_codigo";	
	$w_penal = "";
	
	if ($int_id_ss)  $w_penal.=" AND (o.c33_ss=$int_id_ss)";
	if ($int_id_cat) $w_penal.=" AND (v.$col_categoria=$int_id_cat)";
	elseif ($int_id_mod) $w_penal.=" AND (v.c10_codigo=$int_id_mod)";
	elseif ($mod == "M") $w_penal.=" AND (v.c10_codigo=1 OR v.c10_codigo=2)";
	elseif ($mod == "C") $w_penal.=" AND (v.c10_codigo=4 OR v.c10_codigo=5)";
	
	$query = "SELECT 
				o.c33_motivo AS motivo
				,o.c03_codigo AS numeral
				,o.c33_ss AS trecho
				,getTripulanteNome(v.c03_piloto) AS tripulacao
				,getModeloNome(v.c03_piloto) AS modelo
				,getEquipeNome(c03_piloto) AS equipe
			FROM 
				t33_ocorrencias AS o
				,t03_veiculo AS v
			WHERE 
				v.c03_codigo = o.c03_codigo
				$w_penal
			ORDER BY 
				trecho, numeral";

	return $query;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
*
*
*/
function geraSqlTempo($veiculo, $trecho, $tipo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "DISTINCT c01_valor ";
	$ss_sql .= "FROM t01_tempos ";
	$ss_sql .= "WHERE c02_codigo = ".$trecho." ";
	$ss_sql .= "AND c01_tipo = '".$tipo."' ";
	$ss_sql .= "AND c03_codigo = ".$veiculo." ";
	$ss_sql .= "ORDER BY c01_valor ";
	return $ss_sql;
}

/*
*
*
*/
function geraSqlTripulante($veiculo, $tipo) {
	$ss_sql = 'SELECT ';
	if ($tipo=='P') $ss_sql .= "getTripulanteNome(c03_piloto) AS valor ";
	if ($tipo=='N') $ss_sql .= "getTripulanteNome(c03_navegador) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlModelo($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getModelo(c21_codigo) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlCategoria($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getCategoriaNome(c03_piloto) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlOrigem($veiculo) {
	$ss_sql = 'SELECT ';
	$ss_sql .= "getTripulanteOrigem(c03_piloto) AS valor ";
	$ss_sql .= "FROM t03_veiculo ";
	$ss_sql .= "WHERE c03_codigo = ".$veiculo." ";
	return $ss_sql;
} 

/*
*
*
*/
function geraSqlAbandonos() {
	$ab_sql = "SELECT a.c03_codigo AS numero, ";
	$ab_sql .= "getTripulanteNome(a.c03_piloto) AS piloto, ";
	$ab_sql .= "getTripulanteNome(a.c03_navegador) AS navegador, ";
	$ab_sql .= "b.c02_codigo AS trecho, ";
	$ab_sql .= "b.motivo AS motivo ";
	$ab_sql .= "FROM t03_veiculo AS a, t31_abandonos AS b ";
	$ab_sql .= "WHERE a.c03_codigo = b.c03_codigo ";
	$ab_sql .= "ORDER BY b.c31_codigo ";
	return $ab_sql;
}

?>