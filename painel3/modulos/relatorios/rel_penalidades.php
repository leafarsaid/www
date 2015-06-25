<?

//
set_time_limit(0);

//
header("Content-type: text/html; charset=iso-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
$prova=(int)$_REQUEST["prova"];
$tipo=$_REQUEST["tipo"];

	if ($prova==2) $col_stat = "c03_status2";
	else $col_stat = "c03_status";

//
require_once"util/gerador_linhas.php";
require_once"util/cabecalho.php";
require_once"util/sql.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="css/relatorio_video.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(imagens/fundo.jpg);
	background-repeat: no-repeat;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-position: center top;
	background-color: #FFFFFF;
}
a {
	color: #CC9900;
	text-decoration: none;
}
a:hover {
	color: #FFFFFF;
	text-decoration: underline;
}
.style2 {
	color: #CC9900;
	font-family: Arial, Helvetica, sans-serif;
}
.style5 {
	font-size: 16px
}
-->
</style>
</head>

<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0">
<p align="right">&nbsp;</p>
<p align="right">&nbsp;</p>
<p align="right">&nbsp;</p>
<p align="center"><img src="../../../../br.jpg"/><br>
</p>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="bottom" class="style5">
    <td align="left"><?

$prova = criaArray ("SELECT * FROM t11_prova");
echo $prova[0]["c11_titulo"]."<br />";	
echo $prova[0]["c11_subtitulo"]."<br />";
echo "Prova ".$_GET['prova']."<br />";

	?></td>
    <td align="right"><?
    if ($tipo=="A") echo "Abandonos";
    if ($tipo=="P") echo "Penaliza&ccedil;&otilde;es";
	?></td>
  </tr>
  <tr bgcolor="#CC9900">
    <td height="3" colspan="2"></td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><table width="100%" cellpadding="5" cellspacing="0" class="tb1">
		<tr class="td1">
			<td width="9%" class="cells">No</td>
			<td width="30%" class="cells">Piloto/Navegador</td>
			<td width="9%" class="cells">Especial</td>
			<td width="<?= ($_GET['tipo']=='P') ? '26%' : '52%' ?>" class="cells">Motivo</td>
			<?= ($_GET['tipo']=='P') ? '<td width="26%" class="cells">Tempo</td>' : '' ?>
		</tr>
<?
$query = "SELECT o.c33_motivo AS motivo";
$query .= " ,o.c03_codigo AS numero ";
$query .= " ,o.c33_ss AS especial ";
$query .= " ,o.c33_tempo AS tempo ";
$query .= " ,getTripulanteNome(v.c03_piloto) AS piloto ";
$query .= " ,getTripulanteNome(v.c03_navegador) AS navegador ";
$query .= " FROM t33_ocorrencias AS o";
$query .= " ,t03_veiculo AS v";
$query .= " WHERE o.c33_prova=".$_GET['prova'];
$query .= " AND o.c33_tipo='".$_GET['tipo']."'";
$query .= " AND v.c03_codigo=o.c03_codigo";
$query .= " ORDER BY o.c03_codigo";

$linha = criaArray ($query);

//var_dump($query);

for ($f=0;$f<count($linha);$f++) {

?>		
		<tr class="tr1_alt">
			<td class="cells"><?= $linha[$f]["numero"] ?></td>
			<td class="cells">
				<div class="trip" id="div2">
					<strong><?= $linha[$f]["piloto"] ?></strong><br /> 
					<strong><?= $linha[$f]["navegador"] ?></strong><br /> 
					</div>			</td>
			<td class="cells">SS<?= $linha[$f]["especial"] ?></td> 
			<td class="cells"><?= $linha[$f]["motivo"] ?></td>
            <?= ($_GET['tipo']=='P') ? '<td class="cells">'.$linha[$f]["tempo"].'</td>' : '' ?>
		 </tr>
<?
 
} 
?>
		  
    </table>    
      <p><span class="style2"><br />
      <br />
    </span></p></td>
  </tr>
        <tr bgcolor="#CC9900">
    <td height="3" colspan="2"></td>
  </tr>
</table>
</p>
</body>
</html>
