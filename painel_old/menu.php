<?

$db = $_REQUEST['db'];



function botao($id, $label) {	

global $bt;		

global $db;	

$cor = ($id==$bt) ? "0066FF" : "99CCFF";	

$retorno = sprintf("<tr class=\"botao\">\n<td width=\"232\" align=\"center\" valign=\"middle\" bgcolor=\"#$cor\" onClick=\"location='?db=%s&bt=%s'\" onMouseOver=\"this.bgColor='#0066FF'\" onMouseOut=\"this.bgColor='#$cor'\"><span>%s</span></td>\n</tr>\n\n", $db, $id, $label );	

return $retorno;

}

function botao2($id, $label) {	

global $bt;	$cor = ($id==$bt) ? "0066FF" : "99CCFF";	

$retorno = sprintf("<tr class=\"botao\">\n<td width=\"232\" align=\"center\" valign=\"middle\" bgcolor=\"#$cor\" ><span>%2\$s</span></td>\n</tr>\n\n", $id, $label);	

return $retorno;

}



?>



<table width="242" border="0" cellspacing="5" cellpadding="5">



<? 

	//echo botao("1", "Montadoras");

	//echo botao("2", "Modelos");

	if ($_SESSION['logado']==0) echo botao("15", "Prova");

	if ($_SESSION['logado']==0) echo botao("3", "Categorias");

	if ($_SESSION['logado']==0) echo botao("4", "Modalidades");

	if ($_SESSION['logado']==0) echo botao("5", "Trechos");

	if ($_SESSION['logado']==0) echo botao("6", "Atributos dos Trechos");

	if ($_SESSION['logado']==0) echo botao("7", "Editar Tripulantes");

	if ($_SESSION['logado']==0) echo botao("8", "Editar Ve&iacute;culos");

	if ($_SESSION['logado']==0) echo botao("9", "Editar Penalidades");	
	
	if ($_SESSION['logado']==0) echo botao("12", "Inserir Tempos de CSV");	

	if ($_SESSION['logado']==0) echo botao("10", "Limpar tempos");	

	if ($_SESSION['logado']<4) echo botao("11", "Alterar Senha");	
    
    if ($_SESSION['logado']==0) echo botao("13", "Ocorrencias");	
	
    if ($_SESSION['logado']==0) echo botao("14", "Importar competidores");	

	echo botao2("12", "<input type=\"button\" value=\"Sair\" onclick=\"document.location='../auth.php?sair=1&uri=".$_SERVER['REQUEST_URI']."'\" />");

	//echo botao("9", "Jornal Eletrônico");

?>

</table>

Usuário: <?= $_SESSION['usuario'] ?> (<?= $_SESSION[usuario_sigla] ?>)<br />

Nível: <?= $_SESSION['nivel'] ?>