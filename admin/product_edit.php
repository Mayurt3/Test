<?php
require_once('include/db.php'); 

include('admin_navigation_bar.php');

session_start();
?>

<?php 
function GetImageExtension($imagetype)
   	 {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case 'image/bmp': return '.bmp';
           case 'image/gif': return '.gif';
           case 'image/jpeg': return '.jpg';
           case 'image/png': return '.png';
           default: return false;
       }
     }
	 
if (isset($_POST['submit']))
	{
	
	$pid =	$_SESSION["userid"];
    $product_name = $_POST['product_name'];
	$price =$_POST['price'];
	$category = $_POST['category'];
	$subcategory = $_POST['subcategory'];
	$details = $_POST['details'];

	
	$sql = "UPDATE products SET product_name='$product_name', price='$price', details='$details', category='$category', subcategory='$subcategory' WHERE id='$pid'";
	$run_sql = mysqli_query($conn,$sql);
	
	if ($_FILES['fileField']['tmp_name'] != "") 
	{
	$file_name=$_FILES["fileField"]["name"];
	$temp_name=$_FILES["fileField"]["tmp_name"];
	$imgtype=$_FILES["fileField"]["type"];
	$ext= GetImageExtension($imgtype);
	$imagename=date("d-m-Y")."-".time().$ext;
	$target_path = "../prod-img/".$imagename;
	$sql_img =  "prod-img/".$imagename;
	if(move_uploaded_file($temp_name, $target_path)) 
	{
		$sql = "UPDATE products SET thumb='$sql_img' WHERE id='$pid'";
	$run_sql = mysqli_query($conn,$sql);
	}
	 
	}
	header("location: view_record.php"); 
    exit();
}
?>
<!DOCTYOE HTML>
<html>
	<head>
		<title>Add DAta</title>
		<link rel="stylesheet" href="includes/bootstrap/css/bootstrap.css">
		<script src="includes/jquery/jquery-3.2.1.min.js"></script>
		<script src="includes/bootstrap/js/bootstrap.js"></script>
		

		
	</head>
	<body>
<?php include"side_bar.php"?>
		<div class="col-lg-6">
		
			<div class="col-md-4">
			<div style="width:50px;height:50px;"></div>
			
			
				<div class="container">
				
				 <h1>Edit Product</h1>
		<form class="form-horizontal" action="product_edit.php" role="form" method="post">
		<?php
		
		if(isset($_GET['user_id']))
				{
					
				$userid = $_GET['user_id'];
				$_SESSION["userid"] = $userid;
				
				$sql = "SELECT * FROM products WHERE id ='$_GET[user_id]'";
				$run = mysqli_query($conn,$sql);
				while($rows = mysqli_fetch_assoc($run)){
				echo '
								
				
				<div class="form-group">
					<label for="name" class="control-label col-sm-2">Product Name</label>
					<div class="col-sm-5">
					<input type="text" id="product_name" class="form-control" value="'.$rows['product_name'].'" name="product_name" required>
					</div>
				</div>
				
				<div class="form-group">
					<label for="name" class="control-label col-sm-2">Product Price</label>
					<div class="col-sm-5">
					<input type="text" id="price" class="form-control" value="'.$rows['price'].'" name="price" required>
					</div>
				</div>
				
				<div class="form-group">
				<label for="category" class="control-label col-sm-2">Category</label>
				<div class="col-sm-2">
					<select class="form-control" id="category" value="'.$rows['category'].'" name="category" required>
					';
					if($rows['category'] == NULL)
					{
						echo '<option value="">Select Category</option>';
					}
					else
					{
						echo '<option value="'.$rows['category'].'">'.$rows['category'].'</option>';
					}
					echo'
					<option value="Footwear">Footwear</option>
					<option value="Clothing">Clothing</option>
					<option value="Watches">Watches</option>
					<option value="HandBag">HandBag</option>
					<option value="Perfumes">Perfumes</option>
					<option value="Jewellery">Jewellery</option>
					<option value="Sunglasses">Sunglasses</option>
					<option value="EBooks">EBooks</option>
					<option value="DVD">DVDs</option>
					<option value="Gaming">Gaming</option>
					</select>
				</div>
				</div>
				
				<div class="form-group">
				<label for="subcategory" class="control-label col-sm-2">Subcategory</label>
				<div class="col-sm-2">
					<select class="form-control" name="subcategory" value="'.$rows['subcategory'].'" id="subcategory">';
					if($rows['category'] == NULL)
					{
						echo '<option value="">Select Subategory</option>';
					}
					else
					{
						echo '<option value="'.$rows['subcategory'].'">'.$rows['subcategory'].'</option>';
					}
					
					echo'<option value="Hats">Hats</option>
					<option value="Pants">Pants</option>
					<option value="Shirts">Shirts</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2">Product Details</label>
				<div class="col-sm-5">
					<textarea class="form-control my-fixed" id="details" name="details" rows="5">'.$rows['details'].'</textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2">Product Image</label>
				<div class="col-sm-5">
					<input type="file" name="fileField" id="fileField" />
				</div>
			</div>
			
			
			
				';
				
					
					
				}
				}
		
		?>
			
			
			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="col-sm-5">
					
					<input type="submit" class="btn btn-default btn-block" name="submit" value="Submit form">
				</div>				
			</div>
		</form>
				</div>
			</div>
		</div>
		<aside class="col-lg-4">
			<div class="col-md-8">
		<div style="width:50px;height:50px;"></div>
		
		<?php
		
			if(isset($_GET['user_id']))
				{
					
					
				$sql = "SELECT * FROM products WHERE id ='$_GET[user_id]'";
				$run = mysqli_query($conn,$sql);
				while($rows = mysqli_fetch_assoc($run)){
					
					$img = $rows['thumb'];
					$new = substr($img,9,200);
					
				echo '
				<div class="thumbnail">
						
						<img src="../prod-img/'.$new.'" alt="../prod-img/'.$new.'" height="42" width="42">
				</div>
				';
				}
				}
				?>
				</div>
				
				
		</aside>
			<?php include_once("admin_footer.php");?>
	</body>
</html>