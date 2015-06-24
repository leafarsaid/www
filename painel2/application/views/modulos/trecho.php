<div style="padding-right: 150px">
	<h1>Trechos</h1>
	<form name="comando" method="post">

	<div style="float: right; margin-top: -45px;">
		<button type="button" class="btn btn-primary" onclick="">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
			Adicionar Trecho
		</button>
	</div>
	
	<ul class="nav nav-tabs">
	<?php		
		foreach ($vetor_trechos AS $item_trecho){
			$active = ($item_trecho["c02_codigo"]==$id) ? " class=\"active\"" : "";
			$location = base_url()."modulos/trecho/".$item_trecho["c02_codigo"];
			$texto_mod = $item_trecho["c02_nome"];
	
			printf("<li role=\"presentation\"%s><a href=\"%s\">%s</a></li>", $active, $location, $texto_mod);
		}
	?>
	</ul>
	<div class="panel panel-default col-sm-12" style="padding-top: 30px;">
	
		<div class="form-group">
	
			<div class="col-lg-4 campos">
			<label for="status">Status</label>
			<select id="status" name="status" class="form-control">
				<option value="NI" <?php ($vetor_trecho["c02_status"] == "NI") ? "selected" : "" ?>>N&atilde;o iniciado</option>
				<option value="I" <?php ($vetor_trecho["c02_status"] == "I") ? "selected" : "" ?>>Iniciado</option>
				<option value="F" <?php ($vetor_trecho["c02_status"] == "F") ? "selected" : "" ?>>Finalizado</option>
			</select>
			</div>
			
			<div class="col-lg-4 campos"> 	
				<label for="nome">Nome</label>
				<input type="text" class="form-control" id="nome" name="nome" size="30" maxlength="20" value="<?php echo $vetor_trecho["c02_nome"] ?>" />
			</div>
			
			<?php 
				$origData = $vetor_trecho["c02_data"];
				$valData = $origData[8].$origData[9]."/".$origData[5].$origData[6]."/".$origData[0].$origData[1].$origData[2].$origData[3];
			?>		
			<div class="col-sm-4 campos">
				<label for="dat">Data</label>
				<input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="data" name="data" size="30" maxlength="20" value="<?php echo $valData; ?>" />
			</div>
		
			<div class="col-lg-4 campos">
				<label for="orig">Origem</label>
				<input type="text" class="form-control" id="origem" name="origem" size="30" maxlength="20" value="<?php echo $vetor_trecho["c02_origem"] ?>" />
			</div>
		
			<div class="col-lg-4 campos"> 
				<label for="dest">Destino</label>
				<input type="text" class="form-control" id="destino" name="destino" size="30" maxlength="20" value="<?php echo $vetor_trecho["c02_destino"] ?>" />
			</div>
		
			<div class="col-lg-4 campos"> 
				<label for="dist">Dist&acirc;ncia (m)</label>
				<input type="text" class="form-control" id="distancia" name="distancia" size="30" maxlength="20" value="<?php echo $vetor_trecho["c02_distancia"] ?>" />
			</div>
		
			<div class="col-lg-4 campos"> 
				<label for="tempoch">Tempo CH</label>
				<input type="text" class="form-control" id="tempoch" name="tempoch" size="30" maxlength="11" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_tempo_ch"]).'.'.substr($vetor_trecho["c02_tempo_ch"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
		
			<div class="col-lg-4 campos"> 
				<label for="adianto">Pena min. adianto</label>
				<input type="text" class="form-control" id="adianto" name="adianto" size="30" maxlength="11" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_pena_adianto"]).'.'.substr($vetor_trecho["c02_pena_adianto"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
		
			<div class="col-lg-4 campos"> 
				<label for="atraso">Pena min. atraso</label>
				<input type="text" class="form-control" id="atraso" name="atraso" size="30" maxlength="11" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_pena_atraso"]).'.'.substr($vetor_trecho["c02_pena_atraso"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
		</div>
	</div>
	
	<!-- div class="col-lg-12">
		<ul class="nav nav-tabs">
		<?php 
			/* $query3 = "SELECT * FROM t10_modalidade";
			$obj_res3 = $obj_controle->executa($query3, true);
			  
			while($vetor_trecho3 = $obj_res3->getLinha("assoc")){
				$active = ($vetor_trecho3["c10_codigo"]==$modalidade) ? " class=\"active\"" : "";
				$location = "?db=".$_REQUEST['db']."&bt=".$_REQUEST['bt']."&trecho=".$_REQUEST['trecho']."&modalidade=".$vetor_trecho3["c10_codigo"];
				$texto_mod = $vetor_trecho3["c10_nome"];
		
				printf("<li role=\"presentation\"%s><a href=\"%s\">%s</a></li>", $active, $location, $texto_mod);
			} */
		?>
		</ul>
		<div class="well">
		oioioioii
		</div>
	</div-->
   
	<div class="btn-group btn-group-justified" role="group" aria-label="...">
	  <div class="btn-group" role="group">
	    <button type="button" class="btn btn-success" onclick="enviaComando('atualizar', <?php $vetor_trecho["c02_codigo"] ?>)">
	    	<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
	    	Atualizar
	    </button>
	  </div>
	  <div class="btn-group" role="group">
	    <button type="button" class="btn btn-danger" onclick="if (confirm('Tem certeza que deseja remover o trecho?')) enviaComando('remover', <?php $vetor_trecho["c02_codigo"] ?>)">
	    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	    	Excluir
	    </button>
	  </div>
	  <div class="btn-group" role="group">
	    <button type="button" class="btn btn-warning" onclick="if (confirm('Tem certeza que deseja aplicar penalidades no trecho?')) enviaComando('penalch', <?php $vetor_trecho["c02_codigo"] ?>)">
	    	<span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
	    	Penal CH
	    </button>
	  </div>
	  <div class="btn-group" role="group">
	    <button type="button" class="btn btn-info" onclick="if (confirm('Tem certeza que deseja resetar penalidades no trecho?')) enviaComando('reset_penalch', <?php $vetor_trecho["c02_codigo"] ?>)">
	    	<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
	    	Reset CH
	    </button>
	  </div>	
	</div>

</div>