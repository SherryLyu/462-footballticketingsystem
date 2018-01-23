<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['searchby']) ||
		empty($_POST['value']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$searchby = $_POST['searchby'];
	$value = $_POST['value'];
	$query = "SELECT u.UId FROM User u, UserType ut WHERE u.UTId = ut.UTId AND Email != 'admin@clemson.edu' AND " . $searchby . " = '" . $value . "'";
	$result = mysql_query($query, $con);
	if(mysql_num_rows($result) == 0){
		$response['msg'] = "There is no such user";
		echo json_encode($response);
	}else if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_assoc($result);
		$response['msg'] = "success";
		$response['alluid'] = $row['UId'];
		echo json_encode($response);
		mysql_close($con);
	}else{
		$alluid = array();
		while($row = mysql_fetch_assoc($result)){
			array_push($alluid, $row['UId']);
		}
		$response['msg'] = "success";
		$response['alluid'] = $alluid;
		echo json_encode($response);
		mysql_close($con);
	}
?>