<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
//
require_once"../util/database/include/config_bd.inc.php";
require_once"../util/database/class/ControleBDFactory.class.php";
$obj_controle=ControleBDFactory::getControlador(DB_DRIVER);


//
if (isset($_POST["cmd"]))
{
	$modelo = 1;
	$modelo2 = $_POST["modelo"];
	$categoria = $_POST["categoria"];
	$modalidade = $_POST["modalidade"];
	$status = $_POST["status"];
	$ordem = $_POST["ordem"];
	$id = $_POST["id"];
	$piloto = $_POST["piloto"];
	$uf = $_POST["uf"];
	$patrocinio = $_POST["patrocinio"];
	switch (strtoupper($_POST["cmd"])) 
	{
		case "ATUALIZAR":
			$horalarg = $ordem[$id];
			$parte_decimal = end(explode('.', $horalarg));

			$alert = "alert('ERRO:\\n\\nFalha ao atualizar campo')";
			$sql[] = "UPDATE t03_veiculo SET c21_codigo = 1, c13_codigo = ".$categoria[$id].", c10_codigo = ".$modalidade[$id].", c03_status = '".$status[$id]."', c03_ordem = CONCAT(TIME_TO_SEC('$horalarg'), '.', $parte_decimal) WHERE c03_codigo = ".$id;
			$sql[] = "UPDATE t04_tripulante SET c04_nome = '".$piloto[$id]."', c04_origem = '".$uf[$id]."', c04_equipe = '".$equipe[$id]."', c04_patrocinio = '".$patrocinio[$id]."', c04_montadora = '".$montadora[$id]."', c04_modelo = '".$modelo2[$id]."' WHERE c03_codigo = ".$id;
			break;    
	}
	//print_r($sql);
	//
	if ($obj_controle->executa($sql)) {
	  $alert = "Comando executado com sucesso";
	}
echo "<script>alert('".$alert."');</script>";
}
?>

		