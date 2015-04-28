<?php require(APPPATH.'libraries/REST_Controller.php');

class Services extends REST_Controller  {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->load->model('user');
        $this->load->model('product_master');
        $this->load->model('category');
        $this->load->model("transaction");
		$this->load->model("publish");
		$this->load->model("inventory");
		$this->load->model("staff");
		$this->load->model("message");
    }

    /* Users_Function_start */

	public function users_get(){
		
		if($this->get('created_at')!=null)
			$users=$this->user->getUserSyncCreated($this->get('created_at'));
		else if($this->get('updated_at')!=null)
			$users=$this->user->getUserSyncUpdated($this->get('updated_at'));
		else
			$users=$this->user->getUsers();
		if($users)
            $this->response(array('status'=>'success','result'=>$users),200);
        else
           $this->response(array('status'=>'success','result'=>array()),200);
    	
    }


	public function new_message_get(){
		
		if($this->get('created_at')!=null&&$this->get('id')){
			$new=$this->message->getMessageSyncCreated(substr($this->get('created_at'),0,10).' '.substr($this->get('created_at'),10,8),$this->get('id'));
			if($new){
				$this->response(array('status'=>'success','result'=>$new),200);
			}
			else{
				 $this->response(array('status'=>'success','result'=>array()),200);
			}
		}
		else{
			 $this->response(array('status'=>'success','result'=>array()),200);
		}
	
	}



public function message_user_post(){
		$id=$this->post('i');
		$caption=$this->post('cap');
		$message=$this->post('mes');
		if($this->message->insertMessage($caption,$message,$id)){
			$this->response(array('status'=>'success','result'=>1),200);
		}
		else{
			$this->response(array('status'=>'failed','result'=>0),200);
		}
			
		
	}

	
	
    public function user_get(){
		$id=0;
		if($this->get('id')!=null)
			$id=$this->get('id');
		$users=$this->user->getUser($id);
		
		if($users)
            $this->response(array('result'=>$users[0]), 200);
        else
            $this->response(NULL, 404);
    	
    }


    public function user_delete_post(){
		$id=0;
		$key='';
		if($this->post('id')!=null)
			$id=$this->post('id');
		if($this->post('key')!=null)
			$key=$this->post('key');
		if($key=='VASUDH12309SDBDAAHDA'){
			$users=$this->user->deleteUser($id);
			if($users)
				$this->response(['status'=>'success'],200);
	        else
				$this->response(['status'=>'failed'],200);
    	}
    	else{
				$this->response(['status'=>'failed'],200);
    	}
    	
    }

	public function users_signin_post(){
		if($this->post('username')!=null&&$this->post('password')!=null){
			$username=$this->post('username');
			$password=$this->post('password');

			$users=$this->user->getUserByUsernameAndPassword($username);
			if($users){
				$user=$users[0];
				if($user->password==md5($password))
					$this->response(array('status'=>'success','result'=>$user),200);
				else
					$this->response(array('status'=>'failed','result'=>'Username dan password tidak cocok'));
			}
			else
				$this->response(array('status'=>'failed','result'=>'username tidak ditemukan'),200);
		}
		else
            $this->response(array('status'=>'failed','result'=>'failure'),200);
	}
	
	
	public function push_post(){
		$id=$this->post('i');
		$caption=$this->post('cap');
		$message=$this->post('mes');
		if($this->publish->insertPublish($id,$caption,$message)){
			$this->response(array('status'=>'success','result'=>1),200);
		}
		else{
			$this->response(array('status'=>'failed','result'=>0),200);
		}
			
		
	}
	
	
	public function staff_signin_post(){
		if($this->post('username')!=null&&$this->post('password')!=null){
			$username=$this->post('username');
			$password=$this->post('password');
			if($username=='')
				$this->response(array('status'=>'failed','result'=>'Username harus diisi'),200);
			else if($password=='')
				$this->response(array('status'=>'failed','result'=>'Password harus diisi'),200);
			else{
			$users=$this->staff->getUserByUsername($username);
				if($users){
					$user=$users[0];
					if($user->password==md5($password))
						$this->response(array('status'=>'success','result'=>$user),200);
					else
						$this->response(array('status'=>'failed','result'=>'Username dan password tidak cocok'));
				}
				else{
					$this->response(array('status'=>'failed','result'=>'username tidak ditemukan'),200);
				}
			}
		}
		else
            $this->response(array('status'=>'failed','result'=>'failure'),200);
	}

	public function users_check_username_get(){
		$username=$this->get('username');
		
		if($this->check_username($username))
			$this->response(array('status'=>'success','result'=>'1'),200);
		else
			$this->response(array('status'=>'success','result'=>'0'),200);
	}

	private function check_username($username){
		$users=$this->user->getUserByUsername($username);
		if($users)
			return true;
		else
			return false;
	}

	public function users_register_post(){
		$username=($this->post('username'));
		$password=($this->post('password'));
		$nama=($this->post('nama'));
		$alamat=($this->post('alamat'));
		$telepon=($this->post('telepon'));
		$email=($this->post('email'));
		$status=0;
		if($this->check_username($username))
			$this->response(array('status'=>'failed','result'=>'-1','reason'=>'Username sudah ada'),200);
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)&&$email!=''){
			$this->response(array('status'=>'failed','result'=>'-2','reason'=>'Format Email Salah'),200);
		}
		else{
			$statusInsert=$this->user->insertUser($username,$password,$nama,$alamat,$telepon,$email,$status);
			if($statusInsert){
				$users=$this->user->getUserByUsername($username);
				$this->response(array('status'=>'success','result'=>$users[0]->userid),200);
			}
			else
				$this->response(array('status'=>'failed','result'=>'0','reason'=>'Failed to register'),200);
		}
	}

	function user_update_post(){
		$userid=($this->post('userid'));
		$nama=($this->post('nama'));
		$alamat=($this->post('alamat'));
		$telepon=($this->post('telepon'));
		$email=($this->post('email'));
		$note=($this->post('note'));
		$bb=($this->post('bb'));
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)&&$email!=''){
			$this->response(array('status'=>'failed','result'=>'-1','reason'=>'Format Email Salah'),200);
		}
		else{
			$statusUpdate=$this->user->updateUser($nama,$alamat,$telepon,$email,$note,$bb,$userid);
			if($statusUpdate)
				$this->response(array('status'=>'success','result'=>'1'),200);
			else
				$this->response(array('status'=>'failed','result'=>'0','reason'=>'Gagal Update Data'),200);

		}
	}

	function user_update_status_post(){
		$userid=($this->post('userid'));
		$status=($this->post('status'));
		$statusUpdate=$this->user->updateUserStatus($status,$userid);
		if($statusUpdate)
			$this->response(array('status'=>'success','result'=>'1'),200);
		else
			$this->response(array('status'=>'failed','result'=>'0'),200);
	}

	/* Users_Function_end */

	/* Products_Function_start */

	public function products_master_get(){
		
		$methods=0;
		if($this->get('method')!=null)
			$methods=$this->get('method');
		if($this->get('created_at')!=null)
			$products=$this->product_master->getProductsSyncCreated(substr($this->get('created_at'),0,10).' '.substr($this->get('created_at'),10,8),$methods);
		else if($this->get('updated_at')!=null)
			$products=$this->product_master->getProductsSyncUpdated(substr($this->get('updated_at'),0,10).' '.substr($this->get('updated_at'),10,8),$methods);
		else
			$products=$this->product_master->getProducts($methods);
		
		if($products)
			$this->response(array('status'=>'success','result'=>$products),200);
        else
            $this->response(array('status'=>'success','result'=>array()),200);
	}
	
	
	public function po_master_get(){
		
		$methods=0;
		if($this->get('method')!=null)
			$methods=$this->get('method');
		if($this->get('created_at')!=null)
			$products=$this->product_master->getPOSyncCreated(substr($this->get('created_at'),0,10).' '.substr($this->get('created_at'),10,8),$methods);
		else if($this->get('updated_at')!=null)
			$products=$this->product_master->getPOSyncUpdated(substr($this->get('updated_at'),0,10).' '.substr($this->get('updated_at'),10,8),$methods);
		else
			$products=$this->product_master->getProducts($methods);
		
		if($products)
			$this->response(array('status'=>'success','result'=>$products),200);
        else
            $this->response(array('status'=>'success','result'=>array()),200);
	}
	
	public function inventory_get(){
		
		if($this->get('i')!=null){
		$id=$this->get('i');
		$inventory=$this->inventory->getInventoryByProductId($id);
		
			if($inventory)
				$this->response(array('status'=>'success','result'=>$inventory),200);
			else
				$this->response(array('status'=>'success','result'=>array()),200);
			}
		else{
			$this->response(array(),404);
		}
	}
	
	public function add_stock_post(){
		
		if($this->post('i')!=null&&$this->post('q')!=null){
			$id=$this->post('i');
			$quantity=$this->post('q');
			$type=1;
			$stock=$this->product_master->getStock($id);
				$inventory=$this->inventory->insertInventory($id,$quantity,$type);
				if($inventory)
				{
					$after=$stock+$quantity;
					if($this->product_master->updateStockProduct($after,$id))
					{
						$this->response(array('status'=>'success','result'=>[$inventory,$after]),200);
					}
					else{
						$this->inventory->deleteInventory($inventory->inventoryid);
						$this->response(array('status'=>'failed','result'=>array(),'reason'=>''),200);
					}
				}
				else{
					$this->response(array('status'=>'failed','result'=>array(),'reason'=>''),200);
				}
			
		}	
		else{
			$this->response(array(),404);
		}
	}
	
	public function remove_stock_post(){
		
		if($this->post('i')!=null&&$this->post('q')!=null){
			$id=$this->post('i');
			$quantity=$this->post('q');
			$type=2;
			$stock=$this->product_master->getStock($id);
		
				if($stock<$quantity){
					$this->response(array('status'=>'failed','result'=>array(),'reason'=>'Tidak Mencukupi'),200);
				}
				else{
					$inventory=$this->inventory->insertInventory($id,$quantity,$type);
					if($inventory)
					{
						$after=$stock-$quantity;
						if($this->product_master->updateStockProduct($after,$id))
						{
							$this->response(array('status'=>'success','result'=>[$inventory,$after]),200);
						}
						else{
							$this->inventory->deleteInventory($inventory->inventoryid);
							$this->response(array('status'=>'failed','result'=>array(),'reason'=>''),200);
						}
					}
					else{
						$this->response(array('status'=>'failed','result'=>array(),'reason'=>''),200);
					}
				}
		}	
		else{
			$this->response(array(),404);
		}
	}

	public function new_get(){
		
		if($this->get('created_at')!=null){
			$new=$this->publish->getPublishSyncCreated(substr($this->get('created_at'),0,10).' '.substr($this->get('created_at'),10,8));
			if($new){
				$this->response(array('status'=>'success','result'=>$new),200);
			}
			else{
				 $this->response(array('status'=>'success','result'=>array()),200);
			}
		}
		else{
			 $this->response(array('status'=>'success','result'=>array()),200);
		}
	
	}
	
	public function product_publish_get(){
		$id=0;
		if($this->get('i')!=null)
			$id=$this->get('i');
		$success=$this->product_master->publishProduct($id);
		if($success)
			$this->response(array('status'=>'success'),200);
		else{
			$this->response(array('status'=>'failed'),200);
		}
	}
	
	public function product_delete_post(){
		$id=0;
		if($this->post('i')!=null)
			$id=$this->post('i');
		$success=$this->product_master->deleteProduct($id);
		if($success)
			$this->response(array('status'=>'success'),200);
		else{
			$this->response(array('status'=>'failed'),200);
		}
	}

	public function products_get(){
		$offset=0;
		$limit=0;
		$method='';
		$cat='productname';
		$search='';
		$type='';
		if($this->get('o')!=null)
			$offset=$this->get('o');
		if($this->get('l')!=null)
			$limit=$this->get('l');
		if($this->get('method')!=null)
			$method=$this->get('method');
		if($this->get('cat')!=null)
			$cat=$this->get('cat');
		if($this->get('search')!=null)
			$search=$this->get('search');
		if($this->get('t')!=null)
			$type=$this->get('t');
		
		if($method=='admin'){
			$products=$this->product_master->getProductsForAdmin($offset,$limit,$cat,$search);
			$count=$this->product_master->getProductsForAdminCount($offset+$limit,$limit,$cat,$search);
		}
		else
		{
			$products=$this->product_master->getProductsForCustomer($offset,$limit,$type);
			$count=$this->product_master->getProductsForCustomerCount($offset+$limit,$limit,$type);
		}
		if($products)
           $this->response(array('status'=>'success','result'=>$products,'next'=>$count),200);
        else
           $this->response(array('status'=>'success','result'=>'0','next'=>$count),200);
	}

	public function products_master_add_post(){
	
	    $productname    = ($this->post('productname'));
	    $categoryid     = ($this->post('categoryid'));
	    $hargaeceran    = ($this->post('hargaeceran'));
	    $hargagrosir    = ($this->post('hargagrosir'));
	    $description    = ($this->post('description'));
	    $type    = ($this->post('type'));
		$r_type=$this->post('r_type');
		$berat=$this->post('berat');
		if($hargaeceran<0)
			$this->response(array('status'=>'failed','result'=>'-2','reason'=>'Harus Lebih Besar dari 0'),200);
		else if($hargagrosir<0)
			$this->response(array('status'=>'failed','result'=>'-3','reason'=>'Harus Lebih Besar dari 0'),200);
		else{
			$statusInsert=$this->product_master->insertProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,0,$berat,$type,$r_type);
			if($statusInsert)
				$this->response(array('status'=>'success','result'=>'1','data'=>$statusInsert,'reason'=>'Berhasil'),200);
			else
				$this->response(array('status'=>'failed','result'=>'0'),200);
		}
	}

	function products_master_update_post(){
		$productid    = ($this->post('productid'));
	   	$productname    = ($this->post('productname'));
	    $categoryid     = ($this->post('categoryid'));
	    $hargaeceran    = ($this->post('hargaeceran'));
	    $hargagrosir    = ($this->post('hargagrosir'));
	    $description    = ($this->post('description'));
		$stock    = ($this->post('stock'));
		$berat    = ($this->post('berat'));
    	if($productname=='')
			$this->response(array('status'=>'failed','result'=>'-1','reason'=>'Harus di isi'),200);
		else if($hargaeceran<0)
			$this->response(array('status'=>'failed','result'=>'-2','reason'=>'Harus Lebih Besar dari 0'),200);
		else if($hargagrosir<0)
			$this->response(array('status'=>'failed','result'=>'-3','reason'=>'Harus Lebih Besar dari 0'),200);
		else{
			$statusInsert=$this->product_master->updateProduct($productname,$categoryid,$hargaeceran,$hargagrosir,$description,$stock,$berat,$productid);
			if($statusInsert)
				$this->response(array('status'=>'success','result'=>'1'),200);
			else
				$this->response(array('status'=>'failed','result'=>'0'),200);
		}
	}
	
	public function product_image_upload_post(){
		
		$filename=$this->generate_file_name($_FILES['userfile']['name']);
		$productid=$this->post('productid');
		$config['upload_path']='./image/items/';
		$config['allowed_types']='gif|png|jpg';
		$config['max_size']='1024000';
		$config['max_width']='1024';
		$config['max_height']='768';
		$config['file_name']=$filename;
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload())
		{
			$this->response(array('status'=>'failed','result'=>'0'),200);
		}
		else
		{
			$data=$this->upload->data();
			$full_path=$data['full_path'];
			$file_path=$data['file_path'];
			$name=$data['orig_name'];
			$raw_name=$data['raw_name'];
			$names=explode(".",$name);
			$ext = end($names);
			$this->resize($full_path,$ext,$file_path,$raw_name);
			$statusInsert=$this->product_master->updateProductImage($filename,$raw_name.'_small.'.$ext,$productid);
			if($statusInsert)
			{
				$this->response(array('status'=>'success','result'=>$data),200);

			}
			else
			{
				unlink($config['upload_path'].$filename);
				$this->response(array('status'=>'failed','result'=>'1'),200);
			}
			
		}
	}
	
	
	public function image_upload_post(){
		
		$filename=$this->generate_file_name($_FILES['userfile']['name']);
		$productid=$this->post('productid');
		$config['upload_path']='./image/items/';
		$config['allowed_types']='gif|png|jpg';
		$config['max_size']='1024000';
		$config['max_width']='1024';
		$config['max_height']='768';
		$config['file_name']=$filename;
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload())
		{
			$this->response(array('status'=>'failed','result'=>'0'),200);
		}
		else
		{
			$data=$this->upload->data();
			$statusInsert=$this->product_master->updateProductImage($filename,$productid);
			if($statusInsert)
			{
				$this->response(array('status'=>'success','result'=>$data),200);
			}
			else
			{
				unlink($config['upload_path'].$filename);
				$this->response(array('status'=>'failed','result'=>'1'),200);
			}
			
		}
	}

	private function resize($full_path,$extension,$file_path,$raw_name){

		if($extension=="jpg" || $extension=="jpeg" )
		{
			$src = imagecreatefromjpeg($full_path);
		}
		else if($extension=="png")
		{
			$src = imagecreatefrompng($full_path);
		}
		else 
		{
			$src = imagecreatefromgif($full_path);
		}
		 
		list($width,$height)=getimagesize($full_path);

		$newwidth=50;
		$newheight=($height/$width)*$newwidth;
		$tmp=imagecreatetruecolor($newwidth,$newheight);


		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		$filename = $file_path. $raw_name.'_small.'.$extension;
		imagejpeg($tmp,$filename,30);
		imagedestroy($src);
		imagedestroy($tmp);
	}

	private function generate_file_name($filename){
		$names=explode(".",$filename);
		$ext = end($names);
		$new_filename="".rand();
		/*	for($i=0;$i<count($names)-1;$i++)
		{
			if($i==0)
				$new_filename.=$names[$i];
			else
				$new_filename.='.'.$names[$i];
		}*/
		$new_filename.='_'.date_format(date_create(),'U').'.'.$ext;
		return $new_filename;
	}

	/* Products_Function_end */


	/* Category_Function_start */


	public function categories_get(){
		
		if($this->get('created_at')!=null)
			$categories=$this->category->getCategoriesSyncCreated($this->get('created_at'));
		else if($this->get('updated_at')!=null)
			$categories=$this->category->getCategoriesSyncUpdated($this->get('updated_at'));
		else
			$categories=$this->category->getCategories();
		if($categories)
            $this->response(array('status'=>'success','result'=>$categories),200);
        else
            $this->response(array('status'=>'success','result'=>array()),200);
    	
    }


	public function category_add_post(){
	
	    $categoryname    = mysql_real_escape_string($this->post('categoryname'));
	  
	    if($categoryname=='')
			$this->response(array('status'=>'failed','result'=>'-1','reason'=>'Harus di isi'),200);
		else{
			$statusInsert=$this->category->insertCategory($categoryname);
			if($statusInsert)
				$this->response(array('status'=>'success','result'=>'1'),200);
			else
				$this->response(array('status'=>'failed','result'=>'0'),200);
		}
	}

	public function category_master_detail_post(){
		$categoryname    = mysql_real_escape_string($this->post('categoryname'));
	  	$categoryid  = mysql_real_escape_string($this->post('categoryid'));
	    if($categoryname=='')
			$this->response(array('status'=>'failed','result'=>'-1','reason'=>'Harus di isi'),200);
		else{
			$statusInsert=$this->category->updateCategory($categoryname,$categoryid);
			if($statusInsert)
				$this->response(array('status'=>'success','result'=>'1'),200);
			else
				$this->response(array('status'=>'failed','result'=>'0'),200);
		}
	}


	/* Category_Function_end */


	/* Transactions_Function_Start */

	public function transaction_user_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getTransactionByUserId($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	public function transaction_user_sync_get(){
		$userid=0;
		
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transaction=null;
		
		if($this->get('created_at')!=null)
			$transaction=$this->transaction->getTransactionSyncCreated(substr($this->get('created_at'),0,10).' '.substr($this->get('created_at'),10,8),$userid);
		else if($this->get('updated_at')!=null)
			$transaction=$this->transaction->getTransactionSyncUpdated(substr($this->get('updated_at'),0,10).' '.substr($this->get('updated_at'),10,8),$userid);
		
		if($transaction)
			$this->response(array('status'=>'success','result'=>$transaction),200);
        else
            $this->response(array('status'=>'failed','result'=>array()),200);
	}

	
	public function order_user_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getOrderByUserId($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}


	public function order_user_m_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getOrderByUserIdAdmin($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	public function po_user_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getOrderPOByUserId($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}


	public function po_user_m_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getOrderPOByUserId($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	
	public function order_product_detail_get(){
		$productid=0;
		if($this->get("id")!=null)
			$productid=$this->get("id");
		$transactions=$this->transaction->getOrderByProductId($productid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	public function order_product_get(){
		$transactions=$this->transaction->getOrderProduct();
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	

	public function tr_po_ready_post(){
		if($this->post('i')!=null){
			$id=$this->post('i');
			if($this->transaction->postProductReady($id)){
				$this->response(array('status'=>'success','result'=>true),200);
			}
			else{
				$this->response(array('status'=>'failed','result'=>false),200);
			}
		}
		else{
			$this->response(null,404);
		}
	}

	public function order_get(){
		$transactions=$this->transaction->getOrder();
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	
	public function recapitulation_get(){
		$transactions=$this->transaction->getRecapitulation();
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	
	public function report_post(){
		if($this->post('from')!=null&&$this->post('to')!=null){
			$from=$this->post('from');
			$to=$this->post('to');
			
			if($this->post('userid')==null)
				$transactions=$this->transaction->getReport($from,$to);
			else{
				
				$userid=$this->post('userid');
				$transactions=$this->transaction->getReportByUser($from,$to,$userid);
			}
			if($transactions){
				$this->response(array('status'=>'success','result'=>$transactions),200);
			}
			else
				$this->response(array('status'=>'success','result'=>array()),200);
			}
		else{
			$this->response(null,404);
		}	
	}
	
	
	public function recapitulation_user_get(){
		$userid=0;
		if($this->get("id")!=null)
			$userid=$this->get("id");
		$transactions=$this->transaction->getRecapitulationByUserId($userid);
		if($transactions){
			$this->response(array('status'=>'success','result'=>$transactions),200);
		}
		else
			$this->response(array('status'=>'success','result'=>array()),200);
	}
	
	public function transaction_buy_post(){
		
		$userid=$this->post("userid");
		$productid=$this->post("productid");
		$quantity=$this->post("quantity");
		$stock=$this->product_master->getStock($productid);
		$status="Pending";
		if($stock<$quantity){
			$this->response(array('status'=>'failed','result'=>0,'error'=>"Stock tidak mencukupi"),200);
		}
		else{
			$price=$this->product_master->getPriceGrosir($productid);
			$id=$this->transaction->insertTransaction($userid,$productid,$price,$quantity,$status);
			if($id!=0){
				$this->product_master->updateStockProduct($stock-$quantity,$productid);
				$this->response(array('status'=>'success','result'=>$id),200);
				
			}
			else{
				$this->response(array('status'=>'failed','result'=>$id,'error'=>"Gagal memasukkan data"),200);
			}
		}
	}
	
	public function transaction_undef_buy_post(){
		
		$userid=$this->post("userid");
		$productid=$this->post("productid");
		$quantity=$this->post("quantity");
		$product=$this->product_master->getProduct($productid);
		
		$stock=$product->stock;
		$type=$product->r_type;
		$status='';
		if($type=='PO')
			$status="PO";
		else 
			$status='Pending';
		
		if($stock<$quantity){
			$this->response(array('status'=>'failed','result'=>0,'error'=>"Stock tidak mencukupi"),200);
		}
		else{
			$price=$this->product_master->getPriceGrosir($productid);
			$id=$this->transaction->insertTransaction($userid,$productid,$price,$quantity,$status);
			if($id!=0){
				$this->product_master->updateStockProduct($stock-$quantity,$productid);
				$this->response(array('status'=>'success','result'=>$id),200);
				
			}
			else{
				$this->response(array('status'=>'failed','result'=>$id,'error'=>"Gagal memasukkan data"),200);
			}
		}
	}


	public function product_id_get($id){
		
		$product=$this->product_master->getProductById($id);
		if($product){
			$this->response(array('status'=>'success','result'=>$product),200);
		}
		else{
			$this->response(array('status'=>'failed','result'=>null),200);
		}
		
	}
	
	
	public function transaction_po_buy_post(){
		
		$userid=$this->post("userid");
		$productid=$this->post("productid");
		$quantity=$this->post("quantity");
		$stock=$this->product_master->getStock($productid);
		$status="PO";
		if($stock<$quantity){
			$this->response(array('status'=>'failed','result'=>0,'error'=>"Stock tidak mencukupi"),200);
		}
		else{
			$price=$this->product_master->getPriceGrosir($productid);
			$id=$this->transaction->insertTransaction($userid,$productid,$price,$quantity,$status);
			if($id!=0){
				$this->product_master->updateStockProduct($stock-$quantity,$productid);
				$this->response(array('status'=>'success','result'=>$id),200);
				
			}
			else{
				$this->response(array('status'=>'failed','result'=>$id,'error'=>"Gagal memasukkan data"),200);
			}
		}
	}

	public function update_tr_post(){
		if($this->post('s')!=null&&$this->post('id')!=null){
			$status=$this->post('s');
			$transactionid=$this->post('id');
			
			if($this->transaction->updateStatus($status,$transactionid)){
				if($status=='Reject'){
					$transaction=$this->transaction->getTransactionById($transactionid);
					$stock=$this->product_master->getStock($transaction->productid);
					$this->product_master->updateStockProduct($stock+$transaction->quantity,$transaction->productid);
					
				}
				$this->response(array('status'=>'success','result'=>$status),200);
			}
			else{
				$this->response(array('status'=>'failed'),200);
			}
		
		}
		else{
			$this->response(null,404);
		}
		
	}

	/* Transactions_Function_End */

	public function date_get(){
		
		$date = new DateTime($this->transaction->getDate());
		$transactiondate=$date->format('Y-m-dH:i:s');
		$this->response(array('status'=>'success','result'=>$transactiondate),200);	
	}

	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */