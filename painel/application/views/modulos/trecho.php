<div style="padding-right: 150px">
	<h1>Trechos</h1>
		
	<?php echo form_open("$db/trechos/$id/$modalidade") ?>

	<div style="float: right; margin-top: -45px;">
		<button type="button" class="btn btn-primary" onclick="">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
			Adicionar Trecho
		</button>
	</div>
	
	<?php echo validation_errors(); ?>
	
	<ul class="nav nav-tabs">
	<?php
		foreach ($vetor_trechos AS $item_trecho){
			$active = ($item_trecho["c02_codigo"]==$id) ? " class=\"active\"" : "";
			$location = base_url().$db."/trechos/".$item_trecho["c02_codigo"]."/".$modalidade;
			$texto_mod = $item_trecho["c02_nome"];
	
			printf("<li role=\"presentation\"%s><a href=\"%s\">%s</a></li>", $active, $location, $texto_mod);
		}
	?>
	</ul>
	<div class="panel panel-default col-sm-12" style="padding-top: 30px;">
	
		<div class="form-group">
		
		
			<div class="col-lg-4 campos"> 	
				<label for="nome">Nome</label>
				<input type="text" class="form-control" id="nome" name="nome" value="<?php echo $vetor_trecho["c02_nome"] ?>" />
			</div>		
			

			
			<?php 
				$origData = $vetor_trecho["c02_data"];
				$valData = $origData[8].$origData[9]."/".$origData[5].$origData[6]."/".$origData[0].$origData[1].$origData[2].$origData[3];
			?>		
			<div id="data1" class="col-sm-2 campos">
				<label for="data">Data</label>
				<input data-format="dd/MM/yyyy" type="text" class="form-control" id="data" name="data" value="<?php echo $valData; ?>" />
				<span class="add-on">
      				<i data-time-icon="icon-time" data-date-icon="icon-calendar">
      				</i>
    			</span>
			</div>
					
			<div class="col-lg-3 campos">
				<label for="origem">Origem</label>
				<input type="text" class="form-control" id="origem" name="origem" value="<?php echo $vetor_trecho["c02_origem"] ?>" />
			</div>
		
			<div class="col-lg-3 campos"> 
				<label for="destino">Destino</label>
				<input type="text" class="form-control" id="destino" name="destino" value="<?php echo $vetor_trecho["c02_destino"] ?>" />
			</div>
		
			<div class="col-lg-2 campos"> 
				<label for="distancia">Dist&acirc;ncia (m)</label>
				<input type="text" class="form-control" id="distancia" name="distancia" value="<?php echo $vetor_trecho["c02_distancia"] ?>" />
			</div>
					
			<div class="col-lg-3 campos">
			<label for="status">Status</label>
			<select id="status" name="status" class="form-control">
				<option value="NI" <?php echo ($vetor_trecho["c02_status"] == "NI") ? "selected" : "" ?>>N&atilde;o iniciado</option>
				<option value="I" <?php echo ($vetor_trecho["c02_status"] == "I") ? "selected" : "" ?>>Iniciado</option>
				<option value="F" <?php echo ($vetor_trecho["c02_status"] == "F") ? "selected" : "" ?>>Finalizado</option>
			</select>
			</div>					
		
			<div class="col-lg-3 campos"> 
				<label for="tempoch">Tempo Controle</label>
				<input type="text" class="form-control" id="tempoch" name="tempoch" size="30" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_tempo_ch"]).'.'.substr($vetor_trecho["c02_tempo_ch"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
		
			<div class="col-lg-3 campos"> 
				<label for="adianto">Pena Minuto Adianto</label>
				<input type="text" class="form-control" id="adianto" name="adianto" size="30" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_pena_adianto"]).'.'.substr($vetor_trecho["c02_pena_adianto"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
		
			<div class="col-lg-3 campos"> 
				<label for="atraso">Pena Minuto Atraso</label>
				<input type="text" class="form-control" id="atraso" name="atraso" size="30" value="<?php echo gmdate("H:i:s", $vetor_trecho["c02_pena_atraso"]).'.'.substr($vetor_trecho["c02_pena_atraso"],-2) ?>" onKeypress="formatar(this, '##:##:##.##');" />
			</div>
						
			<div class="col-lg-6 campos">
				<div style="display:block; width: 100%;">
					<label for="tipo_local_largada">Local de Processo da Largada</label>
				</div>
				<div style="display:inline-block; width: 30%;">					
					<select id="tipo_local_largada" name="tipo_local_largada" class="form-control">				
						<?php
							foreach ($vetor_tipos_tempo AS $tipo_tempo){ 
								$valor = $tipo_tempo['tipo'];
								$selected = ($tipo_tempo['tipo'] == $vetor_trecho['c02_tipo_largada']) ? " selected" : "";
								$descricao = $tipo_tempo['descricao'];
								echo sprintf('<option value="%s"%s>%s</option>\r\n',$valor,$selected,$descricao);
							}
						?>
					</select>
				</div>
				<div style="display:inline-block; width: 5%;">em</div>
				<div style="display:inline-block; width: 60%;">
					<select id="local_largada" name="local_largada" class="form-control">
						<?php
							foreach ($vetor_trechos AS $trecho){ 
								$valor = $trecho['c02_codigo'];
								$selected = ($trecho['c02_codigo'] == $vetor_trecho['c02_trecho_largada']) ? " selected" : "";
								$descricao = $trecho['c02_nome'];
								echo sprintf('<option value="%s"%s>%s</option>\r\n',$valor,$selected,$descricao);
							}
						?>
					</select>
				</div>
			</div>
			
			
			<div class="col-lg-6 campos">
				<div style="display:block; width: 100%;">
					<label for="tipo_local_chegada">Local de Processo da Chegada</label>
				</div>
				<div style="display:inline-block; width: 30%;">					
					<select id="tipo_local_chegada" name="tipo_local_chegada" class="form-control">				
						<?php
							foreach ($vetor_tipos_tempo AS $tipo_tempo){ 
								$valor = $tipo_tempo['tipo'];
								$selected = ($tipo_tempo['tipo'] == $vetor_trecho['c02_tipo_chegada']) ? " selected" : "";
								$descricao = $tipo_tempo['descricao'];
								echo sprintf('<option value="%s"%s>%s</option>\r\n',$valor,$selected,$descricao);
							}
						?>
					</select>
				</div>
				<div style="display:inline-block; width: 5%;">em</div>
				<div style="display:inline-block; width: 60%;">
					<select id="local_chegada" name="local_chegada" class="form-control">
						<?php
							foreach ($vetor_trechos AS $trecho){ 
								$valor = $trecho['c02_codigo'];
								$selected = ($trecho['c02_codigo'] == $vetor_trecho['c02_trecho_chegada']) ? " selected" : "";
								$descricao = $trecho['c02_nome'];
								echo sprintf('<option value="%s"%s>%s</option>\r\n',$valor,$selected,$descricao);
							}
						?>
					</select>
				</div>
			</div>
			
			
					
			<div class="col-lg-3 campos">
			<label for="aparece_no_relatorio">Aparece no Relat&oacute;rio</label>
			<select id="aparece_no_relatorio" name="aparece_no_relatorio" class="form-control">
				<option value="0" <?php echo ($vetor_trecho["c02_aparece_no_relatorio"] == "1") ? "selected" : "" ?>>Sim</option>
				<option value="1" <?php echo ($vetor_trecho["c02_aparece_no_relatorio"] == "0") ? "selected" : "" ?>>N&atilde;o</option>
			</select>
			</div>
			
			
			<input type="hidden" name="c02_codigo" value="<?php echo $vetor_trecho["c02_codigo"] ?>">
			<input type="hidden" name="c02_setor" value="<?php echo $vetor_trecho["c02_setor"] ?>">
			
			
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
	    <button type="submit" class="btn btn-success">
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