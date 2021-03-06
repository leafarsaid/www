<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();


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
		case "ADICIONAR":
			$alert = "alert('ERRO:\\n\\nFalha ao adicionar campo')";
			$sql = "INSERT INTO t02_trecho (c02_codigo, c02_numero, c02_nome, c02_status) values ('".$nome[$id]."','".$dat[$id]."', '".$orig[$id]."','".$dest[$id]."','".$dist[$id]."',CONCAT(TIME_TO_SEC('".$tempoch."'),'.',".substr($tempoch,-2)."),CONCAT(TIME_TO_SEC('".$adianto."'),'.',".substr($adianto,-2)."),CONCAT(TIME_TO_SEC('".$atrazo."'),'.',".substr($atrazo,-2)."),'".$status[$id]."')";
			break;
	}	
	if ($obj_controle->executa($sql)) {
	  $alert = "null";
	}
}
?>
<div style="padding-right: 150px">
<h1>Trechos</h1>
<form name="comando" method="post">
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

<div style="float: right; margin-top: -45px;">
	<button type="button" class="btn btn-primary" onclick="enviaComando('add_trecho', <?= $vet_linha["c02_codigo"] ?>)">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Trecho
	</button>
</div>
<div style="clear: both; height: 30px;"></div>

<div class="form-group">
<div class="col-lg-4 campos">
<label for="trecho">Trecho</label>
<select id="trecho" name="trecho[<?= $vet_linha["c02_codigo"] ?>]" class="form-control">
	<option value="1">Trecho 1</option>
</select>
</div>	

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
  <div id="datetimepicker1" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="dat" name="dat[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="20" value="<?= $valData; ?>" />
    <span class="add-on">
      <icon data-time-icon="icon-time" data-date-icon="icon-calendar">
      </icon>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>


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
<label for="atrazo">Pena min. atraso</label>
<input type="text" class="form-control" id="atrazo" name="atrazo[<?= $vet_linha["c02_codigo"] ?>]" size="30" maxlength="11" value="<?= gmdate("H:i:s", $vet_linha["c02_pena_atrazo"]).'.'.substr($vet_linha["c02_pena_atrazo"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
</div>

<div class="col-lg-4 campos"> 
<label for="modalidade">Modalidade</label>
<select id="modalidade" name="modalidade[<?= $vet_linha["c02_codigo"] ?>]" class="form-control">
	<option value="1">Modalidade 1</option>
</select>
</div>

<div style="clear: both; height: 30px;"></div>
   
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
</div>
</div>
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

<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" />
</form>
