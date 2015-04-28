<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_master extends CI_Model {

    var $productid      = '';
    var $productname    = '';
    var $categoryid     = '';
    var $hargaeceran    = '';
    var $hargagrosir    = '';
    var $stock          = '';
	var $type          = '';
    var $gambar         = '';
    var $description    = '';
    var $created_at     = '';
    var $updated_at     = '';
    var $published_at   = '';
	var $r_type='';
    var $berat='';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function getProducts($method){
        if($method==0){
            $this->db->select('*');
		}
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,published_at,deleted_at,r_type');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at.published_at,deleted_at,r_type');
        $this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
        $query=$this->db->get();
        return $query->result();
    }


    function getProduct($id)
    {    
		$this->db->select('productid,productname,categoryid,hargagrosir,hargaeceran,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,published_at,deleted_at,(case when r_type=0 then \'Ready\' when r_type=1 then \'PO\' end) as r_type');
        $this->db->from('product');
        $this->db->where('productid',$id);
        $query=$this->db->get();
        $data=$query->result();
        if($data)
            return $data[0];
        else
            return null;
    }


    function getProductById($id)
    {    
        $this->db->select('productid,productname,categoryid,hargagrosir,hargaeceran,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,published_at,deleted_at,(case when r_type=0 then \'Ready\' when r_type=1 then \'PO\' end) as r_type');
        $this->db->from('product');
        $this->db->where('productid',$id);
        $this->db->where('deleted_at is null',NULL,false);
        $query=$this->db->get();
        $data=$query->result();
        if($data)
            return $data[0];
        else
            return null;
    }

	function getProductsForAdmin($offset,$limit,$cat,$search){
		$this->db->select('productid,product.productname,product.categoryid,categoryname,type,berat,hargagrosir,hargaeceran,stock,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,product.created_at,product.updated_at,product.published_at,product.deleted_at,
		(case when r_type=0 then \'Ready\' when r_type=1 then \'PO\' end) as r_type');
		$this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
		$this->db->like($cat, $search);
		$this->db->limit($limit, $offset);
		$query=$this->db->get();
        return $query->result();
    }
	
	function getProductsForAdminCount($offset,$limit,$cat,$search){
		$this->db->select('productid,productname,product.categoryid,categoryname,type,berat,hargagrosir,hargaeceran,stock,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,product.created_at,product.updated_at,product.published_at,product.deleted_at');
		$this->db->from('product');
		$this->db->join('category','category.categoryid=product.categoryid');
		$this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
        $this->db->like($cat, $search);
		$this->db->limit($limit, $offset);
		$query=$this->db->get();
        return count($query->result());
    }
	
    function getProductsForCustomer($offset,$limit,$type){
         $this->db->select('productid,productname,hargagrosir as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,published_at');
         $this->db->from('product');
         $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		 $this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
         $this->db->where('r_type',$type);		 
         $this->db->order_by("created_at", "desc");
		 $this->db->limit($limit, $offset);
         $query=$this->db->get();
         return $query->result();
    }
	
	function getProductsForCustomerCount($offset,$limit,$type){
         $this->db->select('productid,productname,hargagrosir as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,published_at');
         $this->db->from('product');
         $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
         $this->db->where('`deleted_at` IS  NULL', NULL, FALSE);
         $this->db->where('r_type',$type);		 
         $this->db->order_by("created_at", "desc"); 
         $this->db->limit($limit, $offset);
		 $query=$this->db->get();
        return count($query->result());
    }




     function getProductsSyncCreated($created_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,deleted_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,deleted_at');
        
        $this->db->from('product');
        $this->db->where('created_at >',$created_at);
		$this->db->where('r_type','0');
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
        $this->db->where('`deleted_at` IS NULL', NULL, FALSE);
		$this->db->order_by("created_at", "desc");
		
        $query=$this->db->get();
        return $query->result();
    }

    function getProductsSyncUpdated($updated_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,stock,type,berat,description,created_at,updated_at,deleted_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,stock,type,berat,description,created_at,updated_at,deleted_at');
        $this->db->from('product');
        $this->db->where('updated_at >',$updated_at);
		$this->db->where('r_type','0');
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		$this->db->order_by("created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }

	
	 function getPOSyncCreated($created_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,deleted_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,stock,type,berat,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,description,created_at,updated_at,deleted_at');
        
        $this->db->from('product');
        $this->db->where('created_at >',$created_at);
		$this->db->where('r_type','1');
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
        $this->db->where('`deleted_at` IS NULL', NULL, FALSE);
		$this->db->order_by("created_at", "desc");
		 $query=$this->db->get();
        return $query->result();
    }

    function getPOSyncUpdated($updated_at,$method){
         if($method==0)
            $this->db->select('*');
        else if($method==1)
            $this->db->select('productid,productname,hargagrosir as harga,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,stock,type,berat,description,created_at,updated_at,deleted_at');
        else if($method==2)
            $this->db->select('productid,productname,hargaeceran as harga,(CASE WHEN gambar is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar END) as gambar,(CASE WHEN gambar_small is null THEN '.'\'no_image_thumb.jpg\''.' ELSE gambar_small END) as gambar_small,stock,type,berat,description,created_at,updated_at,deleted_at');
        $this->db->from('product');
        $this->db->where('updated_at >',$updated_at);
		$this->db->where('r_type','1');
        $this->db->where('`published_at` IS NOT NULL', NULL, FALSE);
		$this->db->where('r_type=1',NULL,FALSE);
		$this->db->order_by("created_at", "desc");
        $query=$this->db->get();
        return $query->result();
    }


	function getDate(){
       
        $query= $this->db->query("SELECT NOW() as tgl");
        return $query->result()[0]->tgl;
    }
	
    function insertProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,$stock,$berat,$type,$r_type){
        
		$date = new DateTime($this->getDate());
		$insertedDate=$date->format('Y-m-d H:i:s');
		$newObject=new Product_master;
        $newObject->productid=NULL;
        $newObject->productname=$productname;
        $newObject->categoryid=$categoryid;
        $newObject->hargaeceran=$hargaeceran;
        $newObject->hargagrosir=$hargagrosir;
        $newObject->description=$description;
		$newObject->type=$type;
        $newObject->stock=$stock;
        $newObject->gambar=NULL;
		$newObject->r_type=$r_type;
        $newObject->berat=$berat;
        $newObject->created_at=$insertedDate;
        $newObject->updated_at=NULL;
        $newObject->published_at=NULL;
        if($this->db->insert('product',$newObject)){
            $id=$this->db->insert_id();
            return $this->getProduct($id);
        }
        else 
            return null;
    }


    function updateProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,$stock,$berat,$productid){
        if($categoryid==-1){
			$data= array('productname' => $productname,
                     'hargaeceran' =>$hargaeceran,
                     'hargagrosir' =>$hargagrosir,
                     'description' =>$description,
                     'berat' =>$berat
                    );
		}
		else{
			$data= array('productname' => $productname,
						 'categoryid' => $categoryid,
						 'hargaeceran' =>$hargaeceran,
						 'hargagrosir' =>$hargagrosir,
						 'description' =>$description,
                         'berat' =>$berat
						);
		}
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	
	function publishProduct($productid){
		
		$date = new DateTime($this->getDate());
		$insertedDate=$date->format('Y-m-d H:i:s');
        $data= array('published_at' =>$insertedDate);
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	
	function deleteProduct($productid){
		
		$date = new DateTime($this->getDate());
		$insertedDate=$date->format('Y-m-d H:i:s');
        $data= array('deleted_at' => $insertedDate);
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }

	function updateStockProduct($stock,$productid){
        $data= array('stock'=>$stock);
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }
	

    function updateProductImage($gambar,$gambar_small,$productid){
        $data= array('gambar' => $gambar,
                     'gambar_small' =>$gambar_small
                    );
        $this->db->where('productid',$productid);
        if($this->db->update('product',$data))
            return true;
        else
            return false;
    }

    function getPriceGrosir($productid){
        $this->db->select('hargagrosir as harga');
        $this->db->from('product');
        $this->db->where('productid',$productid);
        $query=$this->db->get();
        $products= $query->result();
        return $products[0]->harga;
    }
	
	function getStock($productid){
        $this->db->select('stock');
        $this->db->from('product');
        $this->db->where('productid',$productid);
        $query=$this->db->get();
        $products= $query->result();
        return $products[0]->stock;
    }

}