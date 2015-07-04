<?php

class Form_Base {

	protected $services;
	protected $form_validation;
	public function __construct(){
		$this->services=&get_instance();
		$this->services->load->library('form_validation');
		$this->form_validation=$this->services->form_validation;
	}

}
