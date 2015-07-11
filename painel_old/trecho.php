<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$dat = $_POST["dat"];
	$orig = $_POST["orig"];
	$dest = $_POST["dest"];
	$dist = $_POST["dist"];
	$status = $_POST["status"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t02_trecho SET c02_nome = '".$nome[$id]."', c02_data = '".$dat[$id]."', c02_origem = '".$orig[$id]."', c02_destino = '".$dest[$id]."', c02_distancia = '".$dist[$id]."', c02_status = '".$status[$id]."' WHERE c02_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t02_trecho (c02_nome, c02_data, c02_origem, c02_destino, c02_distancia, c02_status) values ('".$nome[$id]."','".$dat[$id]."', '".$orig[$id]."','".$dest[$id]."','".$dist[$id]."','".$status[$id]."')";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t02_trecho WHERE c02_codigo = ".$id;
			break;
	}
	//print_r($sql);
	//
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>

<form name="comando" method="post">
<table cellpadding="5" cellspacing="5">
<tr>
<td align="center">Número</td>
<td align="center">Nome</td>
<td align="center">Data</td>
<td align="center">Origem</td>
<td align="center">Destino</td>
<td align="center">Distância</td>
<td align="center">Status</td>
</tr>

<?
$obj_res = $obj_controle->executa("SELECT * FROM t02_trecho ORDER BY c02_codigo", true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
  <tr class="linhas">
  
    <td><?= $vet_linha["c02_codigo"] ?></td>
    <td><input type="text" name="nome[<?= $vet_linha["c02_codigo"] ?>]" size="10" maxsize="20" value="<?= $vet_linha["c02_nome"] ?>" /></td>
    <td><input type="text" name="dat[<?= $vet_linha["c02_codigo"] ?>]" size="10" maxsize="20" value="<?= $vet_linha["c02_data"] ?>" /></td>
    <td><input type="text" name="orig[<?= $vet_linha["c02_codigo"] ?>]" size="10" maxsize="20" value="<?= $vet_linha["c02_origem"] ?>" /></td>
    <td><input type="text" name="dest[<?= $vet_linha["c02_codigo"] ?>]" size="10" maxsize="20" value="<?= $vet_linha["c02_destino"] ?>" /></td>
    <td><input type="text" name="dist[<?= $vet_linha["c02_codigo"] ?>]" size="10" maxsize="20" value="<?= $vet_linha["c02_distancia"] ?>" /></td>
    <td>
<select name="status[<?= $vet_linha["c02_codigo"] ?>]">
<option value="NI" <?= ($vet_linha["c02_status"] == "NI") ? "selected" : "" ?>>N&atilde;o iniciado</option>
<option value="I" <?= ($vet_linha["c02_status"] == "I") ? "selected" : "" ?>>Iniciado</option>
<option value="F" <?= ($vet_linha["c02_status"] == "F") ? "selected" : "" ?>>Finalizado</option>
</select>
    </td>
    <td>
    <a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["c02_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <a href="#" onclick="confirm('Tem certeza que deseja remover o trecho?',enviaComando('remover', <?= $vet_linha["c02_codigo"] ?>))"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c02_codigo"];
}
?>
  <tr class="linhas">
  
    <td>&nbsp;</td>
    <td valign="bottom">
    Adicionar novo:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dat[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="orig[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dest[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dist[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom">
<select name="status[<?= $ultimo_id+1 ?>]">
<option value="NI">N&atilde;o iniciado</option>
<option value="I">Iniciado</option>
<option value="F">Finalizado</option>
</select>
    </td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="imagens/inserir.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
