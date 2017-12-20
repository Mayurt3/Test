<?php session_start();
require_once('include/db.php');

include('navigation_bar.php');
include('header.php');

	if (isset($_GET['success'])){
			//echo "Successful Registration.";
	}
  	if (isset($_GET['userloginsuccess'])){
			//echo "Successful Login.";
	}
	if (isset($_GET['resetsuccess'])){
			//echo "Password Successfully Changed.";
	}
$limit = 4;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

$sql = "SELECT * FROM products ORDER BY id ASC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($conn, $sql); 

?>
<html>
<head>
<!-- // Header -->
<div class="container">
<?php if(isset($_GET['status']) & !empty($_GET['status'])){ 
			if($_GET['status'] == 'success'){
				echo "<div class=\"alert alert-success\" role=\"alert\">Item Successfully Added to Cart</div>";
			}elseif ($_GET['status'] == 'incart') {
				echo "<div class=\"alert alert-info\" role=\"alert\">Item is Already Exists in Cart</div>";
			}elseif ($_GET['status'] == 'failed') {
				echo "<div class=\"alert alert-danger\" role=\"alert\">Failed to Add item, try to Add Again</div>";
			}
	}
?>
<!-- // Main Page -->
  <div class="row">
	<?php 
	
	
	while($item = mysqli_fetch_assoc($rs_result)){ ?>
	  <div class="col-md-4">
	
	    <div class="thumbnail">
	      <img src="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title'] ?>">
	      <div class="caption">
	        <h3><?php echo $item['product_name'] ?></h3>
			 <p>Rs.<?php echo $item['price'] ?></p>
	        <p><?php echo $item['details'] ?></p>
			<?php
			if(isset($_SESSION['user']))
			{
			?>
           <div class="overlay-content">
                                       
             <p><a href="addtocart.php?id=<?php echo $item['id']; ?>" class="btn btn-primary" role="button">Add to Cart</a></p>
             </div>
		<?php } ?>
	        
	      </div>
	    </div>
	  </div>
	  </div>
	  </div>
	<?php } ?>
	
		<div class="container">
		<div class="pagination pagination-centered">
		<?php  
	
        $sql = "SELECT COUNT(id) FROM products";  
        $rs_result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_row($rs_result);  
        $total_records = $row[0];  
        $total_pages = ceil($total_records / $limit);  
        $pagLink = "<nav><ul class='pagination'>";  
        for ($i=1; $i<=$total_pages; $i++) {  
                     $pagLink .= "<li><a href='index.php?page=".$i."'>".$i."</a></li>";  
        };  
        echo $pagLink . "</ul></nav>";  
        ?>
		</div>
		</div>


<?php include('footer.php');?>

       
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
$('.pagination').pagination({
        items: <?php echo $total_records;?>,
        itemsOnPage: <?php echo $limit;?>,
        cssStyle: 'light-theme',
		currentPage : <?php echo $page;?>,
		hrefTextPrefix : 'index.php?page='
    });
	});
</script>