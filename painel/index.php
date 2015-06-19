<?

session_start();

set_time_limit(0);

require_once "../util/objDB.php";
require_once "../util/gerador_linhas.php";

/* 
$sql = "update t02_trecho set c02_codigo = 1 where c02_codigo = 12";
$sql = "select * from t02_trecho";
$obj_res=$obj_controle->executa($sql);
$auth = $obj_res->getLinha("assoc");
exit(); 
*/

if ($_SESSION['logado']>4 || $_SESSION['logado']==null) exit("<script>document.location=\"../auth.php?db=".$_REQUEST['db']."&uri=".$_SERVER['REQUEST_URI']."\"</script>");

//
$bt=(int)$_REQUEST["bt"];

if ($_SESSION['nivel']==0){
	$perfil = "Administrador";	
} else{
	$perfil = "Colaborador";
}

//
?>
<html lang="en">
<head>	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
<title>Painel de Cadastro - Chronosat</title>	
<!-- style type="text/css">	
	.tabelas_resultados {
		font-size: 15px;
		font-family: Arial, Helvetica, sans-serif;
		color: #333333;
		background-color: #eeeeee;
		text-align: center;
		display: table-row-group;
		border: 5px solid #ffffff;
	}
	.linhas {
		border: 1px solid #000000;
		font-size: 15px;
		font-family: Arial, Helvetica, sans-serif;
		color: #333333;
		background-color: #eeeeee;
		text-align: center;
	}
	.botao {
	font-family:Arial, Helvetica, sans-serif;
	size: 20px;
	font-weight: bolder;
	cursor: pointer;
	}
	</style-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dashboard.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img style="max-width:100px; margin-top: -9px;" src="../imagens/logo-site.png" /></a>          
        </div>        
        <div id="navbar" class="navbar-collapse collapse"> 
          <p class="navbar-text">Painel de Cadastro</p>   
          <ul class="nav navbar-nav navbar-right">
            <li><a><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usu&aacute;rio: <?= $_SESSION['usuario'] ?> (<?= $_SESSION[usuario_sigla] ?>)</a></li>
            <li><a><span class="glyphicon glyphicon-profile" aria-hidden="true"></span> Perfil: <?= $perfil; ?></a></li>
            <li><a href="../auth.php?sair=1&uri=<?php echo $_SERVER['REQUEST_URI']; ?>">Sair <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>
          </ul>
        </div>
      </div>
    </nav>	
       

<div class="container-fluid">
      <div class="row">    
    
<? include "menu.php" ?>    
    		
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">	

				<?
				switch($bt){
					case 1: if ($_SESSION['logado']==0) include"montadora.php"; break;
					case 2: if ($_SESSION['logado']==0) include"modelo.php"; break;
					case 3: if ($_SESSION['logado']==0) include"categoria.php"; break;
					case 4: if ($_SESSION['logado']==0) include"modalidade.php"; break;
					case 5: if ($_SESSION['logado']==0) include"trecho.php"; break;
					case 6: if ($_SESSION['logado']==0) include"atribtrecho.php"; break;
					case 7: if ($_SESSION['logado']==0) include"tripulante.php"; break;
					case 8: if ($_SESSION['logado']==0) include"veiculo.php"; break;
					case 9: if ($_SESSION['logado']==0) include"penalidade.php"; break;						
					case 10: if ($_SESSION['logado']==0) include"limpa_tempos.php"; break;					
					case 11: include"senhas.php"; break;
					case 12: include"import.php"; break;
					case 13: include"ocorrencia.php"; break;
					case 14: include"import_comp.php"; break;
					case 15: include"prova.php"; break; 
				}
				?>
</div>
</div>
<iframe name="oculto" width="1" height="1" frameborder="0"></iframe>
</div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script language="javascript">
	function enviaComando(cmd,id) {
		//if (cmd != "atualizar") {
			document.comando.id.value=id;
			document.comando.cmd.value=cmd;
		//}
		document.comando.submit();
	}
	function enviaComandoFrame(cmd,id) {
		document.comando.id.value=id;
		document.comando.cmd.value=cmd;
		document.comando.submit();
	}
	function formatar(src, mask){
	  var i = src.value.length;
	  var saida = mask.substring(0,1);
	  var texto = mask.substring(i);
	if (texto.substring(0,1) != saida)
	  {
		src.value += texto.substring(0,1);
	  }
	}
	</script>
</body>

</html>