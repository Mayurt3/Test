<?php session_start();
require_once('include/db.php');

include('navigation_bar.php');
include('header.php');
$match = '';
$reg_suc ='';
$email = '';

	if(isset($_POST['submit']))
	{
	$name = $_POST['name'];
	$username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];	
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$pin = $_POST['pin'];
	$confirmation_code = md5( rand(0,1000) );
	
	if($password != $cpassword){
		//$reg_suc ='<div class="alert alert-danger">Your passwords do not match.</div>';
		echo 'Your passwords do not match., <a href="register_user.php">Refill here</a>';
		exit();
	}
	$check_mobile = "SELECT id FROM customer WHERE mobile='$mobile' LIMIT 1";
	$userMatch = mysqli_query($conn, $check_mobile);
	//$userMatch = mysqli_num_rows($check_mobile); 
	if (mysqli_num_rows($userMatch) > 0) {
		//$reg_suc ='<div class="alert alert-danger">Sorry your mobile number is already registered into the system</div>';
		echo 'Sorry your mobile number is already registered into the system, <a href="register_user.php">click here</a>';
		exit();
	}
	
	$check_email = "SELECT id FROM customer WHERE email='$email' LIMIT 1";
	$emailcheck = mysqli_query($conn, $check_email);
	//$userMatch = mysqli_num_rows($check_mobile); 
	if (mysqli_num_rows($emailcheck) > 0) {
		//$reg_suc ='<div class="alert alert-danger">Sorry your mobile number is already registered into the system</div>';
		echo 'Sorry your Email is already registered into the system, <a href="register_user.php">click here</a>';
		exit();
	}
	$sql = "INSERT INTO `customer`(`login`, `password`, `name`,`mobile`, `email`, `address`, `city`, `state`, `pin`, `confirmation_code`, `active`) VALUES ('$username','$password','$name','$mobile','$email','$address','$city','$state','$pin','$confirmation_code','')";
			if (mysqli_query($conn, $sql))
				{
	
					$headers =  'MIME-Version: 1.0' . "\r\n"; 
					$headers .= 'From: Mayur Talsania <info@sevenstore.com>' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	
					$_SESSION['active'] = 0; //0 until user activates their account with verify.php
					$_SESSION['logged_in'] = true; // So we know the user has logged in
					$_SESSION['message'] =
                
					"Confirmation link has been sent to $email, please verify
					your account by clicking on the link in the message!";

					// Send registration confirmation link (verify.php)
					$to      = $email;
					$subject = 'Account Verification ( sevenstore.com )';
					$message_body = '
					Hello '.$name.',

					Thank you for signing up!

					Please click this link to activate your account:
		
					http://localhost/Mywebsite/verify.php?email='.$email.'&confirmation_code='.$confirmation_code. '&username='.$name;  

					mail( $to, $subject, $message_body ,$headers);
			
					$reg_suc ='<div class="alert alert-success">Please Check Your Email Address We Sent Your Confirmation mail</div>';
					
					
		
				}
				else 
				{
				//$_SESSION['message'] = 'Registration failed!';
				$reg_suc ='<div class="alert alert-danger">Registration failed!</div>';
			
				}
		
			
	
	//$sql = "INSERT INTO users (first_name, last_name, email, password, confirmation_code,active) VALUES ('$first_name','$last_name','$email','$password', '$confirmation_code','')";
	
	}
	/*
			
			
			if($_POST['password'] == $_POST['c_password'])
		{
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['first_name'] = $_POST['first_name'];
			$_SESSION['last_name'] = $_POST['last_name'];
	
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$confirmation_code = md5( rand(0,1000) );
	
	
			$result = "SELECT * FROM users WHERE email='$email'";
			$run_sql = mysqli_query($conn, $result);
		if (mysqli_num_rows($run_sql) > 0) 
			{
            // output data of each row
				$row = mysqli_fetch_assoc($run_sql);
           
				if($email==$row['email'])
					{
					$reg_suc ='<div class="alert alert-success">User with this email already exists!</div>';
					}
			}	
		else 
			{ // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
			$sql = "INSERT INTO users (first_name, last_name, email, password, confirmation_code,active) VALUES ('$first_name','$last_name','$email','$password', '$confirmation_code','')";
			$username = $first_name.''.$last_name;
	
    // Add user to the database
			if (mysqli_query($conn, $sql))
				{
	
					$headers =  'MIME-Version: 1.0' . "\r\n"; 
					$headers .= 'From: Mayur Talsania <info@sevenstore.com>' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	
					$_SESSION['active'] = 0; //0 until user activates their account with verify.php
					$_SESSION['logged_in'] = true; // So we know the user has logged in
					$_SESSION['message'] =
                
					"Confirmation link has been sent to $email, please verify
					your account by clicking on the link in the message!";

					// Send registration confirmation link (verify.php)
					$to      = $email;
					$subject = 'Account Verification ( sevenstore.com )';
					$message_body = '
					Hello '.$first_name.',

					Thank you for signing up!

					Please click this link to activate your account:
		
					http://localhost/Mywebsite/verify.php?email='.$email.'&confirmation_code='.$confirmation_code. '&username='.$username;  

					mail( $to, $subject, $message_body ,$headers);
	
					
				
					$reg_suc ='<div class="alert alert-success">Please Check Your Email Address We Sent Your Confirmation mail</div>';
			
		//echo "Please Check You Email";
				}

			else 
				{
				//$_SESSION['message'] = 'Registration failed!';
				$reg_suc ='<div class="alert alert-danger">Registration failed!</div>';
			
				}
		
			}
		}
		else
		{
			$match = '<div class="alert alert-danger">Password Doesn&apos;t match!</div>';
		}
		
	
	}*/

?>
<html>
<head>

<div class="container">
					
				<div class="page-header">
					<h2>Registration Form</h2>
					<?php echo $match;
						echo $reg_suc;
						
					?>
				</div>
						
			<form class="form-horizontal" name="userForm" id="userForm" action="register_user.php" role="form" method="post">
		
			<div class="form-group">
				<label for="fname" class="col-sm-2 control-label">Full Name</label>
				<div class="col-sm-3">
					<input type="text" id="name" class="form-control" name="name"  placeholder="Type Your Full Name" required >
				</div>
			</div>
			
			<div class="form-group">
				<label for="lname" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-3">
					<input type="text" id="username" class="form-control" name="username" placeholder="Type Your Username" required>
				</div>
			</div>		
						
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label ">Password</label>
				<div class="col-sm-3">
					<input type="password" id="password" class="form-control" name="password" placeholder="Type Your Password" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="con_password" class="col-sm-2 control-label " required>Confirm Password</label>
				<div class="col-sm-3">
					<input type="password" id="cpassword" class="form-control" name="cpassword" placeholder="Type Your Confirm Password">
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">Mobile</label>
				<div class="col-sm-3">
					<input type="text" id="mobile" class="form-control" name="mobile" placeholder="Type Your Address" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">E-mail Address</label>
				<div class="col-sm-3">
					<input type="email" id="email" class="form-control" name="email" placeholder="Type Your Address" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">Address</label>
				<div class="col-sm-3">
					 <textarea name="address" class="form-control" id="address" cols="64" rows="5"></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">City</label>
				<div class="col-sm-3">
					<input type="text" id="city" class="form-control" name="city" placeholder="Type Your Address" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">State</label>
				<div class="col-sm-3">
					<input type="text" id="state" class="form-control" name="state" placeholder="Type Your Address" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label ">Pin</label>
				<div class="col-sm-3">
					<input type="text" id="pin" class="form-control" name="pin" placeholder="Type Your Address" required>
				</div>
			</div>
			
			
		
			<div class="form-group">
				<label class="col-sm-2 control-label "></label>
				<div class="col-sm-3">
					<input type="submit" value="Sign Up" name="submit" id="submit" class="btn btn-block btn-danger">
				</div>				
			</div>
			
			</form>
		</div>
		</div>
<?php include('footer.php');?>
</body>
</html>
<script type="text/javascript" language="javascript"> 
<!--
function validateMyForm ( ) { 
    var isValid = true;
    if ( document.userForm.name.value == "" ) { 
	    alert ( "Please type Your Name" ); 
	    isValid = false;
    } else if ( document.userForm.login.value == "" ) { 
	    alert ( "Please type Your Login Name" ); 
	    isValid = false;
    } else if ( document.userForm.password.value == "" ) { 
	    alert ( "Please type Your Password" ); 
	    isValid = false;
    } else if ( document.userForm.cpassword.value == "" ) { 
	    alert ( "Please confirm Your Password" ); 
	    isValid = false;
    } else if ( document.userForm.security.value == "" ) { 
	    alert ( "Please select security question" ); 
	    isValid = false;
    } else if ( document.userForm.answer.value == "" ) { 
	    alert ( "Please select security question answer" ); 
	    isValid = false;
    } else if ( document.userForm.mobile.value == "" ) { 
            alert ( "Please enter your Mobile Number" ); 
            isValid = false;
    } else if ( document.userForm.email.value == "" ) { 
            alert ( "Please provide your Email" ); 
            isValid = false;
    } else if ( document.userForm.address.value == "" ) { 
            alert ( "Please provide your address" ); 
            isValid = false;
    } else if ( document.userForm.city.value == "" ) { 
            alert ( "Please provide your city" ); 
            isValid = false;
    } else if ( document.userForm.state.value == "" ) { 
            alert ( "Please provide your state" ); 
            isValid = false;
    } else if ( document.userForm.pin.value == "" ) { 
            alert ( "Please provide your pin" ); 
            isValid = false;
    }
    return isValid;
}
//-->
</script>