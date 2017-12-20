<?php
require_once('include/db.php'); 

include('admin_navigation_bar.php');

session_start();
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
			<table class="table table-striped">
			<thead >
				<center>
			
				<th>Product Name</th>
				<th>Price</th>
				<th>Details</th>
				<th>Data Added</th>
				<th>Category</th>
				<th>Subategory</th>
				<th>Edit</th>
				<th>Delete</th>
				</center>
			</thead>
			<tbody>
	<?php
		$sql = "SELECT * FROM products ";
		$run_sql = mysqli_query($conn,$sql);
		while($rows = mysqli_fetch_array($run_sql)){
			echo '
				<tr>
				
					<td>'.$rows['product_name'].'</td>
					<td>Rs.'.$rows['price'].'</td>
					<td>'.$rows['details'].'</td>
					<td>'.$rows['date_added'].'</td>
					<td>'.$rows['category'].'</td>
					<td>'.$rows['subcategory'].'</td>
					
					';
					
					echo '<td><a class="btn btn-info btn-xs" href="product_edit.php?user_id='.$rows['id'].'">Edit</a></td>
					<td><a class="btn btn-danger btn-xs" href="delet_php.php?del_id='.$rows['id'].'">Delete</a></td>
				</tr>
			';
		}
	?>		</tbody>
	</table>
	
				</div>
			</div>
		</div>
		
			<?php include_once("admin_footer.php");?>
	</body>
</html>