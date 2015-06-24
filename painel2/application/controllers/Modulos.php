<?php
class Modulos extends CI_Controller {
	
		public function __construct()
		{
			parent::__construct();
		}

        public function trecho($id = 1)
        {
        	$this->load->model('trechos_model');
        	
        	$data['id'] = $id;
        	$data['vetor_trecho'] = $this->trechos_model->get_trechos($id);
        	$data['vetor_trechos'] = $this->trechos_model->get_trechos();
        	
        	$this->load->helper('url');
        	$this->load->view('templates/header', $data);
        	$this->load->view('modulos/trecho', $data);
        	$this->load->view('templates/footer', $data);
        }
}