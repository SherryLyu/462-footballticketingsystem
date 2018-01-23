<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['game']) ||
		empty($_POST['section']) ||
		empty($_POST['type']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$game = $_POST['game'];
	$section = $_POST['section'];
	$type = $_POST['type'];
	
	$query = "SELECT SSId FROM Stock WHERE GId = $game AND SId = $section";
	$result = mysql_query($query, $con);
	$section = mysql_fetch_assoc($result);
	$ssid = $section['SSId'];
	$query_1 = "SELECT Price FROM Detail WHERE SSId = $ssid AND UTId = $type";
	$result_1 = mysql_query($query_1, $con);
	$price = mysql_fetch_assoc($result_1);
	$response['status'] = 'success';  
	$response['message'] = strval($price['Price']);
	echo json_encode($response);
	mysql_close($con);
	return true; 
?>