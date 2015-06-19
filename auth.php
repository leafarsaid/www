<?
//
session_start();
set_time_limit(0);

//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
require_once "util/objDB.php";
require_once "util/gerador_linhas.php";

if ($_GET['sair'] && !$_POST['login']) {
	session_destroy();
	$_SESSION['logado'] = null;
}
if ($_POST['login']) {
	$sql = "select * from t40_painel where c40_usuario='".$_POST['login']."' and c40_senha='".$_POST['senha']."'";
	//$auth = criaArray($auth);
	$obj_res=$obj_controle->executa($sql);
	$auth = $obj_res->getLinha("assoc");
	
	//var_dump($auth);
	
    $_SESSION['nivel'] = $auth['c40_nivel'];
	$_SESSION['usuario'] = $auth['c40_usuario'];
	$_SESSION['usuario_sigla'] = $auth['c40_sigla'];
	
	//var_dump($obj_res);
}
if (count($auth))
{
	$_SESSION['logado'] = $_SESSION['nivel'];
	exit("<script>document.location=\"".$_REQUEST['uri']."\"</script>");
}
else {
	$_SESSION['logado'] = null;
	if ($_POST['login']) echo "<h1 align='center' style='color:white;'>Login ou Senha inválidos.</h1>";
	//echo $sql;
}


    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link href="css/chronosat.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			<!--
			.style1 {color: #FFFFFF}
			-->
		</style>
	</head>
	<body bgcolor="black">
		<center>
			<form method="post">
				<br /><br /><br /><br />
				<img src="./imagens/logo-site_b.png" /><br />
				<br /><br /><br /><br />
				<span class="style1"><strong>Sistema de Apura&ccedil;&atilde;o</strong><br />
				<br />Login<br />
				<input type="text" name="login" /><br />
				<br />Senha</span><br />
				<input type="password" name="senha" /><br /><br />
				
				<input type="hidden" name="uri" value="<?= $_REQUEST['uri'] ?>" />
				<input type="submit" />
			</form>
		</center>
	</body>
</html>