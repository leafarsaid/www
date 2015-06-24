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

function botao($modulo, $modulo_atual, $label) {
	$loc = base_url().strtolower($modulo);
	
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

	echo botao("prova", $modulo, "Prova");
	echo botao("categoria", $modulo, "Categorias");
	echo botao("modalidade", $modulo, "Modalidades");
	echo botao("trecho", $modulo, "Trechos");
	echo botao("tripulante", $modulo, "Editar Tripulantes");
	echo botao("veiculo", $modulo, "Editar Ve&iacute;culos");
	echo botao("penalidade", $modulo, "Editar Penalidades");		
	echo botao("tempos", $modulo, "Inserir Tempos de CSV");	
	echo botao("limpar_tempos", $modulo, "Limpar tempos");	
	echo botao("senha", $modulo, "Alterar Senha");
    echo botao("ocorrencias", $modulo, "Ocorrencias");		
    echo botao("importar", $modulo, "Importar competidores");		
?>

	</ul>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">