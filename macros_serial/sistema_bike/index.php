<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?

$trecho = $_GET["trecho"];

if (!$trecho) $trecho = 1;



function sel($text, $event, $nom) {



global $trecho;

$sel = "<form name=\"sel".$nom."\" method=\"get\"> ";

$sel .= " <select name=\"trecho\" id=\"trecho\" onchange=\"form.submit();\"> ";

//$sel .= " <select name=\"trecho\" id=\"trecho\" onchange=\"document.sel".$nom.".submit();\"> ";



//$sel = $text." <select name=\"trecho\" id=\"trecho\" onchange=\"document.location('".$event."+this.value');\"> ";



for ($i=1;$i<=3;$i++) {

     if ($i==$trecho) $txt = " selected";

     else $txt = "";

	

	  	if ($i==1)  $sel .= "<option value=\"".$i."\" ".$txt.">SS".$i."</option>";

		if ($i==3)	$sel .= "<option value=\"3\" ".$txt.">SS2</option>";

}

$sel .= "</select> ".$text;

//$sel .= "<input type='hidden' name='campeonato' value='".$value."'> ";

$sel .= "</form> ";



return $sel;

}







?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

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

.style4 {

        color: #CC9900;

        font-family: Arial, Helvetica, sans-serif;

        font-weight: bold;

        font-size: 18px;

}

.style6 {color: #CC9900; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }

-->

</style>

</head>



<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0" bgcolor="#000000">

<p align="right"><br />

</p>

<p align="right">&nbsp;</p>

<p align="right">&nbsp;</p>

<p align="center"><img width="250" src="imagens/slider_king_2015_capa.jpg" /><br>

</p>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="327" valign="bottom" class="style2"> </td>

    <td align="right" valign="bottom" class="style2">Resultados Extra-Oficiais</td>
	
	
	
	

	
  </tr>

  <tr bgcolor="#CC9900">

    <td height="3" colspan="2"></td>

  </tr>


 
<tr><td colspan="2"><br />
       
	<!--span class="style6"><a href="resultado_regularidade.pdf">Copa Peugeot - Regularidade - Resultados</a></span><br /><br />
    <span class="style6"><a href="classificacao_blumenau.pdf">Copa Peugeot - Velocidade - Ranking do Campeonato até esta etapa</a></span><br /><br /><br /-->

	
	
</tr>
      
        <td width="315" valign="top">

		<br>

        <p><span class="style4"><a href="relatorio1.php?trecho=1">Resultado Geral Bateria 1 - On-line</a></span></p>
		<p><span class="style4"><a href="relatorio2.php?trecho=2">Resultado Geral Bateria 2 - On-line</a></span></p>
		<p><span class="style4"><a href="relatorio3.php?trecho=3">Resultado Geral Bateria 3 - On-line</a></span></p>

        <p>

		<span class="style4"><a href="">Resultados por Categoria</a></span><br />
			<span class="style6"><a href="geral.php">Geral</a></span><br />
			<span class="style6"><a href="geral.php?categoria=1">Masculino</a></span><br />
    <span class="style6"><a href="geral.php?categoria=2">Feminino</a></span><br />
	<span class="style6"><a href="geral.php?categoria=3">Juvenil</a></span></td>
	
        
        <td width="32" valign="top">

<br>

		
		<!--tr>
		<td colspan=2>
		<span class="style6"><a href="ordem1.pdf">Ordem de Largada</a></span><br />
		</td>
		</tr-->
  

  

  

  

         <tr>

        <td align="left" valign="top">

          	<br />

  </tr>



<tr>

        <td colspan="2" align="left" valign="top">

          	<p style="margin-top: 0;">

  <!--span class="style6"><a href="geral.php"><br />

          	Resultados da etapa</a></span-->

  <br />

  <!--span class="style6"><a href="grafico.html">Gráfico</a></span><br>

<span class="style6"><a href="ss_geral.php?trecho=9">Super Prime</a></span-->

  <br />

  <!--span class="style6"><a href="">207 Super - Sábado e Domingo</a></span>

  <br />

  <span class="style6"><a href="">206 Master - Sábado e Domingo</a></span-->

  <br /></td>

  </tr>

<tr>

  <td valign="top">&nbsp;</td>

  <td width="323" valign="top">&nbsp;</td>

</tr>

  <tr bgcolor="#CC9900">

    <td height="3" colspan="2"></td>

  </tr>

</table>

</p>

</body>

</html>

