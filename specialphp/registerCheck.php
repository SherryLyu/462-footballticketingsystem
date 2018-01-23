<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['firstname'])      ||
	   empty($_POST['lastname'])     ||
	   empty($_POST['username'])     ||
	   empty($_POST['password'])   ||
	   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
	   {
		   echo "No arguments Provided!";
		   return false;
	   }

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$firstname = addslashes($_POST['firstname']);
	$lastname = addslashes($_POST['lastname']);
	$email = $_POST['email'];
	$username = addslashes($_POST['username']);
	$password = addslashes($_POST['password']);
	$usertype = $_POST['usertype'];

	$query = "SELECT * FROM User WHERE Email = '$email'";
	$result = mysql_query($query, $con);
	$count = mysql_num_rows($result);
	if($count == 0){
		$query_2 = "INSERT INTO `User`(`Firstname`, `Lastname`, `Username`, `UTId`, `Email`, `Password`, `Balance`) VALUES ('$firstname','$lastname','$username','$usertype','$email', '$password', 0)";
		$result_2 = mysql_query($query_2, $con)
			or die("Error: ".mysql_error());
		if($result_2 == true){
			$response['status'] = 'success';  
			echo json_encode($response);
			mysql_close($con);
			return true;
		}
	}else{
		$response['status'] = 'error';  
		$response['message'] = "Email exist! Change one please or go to login directly:)";
		echo json_encode($response);
	}
	mysql_close($con);
	return false;  
?>