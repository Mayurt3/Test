<?php 

require_once('include/db.php'); 
	
if (isset($_GET['del_id'])) {
	echo 'Do you really want to delete product with ID of ' . $_GET['del_id'] . '? <a href="delet_php.php?yesdelete=' . $_GET['del_id'] . '">Yes</a> | <a href="delet_php.php">No</a>';
	exit();
}
if (isset($_GET['yesdelete']))
	{
	$id_to_delete = $_GET['yesdelete'];
	$sql = "DELETE FROM products WHERE id='$id_to_delete' LIMIT 1" or die (mysql_error());
	$run_sql = mysqli_query($conn,$sql);
	
	
	$img_sql = "SELECT * FROM `products` WHERE id='$id_to_delete'";
	$run_img= mysqli_query($conn,$img_sql);
	while($row = mysqli_fetch_assoc($run_img))
	{
	 $pictodelete = $row=["thumb"];
   
    }
	 if (file_exists($pictodelete)) {
       		    unlink($pictodelete);
		
	}
	header("location: view_record.php"); 
    exit();
}
?>