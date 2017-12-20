<?php require_once('include/db.php'); 
session_start();
include('admin_navigation_bar.php');

	if (!isset($_SESSION["manager"]))
	{
    header("location:admin_login.php"); 
    exit();
	}
	
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); 
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); 
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);

$sql = "SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1";
$run_sql = mysqli_query($conn,$sql);


	
	if(mysqli_num_rows($run_sql) == 0)
	{
		 echo "Your login session data is not on record in the database.";
     exit();
	}

?>
<!DOCTYOE HTML>
<html>
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="includes/bootstrap/css/bootstrap.css">
		<script src="includes/jquery/jquery-3.2.1.min.js"></script>
		<script src="includes/bootstrap/js/bootstrap.js"></script>
		

		
	</head>
	<body>
<?php include"side_bar.php"?>
		<div class="col-lg-8">
			<div class="col-md-4">
			<div style="width:50px;height:50px;"></div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size:4.5em"></i></div>
							<div class="col-xs-9 text-right">
								<div style="font-size:2.5em">20</div>
								<div>Posts</div>
							</div>
						</div>
						
					</div>
					<a href="#">
						<div class="panel-footer">
							<div class="pull-left">View Posts</div>
							<div class="pull-right"><i class="glyphicon glyphicon-circle-arrow-left"></i></div>
							<div class="clearfix"></div>
						</div>
					</a>
					
				</div>
			</div>
		</div>
		<?php include_once("admin_footer.php");?>
	</body>
</html>