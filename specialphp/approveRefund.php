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
	$query_1 = "SELECT t.UId, d.SSId, t.Amount, d.Price FROM Ticket t, Detail d WHERE d.DId = t.DId AND t.TId = '$tid'";
	$result_1 = mysql_query($query_1, $con);
	if($result_1){
		$ticket = mysql_fetch_assoc($result_1);
		$cost = (int)$ticket['Amount'] * (int)$ticket['Price'];
		$uid = $ticket['UId'];
		$amount = (int)$ticket['Amount'];
		$ssid = $ticket['SSId'];

		$query_2 = "UPDATE User SET Balance = Balance + $cost WHERE UId = '$uid'";
		$result_2 = mysql_query($query_2, $con);
		if($result_2){
			$query_3 = "UPDATE Stock SET Stock = Stock + $amount WHERE SSId = '$ssid'";
			$result_3 = mysql_query($query_3, $con);
			if($result_3){
				$query = "DELETE FROM Ticket WHERE TId = '$tid'";
				$result = mysql_query($query, $con);
				if($result){
					$currentPath = getcwd();
					$bigPath = explode("specialphp", $currentPath);
					$filename = $bigPath[0]."/userrequest/".$tid;
					$delectSuccess = unlink($filename);
					if($delectSuccess){
						$response['msg'] = 'success';
						echo json_encode($response);
						mysql_close($con);
						return true;
					}else{
						$response['msg'] = "Error by file remove";
						echo json_encode($response);
						mysql_close($con);
						return false;
					}
				}else{
					$response['msg'] = "Error by delete query";
					echo json_encode($response);
					mysql_close($con);
					return false;
				}
			}else{
				$response['msg'] = "Error by update stock query";
				echo json_encode($response);
				mysql_close($con);
				return false;
			}
		}else{
			$response['msg'] = "Error by update balance query";
			echo json_encode($response);
			mysql_close($con);
			return false;
		}
	}else{
		$response['msg'] = "Error by select query";
		echo json_encode($response);
		mysql_close($con);
		return false;
	}			
?>