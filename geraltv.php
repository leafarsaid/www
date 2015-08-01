<?php 
	$geral = "geral.php";
	$db = $_REQUEST['db'];
	$categoria = $_REQUEST['categoria'];
	$trecho = $_REQUEST['trecho'];
	$mod = $_REQUEST['mod'];
	$tv = $_REQUEST['tv'];

?>
<frameset rows="150,*" border="0">
  <frame src="<?php echo $geral."?db=".$db."&categoria=".$categoria."&trecho=".$trecho."&mod=".$mod; ?>">
  <frame src="<?php echo $geral."?db=".$db."&categoria=".$categoria."&trecho=".$trecho."&mod=".$mod."&tv=".$tv; ?>">
</frameset>