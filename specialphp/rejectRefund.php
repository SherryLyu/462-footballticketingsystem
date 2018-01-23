<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['tid']))
	{
	   echo "No arguments Provided!";
	   return false;
	}
	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$tid = $_POST['tid'];
	$currentPath = getcwd();
	$bigPath = explode("specialphp", $currentPath);
	$oldname = $bigPath[0]."/userrequest/".$tid;
	$newname = $bigPath[0]."/userrequest/reject".$tid;
	$result = rename($oldname, $newname);
	if($result){
		$response['msg'] = "success";
		echo json_encode($response);
		mysql_close($con);
		return true;
	}else{
		$response['msg'] = "error";
		echo json_encode($response);
		mysql_close($con);
		return false;
	}
	
?>