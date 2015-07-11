<?php
class Tempos_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}

	/* public function get_trechos($trecho = FALSE){
		
		if ($trecho === FALSE){
			$query = $this->db->get('t02_trecho');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('t02_trecho', array('c02_codigo' => $trecho));
		return $query->row_array();
	} */
	
	public function insert_tempo($veiculo, $tempo){
		
		$this->load->helper("tempos");
		
		$tempo_segundos = tempo_para_segundos($tempo);
		
		$data = array(
				'c01_valor' => $tempo_segundos,
				'c01_tipo' => $this->input->post('tipo'),
				'c01_status' => 'O',
				'c03_codigo' => $veiculo,
				'c02_codigo' => $this->input->post('trecho'),
				'c01_sigla' => 'FI'
		);
		///$this->output->enable_profiler(TRUE);
	
		return $this->db->insert('t01_tempos', $data);
	}
}
