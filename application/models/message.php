<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Model {

    var $messageid   = '';
    var $userid='';
    var $caption          = '';
    var $message         = '';
    var $created_at          = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	
	function getMessageSyncCreated($created_at,$userid){
        $this->db->select('messageid, caption , message');
        $this->db->from('message');
        $this->db->where('(message.userid=0 OR message.userid='.$userid.')',NULL,false);
	    $this->db->where('message.created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }

	
	  function insertMessage($caption,$message,$userid){
        $newObject=new Message;
        $newObject->messageid=NULL;
        $newObject->caption=$caption;
        $newObject->userid=$userid;
        $newObject->message=$message;
        $newObject->created_at=NULL;
        if($this->db->insert('message',$newObject))
            return true;
        else 
            return false;
    }

}