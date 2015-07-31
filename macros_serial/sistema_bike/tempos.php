<?php

//
session_start();

set_time_limit(0);

//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
//if ($_SESSION['logado']>0 || $_SESSION['logado']==NULL) exit("<script>document.location=\"auth.php?uri=".$_SERVER['SCRIPT_URI']."?".$_SERVER['QUERY_STRING']."\"</script>");

//phpinfo();

//
require_once"util/gerador_linhas.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

//
$flt_inicio=microtime(1);
$int_id_ss=(int)$_REQUEST["trecho"];
$int_id_cat=(int)$_REQUEST["categoria"];
$int_id_mod=(int)$_REQUEST["modalidade"];
$arr_vcl=(array)$_REQUEST["veiculo"];
$str_hdr_rpt=$_REQUEST["txt_cabecalho"];

if ($_REQUEST['acao']=='alterar') {

	$valor_get = explode(",",$_GET["valor"]);
	$_REQUEST["db"] = $valor_get[2];

	//
	//$href = "history.back()";

	$tempo_codigo = $valor_get[0];
	$tempo_tipo = $valor_get[1];
	if ($valor_get[2] == "E") $acao = "OFICIAL";
	elseif ($valor_get[2] == "O")  $acao = "EXCEDENTE";
	elseif ($valor_get[2] == "add")  $acao = "ADD_TEMPO";
	elseif ($valor_get[2] == "T")  $acao = "EXTODOS";
	elseif ($valor_get[2] == "obs")  $acao = "MUDA_OBS";
	$veiculo = $valor_get[3];
	$trecho = $_GET["trecho"];
	$largada_valor = $_GET["largada"];
	$chegada_valor = $_GET["chegada"];
	$id_tempo = $_GET["id_tempo"];
	$txt_obs = $_GET["txt_obs"];
	$sinal_largada = ($largada_valor[0]=="-" && $largada_valor[1]==0) ? "-" : "";
	$sinal_chegada = ($chegada_valor[0]=="-" && $chegada_valor[1]==0) ? "-" : "";


	//
	switch (strtoupper($acao)) {
		case "EXCEDENTE":
			$alert = "alert('ERRO:\\n\\nFalha ao desoficializar tempo')";
			$sql = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_codigo = $tempo_codigo";
			break;
			
		case "EXTODOS":
			$sql = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_tipo = '$tempo_tipo' AND c03_codigo = $veiculo AND c02_codigo = $trecho";
			$alert = "alert('ERRO:\\n\\nFalha ao desoficializar tempos - $sql')";
			break;
		
		case "OFICIAL":
			$alert = "alert('ERRO:\\n\\nFalha ao oficializar tempo')";
			$sql[] = "UPDATE t01_tempos SET c01_status = 'E' WHERE c01_tipo = '$tempo_tipo' AND c03_codigo = $veiculo AND c02_codigo = $trecho";
			$sql[] = "UPDATE t01_tempos SET c01_status = 'O' WHERE c01_codigo = $tempo_codigo";
			break;
		
		case "HABILITAR":
			$alert = "alert('ERRO:\\n\\nFalha ao habilitar penalizações automáticas')";
			$sql = "UPDATE t05_trechomodalidade SET c05_status = 'P' WHERE c02_codigo = $trecho AND c10_codigo = $modalidade";
			break;
		
		case "DESABILITAR":
			$alert = "alert('ERRO:\\n\\nFalha ao desabilitar penalizações automáticas')";
			$sql = "UPDATE t05_trechomodalidade SET c05_status = 'N' WHERE c02_codigo = $trecho AND c10_codigo = $modalidade";
			break;
		
		case "ADD_TEMPO":
			$parte_decimal_largada = end(explode('.', $largada_valor));
			$parte_decimal_chegada = end(explode('.', $chegada_valor));
			
			$sql[] = "UPDATE t01_tempos SET c01_status = 'E' WHERE (c01_tipo = 'L' OR c01_tipo = 'C') AND c03_codigo = $veiculo AND c02_codigo = $trecho";
			
			//$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo) VALUES (CONCAT('$sinal',(TIME_TO_SEC('$tempo_valor')), '.', $parte_decimal), '$tempo_tipo', 'O', $veiculo, $trecho)";
			
			$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal_largada',(TIME_TO_SEC('$largada_valor')), '.', $parte_decimal_largada), 'L', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
			$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES (CONCAT('$sinal_chegada',(TIME_TO_SEC('$chegada_valor')), '.', $parte_decimal_chegada), 'C', 'O', $veiculo, $trecho, '$_SESSION[usuario_sigla]')";
			
			break;
		
		case "MUDA_OBS":
			$alert = "alert('ERRO:\\n\\nFalha ao mudar a observacao')";
			$sql = "UPDATE t01_tempos SET c01_obs = '$txt_obs' WHERE c01_codigo = $id_tempo";
			break;

		}
	//
	if (ControleBDFactory::getControlador(DB_DRIVER)->executa($sql)) {
	  $alert = "alert('CONFIRMAÇÃO:\\n\\nRegistro alterado ou inserido com sucesso. Para que a visualização da linha fique correta perante seu status, caso este tenha mudado, torna-se necessário recarregar a página.')";
	  //$href = "location.href = 'ssl.php?trecho=$trecho&modalidade=$modalidade'";
	}

}


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
//$str_sql .= 'castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)-getTempo(c03_codigo,'.$int_id_ss.',1)+calcPenalidade(c03_codigo,'.$int_id_ss.', 1)) AS total ';


$str_sql.="FROM ";
$str_sql.="t03_veiculo ";

$str_sql .= 'WHERE getTripulanteOrigem(c03_codigo) != "--" ';
//$str_sql .= 'AND castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)-getTempo(c03_codigo,'.$int_id_ss.',1)+calcPenalidade(c03_codigo,'.$int_id_ss.', 1)) != "* * *" ';
$str_sql .= 'AND (castTempo(getTempo(c03_codigo,'.$int_id_ss.',1)) != "* * *" || castTempo(getTempo(c03_codigo,'.$int_id_ss.',6)) != "* * *") ';

//$str_sql.="AND c03_status<>'O' ";
if($int_id_cat) $str_sql.="AND c13_codigo=$int_id_cat ";
if($int_id_mod) $str_sql.="AND c10_codigo=$int_id_mod ";

$str_sql .= 'ORDER BY C';

//print_r($str_sql);

$arr_comp0=$obj_ctrl->executa($str_sql)->getLinha("assoc");

function excedentes($obj_ctrl,$str_sql_E) {
	$arr_tempo_tmp=$obj_ctrl->executa($str_sql_E,true)->getAll();
	for ($f=0;$f<count($arr_tempo_tmp);$f++) {
		$sigla = " (".$arr_tempo_tmp[$f][5].")";
		$conta = $arr_tempo_tmp[$f][6];
		if ($conta==59871232) $conta_txt = "MA";
		if ($conta==59871474) $conta_txt = "SP";
		if ($conta==59871608) $conta_txt = "MG";
		if ($conta==59871639) $conta_txt = "CW";
		if ($conta==59872084) $conta_txt = "D1";				if ($conta==111270) $conta_txt = "MCT";
		if (($arr_tempo_tmp[0][2]=="P")) {
			$conta_txt = "";
			$sigla = " (".$arr_tempo_tmp[$f][2].")";
		}
		printf("        	<option value=\"%s,%s,%s,%s\">%s%s%s</option>\r\n",$arr_tempo_tmp[$f][1],$arr_tempo_tmp[$f][2],'E',$arr_tempo_tmp[$f][4],$arr_tempo_tmp[$f][0],$sigla,$conta_txt);
	}
	$sel = ($arr_tempo_tmp[0][3]=="E") ? " selected" : "";
	printf("        	<option value=\"0,%s,T,%s\"%s>----</option>\r\n",$arr_tempo_tmp[0][2],$arr_tempo_tmp[0][4], $sel);

	if (($arr_tempo_tmp[0][2]=="P")) {
		$txt_obs = $arr_tempo_tmp[0][5];
		$id_obs = $arr_tempo_tmp[0][1];
	}
}


function retornaObs($obj_ctrl,$str_sql_E) {
	global $txt_obs;
	global $id_obs;

	$arr_tempo_tmp=$obj_ctrl->executa($str_sql_E,true)->getAll();
	
	return $arr_tempo_tmp[0][0];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="css/chronosat.css" rel="stylesheet" type="text/css">
<script language="javascript">

/* -------------------------------------------- */

//
<?php

	echo "var trecho = $trecho;\n";
	//echo "var modalidade = $modalidade;\n";

?>

function mudarTempoStatus(valor) {
	trecho = <?= $trecho ?>;
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
	trecho = <?= $trecho ?>;
	valor = "0,L,add," + document.getElementById("veiculo").value;
	destino = "oficializa.php?valor=" + valor + "&trecho=" + trecho + "&largada=" + document.getElementById("largada_valor").value + "&chegada=" + document.getElementById("chegada_valor").value + "&db=<?= $_REQUEST['db'] ?>"
	//alert(destino);
	window.open(destino,"oculto");
	var t=setTimeout(function(){window.open("tempos.php?trecho="+trecho,"_self")},1000);
}
//
window.onload = function() {
  document.getElementById("inserir_tempo").onclick = function() {adicionarTempo()}
}

/* -------------------------------------------- */

function formatar(src, mask){
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i);
if (texto.substring(0,1) != saida)
  {
	src.value += texto.substring(0,1);
  }
}

function AddLeadingZero(currentField)
{
//Check if the value length hasn't reach its max length yet
if (currentField.value.length != currentField.maxLength)
{
//Add leading zero(s) in front of the value
var numToAdd = currentField.maxLength - currentField.value.length;
var value ="";
for (var i = 0; i < numToAdd;i++)
{
value =+ "0";
}
currentField.value = value + currentField.value; 
} 
} 

</script>

<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="201"><img src="imagens/logo-site_b.png" width="150" height="55" border="0"></td>
    <td width="857" align="center"><h2><strong>Relat&oacute;rio parcial ordenado por largada  <? echo $arr_comp["nome_trecho"]; ?>
          </strong></h2>
                Veículo
                <select id="veiculo">
                <option></option>
                <? $obj_ctrl->populaBanco("SELECT c03_codigo, CONCAT(c03_numero, ' ---', getTripulanteNome(c03_piloto), ' --- ', getTripulanteNome(c03_navegador)) FROM t03_veiculo ORDER BY c03_numero", 0) ?>
                </select>
                &nbsp;&nbsp;&nbsp;
                
                <br>
          Largada (HH:MM:SS.CC)
          <input type="text" id="largada_valor" maxlength="11" size="11" onClick="this.value='';" onKeypress="formatar(this, '##:##:##.##');" />
                &nbsp;&nbsp;&nbsp;
          Chegada (HH:MM:SS.CC)
          <input type="text" id="chegada_valor" maxlength="11" size="11" onClick="this.value='';" onKeypress="formatar(this, '##:##:##.##');" />
                
                <input type="button" id="inserir_tempo" value="Inserir">        </td>
        <td width="88" align="right"><font size="+5">SS<?= $trecho ?></font></td>
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
		if($obj_res=$obj_ctrl->executa($str_sql)){
			$int_pos=0;
			
			while($arr_comp=$obj_res->getLinha("assoc")){

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
				if($arr_comp["c03_status"]=="D") echo ' bgcolor="red"';
				if($arr_tmp["C"]<=0) echo ' bgcolor="#222222"';
		?>>
		<!--td valign="top"><?=($arr_comp["c03_status"]=="D")?"NC":++$int_pos?></td-->
		<td valign="top"><?=$arr_comp["c03_numero"]?></td>
		<td valign="top" style="text-align:left;"><? echo $arr_comp["piloto"]."<br>".$arr_comp["navegador"]; ?></td>
		<!--td><?=$arr_comp["tripulacao_origem"]?>&nbsp;</td//-->
		<!--td valign="top"><?=$arr_comp["categoria"]?></td-->
        <td valign="top"><select name="CH" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_CH); ?>
        </select><br />&nbsp;</td>
		<td valign="top"><select name="L" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_L); ?>
        </select>
		  <br>GPS: 
		  <?	
		   if (abs(abs($arr_comp["tempoLT"])-abs($arr_comp["tempoL"]))>2) $cor="red";
		   else $cor="green";
		   printf("<spam style='color:%s'><font color='%s'>%s</font></spam>",$cor ,$cor, $arr_comp["LT"]);   
		   ?></td>
		<!--td valign="top"><select name="R" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_R); ?>
        </select><br />&nbsp;</td-->
        
        <td valign="top"><select name="I1" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_I1); ?>
        </select><br />&nbsp;</td>
        
        <td valign="top"><select name="I2" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_I2); ?>
        </select><br />&nbsp;</td>
        <!--td><select name="I3" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_I3); ?>
        </select><br />&nbsp;</td>
        <td><select name="I4" onChange="mudarTempoStatus(this.value)">
       		<? excedentes($obj_ctrl,$str_sql_E_I4); ?>
        </select><br />&nbsp;</td//-->
        
        <td valign="top"><select name="C" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_C); ?>
        </select>
          <br>GPS: 
		  <?	
		   if (abs(abs($arr_comp["tempoCT"])-abs($arr_comp["tempoC"]))>2) $cor="red";
		   else $cor="green";
		   printf("<spam style='color:%s'><font color='%s'>%s</font></spam>",$cor ,$cor, $arr_comp["CT"]); 		   
		   ?></td>
        <td><select name="A" onChange="mudarTempoStatus(this.value)">
        	<? excedentes($obj_ctrl,$str_sql_E_A); ?>
        </select><br />&nbsp;</td>
        <td valign="top"><select name="P" style="backg-color:#AAA; color:#666;">
        	<? 
				excedentes($obj_ctrl,$str_sql_E_P); 
				/*$txt_obs = retornaObs($obj_ctrl,"SELECT c01_obs FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 7 AND c01_status = \"O\" LIMIT 1");
				$id_obs = retornaObs($obj_ctrl,"SELECT c01_codigo FROM t01_tempos WHERE c03_codigo = {$arr_comp["c03_codigo"]} AND c02_codigo = ".$int_id_ss." AND c01_tipo = 7 AND c01_status = \"O\" LIMIT 1");*/
			?>
        </select><br />&nbsp;
		<!--br><input type="text" size="20" name="obs" value="<?= $txt_obs ?>" onKeyPress="mudarObs(event,'<?= $id_obs ?>',this.value);" --></td>

<!-- onKeyDown="if ((window.event ? event.KeyCode : event.which) == 13) { mudarObs('<?= $id_obs ?>',this.value); }" //-->
		
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