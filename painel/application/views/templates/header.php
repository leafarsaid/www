<html lang="en">
<head>	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
<title>Painel de Cadastro - Chronosat</title>	

	<link href="<?php echo base_url(); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/dashboard.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/css/jquery.bootstrap-touchspin.css" rel="stylesheet">
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

function botao($modulo, $db_url, $modulo_atual, $label) {
	
	$loc = base_url().$db_url."/".strtolower($modulo);
	
	if ($modulo == $modulo_atual){
		$retorno = sprintf("<li class=\"active\"><a href=\"%s\">%s<span class=\"sr-only\">(current)</span></a></li>",$loc,$label);
	} else{
		$retorno = sprintf("<li><a href=\"%s\">%s</a></li>",$loc,$label);	
	}
	return $retorno;

}

?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
<? 
	$modulo = $this->uri->segment(2);
	$db_url = $this->uri->segment(1);

	echo botao("prova", $db_url, $modulo, "Prova");
	echo botao("categorias", $db_url, $modulo, "Categorias");
	echo botao("modalidades", $db_url, $modulo, "Modalidades");
	echo botao("trechos", $db_url, $modulo, "Trechos");
	echo botao("tripulantes", $db_url, $modulo, "Tripulantes");
	echo botao("veiculos", $db_url, $modulo, "Ve&iacute;culos");
	echo botao("penalidades", $db_url, $modulo, "Penalidades");		
	echo botao("usuarios", $db_url, $modulo, "Usu&aacute;rios");	
	echo botao("senha", $db_url, $modulo, "Alterar Minha Senha");	
	echo botao("limpar_tempos", $db_url, $modulo, "Limpar Tempos");	
    echo botao("ocorrencias", $db_url, $modulo, "Ocorr&ecirc;ncias");		
	echo botao("importar_tempos", $db_url, $modulo, "Importar Tempos de CSV");
    echo botao("importar", $db_url, $modulo, "Importar Competidores");		
?>

	</ul>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">