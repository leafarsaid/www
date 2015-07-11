<?
//
if(isset($_POST["cmd"])){
	$idx=$_POST["id"];
	$ext=$_POST["ext"][$idx];
	$tmx=$_POST["tmx"][$idx];
	$pen=$_POST["pen"][$idx];
	$penamax=$_POST["penamax"][$idx];
	$sts=$_POST["status"][$idx];
	list($id_ss,$id_mod)=explode("_",$idx);
	
	switch(strtoupper($_POST["cmd"])){
		case "ATUALIZAR":
			$sql ="UPDATE ";
			$sql.="t05_trechomodalidade ";
			$sql.="SET ";
			$sql.="c05_extensao=$ext, ";
			$sql.="c05_penamax=TIME_TO_SEC('$penamax'), ";
			$sql.="c05_tempomax=CONCAT(TIME_TO_SEC('$tmx'),'.',".substr($tmx,-1)."), ";
			$sql.="c05_penalidade=CONCAT(TIME_TO_SEC('$pen'),'.',".substr($pen,-1)."), ";
			$sql.="c05_status='$sts' ";
			$sql.="WHERE ";
			$sql.="c02_codigo=$id_ss ";
			$sql.="AND c10_codigo=$id_mod";
			
			
			$alert="alert('ERRO:\\n\\nFalha ao atualizar campo')";
			break;
	}
	
	if($obj_controle->executa($sql)){
		$alert="null";
	}
}

//
$sql ="SELECT ";
$sql.="c02_codigo,";
$sql.="c10_codigo,";
$sql.="c05_extensao,";
$sql.="castTempo(c05_tempomax) AS c05_tempomax,";
$sql.="castTempo(c05_penalidade) AS c05_penalidade,";
$sql.="castTempo(c05_penamax) AS c05_penamax,";
$sql.="c05_status,";
$sql.="c02_nome,";
$sql.="c10_nome ";
$sql.="FROM ";
$sql.="t05_trechomodalidade ";
$sql.="NATURAL JOIN t02_trecho ";
$sql.="NATURAL JOIN t10_modalidade ";
$sql.="ORDER BY ";
$sql.="c10_codigo, ";
$sql.="c02_codigo";
$obj_res=$obj_controle->executa($sql,true);
?>
<form name="comando" method="post">

<table cellpadding="5" cellspacing="5">
	<tr>
		<td align="center">Trecho</td>
		<td align="center">Modalidade</td>
		<td align="center">Extensão (m)</td>
		<td align="center">Tempo Máximo</td>
		<td align="center">Penalidade</td>
		<td align="center">Máximo em Penalidades</td>
		<td align="center">Status</td>
	</tr>
	<?
	while($vet_linha=$obj_res->getLinha("assoc")){
		$idx=$vet_linha["c02_codigo"]."_".$vet_linha["c10_codigo"];
	?>
	<tr class="linhas">
		<td><?=$vet_linha["c02_nome"]?></td>
		<td><?=$vet_linha["c10_nome"]?></td>
		<td><input name="ext[<?=$idx?>]" size="15" maxlength="15" value="<?=$vet_linha["c05_extensao"]?>"></td>
		<td><input name="tmx[<?=$idx?>]" size="15" maxlength="15" value="<?=$vet_linha["c05_tempomax"]?>"></td>
		<td><input name="pen[<?=$idx?>]" size="15" maxlength="15" value="<?=$vet_linha["c05_penalidade"]?>"></td>
        <td><input name="penamax[<?=$idx?>]" size="15" maxlength="15" value="<?=$vet_linha["c05_penamax"]?>"></td>
		<td>
			<select name="status[<?=$idx?>]">
				<option value="N">Normal</option>
				<option value="P"<? if($vet_linha["c05_status"]=="P") echo " selected" ?>>Penalização Automática</option>
			</select>
		</td>
		<td>
			<input type="image" src="imagens/botao_atualizar.gif" title="atualizar" onclick="enviaComando('atualizar','<?=$idx?>')">
		</td>
	</tr>
	<?}?>
</table>

<input type="hidden" name="id">
<input type="hidden" name="cmd">
<input type="hidden" name="bt" value="<?=$bt?>">
</form>