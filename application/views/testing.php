<html>
	<head>
		<script src="<?php echo base_url('js/jquery-2.1.1.min.js') ?>"></script>
			<script>
		$(document).ready(function(){
			var data=[{
					"productdetailid":1,
					"jumlah":2
				},
				{
					"productdetailid":2,
					"jumlah":2
				}];
			$("#testingPost").click(function(){

				var request=$.ajax({
				data:{	"userid":1,
				"alamat":"testing",
				"telepon":"083897658595",
				"data":JSON.stringify(data)},
				dataType:"JSON",
				type:"POST",
				url:"http://localhost/store/index.php/services/transactions_check_out/"
				});
				request.done(function(result){
					console.log(result);
				}).fail(function(result){
					console.log(result);
				});


				return false;
			});
		});
			
		</script>
	</head>
	<body>

		<button id="testingPost" >POST</button>
		<form enctype="multipart/form-data" action="http://10.22.70.14/Store/index.php/services/product_image_upload" method="POST">
			<input type="hidden" value="2" name="productid" />
			<input type="file" name="userfile" />
			<input type="submit" />
		</form>
	</body>
</html>