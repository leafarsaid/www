<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		/*case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t10_modalidade SET c10_nome = '".$nome[$id]."' WHERE c10_codigo = ".$id;
			break;*/
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = array();
			$sql[] = "INSERT INTO t03_veiculo (c03_codigo,c03_numero,c21_codigo,c13_codigo,c10_codigo) values (".$nome[$id].",".$nome[$id].",1,1,1)";
			$sql[] = "INSERT INTO t04_tripulante (c04_codigo,c04_nome,c04_origem,c04_tipo,c03_codigo) values (".$nome[$id].",'-','-','P',".$nome[$id].")";
			$sql[] = "INSERT INTO t12_campeonatoveiculo (c11_codigo,c03_codigo) values (1,".$nome[$id].")";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = array();
			$sql[] = "DELETE FROM t01_tempos WHERE c03_codigo = ".$id;
			$sql[] = "DELETE FROM t12_campeonatoveiculo WHERE c03_codigo = ".$id;
			$sql[] = "DELETE FROM t04_tripulante WHERE c03_codigo = ".$id;
			$sql[] = "DELETE FROM t03_veiculo WHERE c03_codigo = ".$id;
			break;
	}

	//
	
	print_r($sql);
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>

<form name="comando" method="post">
<table cellpadding="5" cellspacing="5">

<?
$obj_res = $obj_controle->executa("SELECT * FROM t03_veiculo ORDER BY c03_codigo", true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
  <tr class="linhas">
  
    <td><input type="text" name="nome[<?= $vet_linha["c03_codigo"] ?>]" size="20" maxsize="20" value="<?= $vet_linha["c03_numero"] ?>" /></td>
    <td>
    <!--a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["c03_codigo"] ?>)"><img src="<?= "../".$caminho_prova?>imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a//-->
    <a href="#" onclick="confirm('Tem certeza que deseja remover o veículo?',enviaComando('remover', <?= $vet_linha["c03_codigo"] ?>))"><img src="<?= "../".$caminho_prova?>imagens/remover.gif" border="0" alt="remover" /></a>
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c03_codigo"];
}
?>
  <tr class="linhas">
  
    <td valign="bottom">
    Adicionar nova:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="20" maxsize="20" value="" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('adicionar', <?= $ultimo_id+1 ?>)"><img src="<?= "../".$caminho_prova?>imagens/inserir.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
