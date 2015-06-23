<?php
class Modulos extends CI_Controller {

        public function view($modulo = 'trecho')
        {
        	if ( ! file_exists(APPPATH.'/views/modulos/'.$modulo.'.php'))
        	{
        		// Módulo inexistente
        		show_404();
        	}
        	
        	$data['title'] = ucfirst($modulo);
        	
        	$this->load->helper('url');
        	$this->load->view('templates/header', $data);
        	$this->load->view('modulos/'.$modulo, $data);
        	$this->load->view('templates/footer', $data);
        }
}