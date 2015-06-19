<html>
	<head/>
	<body>
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

		// abrindo arquivos
		if (@is_file($caminho)) {
			$arquivo = @fopen($caminho, 'r');	
			
			// lendo linha por linha do arquivo
			while ($linha = @fgets($arquivo, 256)) {	
				$arr_linha = explode(";",$linha);		
				//
				$trecho = $arr_linha[0];
				$competidor = $arr_linha[1];
				$arr_tempo = explode(":",$arr_linha[2]);
				$tempo = $arr_tempo[0] * 3600;
				$tempo += $arr_tempo[1] * 60;
				$tempo += $arr_tempo[2];				

				print_r("trecho: ".$trecho."<br>");
				print_r("competidor: ".$competidor."<br>");
				print_r("tempo: ".$tempo."<br>");					

				$sql = array();

				$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla) VALUES ($tempo, '".$_REQUEST['tipo']."', getTempoStatus($competidor, $trecho, '".$_REQUEST['tipo']."'), getCodigoVeiculo($competidor), $trecho, 'FI')";	

				// insere o registro no banco
				$obj_controle->executa($sql);
			}

			// fechando os arquivos
			@fclose($arquivo);	

			// gerando cópia do arquivo
			$arquivo_log_velho = @fopen($caminho_log_velho, 'a+');
			@fwrite($arquivo_log_velho, @file_get_contents($caminho) . "\r\n");
			print_r(@file_get_contents($caminho));
			@fclose($arquivo_log_velho);

			// excluindo 
			@unlink($caminho);
		}
	?>

	<form enctype="multipart/form-data" action="" method="post">
		<!- input type="hidden" name="MAX_FILE_SIZE" value="30000" /-->
		Arquivo a ser enviado: <br />
		<input name="userfile" type="file" /><br /><br />
		Tipo de dados: <br />
		<select name="tipo">
			<option value="L">Largadas</option>
			<option value="C">Chegadas</option>
			<option value="P">Penalizações</option>
			<option value="LT">Largadas Totem</option>
			<option value="CT">Chegadas Totem</option>
			<option value="PT">Penalizações Totem</option>
		</select>
		<br /><br />
		<input type="submit" value="Enviar" />
	</form>
	</body>
</html>

