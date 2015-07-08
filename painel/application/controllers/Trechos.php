<?php
class Trechos extends CI_Controller {

	public function __construct(){

		parent::__construct();

	}
	
	public function crud($db = local, $id = 1, $modalidade = 1){	
		
		$this->load->model('trechos_model','',$db);
		$this->load->helper('form');
		$this->load->helper('tempos');
		$this->load->library('form_validation');
		
		$data['db'] = $db;
		$data['id'] = $id;
		$data['modalidade'] = $modalidade;
		$data['vetor_trecho'] = $this->trechos_model->get_trechos($id);
		$data['vetor_trechos'] = $this->trechos_model->get_trechos();
		$data['vetor_tipos_tempo'] = tipos();
		
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
		$this->load->helper('url');
		
		if ($this->form_validation->run() === FALSE){
					
			$this->load->view('templates/header', $data);
			$this->load->view('modulos/trecho', $data);
			$this->load->view('templates/footer', $data);
			
		} else{
			
			$this->trechos_model->update_trecho($id);
			
			$data['vetor_trecho'] = $this->trechos_model->get_trechos($id);
			$data['vetor_trechos'] = $this->trechos_model->get_trechos();
			
			$this->load->view('templates/header', $data);
			$this->load->view('modulos/trecho', $data);
			$this->load->view('templates/footer', $data);	
		}
		
		
		
	}
	
	/* public function update(){
		
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$data['title'] = 'Create a news item';
	
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'text', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
	
		}
		else
		{
			$this->news_model->set_news();
			$this->load->view('news/success');
		}
	} */
}