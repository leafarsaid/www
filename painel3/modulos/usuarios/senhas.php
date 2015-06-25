<?

//
if (isset($_POST["cmd"])){
	$temp = "select * from t40_painel where c40_usuario='".$_SESSION['usuario']."' and c40_senha='".$_POST['antiga']."'";	
	$auth = $obj_controle->executa($temp,true)->getAll();				
	if (count($auth)) {		
		if ($_POST['nova']==$_POST['nova2']) {
			$sql = "UPDATE t40_painel SET c40_senha = '".$_POST['nova']."' WHERE c40_usuario = '".$_SESSION['usuario']."'";
			if ($obj_controle->executa($sql)) {
				echo "<script>alert('Senha alterada com sucesso!');</script>";
			} 
		}
		else echo "<script>alert('Senha nova nao está igual a repetição');</script>";	
	} else {		
		echo "<script>alert('Senha antiga não está certa');</script>";	
	}
}
?>

<form name="comando" method="post">
Nova Senha:<br /><input type="password" name="nova" value="<?= (isset($_POST['nova']) ? $_POST['nova'] : "" ) ?>"><br /><br />
Repetir Nova Senha:<br /><input type="password" name="nova2" value="<?= (isset($_POST['nova2']) ? $_POST['nova2'] : "" ) ?>"><br /><br />
Senha Atual:<br /><input type="password" name="antiga" value="<?= (isset($_POST['antiga']) ? $_POST['antiga'] : "" ) ?>"><br /><br />
<input type="hidden" name="id" />
<input type="hidden" name="cmd" />
<input type="hidden" name="bt" value="<?= $bt ?>" /><input type="submit">
</form>
