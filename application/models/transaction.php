<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Model {

    var $transactionid   = '';
    var $userid          = '';
    
    var $productid          = '';
    var $price         = '';
    var $quantity          = '';
    var $status          = '';
    var $created_at      = '';
    var $updated_at      = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function getTransactionByUserId($userid){
        $this->db->select("transactionid,userid,transaction_product.productid,product.berat,transaction_product.price,transaction_product.quantity,transaction_product.status,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,DATE_ADD(transaction_product.updated_at,INTERVAL 7 HOUR) as updated_at",false);
        $this->db->from("transaction_product");
        $this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
        $query=$this->db->get();
        return $query->result();
    }

	  public function getTransactionById($id){
         $this->db->select("transactionid,userid,transaction_product.productid,transaction_product.price,transaction_product.quantity,transaction_product.status,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,DATE_ADD(transaction_product.updated_at,INTERVAL 7 HOUR) as updated_at",false);
        $this->db->from("transaction_product");
        $this->db->where("transactionid",$id);
        $query=$this->db->get();
        $result=$query->result();
		if($result)
			return $result[0];
		else
			null;
    }
	
	

    public function insertTransaction($userid,$productid,$price,$quantity,$status){
        
		$date = new DateTime($this->getDate());
		$insertedDate=$date->format('Y-m-d H:i:s');
		$newObject=new Transaction;
        $newObject->transactionid=NULL;
        $newObject->userid=$userid;
		$newObject->productid=$productid;
	    $newObject->price=$price;
	    $newObject->quantity=$quantity;
        $newObject->status=$status;
        $newObject->created_at=$insertedDate;
        $newObject->updated_at=NULL;
        if($this->db->insert('transaction_product',$newObject))
            return $this->db->insert_id();
        else 
            return 0;
    }
	
	function getTransactionSyncCreated($created_at,$userid){
        $this->db->select("transactionid,productname,product.berat,price as harga,quantity,transaction_product.status,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,DATE_ADD(transaction_product.updated_at,INTERVAL 7 HOUR) as updated_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small",false);
        $this->db->from('transaction_product');
		$this->db->join('product','product.productid=transaction_product.productid');
		$this->db->where("(transaction_product.status='Delivered' or transaction_product.status='Paid')", NULL, FALSE);
		$this->db->where("transaction_product.userid =",$userid);
        $this->db->where('transaction_product.created_at >',$created_at);
		$this->db->order_by("transaction_product.created_at", "desc");
		$query=$this->db->get();
        return $query->result();
    }

    function getTransactionSyncUpdated($updated_at,$userid){
       $this->db->select("transactionid,productname,product.berat,price as harga,quantity,transaction_product.status,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,DATE_ADD(transaction_product.updated_at,INTERVAL 7 HOUR) as updated_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small",false);
        $this->db->from('transaction_product');
		$this->db->join('product','product.productid=transaction_product.productid');
		$this->db->where("(transaction_product.status='Delivered' or transaction_product.status='Paid')", NULL, FALSE);
		$this->db->where("transaction_product.userid",$userid);
        $this->db->where('transaction_product.updated_at >',$updated_at);
		$this->db->order_by("transaction_product.created_at", "desc");
		$query=$this->db->get();
        return $query->result();
    }
	
	
	public function getOrderByUserId($userid){
        $this->db->select("transaction_product.transactionid,product.berat , product.productid , product.productname,transaction_product.price as harga,product.type,transaction_product.quantity,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
		$this->db->where("transaction_product.status ","Pending");
		$this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	

    public function getOrderByUserIdAdmin($userid){
        $this->db->select("transaction_product.transactionid,product.berat , product.productid , product.productname,transaction_product.price as harga,product.type,transaction_product.quantity,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
        $this->db->from("transaction_product");
        $this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
        $this->db->where("(transaction_product.status='Pending' or transaction_product.status='Paid' or transaction_product.status='PO' )", NULL, FALSE);
        $this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	public function getOrderPOByUserId($userid){
        $this->db->select("transaction_product.transactionid ,product.berat, product.productid , product.productname,transaction_product.price as harga,product.type,transaction_product.quantity,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
		$this->db->where("transaction_product.status ","PO");
		$this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }


    public function getOrderPOByUserIdAdmin($userid){
        $this->db->select("transaction_product.transactionid,product.berat , product.productid , product.productname,transaction_product.price as harga,product.type,transaction_product.quantity,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
        $this->db->from("transaction_product");
        $this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
        $this->db->where("transaction_product.status ","PO");
        $this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	
	
	public function getOrderByProductId($productid){
        $this->db->select("transaction_product.transactionid ,product.berat, user.userid , user.username,transaction_product.price as harga,product.type,transaction_product.quantity,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
		$this->db->from("transaction_product");
		$this->db->join('user','user.userid=transaction_product.userid');
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("product.productid",$productid);
		$this->db->where("(transaction_product.status='Pending' or transaction_product.status='Paid' or transaction_product.status='PO' or transaction_product.status='Delivered')", NULL, FALSE);
		$this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	
	public function getOrder(){
        $this->db->select("user.userid,user.username,user.nama,user.alamat,user.telepon,user.email, count(transaction_product.transactionid) as jml");
		$this->db->from('transaction_product');
		$this->db->join('user','user.userid=transaction_product.userid');
		$this->db->where("(transaction_product.status='Pending' or transaction_product.status='Paid' or transaction_product.status='PO')", NULL, FALSE);
		$this->db->group_by('user.userid,user.username,user.nama,user.alamat,user.telepon,user.email');
		$query=$this->db->get();
        return $query->result();
    }
	
	
	public function getOrderProduct(){
        $this->db->select("product.productid,product.productname,product.type,sum(transaction_product.quantity) as jml,(case when product.r_type=0 then 'Ready' when product.r_type=1 then 'PO' end) as r_type");
		$this->db->from('transaction_product');
		$this->db->join('product','product.productid=transaction_product.productid');
		$this->db->where("(transaction_product.status='Pending' or transaction_product.status='Paid' or transaction_product.status='PO')", NULL, FALSE);
        $this->db->group_by('product.productid,product.productname,product.type,product.r_type ');
		$query=$this->db->get();
        return $query->result();
    }
	
	public function getRecapitulation(){
        $this->db->select("user.userid,user.username,user.nama,user.alamat,user.telepon,user.email, count(transaction_product.transactionid) as jml");
		$this->db->from('transaction_product');
		$this->db->join('user','user.userid=transaction_product.userid');
		$this->db->where("(transaction_product.status='Delivered' or transaction_product.status='Reject')", NULL, FALSE);
		$this->db->group_by('user.userid,user.username,user.nama,user.alamat,user.telepon,user.email');
		$query=$this->db->get();
        return $query->result();
    }
	
	
	public function getRecapitulationByUserId($userid){
        $this->db->select("transaction_product.transactionid , product.productid , product.productname,transaction_product.price as harga,transaction_product.quantity,product.type,DATE_ADD(transaction_product.created_at,INTERVAL 7 HOUR) as created_at,(CASE WHEN gambar is null THEN 'no_image_thumb.jpg' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN 'no_image_thumb.jpg' ELSE gambar_small END) as gambar_small,transaction_product.status",false);
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
        $this->db->where("userid",$userid);
		$this->db->where("(transaction_product.status='Delivered' or transaction_product.status='Reject')", NULL, FALSE);
		$this->db->order_by("created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	
	public function getReport($from,$to){
        $this->db->select("transaction_product.transactionid,DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR)  as transactiondate, user.username ,user.nama,user.alamat,user.telepon,product.productid, product.productname,transaction_product.price as harga,transaction_product.quantity,product.type",false);
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
		$this->db->join('user','user.userid=transaction_product.userid');
		$this->db->where("transaction_product.status =","Delivered");
		$this->db->where("DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR) >='$from'",NULL,FALSE);
		$this->db->where("DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR) <='$to'",NULL,FALSE);
		$this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	public function getReportByUser($from,$to,$userid){
        $this->db->select("transaction_product.transactionid,DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR) as transactiondate, user.username ,user.nama,user.alamat,user.telepon,product.productid, product.productname,transaction_product.price as harga,transaction_product.quantity,product.type",false);
		$this->db->from("transaction_product");
		$this->db->join('product','product.productid=transaction_product.productid');
		$this->db->join('user','user.userid=transaction_product.userid');
		$this->db->where("transaction_product.status =","Delivered");
		$this->db->where("DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR) >='$from'",NULL,FALSE);
		$this->db->where("DATE_ADD(transaction_product.created_at, INTERVAL 7 HOUR) <='$to'",NULL,FALSE);
		$this->db->where("transaction_product.userid =","$userid");
		$this->db->order_by("transaction_product.created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }
	
	function updateStatus($status,$transactionid){
        $data= array('status' => $status);
        $this->db->where('transactionid',$transactionid);
        if($this->db->update('transaction_product',$data))
            return true;
        else
            return false;
    }
	
	
    function postProductReady($productid){
        $data= array('status' => 'Pending');
        $this->db->where('productid',$productid);
        $this->db->where('status','PO');
        if($this->db->update('transaction_product',$data))
            return true;
        else
            return false;
    }

	function getTransactionsSyncCreated($userid,$created_at){
        $this->db->select('*');
        $this->db->from('transaction_product');
        $this->db->where('created_at >',$created_at);
        $query=$this->db->get();
        return $query->result();
    }
	
	function getDate(){
       
        $query= $this->db->query("SELECT NOW() as tgl");
        return $query->result()[0]->tgl;
    }

    function getTransactionsSyncUpdated($userid,$updated_at){
        $this->db->select('*');
        $this->db->from('transaction_product');
        $this->db->where('updated_at >',$updated_at);
        $query=$this->db->get();
        return $query->result();
    }

}