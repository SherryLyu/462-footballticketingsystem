<?php
	header('Content-type: application/json');
	include("config1.php");

	// Check for empty fields
	if(empty($_POST['tableName']))
	{
	   echo "No arguments Provided!";
	   return false;
	}

	$con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$con);

	date_default_timezone_set('US/Eastern');
	$date = date('m-d-Y-h-i-s-a', time());
	$dateOutput = date('m/d/Y h:i:s a', time());
	$tableName = $_POST['tableName'];
	$backupFile  = "backuprecord/".$date;
	$backupFiletype  = ".sql";
	$query = "SELECT * FROM " . $tableName;
	$result = mysql_query($query, $con);
	$currentPath = getcwd();
	$bigPath = explode("specialphp", $currentPath);
	$backupPath = $bigPath[0]. $backupFile . "-" . $tableName . $backupFiletype;
	$myfile = fopen($backupPath, "w") or die("Unable to open file!");
	$columnCount = mysql_num_fields($result);
	$query_1 = "SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.columns WHERE TABLE_NAME = '". $tableName . "'";
	$result_1 = mysql_query($query_1, $con);
	fwrite($myfile, "TRUNCATE TABLE ". $tableName . ";\n");
	$allInsert = "INSERT INTO " . $tableName . " (";
	$type = array();
	while($rowColumn = mysql_fetch_row($result_1)){
		$allInsert .= $rowColumn[0] . ",";
		array_push($type, $rowColumn[1]);
	}
	if(substr($allInsert, -1) == ','){
  		$allInsert = substr($allInsert, 0, -1);
  	}
	$allInsert .= ") VALUES ";
	while($row = mysql_fetch_row($result)){
		$allInsert .= "(";
		for($i = 0; $i < $columnCount; $i++){
			if($i == ($columnCount-1)){
				if($type[$i] == "varchar") {
					$allInsert .= "'" . addslashes($row[$i]) . "'";
				}else $allInsert .= $row[$i];
			}else{
				if($type[$i] == "varchar") {
					$allInsert .= "'" . addslashes($row[$i]) . "',";
				}else $allInsert .= $row[$i] . ",";
			}
		}
		$allInsert .= "),";
	}
	if(substr($allInsert, -1) == ','){
  		$finalInput = substr($allInsert, 0, -1) . ";";
  	}
  	fwrite($myfile, $finalInput);
    fclose($myfile);
    chmod($backupPath,0755);

	if(!$result) die('Could not take data backup: ' . mysql_error());
	else{
		$responce['msg'] = "success";
		$responce['reminder'] = "Successfully back up table ".$tableName." at " .$dateOutput. " as " . $date . "-" . $tableName . $backupFiletype;
		echo json_encode($responce);
	}

	mysql_close($con);
?>