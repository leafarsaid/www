<?

//
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE jornal SET texto = '".$nome[$id]."' WHERE id = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO jornal (texto) values ('".$nome[$id]."')";
			break;
		/*
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover ítem')";
			$sql = "DELETE FROM t20_montadora WHERE c20_codigo = ".$id;
			break;
		*/
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
$obj_res = $obj_controle->executa("SELECT * FROM jornal ORDER BY id", true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
  <tr class="linhas">
  
    <td><input type="text" name="nome[<?= $vet_linha["id"] ?>]" size="80" maxsize="80" value="<?= $vet_linha["texto"] ?>" /></td>
    <td>
    <a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["id"] ?>)"><img src="<?= "../".$caminho_prova?>imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <!--a href="#" onclick="enviaComando('remover', <?= $vet_linha["id"] ?>)"><img src="<?= "../".$caminho_prova?>imagens/remover.gif" border="0" /></a//-->
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["id"];
}
?>
  <tr class="linhas">
  
    <td valign="bottom">
    Adicionar nova:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="80" maxsize="80" value="" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="<?= "../".$caminho_prova?>imagens/inserir.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
