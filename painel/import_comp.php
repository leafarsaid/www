<html><head></head><body>
<?php
// bibliotecas
require_once "../util/database/include/config_bd.inc.php";
require_once "../util/database/class/ControleBDFactory.class.php";

// criando objetos
$obj_controle = ControleBDFactory::getControlador(DB_DRIVER);

// caminho dos arquivos
//$caminho = 'penal_ss1.csv';
//$caminho = $_REQUEST['arquivo'];
$caminho = $_FILES['userfile']['tmp_name'];

//$caminho_log_velho = 'log_' . @strtolower($caminho);
$caminho_log_velho = 'log_' . @strtolower($_FILES['userfile']['name']);


if (@is_file($caminho)) {
	// abrindo arquivos
	$arquivo = @fopen($caminho, 'r');
	
	$sql0[] = "DELETE FROM t03_veiculo";
	$sql0[] = "DELETE FROM t04_tripulante";
	$exec0 = $obj_controle->executa($sql0);

	// lendo linha por linha do arquivo
	while ($linha = @fgets($arquivo, 256)) {
			$arr_linha = explode(";",$linha);		
			//
			$numeral = 1*($arr_linha[0]);
			$nome = ($arr_linha[1]);
			$categoria = 1*($arr_linha[2]);
			$modalidade = 1*($arr_linha[3]);
			$origem = ($arr_linha[4]);
			$modelo = ($arr_linha[5]);
			$equipe = ($arr_linha[6]);

			/*print_r("numeral: ".$numeral."<br>");
			print_r("nome: ".$nome."<br>");
			print_r("categoria: ".$categoria."<br>");
			print_r("modalidade: ".$modalidade."<br>");	
			print_r("origem: ".$origem."<br>");	
			print_r("modelo: ".$modelo."<br>");	*/				

			$sql = array();
			
			$sql[] = "INSERT INTO t04_tripulante 
						(c04_codigo,c04_nome,c04_origem,c04_modelo,c04_equipe) 
					  VALUES
					    ($numeral,'$nome','$origem','$modelo','$equipe');";
			$sql[] = "INSERT INTO t03_veiculo 
						(c03_codigo,c03_numero,c03_piloto,c13_codigo,c10_codigo) 
					  VALUES
					    ($numeral,$numeral,$numeral,$categoria,$modalidade);";

			// insere o registro no banco
			$exec = $obj_controle->executa($sql);
			var_dump($exec);			
	}

	// fechando os arquivos
	@fclose($arquivo);	

	// gerando cópia do arquivo
	$arquivo_log_velho = @fopen($caminho_log_velho, 'a+');
	@fwrite($arquivo_log_velho, @file_get_contents($caminho) . "\r\n");
	//print_r(@file_get_contents($caminho));
	@fclose($arquivo_log_velho);

	// excluindo 
	@unlink($caminho);
}
?>

<form enctype="multipart/form-data" action="" method="post">
  <p><!-input type="hidden" name="MAX_FILE_SIZE" value="30000" /--> Insira um arquivo no formato CSV com o seguinte formato:<br>
  Numeral ; Competidor ; Id Categoria ; Id Modalidade ; UF Origem ; Modelo ; Equipe</p>
  <p>Arquivo a ser enviado: <br />
    <input name="userfile" type="file" /><br />
    <br />
  </p>
<br />
    <br />
    <input type="submit" value="Enviar" />
  </p>
</form>
</body></html>

