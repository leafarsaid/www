<?php
//
session_start();

set_time_limit(0);
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

if ($_SESSION['logado'] > 0 || $_SESSION['logado'] == NULL) 
	exit("<script> document.location=\"./auth.php?uri=".$_SERVER['SCRIPT_URI']."?".$_SERVER['QUERY_STRING']."\"</script>");

//
require_once "util/objDB.php";
require_once"util/gerador_linhas.php";

//
$flt_inicio=microtime(1);
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$strMod=$_REQUEST["mod"];
$arr_vcl=(array)$_REQUEST["veiculo"];
$str_hdr_rpt=$_REQUEST["txt_cabecalho"];

// classificados
$str_sql = 'SELECT ';
$str_sql .= "DISTINCT c03_numero,";
$str_sql .= "c03_codigo,";
$str_sql .= "c10_codigo,";
$str_sql .= "c03_status,";
$str_sql .= 'getTrechoNome('.$int_id_ss.') AS nome_trecho, ';
$str_sql .= 'getCategoriaNome(c13_codigo) AS categoria, ';
$str_sql .= 'getModalidadeNome(c10_codigo) AS modalidade, ';
$str_sql .= 'getTripulanteNome(c03_piloto) AS piloto, ';
$str_sql .= 'getTripulanteNome(c03_navegador) AS navegador, ';
$str_sql .= 'getTripulanteOrigem(c03_codigo) AS tripulacao_origem, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',1)) AS L, ';
$str_sql .= 'getTempo(c03_codigo,'.$int_id_ss.',1) AS tempoL, ';
$str_sql .= 'getTempo(c03_codigo,'.$int_id_ss.',9) AS R, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',8)) AS CH, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',2)) AS I1, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',3)) AS I2, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',4)) AS I3, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',5)) AS I4, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)) AS C, ';
$str_sql .= 'getTempo(c03_codigo,'.$int_id_ss.',6) AS tempoC, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',10)) AS A, ';
$str_sql .= '(getTempo(c03_codigo,'.$int_id_ss.',11)) AS tempoLT, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',11)) AS LT, ';
$str_sql .= '(getTempo(c03_codigo,'.$int_id_ss.',12)) AS tempoCT, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',12)) AS CT, ';
$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',13)) AS PT, ';
$str_sql .= 'castTempo(calcPenalidade(c03_codigo,'.$int_id_ss.', 1)) AS P, ';
$str_sql .= 'castTempo(calcTempo(c03_codigo,'.$int_id_ss.',1,6)) AS total ';

$str_sql.="FROM ";
$str_sql.="t03_veiculo ";
$str_sql .= 'WHERE getTripulanteOrigem(c03_codigo) != "--" ';
//$str_sql .= 'AND castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)-getTempo(c03_codigo,'.$int_id_ss.',1)+calcPenalidade(c03_codigo,'.$int_id_ss.', 1)) != "* * *" ';
$str_sql .= "AND (castTempo(getTempo(c03_codigo,$int_id_ss,1)) != '* * *' 
				|| castTempo(getTempo(c03_codigo,$int_id_ss,2)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,3)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,4)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,5)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,6)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,7)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,8)) != '* * *'
				|| castTempo(getTempo(c03_codigo,$int_id_ss,9)) != '* * *'
				)
				";

//$str_sql.="AND c03_status<>'O' ";
if($int_id_cat) $str_sql.="AND c13_codigo=$int_id_cat ";
elseif($int_id_mod) $str_sql.="AND c10_codigo=$int_id_mod ";
elseif($strMod == "M") $str_sql.="AND (c10_codigo=1 OR c10_codigo=2 OR c10_codigo=3) ";
elseif($strMod == "C") $str_sql.="AND (c10_codigo=4 OR c10_codigo=5) ";

$str_sql .= 'ORDER BY L';

//print_r($str_sql);
$arr_comp0=$obj_controle->executa($str_sql)->getLinha("assoc");

//----------------------------------------------------------------------------------------------------
//*  coloca os tempos excedentes nas combos
//*  [AJUSTE] - Arrumar os IFs para o caso das contas que estão sendo usadas
//----------------------------------------------------------------------------------------------------
function excedentes($obj_controle, $str_sql_E) {
	$arr_tempo_tmp = $obj_controle->executa($str_sql_E,true)->getAll();
	for ($f = 0; $f < count($arr_tempo_tmp); $f++) {
		$sigla = " (".$arr_tempo_tmp[$f][5].")";
		$conta = $arr_tempo_tmp[$f][6];
		if ($conta==59871232) $conta_txt = "MA";
		if ($conta==59871474) $conta_txt = "SP";
		if ($conta==59871608) $conta_txt = "MG";
		if ($conta==59871639) $conta_txt = "CW";
		if ($conta==59872084) $conta_txt = "D1";				
		if ($conta==111270)   $conta_txt = "MCT";
		if (($arr_tempo_tmp[0][2] == "P")) {
			$conta_txt = "";
			$sigla = " (".$arr_tempo_tmp[$f][2].")";
		}
		printf("        	<option value=\"%s,%s,%s,%s\">%s%s%s</option>\r\n",$arr_tempo_tmp[$f][1],$arr_tempo_tmp[$f][2],'E',$arr_tempo_tmp[$f][4],$arr_tempo_tmp[$f][0],$sigla,$conta_txt);
	}
	$sel = ($arr_tempo_tmp[0][3] == "E") ? " selected" : "";
	printf("        	<option value=\"0,%s,T,%s\"%s>----</option>\r\n",$arr_tempo_tmp[0][2],$arr_tempo_tmp[0][4], $sel);

	if (($arr_tempo_tmp[0][2] == "P")) {
		$txt_obs = $arr_tempo_tmp[0][5];
		$id_obs = $arr_tempo_tmp[0][1];
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link href="css/chronosat.css" rel="stylesheet" type="text/css">
		<script language="javascript">
		/* -------------------------------------------- */
		//
		<?php echo "var trecho = $int_id_ss;\n"; ?>
		//
		function mudarTempoStatus(valor) {
			trecho = <?= $int_id_ss ?>;
			destino = "oficializa.php?valor=" + valor + "&trecho=" + trecho + "&db=<?= $_REQUEST['db'] ?>";
			window.open(destino,"oculto");
		}

		//
		function mudarObs(e, id_tempo, txt_obs) {
			if ((window.event ? e.keyCode : e.which) == 13) {
				valor = "0,P,obs,0";
				destino = "oficializa.php?valor=" + valor + "&id_tempo=" + id_tempo + "&txt_obs=" + txt_obs + "&db=<?= $_REQUEST['db'] ?>"
				window.open(destino,"oculto");
			}
		}

		//
		function adicionarTempo() {
			trecho = <?= $int_id_ss ?>;
			valor = "0," + document.getElementById("tempo_tipo").value + ",add," + document.getElementById("veiculo").value;
			destino = "oficializa.php?valor=" + valor + "&trecho=" + trecho + "&tempo=" + document.getElementById("tempo_valor").value + "&db=<?= $_REQUEST['db'] ?>"
			window.open(destino,"oculto");
		}

		//
		function formatar(src, mask) {
			var i = src.value.length;
			var saida = mask.substring(0,1);
			var texto = mask.substring(i);
			if (texto.substring(0,1) != saida) {
				src.value += texto.substring(0,1);
			}
		}

		//
		function AddLeadingZero(currentField) {
			//Check if the value length hasn't reach its max length yet
			if (currentField.value.length != currentField.maxLength) {
				//Add leading zero(s) in front of the value
				var numToAdd = currentField.maxLength - currentField.value.length;
				var value ="";
				for (var i = 0; i < numToAdd; i++) {
					value =+ "0";
				}
				currentField.value = value + currentField.value; 
			} 
		} 
		
		//
		window.onload = function() { document.getElementById("inserir_tempo").onclick = function() { adicionarTempo() } }
		/* -------------------------------------------- */
		</script>
		<style type="text/css"></style>
	</head>
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="201"><img src="imagens/logo-site_b.png" width="150" height="55" border="0"></td>
				<td width="857" align="center">
					<h2><strong>Relat&oacute;rio parcial ordenado por largada  <? echo $arr_comp["nome_trecho"]; ?></strong></h2>
					Veículo
					<select id="veiculo">
						<option></option>
						<? $obj_controle->populaBanco("SELECT c03_codigo, CONCAT(c03_numero, ' --- ', getTripulanteNome(c03_piloto)) FROM t03_veiculo ORDER BY c03_numero", 0) ?>
					</select>			
					<br>Tempo (HH:MM:SS.CC)<input type="text" id="tempo_valor" maxlength="11" size="11" onClick="this.value='';" onKeypress="formatar(this, '##:##:##.##');" />
					&nbsp;&nbsp;&nbsp;Tipo
					<select id="tempo_tipo">
						<option value="L">Largada</option>
						<option value="I1">Intemediária 1</option>
						<option value="I2">Intemediária 2</option>
						<!--option value="I3">Intemediária 3</option>
						<option value="I4">Intemediária 4</option-->
						<option value="C">Chegada</option>
						<!--option value="P">Penalização</option-->
						<option value="CH">CH</option>
						<option value="R">Reação</option>
						<option value="A">Bônus</option>
					</select>
					<input type="button" id="inserir_tempo" value="Inserir">
				</td>
				<td width="88" align="right"><font size="+5">SS<?= $_REQUEST["trecho"] ?></font></td>
				<td width="105" align="right">
					Usuário: <?= $_SESSION['usuario'] ?> (<?= $_SESSION[usuario_sigla] ?>)<br />
					Nível: <?= $_SESSION['nivel'] ?>
					<input type="button" value="Sair" onClick="document.location='auth.php?sair=1&uri=<?= $_SERVER['SCRIPT_URI']."?".$_SERVER['QUERY_STRING'] ?>'" />
				</td>
			</tr>
		</table>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<tr>
				<!--th>Pos</th-->
				<th>Num</th>
				<th>Piloto - Navegador</th>
				<!--th>Origem</th//-->
				<!--th>Cat</th-->
				<th>CH</th>
				<th>Largada</th>
				<!--th>Reação</th-->
				<th>I1</th>
				<th>I2</th>
				<!--th>I3</th>
				<th>I4</th//-->
				<th>Chegada</th>
				<th>Bônus</th>
				<th>Penais</th>
				<th>Total</th>
			</tr>
			<?
				if ($obj_res=$obj_controle->executa($str_sql)) {
					$int_pos=0;
					while($arr_comp=$obj_res->getLinha("assoc")) {
						$str_sql_E_L = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 1 ORDER BY c01_status ASC";
						$str_sql_E_R = "SELECT c01_valor,c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 9 ORDER BY c01_status ASC";
						$str_sql_E_CH = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 8 ORDER BY c01_status ASC";
						$str_sql_E_I1 = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 2 ORDER BY c01_status ASC";
						$str_sql_E_I2 = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 3 ORDER BY c01_status ASC";
						$str_sql_E_I3 = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 4 ORDER BY c01_status ASC";
						$str_sql_E_I4 = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 5 ORDER BY c01_status ASC";
						$str_sql_E_C = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 6 ORDER BY c01_status ASC";
						$str_sql_E_A = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 10 ORDER BY c01_status ASC";
						$str_sql_E_P = "SELECT castTempo((c01_valor)),c01_codigo,c01_tipo,c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND (c01_tipo = 7 OR c01_tipo = 13) ORDER BY c01_tipo ASC";
						//$str_sql_E_P = "SELECT castTempo(calcPenalidade({$arr_comp["c03_codigo"]},".$int_id_ss.", {$arr_comp["c10_codigo"]})),c01_codigo,'P',c01_status,c03_codigo,c01_sigla,c01_conta FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 6 ORDER BY c01_status ASC";
						//print_r($str_sql_E_P);
			?>
			<tr<? 
						if ($arr_comp["c03_status"] == "D") echo ' bgcolor="red"';
						if ($arr_tmp["C"] <= 0) echo ' bgcolor="#222222"';
			?>>
				<td valign="top"><?=$arr_comp["c03_numero"]?></td>
				<td valign="top" style="text-align:left;"><? echo $arr_comp["piloto"]?></td>
				
				<!-- COMBO DE TEMPOS DE CONTROLE DE LARGADA -->
				<td valign="top">
					<select name="CH" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle, $str_sql_E_CH); ?>
					</select><br/>&nbsp;
				</td>
				
				<!-- COMBO DE TEMPOS DE LARGADA -->
				<td valign="top">
					<select name="L" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_L); ?>
					</select>
					<br>GPS:<?	
							if (abs(abs($arr_comp["tempoLT"]) - abs($arr_comp["tempoL"]))>2) $cor="red";
							else $cor="green";
							printf("<spam style='color:%s'><font color='%s'>%s</font></spam>",$cor ,$cor, $arr_comp["LT"]);?>
				</td>
				
				<!-- COMBO DE TEMPOS DE REAÇÃO -->
				<!--td valign="top">
					<select name="R" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_R); ?>
					</select>
					<br />&nbsp;
				</td
				-->
				
				<!-- COMBO DE TEMPOS DE INTERMEDIARIA 1 -->
				<td valign="top">
					<select name="I1" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_I1); ?>
					</select>
					<br />&nbsp;
				</td>
				
				<!-- COMBO DE TEMPOS DE INTERMEDIARIA 2 -->
				<td valign="top">
					<select name="I2" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_I2); ?>
					</select>
					<br />&nbsp;</td>
				
				<!-- COMBO DE TEMPOS DE INTERMEDIARIA 3 -->
				<!--td>
					<select name="I3" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_I3); ?>
					</select>
					<br />&nbsp;
				</td-->
				
				<!-- COMBO DE TEMPOS DE INTERMEDIARIA 4 -->
				<!--td>
					<select name="I4" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_I4); ?>
					</select>
					<br />&nbsp;
				</td-->
				
				<!-- COMBO DE TEMPOS DE CHEGADA 4 -->
				<td valign="top">
					<select name="C" onChange="mudarTempoStatus(this.value)">
						<? excedentes($obj_controle,$str_sql_E_C); ?>
					</select>
					<br>GPS: <?	
							if (abs(abs($arr_comp["tempoCT"])-abs($arr_comp["tempoC"]))>2) $cor="red";
							else $cor="green";
							printf("<spam style='color:%s'><font color='%s'>%s</font></spam>",$cor ,$cor, $arr_comp["CT"]); ?>
				</td>
				<!-- COMBO DE TEMPOS DE BONUS -->
				<td valign="top">
					<select name="A" style="backg-color:#AAA; color:#666;">
						<? excedentes($obj_controle,$str_sql_E_A); ?>
					</select>
					<br />&nbsp;
				</td>
				<!-- COMBO DE TEMPOS DE PENAL -->
				<td valign="top"><select name="P" style="backg-color:#AAA; color:#666;">
					<? excedentes($obj_controle,$str_sql_E_P); ?>
				</select>
				<br />&nbsp;
				</td>
				<td valign="top"><?=$arr_comp["total"]?></td>
			</tr>
			<?
					}
				}
			?>
		</table>
		<iframe name="oculto" width="1" height="1" scrolling="no" src="" frameborder="0"></iframe>
	</body>
</html>