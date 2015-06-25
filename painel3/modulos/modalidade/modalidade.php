<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t10_modalidade SET c10_nome = '".$nome[$id]."' WHERE c10_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t10_modalidade (c10_nome) values ('".$nome[$id]."')";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t10_modalidade WHERE c10_codigo = ".$id;
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
$obj_res = $obj_controle->executa("SELECT * FROM t10_modalidade ORDER BY c10_codigo", true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
  <tr class="linhas">
  
    <td><?= $vet_linha["c10_codigo"] ?><input type="text" name="nome[<?= $vet_linha["c10_codigo"] ?>]" size="20" maxsize="20" value="<?= $vet_linha["c10_nome"] ?>" /></td>
    <td>
    <a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["c10_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <a href="#" onclick="confirm('Tem certeza que deseja remover a modalidade?',enviaComando('remover', <?= $vet_linha["c10_codigo"] ?>))"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c10_codigo"];
}
?>
  <tr class="linhas">
  
    <td valign="bottom">
    Adicionar nova:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="20" maxsize="20" value="" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="imagens/inserir.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
