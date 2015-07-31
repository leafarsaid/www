<?

//
session_start();

set_time_limit(0);

//
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

//
require_once"util/gerador_linhas.php";
require_once"util/database/include/config_bd.inc.php";
require_once"util/database/class/ControleBDFactory.class.php";
$obj_ctrl=ControleBDFactory::getControlador(DB_DRIVER);

if ($_GET['sair'] && !$_POST['login']) {
	session_destroy();
	$_SESSION['logado']=null;
}
if ($_POST['login']) {
	$sql = "select * from t40_painel where c40_usuario='".$_POST['login']."' and c40_senha='".$_POST['senha']."'";
	$auth = criaArray($sql);
    //echo "teste: ".$sql;
	//var_dump($auth);
	$_SESSION['nivel']=$auth[0]['c40_nivel'];
	$_SESSION['usuario']=$auth[0]['c40_usuario'];
	$_SESSION['usuario_sigla']=$auth[0]['c40_sigla'];
}
if (count($auth))
{
	$_SESSION['logado']=$_SESSION['nivel'];
	if(strpos($_REQUEST['uri'], 'auth.php') === false && !empty($_REQUEST['uri'])) {
		exit("<script>document.location=\"".$_REQUEST['uri']."\"</script>");
	} else {
		exit("<script>document.location=\"./painel/\"</script>");
	}
}
else {
	$_SESSION['logado']=null;
	if ($_POST['login']) echo "<h1 align='center' style='color:white;'>Login ou senha inválidos.</h1>";
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
<br />
<br />
<br />
<br />
<img src="logo-site_b.png" /><br />
<br />
<br />
<br />
<br />
<span class="style1"><strong>Sistema de Apura&ccedil;&atilde;o do Rally de Velocidade</strong><br />
<br />
Login<br />
<input type="text" name="login" />
<br />
<br />
Senha</span><br />
<input type="password" name="senha" /><br /><br />
<input type="hidden" name="uri" value="<?= $_REQUEST['uri'] ?>" />
<input type="submit" />
</form>
</center>

</body>
</html>