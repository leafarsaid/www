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
		
		$this->load->helper("tempos");
		
		$tempoch = tempo_para_segundos($this->input->post('tempoch'));
		$adianto = tempo_para_segundos($this->input->post('adianto'));
		$atraso = tempo_para_segundos($this->input->post('atraso'));
		$data_txt = data_para_bd($this->input->post('data'));
		
		$data = array(
				'c02_nome' => $this->input->post('nome'),
				'c02_data' => $data_txt,
				'c02_origem' => $this->input->post('origem'),
				'c02_destino' => $this->input->post('destino'),
				'c02_distancia' => $this->input->post('distancia'),
				'c02_tempo_ch' => $tempoch,
				'c02_pena_adianto' => $adianto,
				'c02_pena_atraso' => $atraso,
				'c02_codigo'	=>	$this->input->post('c02_codigo'),
				'c02_setor'	=>	$this->input->post('c02_setor'),
				'c02_trecho_largada'	=>	$this->input->post('local_largada'),
				'c02_tipo_largada'	=>	$this->input->post('tipo_local_largada'),
				'c02_trecho_chegada'	=>	$this->input->post('local_chegada'),
				'c02_tipo_chegada'	=>	$this->input->post('tipo_local_chegada'),
				'c02_status'	=>	$this->input->post('status'),
				'c02_aparece_no_relatorio'	=>	$this->input->post('aparece_no_relatorio'),
				'c02_numero'	=>	$this->input->post('c02_codigo')
		);
	
		return $this->db->update('t02_trecho', $data, array('c02_codigo' => $id));
	}
}
