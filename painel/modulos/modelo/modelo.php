<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$cmd = $_POST["cmd"];
	$id = $_POST["id"];
	$id2 = $_POST["id2"];
	$nome = $_POST["nome"];
	$montadora = $_POST["montadora"];
	switch (strtoupper($cmd)) 
	{
		case "ATUALIZAR":
			for ($r=0;$r<count($id2);$r++) {
				//nome
				$sql_sel = "SELECT c21_nome, c20_codigo FROM t21_modelo WHERE c21_codigo = ".$id2[$r];
				$obj_res = $obj_controle->executa($sql_sel, true);
				$vet = $obj_res->getLinha();
				
				if ($vet[0][0]!=$nome[$id2[$r]] || $vet[0][1]!=$montadora[$id2[$r]]) {
					$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
					$sql[] = "UPDATE t21_modelo SET c21_nome = '".$nome[$id2[$r]]."', c20_codigo = '".$montadora[$id2[$r]]."'  WHERE c21_codigo = ".$id2[$r];
				}
			}
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t21_modelo (c21_nome,c20_codigo) values ('".$nome[$id]."',".$montadora[$id].")";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover ítem')";
			$sql = "DELETE FROM t21_modelo WHERE c21_codigo = ".$id;
			break;
	}

	//
	//print_r($sql);
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}

//
$obj_mont = $obj_controle->executa("SELECT c20_codigo, c20_nome FROM t20_montadora ORDER BY c20_codigo", true);
$i=1;
while ($vet_mont = $obj_mont->getLinha())
{
	$vet_mont_result[$i] = $vet_mont[1];
	$i++;
}

?>

<form name="comando" method="post">
<table cellpadding="5" cellspacing="5">
<?

$obj_res = $obj_controle->executa("SELECT c21_codigo, c21_nome, c20_codigo FROM t21_modelo ORDER BY c21_codigo", true);
//$j = 0;
while ($vet = $obj_res->getLinha()) 
{
?>
  <tr class="linhas">
  	<td valign="bottom">
    <select name="montadora[<?= $vet[0] ?>]"><option></option><? $obj_controle->popula($vet_mont_result, $vet[2]) ?></select>    </td>
    
    <td><input type="text" name="nome[<?= $vet[0] ?>]" size="20" maxsize="20" value="<?= $vet[1] ?>" />
		<input type="hidden" name="id2[<?= $vet[0] ?>]" value="<?= $vet[0] ?>" />
    </td>    
    
    <td><a href="#" onclick="confirm('Deseja realmente apagar o ítem?',enviaComando('remover', <?= $vet[0] ?>))"><img src="imagens/remover.gif" border="0" alt="remover" /></a></td>
  </tr>
<?
//$j++;
$ultimo_id = $vet[0];
}

?>
  <tr class="linhas">
    <td valign="bottom">&nbsp;</td>
    
    <td valign="bottom">&nbsp;</td>
    
    <td valign="bottom"><a href="#" onclick="enviaComando('atualizar')" /><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a></td>
  </tr>
  <tr class="linhas">
    <td valign="bottom"><select name="montadora[<?= $ultimo_id+1 ?>]">
      <option></option>
      <? $obj_controle->populaBanco("SELECT c20_codigo, c20_nome FROM t20_montadora ORDER BY c20_codigo", 0) ?>
    </select></td>
    <td valign="bottom">Adicionar nova:<br />
      <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="20" maxsize="20" value="" /></td>
    <td valign="bottom"><a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="imagens/inserir.gif" border="0" /></a></td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
