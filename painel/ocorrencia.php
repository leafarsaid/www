<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
if (isset($_POST["cmd"]))
{
	$numero = $_POST["numero"];
	$especial = $_POST["especial"];
	$motivo = $_POST["motivo"];
	$prova = $_POST["prova"];
	$tipo = $_POST["tipo"];
	$tempo = $_POST["tempo"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t33_ocorrencias SET ";
			$sql .= "c03_codigo = '".$numero[$id]."'";
			$sql .= ", c33_ss = '".$especial[$id]."'";
			$sql .= ", c33_motivo = '".$motivo[$id]."'";
			$sql .= ", c33_prova = '".$prova[$id]."'";
			$sql .= ", c33_tipo = '".$tipo[$id]."'";
			$sql .= ", c33_tempo = '".$tempo[$id]."'";
			$sql .= " WHERE c33_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t33_ocorrencias (c03_codigo,c33_ss,c33_motivo,c33_prova,c33_tipo,c33_tempo) values (";
			$sql .= "'".$numero[$id]."'";
			$sql .= ",'".$especial[$id]."'";
			$sql .= ",'".$motivo[$id]."'";
			$sql .= ",'".$prova[$id]."'";
			$sql .= ",'".$tipo[$id]."'";
			$sql .= ",'".$tempo[$id]."'";
			$sql .= ")";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t33_ocorrencias WHERE c33_codigo = ".$id;
			break;
	}
	//printf("<script>alert('%s');</script>",$sql);

	//
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	 // printf("<script>alert('%s');</script>",$sql);
	}
}
 //printf($sql);
?>

<form name="comando" method="post">
<table cellpadding="5" cellspacing="5">
  <tr class="linhas">	
    <td>Id</td>	
    <td>Numero do Carro</td>
    <td>Especial</td>    
    <td>Motivo</td>
    <td>Prova</td>
    <td>Tipo</td>
    <td>Tempo  (em caso de penalidade) <br />
      ex: 01:00</td>
    <td></td>
  </tr> 
<?
if (isset($_POST["pag"]))
{
	$pag = $_POST["pag"];
} else {
	$pag = 0;
}
$sql = "SELECT * FROM t33_ocorrencias ORDER BY c03_codigo LIMIT ".$pag.",15";
$obj_res = $obj_controle->executa($sql, true);
//print_r($sql);

while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
 
  <tr class="linhas">
  
    <td><?= $vet_linha["c33_codigo"] ?></td>
    <td><input type="text" name="numero[<?= $vet_linha["c33_codigo"] ?>]" size="3" value="<?= $vet_linha["c03_codigo"] ?>" /></td>
    <td><input type="text" name="especial[<?= $vet_linha["c33_codigo"] ?>]" size="3" value="<?= $vet_linha["c33_ss"] ?>" /></td>
    <td><input type="text" name="motivo[<?= $vet_linha["c33_codigo"] ?>]" size="30" value="<?= $vet_linha["c33_motivo"] ?>" /></td>
    <td><input type="text" name="prova[<?= $vet_linha["c33_codigo"] ?>]" size="1" value="<?= $vet_linha["c33_prova"] ?>" /></td>
    <td>
    <!--input type="text" name="tipo[<?= $vet_linha["c33_codigo"] ?>]" size="8" value="<?= $vet_linha["c33_tipo"] ?>" /-->
    <select name="tipo[<?= $vet_linha["c33_codigo"] ?>]">
      <option value="A"<?= ($vet_linha["c33_tipo"]=="A") ? " selected" : "" ?>>Abandono</option>
      <option value="P"<?= ($vet_linha["c33_tipo"]=="P") ? " selected" : "" ?>>Penalização</option>
      </select>
    </td>
    <td><input type="text" name="tempo[<?= $vet_linha["c33_codigo"] ?>]" size="8" value="<?= $vet_linha["c33_tempo"] ?>" />
    </td>
    <td>
    <a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c33_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <a href="#" onclick="if (confirm('Tem certeza que deseja remover o tripulante?')) enviaComandoFrame('remover', <?= $vet_linha["c33_codigo"] ?>);"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c04_codigo"];
}
?>
  <tr class="linhas">
  
    <td colspan="8">
      <p>&nbsp;</p>
      <p>Use o formul&aacute;rio abaixo para adicionar novo registro:      </p>
      </td>
  </tr>
  <tr class="linhas">	
    <td>Id</td>	
    <td>Numero do Carro</td>
    <td>Especial</td>    
    <td>Motivo</td>
    <td>Prova</td>
    <td>Tipo</td>
    <td>Tempo  (em caso de penalidade) <br />
      ex: 01:00</td>
    <td></td>
  </tr> 
  <tr class="linhas">  	
    <td></td> 
    <td><input type="text" name="numero[<?= $ultimo_id+1 ?>]" size="3" value="" /></td>
    <td><input type="text" name="especial[<?= $ultimo_id+1 ?>]" size="3" value="" /></td>
    <td><input type="text" name="motivo[<?= $ultimo_id+1 ?>]" size="30" value="" /></td>
    <td><input type="text" name="prova[<?= $ultimo_id+1 ?>]" size="1" value="1" /></td>
    <td><select name="tipo[<?= $ultimo_id+1 ?>]">
      <option value="A">Abandono</option>
      <option value="P">Penalização</option>
      </select>
      </td>      
    <td><input type="text" name="tempo[<?= $ultimo_id+1 ?>]" size="15" value="" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComandoFrame('adicionar', <?= $ultimo_id+1 ?>)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="pag" value="<?=$pag?>" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
<form name="paginacao" method="post">
<input type="hidden" name="pag" />
<center>
<input type="button" name="voltar" value="<< voltar" onclick="document.paginacao.pag.value=<?= ($pag>0) ? $pag-15 : $pag ?>; document.paginacao.submit();" />
<input type="button" name="avancar" value="avançar >>" onclick="document.paginacao.pag.value=<?= $pag+15 ?>; document.paginacao.submit();" />
<br>Página <?= ($pag/15)+1 ?>
</center>
</form>