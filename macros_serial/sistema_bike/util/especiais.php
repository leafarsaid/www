<?



$arr = criaArray ("SELECT MAX(c02_codigo) AS maxtrecho FROM t02_trecho WHERE c02_status='I'");

$maxtrecho = $arr[0]["maxtrecho"];



if (!$_REQUEST["trecho"]) {
	$_REQUEST["trecho"]=$maxtrecho;
	$trecho=$maxtrecho;
	$int_id_ss=$maxtrecho;
}

if ($_REQUEST["prova"]==1) {
	if ($_REQUEST["trecho"]==1) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==2) $arr_ss=explode(",","1,2");	
	elseif ($_REQUEST["trecho"]==3) $arr_ss=explode(",","1,2,3");	
	elseif ($_REQUEST["trecho"]==4) $arr_ss=explode(",","1,2,3,4");		
	else {	
		$arr_ss=explode(",","1,2,3,4");	
	}
} elseif ($_REQUEST["prova"]==2) {	
	if ($_REQUEST["trecho"]==5) $arr_ss=explode(",","5");	
	elseif ($_REQUEST["trecho"]==6) $arr_ss=explode(",","5,6");	
	elseif ($_REQUEST["trecho"]==7) $arr_ss=explode(",","5,6,7");	
	elseif ($_REQUEST["trecho"]==8) $arr_ss=explode(",","5,6,7,8");		
	else {	
		$arr_ss=explode(",","5,6,7,8");
	}	
} else {
	if ($_REQUEST["trecho"]==1) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==2) $arr_ss=explode(",","1,2");	
	elseif ($_REQUEST["trecho"]==3) $arr_ss=explode(",","1,2,3");	
	elseif ($_REQUEST["trecho"]==4) $arr_ss=explode(",","1,2,3,4");	
	elseif ($_REQUEST["trecho"]==5) $arr_ss=explode(",","1,2,3,4,5");	
	elseif ($_REQUEST["trecho"]==6) $arr_ss=explode(",","1,2,3,4,5,6");	
	elseif ($_REQUEST["trecho"]==7) $arr_ss=explode(",","1,2,3,4,5,6,7");	
	elseif ($_REQUEST["trecho"]==8) $arr_ss=explode(",","1,2,3,4,5,6,7,8");	
	else {	
		$arr_ss=explode(",","1,2,3,4,5,6,7,8");	
	}	
}

/*
if ($_REQUEST["prova"]==1) {
	if ($_REQUEST["trecho"]==1) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==2) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==3) $arr_ss=explode(",","1,2,3");	
	elseif ($_REQUEST["trecho"]==4) $arr_ss=explode(",","1,2,3,4");	
	elseif ($_REQUEST["trecho"]==5) $arr_ss=explode(",","1,2,3,4,5");	
	else {	
		$arr_ss=explode(",","1,2,3,4,5");	
	}
} elseif ($_REQUEST["prova"]==2) {	
	if ($_REQUEST["trecho"]==6) $arr_ss=explode(",","6");	
	elseif ($_REQUEST["trecho"]==7) $arr_ss=explode(",","6,7");	
	elseif ($_REQUEST["trecho"]==8) $arr_ss=explode(",","6,7,8");	
	elseif ($_REQUEST["trecho"]==9) $arr_ss=explode(",","6,7,8,9");	
	elseif ($_REQUEST["trecho"]==10) $arr_ss=explode(",","6,7,8,9,10");		
	else {	
		$arr_ss=explode(",","6,7,8,9,10");
		//$arr_ss=explode(",","5,6,7");	
	}	
} else {
	if ($_REQUEST["trecho"]==1) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==2) $arr_ss=explode(",","1");	
	elseif ($_REQUEST["trecho"]==3) $arr_ss=explode(",","1,2,3");	
	elseif ($_REQUEST["trecho"]==4) $arr_ss=explode(",","1,2,3,4");	
	elseif ($_REQUEST["trecho"]==5) $arr_ss=explode(",","1,2,3,4,5");	
	elseif ($_REQUEST["trecho"]==6) $arr_ss=explode(",","1,2,3,4,5,6");	
	elseif ($_REQUEST["trecho"]==7) $arr_ss=explode(",","1,2,3,4,5,6,7");	
	elseif ($_REQUEST["trecho"]==8) $arr_ss=explode(",","1,2,3,4,5,6,7,8");	
	elseif ($_REQUEST["trecho"]==9) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9");
	elseif ($_REQUEST["trecho"]==10) $arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");	
	else {	
		$arr_ss=explode(",","1,2,3,4,5,6,7,8,9,10");	
	}	
}
*/
	
if (isset($_REQUEST["trechos"])) {

	$arr_ss = explode(",",$_REQUEST["trechos"]);

}







?>