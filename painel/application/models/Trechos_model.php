<?php
class Trechos_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}

	public function get_trechos($trecho = FALSE){
		
		if ($trecho === FALSE){
			$query = $this->db->get('t02_trecho');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('t02_trecho', array('c02_codigo' => $trecho));
		return $query->row_array();
	}
	
	public function update_trecho($id){
		
		$data = array(
				'c02_nome' => $this->input->post('nome'),
				'c02_data' => $this->input->post('data'),
				'c02_origem' => $this->input->post('origem'),
				'c02_destino' => $this->input->post('destino'),
				'c02_distancia' => $this->input->post('distancia'),
				'c02_tempo_ch' => $this->input->post('tempoch'),
				'c02_pena_adianto' => $this->input->post('adianto'),
				'c02_pena_atraso' => $this->input->post('atraso')
		);
	
		return $this->db->update('t02_trecho', $data, array('c02_codigo' => $id));
	}
}