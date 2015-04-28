<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publish extends CI_Model {

    var $publishid   = '';
    var $productid          = '';
    var $caption          = '';
    var $message         = '';
    var $created_at          = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	
	function getPublishSyncCreated($created_at){
        $this->db->select('product_publish.productid as id, caption , message, r_type');
        $this->db->from('product_publish');
		$this->db->join('product','product.productid=product_publish.productid');
        $this->db->where('product_publish.created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }

	
	  function insertPublish($productid,$caption,$message){
        $newObject=new Publish;
        $newObject->publishid=NULL;
        $newObject->productid=$productid;
        $newObject->caption=$caption;
        $newObject->message=$message;
        $newObject->created_at=NULL;
        if($this->db->insert('product_publish',$newObject))
            return true;
        else 
            return false;
    }

}