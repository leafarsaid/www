<?php
class Trecho extends CI_Controller {
	
	public function __construct(){	
		
		parent::__construct();	
		
	}
	
	public function view($db, $id = 1, $modalidade = 1){	
		
		$this->db->hostname = "localhost";
		$this->db->username = "root";
		$this->db->password = "";
		$this->db->database = "chronosat1";
		
		$this->load->model('trechos_model');
		
		$data['db'] = $db;
		$data['id'] = $id;
		$data['modalidade'] = $modalidade;
		$data['vetor_trecho'] = $this->trechos_model->get_trechos($id);
		$data['vetor_trechos'] = $this->trechos_model->get_trechos();
		
		$this->load->helper('url');
		$this->load->view('templates/header', $data);
		$this->load->view('modulos/trecho', $data);
		$this->load->view('templates/footer', $data);
	}
}