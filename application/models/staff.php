<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Model {

    var $staffid         = '';
    var $username       = '';
    var $password       = '';
    var $created_at     = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    	
	
    function getStaff($id){
	    $this->db->select('*');
        $this->db->from('staff');
        $this->db->where('staffid',$id);
        $query=$this->db->get();
        return $query->result();
        }

   
    
    function getUserByUsername($username){
		$this->db->select('*');
		$this->db->from('staff');
        $this->db->where('username =',$username);
        $query=$this->db->get();
        return $query->result();
    }

  


  


}