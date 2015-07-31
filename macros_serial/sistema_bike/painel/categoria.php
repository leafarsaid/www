<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$descricao = $_POST["descricao"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t13_categoria SET c13_nome = '".$nome[$id]."', c13_descricao = '".$descricao[$id]."' WHERE c13_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t13_categoria (c13_nome, c13_descricao) values ('".$nome[$id]."','".$descricao[$id]."')";
			break;
	}

	//
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>

<form name="comando" method="post">
<table cellpadding="5" cellspacing="5">
<?
$obj_res = $obj_controle->executa("SELECT * FROM t13_categoria ORDER BY c13_codigo", true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
  <tr class="linhas">
    <td>Nome</td>    
    <td>Descrição</td>
    <td></td>
  </tr> 
  <tr class="linhas">
  
    <td><?= $vet_linha["c13_codigo"] ?><input type="text" name="nome[<?= $vet_linha["c13_codigo"] ?>]" size="20" maxsize="20" value="<?= $vet_linha["c13_nome"] ?>" /></td>
    <td><input type="text" name="descricao[<?= $vet_linha["c13_codigo"] ?>]" size="20" maxsize="20" value="<?= $vet_linha["c13_descricao"] ?>" /></td>
    <td>
    <a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["c13_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <!--a href="#" onclick="enviaComando('remover', <?= $vet_linha["c13_codigo"] ?>)"><img src="imagens/remover.gif" border="0" /></a//-->
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c13_codigo"];
}
?>
  <tr class="linhas">
  
    <td valign="bottom">
    Adicionar Nome:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="20" maxsize="20" value="" /></td>
    <td valign="bottom">
    Adicionar Descrição:<br />
    <input type="text" name="descricao[<?= $ultimo_id+1 ?>]" size="20" maxsize="20" value="" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="imagens/inserir.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
