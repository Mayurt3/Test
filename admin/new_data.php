<?php
require_once('include/db.php'); 

include('admin_navigation_bar.php');

session_start();

if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); 
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); 
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);

$sql = "SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1";
$run_sql = mysqli_query($conn,$sql);

if (mysqli_num_rows($run_sql) == 0) {
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
if (isset($_GET['deleteid'])) {
	echo 'Do you really want to delete product with ID of ' . $_GET['deleteid'] . '? <a href="inventory_list.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | <a href="inventory_list.php">No</a>';
	exit();
}
if (isset($_GET['yesdelete'])) {
	$id_to_delete = $_GET['yesdelete'];
	$sql = "DELETE FROM products WHERE id='$id_to_delete' LIMIT 1" or die (mysql_error());
	$run_sql = mysqli_query($conn,$sql);
    $pictodelete = ("prod-img/$id_to_delete.jpg");
    if (file_exists($pictodelete)) {
       		    unlink($pictodelete);
    }
	header("location: new_data.php"); 
    exit();
}
?>
<script type="text/javascript" language="javascript"> 
<!--
function validateMyForm ( ) { 
    var isValid = true;
    if ( document.myForm.product_name.value == "" ) { 
	    alert ( "Please type Product Name" ); 
	    isValid = false;
    } else if ( document.myForm.price.value == "" ) { 
            alert ( "Please enter price" ); 
            isValid = false;
    } else if ( document.myForm.details.value == "" ) { 
            alert ( "Please provide details" ); 
            isValid = false;
    } else if ( document.myForm.fileField.value == "" ) { 
            alert ( "Please provide picture" ); 
            isValid = false;
    }
    return isValid;
}
//-->
</script>
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
if (isset($_POST['product_name'])) {
	
    $product_name = $_POST['product_name'];
	$price = $_POST['price'];
	$category = $_POST['category'];
	$subcategory = $_POST['subcategory'];
	$details = $_POST['details'];
	$sql = "SELECT id FROM products WHERE product_name='$product_name' LIMIT 1";
	$run_sql = mysqli_query($conn,$sql);
	
 
    if (mysqli_num_rows($run_sql) > 0)
	{
		echo 'Sorry you tried to place a duplicate "Product Name" into the system, <a href="inventory_list.php">click here</a>';
		exit();
	}
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
	$sql = "INSERT INTO products (product_name, price, details,thumb,category, subcategory,date_added) 
        VALUES('$product_name','$price','$details','$sql_img','$category','$subcategory',now())" or die (mysql_error());
	$run_sql = mysqli_query($conn,$sql);
	
	header("location: new_data.php"); 
    exit();
	}
	else
	{
		
	}
	}
	
	
}
?>
<?php 
$product_list = "";
$sql = "SELECT * FROM products ORDER BY date_added DESC";
$run_sql = mysqli_query($conn,$sql);
 
if (mysqli_num_rows($run_sql) > 0) {
	while($row = mysqli_fetch_array($run_sql)){ 
             $id = $row["id"];
			 $product_name = $row["product_name"];
			 $price = $row["price"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			 $product_list .= "Product ID: $id - <strong>$product_name</strong> - $$price - <em>Added $date_added</em> &nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='inventory_list.php?deleteid=$id'>delete</a><br />";
    }
} else {
	$product_list = "You have no products listed in your store yet";
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
		<div class="col-lg-8">
			<div class="col-md-4">
			<div style="width:50px;height:50px;"></div>
				<div class="container">
		<h1>Add New Product</h1>
		<form class="form-horizontal" action="new_data.php" role="form" method="post">
		
			<div class="form-group">
				<label for="name" class="control-label col-sm-2">Product Name</label>
				<div class="col-sm-5">
					<input type="text" id="product_name" class="form-control" value="" name="product_name"  required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="control-label col-sm-2">Product Price</label>
				<div class="col-sm-5">
					<input type="text" id="price" class="form-control" value="" name="price" required>
				</div>
			</div>
				
			<div class="form-group">
				<label for="country" class="control-label col-sm-2">Category</label>
				<div class="col-sm-2">
					<select class="form-control" id="category" name="category" required>
					<option value="">Select Category</option>
					<option value="Footwear">Footwear</option>
					<option value="Clothing">Clothing</option>
					<option value="Watches">Watches</option>
					<option value="HandBag">HandBag</option>
					<option value="Perfumes">Perfumes</option>
					<option value="Jewellery">Jewellery</option>
					<option value="Sunglasses">Sunglasses</option>
					<option value="EBooks">EBooks</option>
					<option value="DVD">DVD's</option>
					<option value="Gaming">Gaming</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="country" class="control-label col-sm-2">Subcategory</label>
				<div class="col-sm-2">
					<select class="form-control" name="subcategory" id="subcategory">
					<option value="">Select Subcategory</option>
					<option value="Hats">Hats</option>
					<option value="Pants">Pants</option>
					<option value="Shirts">Shirts</option>
					</select>
				</div>
			</div>
			

			<div class="form-group">
				<label class="control-label col-sm-2">Product Details</label>
				<div class="col-sm-5">
					<textarea class="form-control my-fixed" id="details" name="details" value="" rows="5"></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2">Product Image</label>
				<div class="col-sm-5">
					<input type="file" name="fileField" id="fileField" />
				</div>
			</div>
			
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
		<?php include_once("admin_footer.php");?>
	</body>
</html>