<html lang="en">
<head>	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
<title>Painel de Cadastro - Chronosat</title>	

	<link href="<?php echo base_url(); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/dashboard.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/lightbox.min.css" rel="stylesheet">
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
          <a class="navbar-brand" href="#"><img style="max-width:100px; margin-top: -9px;" src="<?php echo base_url(); ?>img/logo-site.png" /></a>          
        </div>        
        <div id="navbar" class="navbar-collapse collapse"> 
          <p class="navbar-text">Painel de Cadastro</p>   
          <ul class="nav navbar-nav navbar-right">
            <li><a><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usu&aacute;rio:)</a></li>
            <li><a><span class="glyphicon glyphicon-profile" aria-hidden="true"></span> Perfil:</a></li>
            <li><a href="../auth.php?sair=1&uri=<?php echo $_SERVER['REQUEST_URI']; ?>">Sair <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>
          </ul>
        </div>
      </div>
    </nav>	
       
<div class="container-fluid">
      <div class="row">          
<?
$db = 1;
$bt = 1;

function botao($id, $currentId, $label) {
	global $bt;	
	global $db;	
	
	if ($id == $currentId) 	$retorno = sprintf("<li class=\"active\"><a href=\"?db=%s&bt=%s\">%s<span class=\"sr-only\">(current)</span></a></li>", $db, $id, $label);
	else 					$retorno = sprintf("<li><a href=\"?db=%s&bt=%s\">%s</a></li>", $db, $id, $label);	
	
	return $retorno;

}

?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
<? 
	echo botao("15", $bt, "Prova");
	echo botao("3", $bt, "Categorias");
	echo botao("4", $bt, "Modalidades");
	echo botao("5", $bt, "Trechos");
	echo botao("7", $bt, "Editar Tripulantes");
	echo botao("8", $bt, "Editar Ve&iacute;culos");
	echo botao("9", $bt, "Editar Penalidades");		
	echo botao("12", $bt, "Inserir Tempos de CSV");	
	echo botao("10", $bt, "Limpar tempos");	
	echo botao("11", $bt, "Alterar Senha");	    
    echo botao("13", $bt, "Ocorrencias");		
    echo botao("14", $bt, "Importar competidores");		
?>

	</ul>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">