<?
session_start();

set_time_limit(0);
header("Content-type: text/html; charset=ISO-8859-1",true);
header("Cache-Control: no-cache, must-revalidate",true);
header("Pragma: no-cache",true);

require_once "util/database/include/config_bd.inc.php";
require_once "util/database/class/ControleBDFactory.class.php";

if (isset($_POST["sqlquery"]))
{
	echo $_POST["sqlquery"]."<br> ----------------------------------------------------------------------------------------------- <br>";
	$sql_result = ControleBDFactory::getControlador(DB_DRIVER)->executa($_POST["sqlquery"], true);
	while($vet_linha = $sql_result->getLinha()) {
		foreach ($vet_linha as $v) echo $v." --- ";
		echo "<br>";
	}
	echo " ----------------------------------------------------------------------------------------------- <br>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
		<title>SQL Executor - Chronosat</title>	
	</head>
	<body>
		<form name="comando" action="./query.php" method="post">
			<table cellpadding="5" cellspacing="5">
				<tr class="linhas">
					<p>SQL Query:</p>
					<td><input type="text" name="sqlquery" size="100" value=""/></td>
					<td><input type="submit" value="RUN"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>