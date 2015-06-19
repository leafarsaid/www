<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();

//
if (isset($_POST["cmd"]))
{
	$tit = $_POST["tit"];
	$sub = $_POST["sub"];
	$ord = $_POST["ord"];	
	
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t11_prova SET 
				c11_titulo = '$tit'
				,c11_subtitulo = '$sub'
				,c11_ordemch = '$ord'";
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
<td align="center">&nbsp;</td>
<td align="center">T&iacute;tulo</td>
<td align="center">Sub-t&iacute;tulo</td>
<td align="center">Ordem de CHs</td>
</tr>

<?
$obj_res = $obj_controle->executa("SELECT * FROM t11_prova LIMIT 1", true);
$vet_linha = $obj_res->getLinha("assoc");
?>
  <tr class="linhas">
  
    <td>&nbsp;</td>
    <td valign="bottom"><input type="text" name="tit" size="30" maxlength="200" value="<? echo $vet_linha["c11_titulo"]; ?>" /></td>
    <td valign="bottom"><input type="text" name="sub" size="20" maxlength="200" value="<? echo $vet_linha["c11_subtitulo"]; ?>" /></td>
    <td valign="bottom"><input type="text" name="ord" size="50" maxlength="200" value="<? echo $vet_linha["c11_ordemch"]; ?>" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComando('atualizar', 0)"><img src="imagens/botao_atualizar.gif" border="0" /></a>
    </td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
