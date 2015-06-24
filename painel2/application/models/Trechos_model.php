<?php
class Trechos_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
        public function get_trechos($trecho = FALSE)
        {
        	if ($trecho === FALSE)
        	{
        		$query = $this->db->get('t02_trecho');
        		return $query->result_array();
        	}
        
        	$query = $this->db->get_where('t02_trecho', array('c02_codigo' => $trecho));
        	return $query->row_array();
        }
}