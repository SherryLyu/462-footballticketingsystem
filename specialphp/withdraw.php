<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['withdraw']) ||
		empty($_POST['email']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$withdraw = $_POST['withdraw'];
	$email = $_POST['email'];
	$query = "SELECT Balance FROM User WHERE Email = '$email'";
	$result = mysql_query($query, $con);
	if($row = mysql_fetch_assoc($result)){
		if((int)$row['Balance'] - $withdraw < 0){
			$response['msg'] = "error";
			$response['newbalance'] = (int)$row['Balance'];
			echo json_encode($response);
			mysql_close($con);
		}else{
			$query_1 = "UPDATE User SET Balance = Balance - '$withdraw' WHERE Email = '$email'";
			$result_1 = mysql_query($query_1, $con);
			$response['msg'] = "success";
			$response['newbalance'] = (int)$row['Balance'] - $withdraw;
			echo json_encode($response);
			mysql_close($con);
		}
	}
?>