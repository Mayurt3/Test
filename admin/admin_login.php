<?php 
session_start();
require_once('include/db.php'); 
include('admin_navigation_bar.php');
if (isset($_SESSION["manager"])) {
    header("location: index.php"); 
    exit();
}


?>
<?php 
if (isset($_POST["username"]) && isset($_POST["password"])) {

	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]);
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);


    $sql = "SELECT id FROM admin WHERE username='$manager' AND password='$password' LIMIT 1"; 
	$run_sql = mysqli_query($conn,$sql);
	
	//if(mysqli_error($conn)) exit($run_sql.'<br>'.mysqli_error($conn)); 
	
	if(mysqli_num_rows($run_sql) == 1)
	{
		 while($row = mysqli_fetch_assoc($run_sql))
		 { 
             $id = $row["id"];
		 }
		 $_SESSION["id"] = $id;
		 $_SESSION["manager"] = $manager;
		 $_SESSION["password"] = $password;
		 
		  header("location:index.php");
         exit();
	}
	else {
		echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
		exit();
	}
	    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Log In </title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
 
  <div id="pageContent"><br />
    <div align="center" style="margin-center:24px;">
	<div style="width:50px;height:50px;"></div>
      <h2>Please Log In To Manage the Store</h2>
      <form id="form1" name="form1" method="post" action="admin_login.php">
        User Name:<br />
          <input name="username" align="left" type="text" id="username" size="40" />
        <br /><br />
        Password:<br />
       <input name="password" type="password" id="password" size="40" />
       <br />
       <br />
       <br />
       
         <input type="submit" name="button" id="button" value="Log In" />
       
      </form>
      <p>&nbsp; </p>
    </div>
    <br />
  <br />
  <br />
  </div>
  <?php include_once("admin_footer.php");?>
</div>
</body>
</html>