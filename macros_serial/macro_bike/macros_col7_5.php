<pre>
<?php
set_time_limit(0);
ob_implicit_flush(true);
ob_end_flush();

/////
// bibliotecas
require_once "../sistema_bike/util/database/include/config_bd.inc.php";
require_once "../sistema_bike/util/database/class/ControleBDFactory.class.php";

	echo "INICIANDO...\n";
	ob_flush();
	flush();


// criando objetos
$obj_controle = ControleBDFactory::getControlador(DB_DRIVER);

`mode com5: baud=9600 parity=n data=8 stop=1 to=on xon=off`;

if ($f = fopen('COM5:', 'r')) {
 // lendo linha por linha do arquivo
 $linha = "";
 while (true) {
    $output = fread($f, 1);
	$linha .= $output;
	if($output == "\n") {
 
	echo "entrou - ".$linha;
	ob_flush();
	flush();
  //$linha = str_replace("--","-00-",$linha);
  $sql = null;
  //print_r($linha);
  
  /* ----------------------------------------------------------------------------------------------- */
  //if (@ereg('\$READ\$', $linha)) {
   // posição inicial de leitura dos dados na linha
   
   // lendo os dados da linha
   //$dados = explode(";",$linha);
   
   $dados_anteriores = $dados;
   if (strlen($dados_anteriores)>0) print_r("$dados_anteriores</br>");
   $dados = $linha;
         
   $competidor = @substr($linha, 12, 3); 
   $largada = (@substr($linha, 11, 1) == 1)?'L':'C';
   
   if (strlen($dados)<16)
   {
	$dados = $dados_anteriores.$dados;
   }
   else {
	$hh = @substr($dados, 0, 2);
	$mm = @substr($dados, 3, 2);
	$ss = @substr($dados, 6, 2);
	$dc = @substr($dados, 9, 2);
	$sp1 = @substr($dados, 2, 1);
	$sp2 = @substr($dados, 5, 1);
	
	$tempo = $hh*3600+$mm*60+$ss+$dc/10;
	$trecho=1;
	$mct='1111';
	
	$sql = "INSERT INTO t01_tempos (c01_valor, c01_tipo, c01_status, c03_codigo, c02_codigo, c01_sigla, c01_conta, c01_mct) VALUES ($tempo, '$largada', getTempoStatus($competidor, $trecho, '$largada'), getCodigoVeiculo($competidor), $trecho, 'AD', $mct, $mct)";
   	
  // inserindo no banco de dados
  if (! @empty($sql)) $obj_controle->executa($sql);
  
	   $err = mysql_error();
	   var_dump($err);
	$dados = "";
   }
   
   
   //if ($chars>13) print_r("$hh:$mm:$ss,$dc $competidor<br />");
   
   
   if ($sep1==":" && $sep2!=":" ) {
	$vlinha = ("$hh:$mm");
   }
   
   //("$hh:$mm:$ss,$dc $competidor");
   
   // instrução sql
   //$sql = array();
   
   // escrevendo no arquivo de log
   //@fwrite($arquivo.$log_novo, "$mct " . @substr($linha, $inicio, -1) . "\r\n");
  
  
  // inserindo no banco de dados
  //if (! @empty($sql)) $obj_controle->executa($sql);
 //}
 $linha = "";
 }
 }
 // fechando os arquivos
 @fclose($arquivo);
 //@fclose($arquivo.$log_novo);
 
 // gerando cópia do arquivo
 $log_velho = @fopen($log_velho, 'a+');
 @fwrite($log_velho, @file_get_contents($caminho.$arquivo_inbox) . "\r\n");
 @fclose($log_velho);
 
 // excluindo arquivo base
 @unlink($caminho.$arquivo_inbox);
} else {
    echo "Erro ao abrir COM5!";
}

?>
</pre>