<?php
	header('Content-type: application/json');
	include("config1.php");
	// Check for empty fields
	if(empty($_POST['game']) ||
		empty($_POST['section']) ||
		empty($_POST['type']) ||
		empty($_POST['amount']) ||
		empty($_POST['user']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);
	$game = $_POST['game']; //gid --------/ssid
	$section = $_POST['section']; //sid------/ssid
	$type = $_POST['type']; //utid
	$user = $_POST['user']; 
	$amount = $_POST['amount']; 

	$query_0 = "SELECT Stock FROM Stock WHERE GId = $game AND SId = $section";
	$result_0 = mysql_query($query_0, $con);
	$stock = mysql_fetch_assoc($result_0);
	if((int)$stock['Stock'] - (int)$amount < 0){
		$response['status'] = 'error';  
		$response['message'] = "Out of stock! Not available or try to reduce your amount.";
		echo json_encode($response);
		mysql_close($con);
		return false;
	}else{
		$query_3 = "SELECT Balance FROM User WHERE UId = $user";
		$result_3 = mysql_query($query_3, $con);
		$balance = mysql_fetch_assoc($result_3);
		$query = "SELECT d.DId, d.Price FROM Detail d JOIN Stock s ON d.SSId = s.SSId WHERE GId = $game AND SId = $section AND UTId = $type";
		$result = mysql_query($query, $con);
		$detail = mysql_fetch_assoc($result);
		$take = $detail['Price'] * $amount;
		if((int)$take > (int)$balance['Balance']){
			$response['status'] = 'error';  
			$response['message'] = "Out of your balance! Go deposit or reduce ticket amount.";
			echo json_encode($response);
			mysql_close($con);
			return false;
		}else{
			$did = $detail['DId'];
			$query_7 = "SELECT t.Amount FROM Detail d, Stock s, Ticket t WHERE d.SSId = s.SSId AND d.DId = t.DId AND t.UId = '$user' AND s.GId = '$game'";
			$result_7 = mysql_query($query_7, $con);
			$countTicket = 0;
			while($row = mysql_fetch_assoc($result_7)){
				$countTicket = $countTicket + $row['Amount'];
			}
			if(((int)$countTicket + (int)$amount) > 10){
				$rest = 10 - (int)$countTicket;
				$response['status'] = 'error'; 
				if($rest == 0){
					$response['message'] = "You already had " . $countTicket ." tickets. No more tickets are allowed for this game.";
				}else{
					$response['message'] = "You already had " . $countTicket ." tickets. Only " . $rest . " more tickets are allowed for this game.";
				}
				echo json_encode($response);
				mysql_close($con);
				return false;
			}else{
				$flag = false;
				$query_5 = "SELECT TId FROM Ticket WHERE UId = '$user' AND DId = '$did'";
				$result_5 = mysql_query($query_5, $con);
				if(mysql_num_rows($result_5) != 0){
					$ticketInfo = mysql_fetch_assoc($result_5);
					$tidGot = $ticketInfo['TId'];
					$query_6 = "UPDATE Ticket SET Amount = Amount + $amount WHERE TId = '$tidGot'";
					$result_6 = mysql_query($query_6, $con);
					if($result_6) $flag = true;
				}else{
					$query_1 = "INSERT INTO `Ticket`(`UId`, `DId`, `Amount`) VALUES ($user,$did,$amount)";
					$result_1 = mysql_query($query_1, $con);
					if($result_1) $flag = true;
				}
				if($flag){
					$query_2 = "UPDATE Stock SET Stock = Stock - $amount WHERE GId = $game AND SId = $section";
					$result_2 = mysql_query($query_2, $con);
					if($result_2 == true){
						$query_4 = "UPDATE User SET Balance = Balance - $take WHERE UId = $user";
						$result_4 = mysql_query($query_4, $con);
						if($result_4 == true){
							$response['status'] = 'success';  
							$response['message'] = "Great! You have purchased the ticket(s). Go to Ticket page if checking needed.";
							$response['newstock'] = (int)$stock['Stock'] - (int)$amount;
							$response['newbalance'] = (int)$balance['Balance'] - (int)$take;
							mysql_close($con);
							echo json_encode($response);
							return true;
						}else{
							$response['status'] = 'error';  
							$response['message'] = "Sorry! Something went wrong when updating your balance! Do it again please!";
							echo json_encode($response);
							mysql_close($con);
							return false;
						}
					}else{
						$response['status'] = 'error';  
						$response['message'] = "Sorry! Something went wrong when updating stock! Do it again please!";
						echo json_encode($response);
						mysql_close($con);
						return false; 
					} 
				}else{
					$response['status'] = 'error';  
					$response['message'] = "Sorry! Something went wrong when putting your tickets! Do it again please!";
					echo json_encode($response);
					mysql_close($con);
					return false; 
				}
			}
			
		}
	}
?>