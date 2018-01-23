<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['game']) ||
		empty($_POST['section']) ||
		empty($_POST['type']) ||
		empty($_POST['amount']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$game = $_POST['game'];
	$section = $_POST['section'];
	$type = $_POST['type'];
	$amount = $_POST['amount'];
	
	$query = "SELECT d.Price FROM Detail d JOIN Stock s ON d.SSId = s.SSId WHERE GId = $game AND SId = $section AND UTId = $type";
	$result = mysql_query($query, $con);
	$price = mysql_fetch_assoc($result);
	$cost = (int)$price['Price'] * (int)$amount;  
	$response['cost'] = $cost;
	echo json_encode($response);
	mysql_close($con);
	return true; 
?>