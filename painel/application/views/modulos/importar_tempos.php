<?php 
if (isset($error)){
	echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
}

if (isset($message_ok)){
	echo '<div class="alert alert-info" role="alert">'.$message_ok.'</div>';
}
?>
<h1>Importar tempos</h1>

<p>
Insira um arquivo no formato CSV com o seguinte formato:<br />
Numeral ; Tempo ; Observa&ccedil;&atilde;o
</p>

<?php echo form_open_multipart($db.'/importar_tempos/upload');?>


<div class="col-lg-4">
	<label for="status">Arquivo</label>
	<input type="file" name="userfile" size="20" />	
</div>

<div class="col-lg-4">
	<label for="tipo">Tipo de Tempo</label>
	<select id="tipo" name="tipo" class="form-control">
		<?php
			foreach ($vetor_tipos_tempo AS $tipo_tempo){ 
				$valor = $tipo_tempo['tipo'];
				$descricao = $tipo_tempo['descricao'];
				echo sprintf('<option value="%s">%s</option>\r\n',$valor,$descricao);
			}
		?>
	</select>
</div>

<div class="col-lg-4">
	<label for="trecho">Trecho</label>
	<select id="trecho" name="trecho" class="form-control">
		<?php
			foreach ($vetor_trechos AS $trecho){ 
				$valor = $trecho['c02_codigo'];
				$descricao = $trecho['c02_nome'];
				echo sprintf('<option value="%s">%s</option>\r\n',$valor,$descricao);
			}
		?>
	</select>
</div>

<div class="col-lg-4">
	<input type="submit" value="upload" />
</div>
<?php 
if (isset($string)){

	echo '<div class="alert alert-info" role="alert">'.$string.'</div>';
}
?>
</form>