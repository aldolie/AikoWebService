<?php

require_once APPPATH.'libraries/form/Form_Base.php';

class Form_Signin extends Form_Base{

	private $username;
	private $password;

	public function __construct(){
		parent::__construct();
		$this->for
	}

	public function setRules(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
	}
}
