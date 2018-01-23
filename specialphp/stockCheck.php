<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['game']) ||
		empty($_POST['section']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$game = $_POST['game'];
	$section = $_POST['section'];
	
	$query = "SELECT Stock FROM Stock WHERE GId = $game AND SId = $section";
	$result = mysql_query($query, $con);
	$stock = mysql_fetch_assoc($result);
	$response['status'] = 'success';  
	$response['message'] = strval($stock['Stock']);
	echo json_encode($response);
	mysql_close($con);
	return true; 
?>