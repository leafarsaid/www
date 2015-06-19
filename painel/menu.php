<?

$db = $_REQUEST['db'];



function botao($id, $currentId, $label) {
	global $bt;	
	global $db;	
	
	if ($id == $currentId) 	$retorno = sprintf("<li class=\"active\"><a href=\"?db=%s&bt=%s\">%s<span class=\"sr-only\">(current)</span></a></li>", $db, $id, $label);
	else 					$retorno = sprintf("<li><a href=\"?db=%s&bt=%s\">%s</a></li>", $db, $id, $label);	
	
	
	
	
	return $retorno;

}

?>

<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">

<? 

	//echo botao("1", "Montadoras");

	//echo botao("2", "Modelos");

	if ($_SESSION['logado']==0) echo botao("15", $_REQUEST['bt'], "Prova");

	if ($_SESSION['logado']==0) echo botao("3", $_REQUEST['bt'], "Categorias");

	if ($_SESSION['logado']==0) echo botao("4", $_REQUEST['bt'], "Modalidades");

	if ($_SESSION['logado']==0) echo botao("5", $_REQUEST['bt'], "Trechos");

	//if ($_SESSION['logado']==0) echo botao("6", $_REQUEST['bt'], "Atributos dos Trechos");

	if ($_SESSION['logado']==0) echo botao("7", $_REQUEST['bt'], "Editar Tripulantes");

	if ($_SESSION['logado']==0) echo botao("8", $_REQUEST['bt'], "Editar Ve&iacute;culos");

	if ($_SESSION['logado']==0) echo botao("9", $_REQUEST['bt'], "Editar Penalidades");	
	
	if ($_SESSION['logado']==0) echo botao("12", $_REQUEST['bt'], "Inserir Tempos de CSV");	

	if ($_SESSION['logado']==0) echo botao("10", $_REQUEST['bt'], "Limpar tempos");	

	if ($_SESSION['logado']<4) echo botao("11", $_REQUEST['bt'], "Alterar Senha");	
    
    if ($_SESSION['logado']==0) echo botao("13", $_REQUEST['bt'], "Ocorrencias");	
	
    if ($_SESSION['logado']==0) echo botao("14", $_REQUEST['bt'], "Importar competidores");	

	

	//echo botao("9", "Jornal Eletrônico");

?>

	</ul>
</div>
