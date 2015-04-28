<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Model {

    var $inventoryid   = '';
    var $productid          = '';
    var $quantity          = '';
    var $type         = '';
    var $created_at          = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	
	function getInventoryByProductId($id){
        $this->db->select('inventoryid,productid,quantity,type,(case when type=1 then \'Add\' when type=2 then \'Remove\' end) as typeKata, created_at');
        $this->db->from('inventory');
        $this->db->where('productid',$id);
		$query=$this->db->get();
        return $query->result();
    }
	
    function getInventory($id)
    {    
       $this->db->select('inventoryid,productid,quantity,type,(case when type=1 then \'Add\' when type=2 then \'Remove\' end) as typeKata,  created_at');
		$this->db->from('inventory');
        $this->db->where('inventoryid',$id);
        $query=$this->db->get();
        $data=$query->result();
        if($data)
            return $data[0];
        else
            return null;
    }

	
	function insertInventory($productid,$quantity,$type){
        $newObject=new Inventory;
        $newObject->inventoryid=NULL;
        $newObject->productid=$productid;
        $newObject->quantity=$quantity;
        $newObject->type=$type;
        $newObject->created_at=NULL;
        if($this->db->insert('inventory',$newObject)){
            $id=$this->db->insert_id();
            return $this->getInventory($id);
        }
        else 
            return null;
    }
	
	function deleteInventory($id){
		return $this->db->delete('inventory', array('inventoryid' => $id)); 
	}

}