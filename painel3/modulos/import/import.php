<html><head></head><body>
<?php
// bibliotecas
require_once "../../../util/database/include/config_bd.inc.php";
require_once "../../../util/database/class/ControleBDFactory.class.php";

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

	// lendo linha por linha do arquivo
	while ($linha = @fgets($arquivo, 256)) {	
			$arr_linha = explode(";",$linha);		
			//
			$trecho = $_REQUEST['trecho'];
			$competidor = 1*($arr_linha[0]);
			$arr_tempo = explode(":",$arr_linha[1]);
			$tempo = $arr_tempo[0] * 3600;
			$tempo += $arr_tempo[1] * 60;
			$tempo += $arr_tempo[2];	
			$obs = $arr_linha[2];			

			print_r("trecho: ".$trecho."<br>");
			print_r("competidor: ".$competidor."<br>");
			print_r("tempo: ".$tempo."<br>");
			print_r("motivo: ".$obs."<br>");					

			$sql = array();

			$sql[] = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla, c01_obs) VALUES ($tempo, '".$_REQUEST['tipo']."', getTempoStatus($competidor, $trecho, '".$_REQUEST['tipo']."'), getCodigoVeiculo($competidor), $trecho, 'FI', '$obs')";	

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
  <p><!-input type="hidden" name="MAX_FILE_SIZE" value="30000" /--> Insira um arquivo no formato CSV com o seguinte formato:<br>
  Numeral ; Tempo ; Observa&ccedil;&atilde;o</p>
  <p>Arquivo a ser enviado: <br />
    <input name="userfile" type="file" /><br />
    <br />
    Tipo de dados: <br />
    <select name="tipo">
      <option value="L">Largadas</option>
      <option value="C">Chegadas</option>
      <option value="CH">Controles</option>
      <option value="P">Penaliza&ccedil;&otilde;es</option>
      <option value="I1">Parcial 1</option>
      <option value="I2">Parcial 2</option>
      <option value="A">Bônus</option>
      <option value="LT">Largadas Totem</option>
      <option value="CT">Chegadas Totem</option>
      <option value="PT">Penaliza&ccedil;&otilde;es Totem</option>
    </select>
  </p>
  <p> Especial: <br />
<select name="trecho">
  <option value="0">Prólogo</option>
  <option value="1">SS1</option>
  <option value="2">SS2</option>
  <option value="3">SS3</option>
  <option value="4">SS4</option>
  <option value="5">SS5</option>
  <option value="6">SS6</option>
  <option value="7">SS7</option>
  <option value="8">SS8</option>
  <option value="9">SS9</option>
  <option value="10">SS10</option>
</select>
<br />
    <br />
    <input type="submit" value="Enviar" />
  </p>
</form>
</body></html>

