<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['deposit']) ||
		empty($_POST['email']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$deposit = $_POST['deposit'];
	$email = $_POST['email'];
	$query = "UPDATE User SET Balance = Balance + '$deposit' WHERE Email = '$email'";
	$result = mysql_query($query, $con);
	$query_1 = "SELECT Balance FROM User WHERE Email = '$email'";
	$result_1 = mysql_query($query_1, $con);
	$row = mysql_fetch_assoc($result_1);
	$response['msg'] = "success";
	$response['newbalance'] = (int)$row['Balance'];
	echo json_encode($response);
	mysql_close($con);
	return true;
?>