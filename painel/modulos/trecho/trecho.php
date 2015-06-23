<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();

$obj_controle2 = $obj_controle;

$arr_ordem_ch = array();
$obj_res0 = $obj_controle->executa("SELECT * FROM t11_prova LIMIT 1", true);
$vet_ch = $obj_res0->getLinha("assoc");
$etapas_ch = explode(';',$vet_ch["c11_ordemch"]);
$trecho = (isset($_REQUEST['trecho'])) ? $_REQUEST['trecho'] : 1;
$modalidade = (isset($_REQUEST['modalidade'])) ? $_REQUEST['modalidade'] : 1;
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
	$atraso = ($_POST["atraso"][$id]) ? ($_POST["atraso"][$id]) : '00:00:00.00';	
		

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
			$pena_trecho_ch = ($dif < 0) ? (($dif *(-1)) * $vet_trecho['c02_pena_adianto']) : (($dif) * $vet_trecho['c02_pena_atraso']);
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
			$sql = "UPDATE t02_trecho SET c02_nome = '".$nome[$id]."', c02_data = '".$dat[$id]."', c02_origem = '".$orig[$id]."', c02_destino = '".$dest[$id]."', c02_distancia = '".$dist[$id]."', c02_tempo_ch = CONCAT(TIME_TO_SEC('".$tempoch."'),'.','".substr($tempoch,-2)."'), c02_pena_adianto = CONCAT(TIME_TO_SEC('".$adianto."'),'.','".substr($adianto,-2)."'), c02_pena_atraso = CONCAT(TIME_TO_SEC('".$atraso."'),'.','".substr($atraso,-2)."'), c02_status = '".$status[$id]."' WHERE c02_codigo = ".$id;
			break;
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t02_trecho (c02_nome, c02_data, c02_origem, c02_destino, c02_distancia, c02_tempo_ch, c02_pena_adianto, c02_pena_atraso, c02_status) values ('".$nome[$id]."','".$dat[$id]."', '".$orig[$id]."','".$dest[$id]."','".$dist[$id]."',CONCAT(TIME_TO_SEC('".$tempoch."'),'.',".substr($tempoch,-2)."),CONCAT(TIME_TO_SEC('".$adianto."'),'.',".substr($adianto,-2)."),CONCAT(TIME_TO_SEC('".$atraso."'),'.',".substr($atraso,-2)."),'".$status[$id]."')";
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
<div style="padding-right: 150px">
<h1>Trechos</h1>
<form name="comando" method="post">
<?

$query = "SELECT * FROM t02_trecho WHERE c02_codigo=$trecho";

$obj_res = $obj_controle->executa($query, true);
$vet_linha = $obj_res->getLinha("assoc"); 

$vet_linha["c02_tempo_ch"] = ($vet_linha["c02_tempo_ch"]) ? $vet_linha["c02_tempo_ch"] : '0.00';
$vet_linha["c02_pena_adianto"] = ($vet_linha["c02_pena_adianto"]) ? $vet_linha["c02_pena_adianto"] : '0.00';
$vet_linha["c02_pena_atraso"] = ($vet_linha["c02_pena_atraso"]) ? $vet_linha["c02_pena_atraso"] : '0.00';

?>


<div style="float: right; margin-top: -45px;">
	<button type="button" class="btn btn-primary" onclick="enviaComando('add_trecho', <?= $vet_linha["c02_codigo"] ?>)">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Trecho
	</button>
</div>

<div class="panel panel-default">

<div style="clear: both; height: 30px;"></div>

<div class="form-group">

<div class="col-lg-4 campos"> 
<label for="status">Status</label>
<select id="status" name="status[<?= $vet_linha["c02_codigo"] ?>]" class="form-control">
	<option value="NI" <?= ($vet_linha["c02_status"] == "NI") ? "selected" : "" ?>>N&atilde;o iniciado</option>
	<option value="I" <?= ($vet_linha["c02_status"] == "I") ? "selected" : "" ?>>Iniciado</option>
	<option value="F" <?= ($vet_linha["c02_status"] == "F") ? "selected" : "" ?>>Finalizado</option>
</select>
</div>
	
<div class="col-lg-4 campos"> 	
<label for="nome">Nome</label>
<input type="text" class="form-control" id="nome" name="nome[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_nome"] ?>" />
</div>

<?php 
$origData = $vet_linha["c02_data"];
$valData = $origData[8].$origData[9]."/".$origData[5].$origData[6]."/".$origData[0].$origData[1].$origData[2].$origData[3];
?>

<div class="col-sm-4">
	<label for="dat">Data</label>
	<input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="dat" name="dat[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $valData; ?>" />
</div>


<div class="col-lg-4 campos"> 
	<label for="orig">Origem</label>
	<input type="text" class="form-control" id="orig" name="orig[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_origem"] ?>" />
</div>

<div class="col-lg-4 campos"> 
	<label for="dest">Destino</label>
	<input type="text" class="form-control" id="dest" name="dest[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_destino"] ?>" />
</div>

<div class="col-lg-4 campos"> 
	<label for="dist">Dist&acirc;ncia (m)</label>
	<input type="text" class="form-control" id="dist" name="dist[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $vet_linha["c02_distancia"] ?>" />
</div>

<div class="col-lg-4 campos"> 
	<label for="tempoch">Tempo CH</label>
	<input type="text" class="form-control" id="tempoch" name="tempoch[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_tempo_ch"]).'.'.substr($vet_linha["c02_tempo_ch"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
</div>

<div class="col-lg-4 campos"> 
	<label for="adianto">Pena min. adianto</label>
	<input type="text" class="form-control" id="adianto" name="adianto[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_pena_adianto"]).'.'.substr($vet_linha["c02_pena_adianto"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
</div>

<div class="col-lg-4 campos"> 
	<label for="atraso">Pena min. atraso</label>
	<input type="text" class="form-control" id="atraso" name="atraso[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_pena_atraso"]).'.'.substr($vet_linha["c02_pena_atraso"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
</div>

</div>
</div>
</div>

<div class="col-lg-12">
<ul class="nav nav-tabs">
<?php 
	$query3 = "SELECT * FROM t10_modalidade";
	$obj_res3 = $obj_controle->executa($query3, true);
	  
	while($vet_linha3 = $obj_res3->getLinha("assoc")){
		$active = ($vet_linha3["c10_codigo"]==$modalidade) ? " class=\"active\"" : "";
		$location = "?db=".$_REQUEST['db']."&bt=".$_REQUEST['bt']."&trecho=".$_REQUEST['trecho']."&modalidade=".$vet_linha3["c10_codigo"];
		$texto_mod = $vet_linha3["c10_nome"];

		printf("<li role=\"presentation\"%s><a href=\"%s\">%s</a></li>", $active, $location, $texto_mod);
	}
?>
</ul>
<div class="well">
oioioioii
</div>
</div>
   
<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-success" onclick="enviaComando('atualizar', <?= $vet_linha["c02_codigo"] ?>)">
    	<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
    	Atualizar
    </button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-danger" onclick="if (confirm('Tem certeza que deseja remover o trecho?')) enviaComando('remover', <?= $vet_linha["c02_codigo"] ?>)">
    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    	Excluir
    </button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-warning" onclick="if (confirm('Tem certeza que deseja aplicar penalidades no trecho?')) enviaComando('penalch', <?= $vet_linha["c02_codigo"] ?>)">
    	<span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
    	Penal CH
    </button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-info" onclick="if (confirm('Tem certeza que deseja resetar penalidades no trecho?')) enviaComando('reset_penalch', <?= $vet_linha["c02_codigo"] ?>)">
    	<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    	Reset CH
    </button>
  </div>


</div>

<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
