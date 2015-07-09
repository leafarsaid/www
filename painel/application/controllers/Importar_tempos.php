<?php

class Importar_tempos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));		
	}

	function index($db = "local")
	{
		$this->load->helper('tempos');
		$this->load->model('trechos_model','',$db);
		$data = array(
				'vetor_trechos' => $this->trechos_model->get_trechos(),
				'vetor_tipos_tempo' => tipos(),
				'db' => $db
		);
		$this->load->view('templates/header', $data);
		$this->load->view('modulos/importar_tempos', $data);
		$this->load->view('templates/footer', $data);
	}

	function upload($db = "local")
	{
		$this->load->helper('tempos');
		$this->load->model('tempos_model','',$db);
		$this->load->model('trechos_model','',$db);
		$this->load->helper('file');
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv|txt';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('modulos/importar_tempos', $error);
		}
		else
		{
			$upload_data = $this->upload->data();
			$message_ok = 'Arquivo importado com sucesso;';
			
			$string = read_file($upload_data["file_path"].$upload_data["file_name"]);
			
			$linhas = explode($string,'\r');
			
			foreach($linhas AS $linha){
				
				$arr_linha = explode($linha,';');
				$this->tempos_model->insert_tempo($arr_linha[0], $arr_linha[1], $this->input->post('tipo'), $this->input->post('trecho'));
			}			
			
			$data = array(
					'upload_data' => $upload_data,
					'message_ok' => $message_ok,
					'db' => $db
			);
			$this->load->view('templates/header', $data);
			$this->load->view('modulos/importar_tempos', $data);
			$this->load->view('templates/footer', $data);
		}
	}
}
?>