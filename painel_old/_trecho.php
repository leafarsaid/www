<style>
.botaotrecho{
	display: inline-block;
	border: thin solid black;
	background: grey;
	margin: 5px;
	padding: 5px;
	color: black;
}

</style>

<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();

$obj_controle2 = $obj_controle;

$arr_ordem_ch = array();
$obj_res0 = $obj_controle->executa("SELECT * FROM t11_prova LIMIT 1", true);
$vet_ch = $obj_res0->getLinha("assoc");
$etapas_ch = explode(';',$vet_ch["c11_ordemch"]);
$i = 0;

foreach($etapas_ch AS $etapa){

	$exp = explode(',',$etapa);
	
	//largada ch
	$ss = substr($exp[0],1,1);
	$ch = substr($exp[0],2,1);
	$arr_ordem_ch[$i]['larg_ss'] = $ss;
	$arr_ordem_ch[$i]['larg_ch'] = $ch;
	
	//chegada ch
	$ss = substr($exp[1],0,1);
	$ch = substr($exp[1],1,1);
	$arr_ordem_ch[$i]['cheg_ss'] = $ss;
	$arr_ordem_ch[$i]['cheg_ch'] = $ch;
	
	$i++;
}

if (isset($_POST["cmd"]))
{
	$nome = $_POST["nome"];
	$dat = $_POST["dat"];
	$orig = $_POST["orig"];
	$dest = $_POST["dest"];
	$dist = $_POST["dist"];
	$status = $_POST["status"];
	$id = $_POST["id"];	
	$tempoch = ($_POST["tempoch"][$id]) ? ($_POST["tempoch"][$id]) : '00:00:00.00';
	$adianto = ($_POST["adianto"][$id]) ? ($_POST["adianto"][$id]) : '00:00:00.00';
	$atrazo = ($_POST["atrazo"][$id]) ? ($_POST["atrazo"][$id]) : '00:00:00.00';	
		

	$competidores = array();
	$obj_res1 = $obj_controle->executa("SELECT * FROM t03_veiculo WHERE c03_status='N'", true);
	while($vet_comp = $obj_res1->getLinha("assoc")) {
		$numeral = ($vet_comp["c03_codigo"] > 0) ? $vet_comp["c03_codigo"] : 0;
		$competidores[$numeral]['numeral'] 		= $numeral;
		$competidores[$numeral]['larg_ss'] 		= ($arr_ordem_ch[$id]['larg_ss'] > 0) ? $arr_ordem_ch[$id]['larg_ss'] : 0;
		$competidores[$numeral]['larg_tipo'] 	= ($arr_ordem_ch[$id]['larg_ch']=='a') ? 'ACH' : 'CH';
		$competidores[$numeral]['cheg_ss'] 		= ($arr_ordem_ch[$id]['cheg_ss'] > 0) ? $arr_ordem_ch[$id]['cheg_ss'] : 0;
		$competidores[$numeral]['cheg_tipo'] 	= ($arr_ordem_ch[$id]['cheg_ch']=='a') ? 'ACH' : 'CH';
	}
	
	$obj_trecho = $obj_controle->executa("SELECT * FROM t02_trecho WHERE c02_codigo=$id", true);
	$vet_trecho = $obj_trecho->getLinha("assoc");
	
	foreach ($competidores AS $numeral => $competidor){
	
		$larg_ss = $competidor['larg_ss'];
		$larg_tipo = $competidor['larg_tipo'];
		$cheg_ss = $competidor['cheg_ss'];
		$cheg_tipo = $competidor['cheg_tipo'];
	
		$sql_tempo = "SELECT (COALESCE(((SELECT c01_valor FROM t01_tempos WHERE c01_tipo='$cheg_tipo' AND c02_codigo=$cheg_ss AND c03_codigo=$numeral AND c01_status='O' LIMIT 1) - (SELECT c01_valor FROM t01_tempos WHERE c01_tipo='$larg_tipo' AND c02_codigo=$larg_ss AND c03_codigo=$numeral AND c01_status='O' LIMIT 1)),0)) AS valor";
		
		$obj_tempoch = $obj_controle->executa($sql_tempo, true);
		
		$vet_tempo = $obj_tempoch->getLinha("assoc");
		$tempoch_txt = ($vet_tempo['valor'] > 0) ? $vet_tempo['valor'] : 0;
		$competidores[$numeral]['tempoch'] = $tempoch_txt;
		if ($tempoch_txt > 0){
			$dif = ($tempoch_txt - $vet_trecho['c02_tempo_ch'])/60;
			$dif = ($dif < 0) ? ceil($dif) : floor($dif);
			$competidores[$numeral]['dif_tempoch'] = $dif;
			$pena_trecho_ch = ($dif < 0) ? (($dif *(-1)) * $vet_trecho['c02_pena_adianto']) : (($dif) * $vet_trecho['c02_pena_atrazo']);
			$competidores[$numeral]['pena_trecho_ch'] = $pena_trecho_ch;
		} else {
			$dif = NULL;
		}
		
		//se nao tem pena nao precisa estar aqui
		if ($dif == NULL) unset($competidores[$numeral]);
			
	}

	//echo '<pre>';
	//var_dump($competidores);
	
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql = "UPDATE t02_trecho SET c02_nome = '".$nome[$id]."', c02_data = '".$dat[$id]."', c02_origem = '".$orig[$id]."', c02_destino = '".$dest[$id]."', c02_distancia = '".$dist[$id]."', c02_tempo_ch = CONCAT(TIME_TO_SEC('".$tempoch."'),'.','".substr($tempoch,-2)."'), c02_pena_adianto = CONCAT(TIME_TO_SEC('".$adianto."'),'.','".substr($adianto,-2)."'), c02_pena_atrazo = CONCAT(TIME_TO_SEC('".$atrazo."'),'.','".substr($atrazo,-2)."'), c02_status = '".$status[$id]."' WHERE c02_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t02_trecho (c02_nome, c02_data, c02_origem, c02_destino, c02_distancia, c02_tempo_ch, c02_pena_adianto, c02_pena_atrazo, c02_status) values ('".$nome[$id]."','".$dat[$id]."', '".$orig[$id]."','".$dest[$id]."','".$dist[$id]."',CONCAT(TIME_TO_SEC('".$tempoch."'),'.',".substr($tempoch,-2)."),CONCAT(TIME_TO_SEC('".$adianto."'),'.',".substr($adianto,-2)."),CONCAT(TIME_TO_SEC('".$atrazo."'),'.',".substr($atrazo,-2)."),'".$status[$id]."')";
			break;
		case "REMOVER":
			$alert = "alert('ERRO:\\n\\nFalha ao remover campo')";
			$sql = "DELETE FROM t02_trecho WHERE c02_codigo = ".$id;
			break;
		case "PENALCH":
			$sql[] = "DELETE FROM t01_tempos WHERE c01_obs = 'PENA_AUTOMATICA_CH' AND c01_tipo='P' AND c02_codigo = ".$id;
			foreach ($competidores AS $numeral => $competidor){
				$c01_valor = ($competidor['pena_trecho_ch'] > 0) ? $competidor['pena_trecho_ch'] : 0;
				$c03_codigo = ($numeral > 0) ? $numeral : 0;
				$c02_codigo = ($id > 0) ? $id : 0;
				$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c01_obs, c03_codigo, c02_codigo, c01_sigla) values ($c01_valor, 'P', 'O', 'PENA_AUTOMATICA_CH', $c03_codigo, $c02_codigo, 'AUT_CH')";
			}
			
			break;
		case "RESET_PENALCH":
			$sql = "DELETE FROM t01_tempos WHERE c01_obs = 'PENA_AUTOMATICA_CH' AND c01_tipo='P' AND c02_codigo = ".$id;
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
<?
$query = "SELECT * FROM t02_trecho";

//if (){
$query .= " WHERE c02_codigo=1";
//}

$obj_res = $obj_controle->executa($query, true);
while ($vet_linha = $obj_res->getLinha("assoc")) 
{
	$vet_linha["c02_tempo_ch"] = ($vet_linha["c02_tempo_ch"]) ? $vet_linha["c02_tempo_ch"] : '0.00';
	$vet_linha["c02_pena_adianto"] = ($vet_linha["c02_pena_adianto"]) ? $vet_linha["c02_pena_adianto"] : '0.00';
	$vet_linha["c02_pena_atrazo"] = ($vet_linha["c02_pena_atrazo"]) ? $vet_linha["c02_pena_atrazo"] : '0.00';
?>
  
  <tr>
    <td colspan="2" align="right"><a href="#" onclick="enviaComando('add_trecho', <?= $vet_linha["c02_codigo"] ?>)"><div class="botaotrecho">+ Adicionar Trecho</div></a></td>
  </tr>
  <tr>
    <td>
	Trecho<br />
	<select name="trecho[<?= $vet_linha["c02_codigo"] ?>]">
		<option value="1">Trecho 1</option>
	</select>
	</td>
	<td>
	Status<br />
	<select name="status[<?= $vet_linha["c02_codigo"] ?>]">
		<option value="NI" <?= ($vet_linha["c02_status"] == "NI") ? "selected" : "" ?>>N&atilde;o iniciado</option>
		<option value="I" <?= ($vet_linha["c02_status"] == "I") ? "selected" : "" ?>>Iniciado</option>
		<option value="F" <?= ($vet_linha["c02_status"] == "F") ? "selected" : "" ?>>Finalizado</option>
	</select>
	</td>
  </tr>
  <tr>
    <td>Nome<br /><input type="text" name="nome[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_nome"] ?>" /></td>
    <td>Data<br /><input type="text" name="dat[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_data"] ?>" /></td>
  </tr>
  <tr>
    <td>Origem<br /><input type="text" name="orig[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_origem"] ?>" /></td>
    <td>Destino<br /><input type="text" name="dest[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_destino"] ?>" /></td>
  </tr>
  <tr>
    <td>Distância<br /><input type="text" name="dist[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_distancia"] ?>" /></td>
    <td>Tempo CH<br /><input type="text" name="tempoch[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_tempo_ch"]).'.'.substr($vet_linha["c02_tempo_ch"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" /></td>
  </tr>
  <tr>
    <td>Pena min. adianto<br /><input type="text" name="adianto[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_pena_adianto"]).'.'.substr($vet_linha["c02_pena_adianto"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" /></td>
    <td>Pena min. atraso<br /><input type="text" name="atrazo[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_pena_atrazo"]).'.'.substr($vet_linha["c02_pena_atrazo"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" /></td>
  </tr>
  <tr>
    <td>
    Modalidade<br />
	<select name="modalidade[<?= $vet_linha["c02_codigo"] ?>]">
		<option value="1">Modalidade 1</option>
	</select>
    </td>
	<td></td>
  </tr>
  <tr>
    <td colspan=2>
    <a href="#" onclick="enviaComando('atualizar', <?= $vet_linha["c02_codigo"] ?>)"><div class="botaotrecho"><img src="imagens/botao_atualizar.gif" border="0" alt="atualizar" valign="absmiddle" /> Atualizar</div></a>
    <a href="#" onclick="confirm('Tem certeza que deseja remover o trecho?',enviaComando('remover', <?= $vet_linha["c02_codigo"] ?>))"><div class="botaotrecho"><img src="imagens/remover.gif" border="0" alt="remover" valign="absmiddle" /> Excluir</div></a>
    <a href="#" onclick="confirm('Tem certeza que deseja aplicar penalidades no trecho?',enviaComando('penalch', <?= $vet_linha["c02_codigo"] ?>))"><div class="botaotrecho"><img src="imagens/penalch.gif" border="0" alt="Penalidades CH" valign="absmiddle" /> Penal CH</div></a>
    <a href="#" onclick="confirm('Tem certeza que deseja resetar penalidades no trecho?',enviaComando('reset_penalch', <?= $vet_linha["c02_codigo"] ?>))"><div class="botaotrecho"><img src="imagens/reset_penalch.gif" border="0" alt="Resetar Penalidades CH" valign="absmiddle" /> Reset CH</div></a>
    
	</td>
  </tr>
<?
$ultimo_id = $vet_linha["c02_codigo"];
}
?>
  <!--tr class="linhas">
  
    <td>&nbsp;</td>
    <td valign="bottom">
    Adicionar novo:<br />
    <input type="text" name="nome[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dat[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="orig[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dest[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="dist[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="tempoch[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="adianto[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
    <td valign="bottom"><input type="text" name="atrazo[<?= $ultimo_id+1 ?>]" size="10" maxsize="20" value="" /></td>
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
  </tr-->
</table>
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
