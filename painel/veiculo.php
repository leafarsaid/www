<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
$sql1 = "SELECT c04_codigo, c04_nome FROM t04_tripulante ORDER BY c04_nome";
$obj_res1 = $obj_controle->executa($sql1, true);
$l=0;
while ($vet_linha1 = $obj_res1->getLinha("assoc"))
{
	$codigos[$l] = $vet_linha1["c04_codigo"];
	$nomes[$l] = $vet_linha1["c04_nome"];
	$l++;
}

//
$sql2 = "SELECT c13_codigo, c13_nome FROM t13_categoria ORDER BY c13_codigo";
$obj_res2 = $obj_controle->executa($sql2, true);
$m=0;
while ($vet_linha2 = $obj_res2->getLinha("assoc"))
{
	$codigos_cats[$m] = $vet_linha2["c13_codigo"];
	$categorias[$m] = $vet_linha2["c13_nome"];
	$m++;
}

//
$sql3 = "SELECT c10_codigo, c10_descricao FROM t10_modalidade ORDER BY c10_codigo";
$obj_res3 = $obj_controle->executa($sql3, true);
$n=0;
while ($vet_linha3 = $obj_res3->getLinha("assoc"))
{
	$codigos_mods[$n] = $vet_linha3["c10_codigo"];
	$modalidades[$n] = $vet_linha3["c10_descricao"];
	$n++;
}

//
$sql4 = "SELECT c14_codigo, c14_nome FROM t14_campeonato ORDER BY c14_codigo";
$obj_res4 = $obj_controle->executa($sql4, true);
$o=0;
while ($vet_linha4 = $obj_res4->getLinha("assoc"))
{
	$codigos_camps[$o] = $vet_linha4["c14_codigo"];
	$campeonatos[$o] = $vet_linha4["c14_nome"];
	$o++;
}

//
$tipo_status[0]="D";
$tipo_status[1]="N";
$tipo_status[2]="NC";
$tipo_status[3]="O";
$tipo_status[4]="C";

function combo($nome_campo, $matriz_id, $id_selec, $id_veic, $matriz) {
	$retorno = sprintf('<select name="%s">\n',$nome_campo.'['.$id_veic.']');
	if ($matriz_id[$k]==0) { 
		$retorno .= sprintf('<option value="0" selected>***</option>');
	} else {
		$retorno .= sprintf('<option value="0">***</option>');
	}
	for ($k=0;$k<count($matriz_id);$k++) {
		$retorno .= sprintf('<option value="%s"',$matriz_id[$k]);
		if ($matriz_id[$k] == $id_selec) $retorno .= sprintf(' selected');
		$retorno .= sprintf('>%s</option>\n',$matriz[$k]);
	}
	$retorno .= sprintf('</select>');
	return $retorno;
}

if (isset($_POST["cmd"]))
{
	$numero = $_POST["numero"];
	$numero_ins = $_POST["numero_ins"];
	$status = $_POST["status"];
	$status2 = $_POST["status2"];
	$piloto = $_POST["piloto"];
	$navegador = $_POST["navegador"];
	$navegador2 = $_POST["navegador2"];
	$categoria = $_POST["categoria"];
	$subcategoria = $_POST["subcategoria"];
	$modalidade = $_POST["modalidade"];
	$campeonato = $_POST["campeonato"];
	$ordem_largada = $_POST["ordem_largada"];
	$id = $_POST["id"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t03_veiculo SET c03_codigo = '".$numero[$id]."', c03_numero = '".$numero[$id]."', c03_status = '".$status[$id]."', c03_status2 = '".$status2[$id]."', c03_piloto = '".$piloto[$id]."', c03_navegador = '".$navegador[$id]."', c03_navegador2 = '".$navegador2[$id]."', c13_codigo = '".$categoria[$id]."', c13_codigo2 = '".$subcategoria[$id]."', c10_codigo = '".$modalidade[$id]."', c14_codigo = '".$campeonato[$id]."' WHERE c03_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			//$sql = "INSERT INTO t03_veiculo (c03_codigo,c03_numero,c03_status,c03_piloto,c03_navegador,c03_navegador2,c13_codigo,c13_codigo2,c10_codigo,c14_codigo) values ('".$numero[$id]."','".$numero[$id]."','".$status[$id]."','".$piloto[$id]."','".$navegador[$id]."','".$navegador2[$id]."','".$categoria[$id]."','".$subcategoria[$id]."','".$modalidade[$id]."','".$campeonato[$id]."')";
			$sql = "INSERT INTO t03_veiculo (c03_codigo,c03_numero,c03_status,c03_status2,c13_codigo,c13_codigo2,c10_codigo,c14_codigo,c21_codigo) values ('".$numero_ins."','".$numero_ins."','N','N',1,1,1,1,1)";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql[] = "DELETE FROM t01_tempos WHERE c03_codigo = ".$id;
			$sql[] = "DELETE FROM t03_veiculo WHERE c03_codigo = ".$id;
			break;
	}

	//
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>


<form name="veiculo" method="post">
D=Desclassificado;&nbsp;&nbsp;&nbsp; N=Normal;&nbsp;&nbsp;&nbsp; NC=Não classificado;&nbsp;&nbsp;&nbsp; O=Oculto; 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Escolha o veiculo a modificar:
<input type="text" name="veiculo" maxlength="3" size="3" />
<input type="submit" />
</form>
<form name="comando" method="post"><table cellpadding="5" cellspacing="5">
  <tr class="linhas">	
  	<td>numero</td>
    <td>status prova 1</td>
    <td>status prova 2</td>    
    <td>tripulação</td>
    <td>categoria</td>
    <td>subcategoria</td>
    <td>modalidade</td>
    <td>campeonato</td>
    <td>ordem largada</td>
    <td></td>
  </tr> 
<?
if (isset($_POST["pag"]))
{
	$pag = $_POST["pag"];
} else {
	$pag = 0;
}
$sql = "SELECT * FROM t03_veiculo ";
if ($veiculo>0) $sql .= "WHERE c03_codigo=".$veiculo." ";
$sql .= "ORDER BY c03_codigo ";
$sql .= "LIMIT ".$pag.",5";

//print_r($sql);

$obj_res = $obj_controle->executa($sql, true);
//print_r($sql);

while ($vet_linha = $obj_res->getLinha("assoc")) 
{
?>
 
  <tr class="linhas">
  
    <td><input type="text" name="numero[<?= $vet_linha["c03_codigo"] ?>]" size="3" value="<?= $vet_linha["c03_codigo"] ?>" /></td>
    <td><?= combo('status', $tipo_status, $vet_linha["c03_status"], $vet_linha["c03_codigo"], $tipo_status) ?></td>
    <td><?= combo('status2', $tipo_status, $vet_linha["c03_status2"], $vet_linha["c03_codigo"], $tipo_status) ?></td>
    <td>
    	<!-- tripulação //-->
        <table border="0">
        <tr><td>Piloto</td><td><?= combo('piloto', $codigos, $vet_linha["c03_piloto"], $vet_linha["c03_codigo"], $nomes) ?></td></tr>
        <tr><td>Navegador</td><td><?= combo('navegador', $codigos, $vet_linha["c03_navegador"], $vet_linha["c03_codigo"], $nomes) ?></td></tr>
        <tr><td>Navegador</td><td><?= combo('navegador2', $codigos, $vet_linha["c03_navegador2"], $vet_linha["c03_codigo"], $nomes) ?></td></tr>
        </table>
        <!-- tripulação //-->
    </td>
    <td><?= combo('categoria', $codigos_cats, $vet_linha["c13_codigo"], $vet_linha["c03_codigo"], $categorias) ?></td>
    <td><?= combo('subcategoria', $codigos_cats, $vet_linha["c13_codigo2"], $vet_linha["c03_codigo"], $categorias) ?></td>
    <td><?= combo('modalidade', $codigos_mods, $vet_linha["c10_codigo"], $vet_linha["c03_codigo"], $modalidades) ?></td>
    <td><?= combo('campeonato', $codigos_camps, $vet_linha["c14_codigo"], $vet_linha["c03_codigo"], $campeonatos) ?></td>
    <td><!-- ordem de largada //--></td>
    <td>
    <a href="#" onclick="enviaComandoFrame('atualizar', <?= $vet_linha["c03_codigo"] ?>)"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" /></a>
    <a href="#" onclick="if (confirm('Tem certeza que deseja remover o veiculo <?= $vet_linha["c03_codigo"] ?>?')) enviaComandoFrame('remover', <?= $vet_linha["c03_codigo"] ?>);"><img src="imagens/remover.gif" border="0" alt="remover" /></a>
    </td>
  </tr>
<?
$ultimo_id = $vet_linha["c04_codigo"];
}
?>
  <tr class="linhas">
  
    <td colspan="10">
    Adicionar novo:
    </td>
  </tr>
  <tr class="linhas">	
  	<td>numero</td>
    <td>--</td>    
    <td>--</td>
    <td>--</td>
    <td>--</td>
    <td>--</td>
    <td>--</td>
    <td>--</td>
    <td>--</td>
    <td></td>
  </tr>


  

  <tr class="linhas">  	
    <td><input type="text" name="numero_ins" size="3" /></td>
    <td valign="bottom">
    <a href="#" onclick="enviaComandoFrame('adicionar', 1)"><img src="imagens/inserir.gif" border="0" alt="inserir" /></a>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="pag" value="<?=$pag?>" />
<input type="hidden" name="veic" value="<?=$veic?>" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>

<form name="paginacao" method="post">
<input type="hidden" name="pag" />
<center>
<input type="button" name="voltar" value="<< voltar" onclick="document.paginacao.pag.value=<?= ($pag>0) ? $pag-5 : $pag ?>; document.paginacao.submit();" />
<input type="button" name="avancar" value="avançar >>" onclick="document.paginacao.pag.value=<?= $pag+5 ?>; document.paginacao.submit();" />
<br>Página <?= ($pag/5)+1 ?>
</center>
</form>