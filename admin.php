<?php 
  ini_set('session.save_path', 'tmp');
  session_start(); 
  include("config.php");
  $con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
  mysql_select_db(DB_DATABASE,$con);
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Football ticketing</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/agency.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="https://people.cs.clemson.edu/~siyunl/4620/project">Back to homepage</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" style="color:#fed136;" href="#stock">Stock</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" style="color:#fed136;" href="#price">Price</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" style="color:#fed136;" href="#users">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" style="color:#fed136;" href="#backup">Backup</a>
            </li>
            <?php
              if(isset($_SESSION['views'])){
                $temp = $_SESSION['views'];
                $query = "SELECT Username FROM User WHERE Email = '$temp'";
				$result = mysql_query($query, $con);
				$user = mysql_fetch_assoc($result);
				$username = $user['Username'];
                echo "<li class=\"nav-item\" \"dropdown\">";
                echo "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style=\"color:#fed136;\">";
                echo $username;
                echo "</a>";
                echo "<div class=\"dropdown-menu\" style=\"top:auto;right:auto;left:auto;\" aria-labelledby=\"navbarDropdownMenuLink\">";
                echo "<a class=\"dropdown-item\" href=\"https://people.cs.clemson.edu/~siyunl/4620/project/profile.php\"><i class=\"fa fa-user fa-fw\"></i> Profile</a>";
                if($temp == "admin@clemson.edu"){
                  echo "<a class=\"dropdown-item\" href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"><i class=\"fa fa-cogs fa-fw\"></i> Admin</a>";
                }else{
                  echo "<a class=\"dropdown-item\" href=\"https://people.cs.clemson.edu/~siyunl/4620/project/ticket.php\"><i class=\"fa fa-ticket fa-fw\"></i> Ticket</a>";
                }
                echo "<a class=\"dropdown-item\" href=\"https://people.cs.clemson.edu/~siyunl/4620/project/logout.php\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a>";
                echo "</div>";
                echo "</li>";
              }else{
                echo "<li class=\"nav-item\">";
                echo "<a class=\"nav-link\" data-toggle=\"modal\" href=\"#signup_login\">Regitser/Login</a>";
                echo "</li>";
              }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <style>
		table {
		  font-family: arial, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		td{
		  border: 1px solid #dddddd;
		  text-align: center;
		  padding: 8px;
		  background-color: #9A75C8;

		}
		th{
		  border: 1px solid #dddddd;
		  text-align: center;
		  padding: 8px;
		  background-color: #F57E53;
		}
		div.scroll {
			width: auto;
			height: 400px;
			overflow-y: auto;
		}
		.button {
			border: none;
			color: white;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			cursor: pointer;
		}
		button:disabled,
		button[disabled]{
		  border: 1px solid #FAAC58;
		  border-radius: 8px;
		  background-color: #FAAC58;
		  color: white;
		}
		.button3 {
			background-color: #22598D;
			border-radius: 8px;
		}
		.button2 {
			background-color: #D07432;
			border-radius: 8px;
		}
		input[type=number]{
		    width: 65px;
		    height: 25px;
		} 
		input[type=text] {
		    width: 300px;
		    box-sizing: border-box;
		    border: 2px solid #ccc;
		    border-radius: 4px;
		    font-size: 16px;
		    background-color: white;
		    padding: 1px 3px;
		}
    </style>

    <section id="headersection" style="background-image: url(./img/adminbg.jpg); background-position: center center;">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Welcome to administrator page!</h2>
            <h3 class="section-subheading text-muted">Manage the stock, section price, user's ticket, and back up database!</h3>
          </div>
        </div>
    </section>

    <section id="stock">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Edit stock</h2>
            <h3 class="section-subheading text-muted">Manage the stock for different games and sections</h3>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="container">
              <div class="scroll">
                <?php
                  if(isset($_SESSION['views'])){
                    echo "<table align=\"center\">";
                    $queryForStockgame = "SELECT * FROM Game";
                    
                    if(isset($_GET['Home']) && !empty($_GET['Home'])){
                        $HomeStock = $_GET['Home'];
                        if(strpos($queryForStockgame, "WHERE") !== false){
                            $queryForStockgame .= " AND Home = '$HomeStock'";
                        }else{
                            $queryForStockgame .= " WHERE Home = '$HomeStock'";
                        }
                    }
                    if(isset($_GET['Away']) && !empty($_GET['Away'])){
                        $AwayStock = $_GET['Away'];
                        if(strpos($queryForStockgame, "WHERE") !== false){
                            $queryForStockgame .= " AND Away = '$AwayStock'";
                        }else{
                            $queryForStockgame .= " WHERE Away = '$AwayStock'";
                        }

                    }
                    if(isset($_GET['Date']) && !empty($_GET['Date'])){
                        $DateStock = $_GET['Date'];
                        if(strpos($queryForStockgame, "WHERE") !== false){
                            $queryForStockgame .= " AND Date = '$DateStock'";
                        }else{
                            $queryForStockgame .= " WHERE Date = '$DateStock'";
                        }

                    }
                    if(isset($_GET['Time']) && !empty($_GET['Time'])){
                        $TimeStock = $_GET['Time'];
                        if(strpos($queryForStockgame, "WHERE") !== false){
                            $queryForStockgame .= " AND Time = '$TimeStock'";
                        }else{
                            $queryForStockgame .= " WHERE Time = '$TimeStock'";
                        }
                    }
                    if(isset($_GET['Stadium']) && !empty($_GET['Stadium'])){
                        $StadiumStock = str_replace("*","'",$_GET['Stadium']);
                        if(strpos($queryForStockgame, "WHERE") !== false){
                            $queryForStockgame .= " AND Stadium = \"$StadiumStock\"";
                        }else{
                            $queryForStockgame .= " WHERE Stadium = \"$StadiumStock\"";
                        }
                    }

                    $resultForStockgame = mysql_query($queryForStockgame, $con);
                    $data_array_game_stock = array();
                    while ($data_game_stock = mysql_fetch_assoc($resultForStockgame)) {
                        $data_array_game_stock[] = $data_game_stock;
                    }
                    echo "<tr>";
                    echo "<th><select id='Home' onchange=\"selectedHomes();\"><option value='null'></option>";
                    foreach ($data_array_game_stock as $Home) {
                        echo "<script type=\"text/javascript\">
                            if($(\"#Home option[value='".$Home['Home']."']\").length == 0){
                                var checkUrlHome = window.location.search;
                                var flag = null, substringHome = 'Home';
                                if(checkUrlHome){
                                    var seperateValues = checkUrlHome.substring(1).split('&');
                                    for(i = 0; i < seperateValues.length; i++){
                                        if(seperateValues[i].indexOf(substringHome) !== -1){
                                            flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                        }
                                    }
                                }
                                if('" . $Home['Home'] . "' == flag){
                                    $('#Home').append(\"<option value='".$Home['Home']."' selected>".$Home['Home']."</option>\");
                                }else{
                                    $('#Home').append(\"<option value='".$Home['Home']."'>".$Home['Home']."</option>\");
                                }
                                
                            }
                        </script>";
                    }
                    echo "</select></th>";
                    echo "<script type=\"text/javascript\">
                        function selectedHomes(){
                          var e = document.getElementById(\"Home\").value;
                          var checkUrlHome = window.location.search;
                          var i, substringHome = \"Home\", finalstring=\"?\";
                          if(checkUrlHome){
                            var seperateValues = checkUrlHome.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringHome) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"Home=\" + e + \"#stock\";
                          }
                          
                        }
                        </script>";


                    echo "<th><select id='Away' onchange=\"selectedAways();\"><option value='null'></option>";
                    foreach ($data_array_game_stock as $Away) {
                        echo "<script type=\"text/javascript\">
                            if($(\"#Away option[value='".$Away['Away']."']\").length == 0){
                                var checkUrlAway = window.location.search;
                                var flag = null, substringAway = 'Away';
                                if(checkUrlAway){
                                    var seperateValues = checkUrlAway.substring(1).split('&');
                                    for(i = 0; i < seperateValues.length; i++){
                                        if(seperateValues[i].indexOf(substringAway) !== -1){
                                            flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                        }
                                    }
                                }
                                if('" . $Away['Away'] . "' == flag){
                                    $('#Away').append(\"<option value='".$Away['Away']."' selected>".$Away['Away']."</option>\");
                                }else{
                                    $('#Away').append(\"<option value='".$Away['Away']."'>".$Away['Away']."</option>\");
                                }
                                
                            }
                        </script>";
                    }
                    echo "</select></th>";

                    echo "<script type=\"text/javascript\">
                        function selectedAways(){
                          var e = document.getElementById(\"Away\").value;
                          var checkUrlAway = window.location.search;
                          var i, substringAway = \"Away\", finalstring=\"?\";
                          if(checkUrlAway){
                            var seperateValues = checkUrlAway.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringAway) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"Away=\" + e + \"#stock\";
                          }
                          
                        }
                        </script>";

                    echo "<th><select id='Date' onchange=\"selectedDates();\"><option value='null'></option>";
                    foreach ($data_array_game_stock as $Date) {
                        echo "<script type=\"text/javascript\">
                            var checkUrlDate = window.location.search;
                            var flag = null, substringDate = 'Date';
                            if(checkUrlDate){
                                var seperateValues = checkUrlDate.substring(1).split('&');
                                for(i = 0; i < seperateValues.length; i++){
                                    if(seperateValues[i].indexOf(substringDate) !== -1){
                                        flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                    }
                                }
                            }
                            if('" . $Date['Date'] . "' == flag){
                                $('#Date').append(\"<option value='".$Date['Date']."' selected>".$Date['Date']."</option>\");
                            }else{
                                $('#Date').append(\"<option value='".$Date['Date']."''>".$Date['Date']."</option>\");
                            }
                        </script>";
                    }
                    echo "</select></th>";

                    echo "<script type=\"text/javascript\">
                        function selectedDates(){
                          var e = document.getElementById(\"Date\").value;
                          var checkUrlDate = window.location.search;
                          var i, substringDate = \"Date\", finalstring=\"?\";
                          if(checkUrlDate){
                            var seperateValues = checkUrlDate.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringDate) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"Date=\" + e + \"#stock\";
                          }
                          
                        }
                        </script>";


                    echo "<th><select id='Time' onchange=\"selectedTimes();\"><option value='null'></option>";
                    foreach ($data_array_game_stock as $Time) {
                        echo "<script type=\"text/javascript\">
                            if($(\"#Time option[value='".$Time['Time']."']\").length == 0){
                                var checkUrlTime = window.location.search;
                                var flag = null, substringTime = 'Time';
                                if(checkUrlTime){
                                    var seperateValues = checkUrlTime.substring(1).split('&');
                                    for(i = 0; i < seperateValues.length; i++){
                                        if(seperateValues[i].indexOf(substringTime) !== -1){
                                            flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                        }
                                    }
                                }
                                if('" . $Time['Time'] . "' == flag){
                                    $('#Time').append(\"<option value='".$Time['Time']."' selected>".$Time['Time']."</option>\");
                                }else{
                                    $('#Time').append(\"<option value='".$Time['Time']."'>".$Time['Time']."</option>\");
                                }
                                
                            }
                        </script>";
                    }
                    echo "</select></th>";

                    echo "<script type=\"text/javascript\">
                        function selectedTimes(){
                          var e = document.getElementById(\"Time\").value;
                          var checkUrlTime = window.location.search;
                          var i, substringTime = \"Time\", finalstring=\"?\";
                          if(checkUrlTime){
                            var seperateValues = checkUrlTime.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringTime) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"Time=\" + e + \"#stock\";
                          }
                          
                        }
                        </script>";

                    echo "<th><select id='Stadium' onchange=\"selectedStadiums();\"><option value='null'></option>";
                    foreach ($data_array_game_stock as $Stadium) {
                        echo "<script type=\"text/javascript\">
                            var fixStadium = \"".$Stadium['Stadium']."\".replace(\"'\", \"*\");
                            if($(\"#Stadium option[value='\" + fixStadium + \"']\").length == 0){
                                var checkUrlStadium = window.location.search;
                                var flag = null, substringStadium = 'Stadium';
                                if(checkUrlStadium){
                                    var seperateValues = checkUrlStadium.substring(1).split('&');
                                    for(i = 0; i < seperateValues.length; i++){
                                        if(seperateValues[i].indexOf(substringStadium) !== -1){
                                            flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                        }
                                    }
                                }
                                if(fixStadium == flag){
                                    $('#Stadium').append(\"<option value='\" + fixStadium + \"' selected>".$Stadium['Stadium']."</option>\");
                                }else{
                                    $('#Stadium').append(\"<option value='\" + fixStadium + \"'>".$Stadium['Stadium']."</option>\");
                                }
                                
                            }
                        </script>";
                    }
                    echo "</select></th>";

                    echo "<script type=\"text/javascript\">
                        function selectedStadiums(){
                          var e = document.getElementById(\"Stadium\").value;
                          var checkUrlStadium = window.location.search;
                          var i, substringStadium = \"Stadium\", finalstring=\"?\";
                          if(checkUrlStadium){
                            var seperateValues = checkUrlStadium.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringStadium) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"Stadium=\" + e + \"#stock\";
                          }
                          
                        }
                        </script>";

                    $queryForStocksection = "SELECT * FROM Section";
                    $resultForStocksection = mysql_query($queryForStocksection, $con);
                    echo "<th><select id='SectionName' onchange=\"selectedSectionnames();\"><option value='null'></option>";
                    while($row_stock = mysql_fetch_assoc($resultForStocksection)){
                        echo "<script type=\"text/javascript\">
                            var checkUrlSectionName = window.location.search;
                            var flag = null, substringSectionname = 'SectionName';
                            if(checkUrlSectionName){
                                var seperateValues = checkUrlSectionName.substring(1).split('&');
                                for(i = 0; i < seperateValues.length; i++){
                                    if(seperateValues[i].indexOf(substringSectionname) !== -1){
                                        flag = decodeURI(seperateValues[i].split(\"=\")[1]);
                                    }
                                }
                            }
                            if('" . $row_stock['Name'] . "' == flag){
                                $('#SectionName').append(\"<option value='".$row_stock['Name']."' selected>".$row_stock['Name']."</option>\");
                            }else{
                                $('#SectionName').append(\"<option value='".$row_stock['Name']."'>".$row_stock['Name']."</option>\");
                            }
                        </script>";
                    }
                    echo "</select></th>";

                    echo "<script type=\"text/javascript\">
                        function selectedSectionnames(){
                          var e = document.getElementById(\"SectionName\").value;
                          var checkUrlSectionName = window.location.search;
                          var i, substringSectionname = \"SectionName\", finalstring=\"?\";
                          if(checkUrlSectionName){
                            var seperateValues = checkUrlSectionName.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substringSectionname) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                          }
                          if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }else{
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"SectionName=\" + e + \"#stock\";
                          }
                        }
                        </script>";

                    echo "<th id='changeStockoutput'><button id='changeStock' class=\"button button3\" onclick=\"changeStock();\">change</button><button id='resetStock' class=\"button button3\" style='float:right;' type='button' onclick=\"resetStocktable();\">reset</button></th>";

                    echo "<script type=\"text/javascript\">
                        function changeStock(){
                            var inputarea=\"<form onsubmit='return false;'><input id='newStock' type='number' min='0' max='500' step='1' required><button id='submitNewStock' class='button button2' style='float:right;' onclick='submitStock();'>submit</button></form>\";
                            document.getElementById(\"changeStockoutput\").innerHTML = inputarea;
                          }
                        function submitStock(){
                            var e = document.getElementById('newStock').value;
                            var limitmax = parseInt(document.getElementById('newStock').max);
                            var limitmin = parseInt(document.getElementById('newStock').min);
                            if(e !== \"\" && e <= limitmax && e >= limitmin){
                                var checkUrl = window.location.search;
                                var i, substringNp = \"newStock\", finalstring=\"?\";
                                if(checkUrl){
                                    var seperateValues = checkUrl.substring(1).split('&');
                                    for(i = 0; i < seperateValues.length; i++){
                                        if(seperateValues[i].indexOf(substringNp) === -1){
                                            finalstring += seperateValues[i] + '&';
                                        }
                                    }
                                }
                                if(e === 'null'){
                                    if(finalstring.slice(-1) === '&'){
                                        finalstring = finalstring.slice(0, finalstring.length-1);
                                    }
                                    window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                                }else{
                                    window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"newStock=\" + e + \"#stock\";
                                }     
                            }                   
                          }
                        function resetStocktable(){
                            var checkUrl = window.location.search;
                            var i, j, count=0, substrings = [\"Home\",\"Away\",\"Date\",\"Time\",\"Stadium\",\"SectionName\"], finalstring=\"?\";
                            if(checkUrl){
                                var seperateValues = checkUrl.substring(1).split('&');
                                for(i = 0; i < seperateValues.length; i++){
                                    for(j = 0; j < substrings.length; j++){
                                        if(seperateValues[i].indexOf(substrings[j]) !== -1){
                                            count++;
                                        }
                                    }
                                    if(count == 0) finalstring += seperateValues[i] + '&';
                                    count = 0;
                                }
                            }
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                          }
                        </script>";

                    echo "</tr>";
                    
                    if(isset($_GET['newStock']) && !empty($_GET['newStock'])){
                        $newStockGot = $_GET['newStock'];
                        $queryForStockchange = "UPDATE Stock
                                                JOIN Game ON Game.GId = Stock.GId
                                                JOIN Section ON Section.SId = Stock.SId
                                                SET Stock.Stock = '$newStockGot' ";
                        $queryForStockgameCheck = "SELECT GId FROM Game";
                        if(isset($_GET['Home']) && !empty($_GET['Home'])){
                            $HomeStock = $_GET['Home'];
                            if(strpos($queryForStockgameCheck, "WHERE") !== false){
                                $queryForStockgameCheck .= " AND Home = '$HomeStock'";
                            }else{
                                $queryForStockgameCheck .= " WHERE Home = '$HomeStock'";
                            }
                        }
                        if(isset($_GET['Away']) && !empty($_GET['Away'])){
                            $AwayStock = $_GET['Away'];
                            if(strpos($queryForStockgameCheck, "WHERE") !== false){
                                $queryForStockgameCheck .= " AND Away = '$AwayStock'";
                            }else{
                                $queryForStockgameCheck .= " WHERE Away = '$AwayStock'";
                            }

                        }
                        if(isset($_GET['Date']) && !empty($_GET['Date'])){
                            $DateStock = $_GET['Date'];
                            if(strpos($queryForStockgameCheck, "WHERE") !== false){
                                $queryForStockgameCheck .= " AND Date = '$DateStock'";
                            }else{
                                $queryForStockgameCheck .= " WHERE Date = '$DateStock'";
                            }

                        }
                        if(isset($_GET['Time']) && !empty($_GET['Time'])){
                            $TimeStock = $_GET['Time'];
                            if(strpos($queryForStockgameCheck, "WHERE") !== false){
                                $queryForStockgameCheck .= " AND Time = '$TimeStock'";
                            }else{
                                $queryForStockgameCheck .= " WHERE Time = '$TimeStock'";
                            }
                        }
                        if(isset($_GET['Stadium']) && !empty($_GET['Stadium'])){
                            $StadiumStock = str_replace("*","'",$_GET['Stadium']);
                            if(strpos($queryForStockgameCheck, "WHERE") !== false){
                                $queryForStockgameCheck .= " AND Stadium = \"$StadiumStock\"";
                            }else{
                                $queryForStockgameCheck .= " WHERE Stadium = \"$StadiumStock\"";
                            }
                        }
                        if($queryForStockgameCheck !== "SELECT GId FROM Game"){
                            $howManyRow = mysql_query($queryForStockgameCheck, $con);
                            $countRow = mysql_num_rows($howManyRow);
                            if($countRow == 1){
                                $queryForStockchange .= "WHERE Game.GId = (" . $queryForStockgameCheck . ")";
                            }else{
                                $queryForStockchange .= "WHERE Game.GId IN (" . $queryForStockgameCheck . ")";
                            }
                        }
                            
                        if(isset($_GET['SectionName']) && !empty($_GET['SectionName'])){
                            $SectionNameStock = $_GET['SectionName'];
                            if(strpos($queryForStockchange, "WHERE") !== false){
                                $queryForStockchange .= " AND Section.name = '$SectionNameStock'";
                            }else{
                                $queryForStockchange .= " WHERE Section.name = '$SectionNameStock'";
                            }
                        }

                        mysql_query($queryForStockchange, $con);
                        echo "<script type=\"text/javascript\">
                            var checkUrl = window.location.search;
                            var i, substringNp = \"newStock\", finalstring=\"?\";
                            if(checkUrl){
                                var seperateValues = checkUrl.substring(1).split('&');
                                for(i = 0; i < seperateValues.length; i++){
                                    if(seperateValues[i].indexOf(substringNp) === -1){
                                        finalstring += seperateValues[i] + '&';
                                    }
                                }
                            }
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#stock\";
                            </script>";
                        
                    }

                    echo "<tr>
                            <th>Home</th>
                            <th>Away</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Stadium</th>
                            <th>Section</th>
                            <th>Stock</th>
                          </tr>";
                    
                    $queryForStockall = "SELECT s.Name, g.Home, g.Away, g.Date, g.Time, g.Stadium, ss.Stock
                              FROM Game g, Section s, Stock ss
                              WHERE g.GId = ss.GId AND
                              s.SId = ss.SId";

                    if(isset($_GET['Home']) && !empty($_GET['Home'])){
                        $HomeStock = $_GET['Home'];
                        $queryForStockall .= " AND g.Home = '$HomeStock'";                     
                    }

                    if(isset($_GET['Away']) && !empty($_GET['Away'])){
                        $AwayStock = $_GET['Away'];
                        $queryForStockall .= " AND g.Away = '$AwayStock'";

                    }
                    if(isset($_GET['Date']) && !empty($_GET['Date'])){
                        $DateStock = $_GET['Date'];
                        $queryForStockall .= " AND g.Date = '$DateStock'";

                    }
                    if(isset($_GET['Time']) && !empty($_GET['Time'])){
                        $TimeStock = $_GET['Time'];
                        $queryForStockall .= " AND g.Time = '$TimeStock'";

                    }
                    if(isset($_GET['Stadium']) && !empty($_GET['Stadium'])){
                        $StadiumStock = str_replace("*","'",$_GET['Stadium']);
                        $queryForStockall .= " AND g.Stadium = \"$StadiumStock\"";

                    }
                    if(isset($_GET['SectionName']) && !empty($_GET['SectionName'])){
                        $SectionNameStock = $_GET['SectionName'];
                        $queryForStockall .= " AND s.Name = \"$SectionNameStock\"";

                    }                  
                    
                    $resultForStockall = mysql_query($queryForStockall, $con);
                    while($row_stock_output = mysql_fetch_assoc($resultForStockall)){
                        echo "<tr>";
                        echo "<td>".$row_stock_output['Home']."</td>";
                        echo "<td>".$row_stock_output['Away']."</td>";
                        echo "<td>".$row_stock_output['Date']."</td>";
                        echo "<td>".$row_stock_output['Time']."</td>";
                        echo "<td>".$row_stock_output['Stadium']."</td>";
                        echo "<td>".$row_stock_output['Name']."</td>";
                        echo "<td>".$row_stock_output['Stock']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                  }
                ?>
              </div>
            </div>
          </div>
    </section>

    <section id="price" style="background-color: #f8f9fa;">
    	<div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Edit price</h2>
            <h3 class="section-subheading text-muted">Manage the price for selected factors</h3>
          </div>
        </div>
   		<div class="col-lg-12">
            <div class="container">
              <div class="scroll">
                <?php
                  if(isset($_SESSION['views'])){
                    echo "<table align=\"center\">";
                    $queryForPricegame = "SELECT * FROM Game";
                    
                    if(isset($_GET['home']) && !empty($_GET['home'])){
						$homePrice = $_GET['home'];
						if(strpos($queryForPricegame, "WHERE") !== false){
							$queryForPricegame .= " AND Home = '$homePrice'";
						}else{
							$queryForPricegame .= " WHERE Home = '$homePrice'";
						}
					}
					if(isset($_GET['away']) && !empty($_GET['away'])){
						$awayPrice = $_GET['away'];
						if(strpos($queryForPricegame, "WHERE") !== false){
							$queryForPricegame .= " AND Away = '$awayPrice'";
						}else{
							$queryForPricegame .= " WHERE Away = '$awayPrice'";
						}

					}
					if(isset($_GET['date']) && !empty($_GET['date'])){
						$datePrice = $_GET['date'];
						if(strpos($queryForPricegame, "WHERE") !== false){
							$queryForPricegame .= " AND Date = '$datePrice'";
						}else{
							$queryForPricegame .= " WHERE Date = '$datePrice'";
						}

					}
					if(isset($_GET['time']) && !empty($_GET['time'])){
						$timePrice = $_GET['time'];
						if(strpos($queryForPricegame, "WHERE") !== false){
							$queryForPricegame .= " AND Time = '$timePrice'";
						}else{
							$queryForPricegame .= " WHERE Time = '$timePrice'";
						}
					}
					if(isset($_GET['stadium']) && !empty($_GET['stadium'])){
						$stadiumPrice = str_replace("*","'",$_GET['stadium']);
						if(strpos($queryForPricegame, "WHERE") !== false){
							$queryForPricegame .= " AND Stadium = \"$stadiumPrice\"";
						}else{
							$queryForPricegame .= " WHERE Stadium = \"$stadiumPrice\"";
						}
					}

                    $resultForPricegame = mysql_query($queryForPricegame, $con);
                    $data_array_game_price = array();
					while ($data_game_price = mysql_fetch_assoc($resultForPricegame)) {
					    $data_array_game_price[] = $data_game_price;
					}
                    echo "<tr>";
                    echo "<th><select id='home' onchange=\"selectedHome();\"><option value='null'></option>";
                    foreach ($data_array_game_price as $home) {
                    	echo "<script type=\"text/javascript\">
                    		if($(\"#home option[value='".$home['Home']."']\").length == 0){
                    			var checkUrlhome = window.location.search;
                    			var flag = null, substringHome = 'home';
                    			if(checkUrlhome){
		                          	var seperateValues = checkUrlhome.substring(1).split('&');
		                          	for(i = 0; i < seperateValues.length; i++){
		                          		if(seperateValues[i].indexOf(substringHome) !== -1){
		                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
		                          		}
		                          	}
		                        }
		                        if('" . $home['Home'] . "' == flag){
		                        	$('#home').append(\"<option value='".$home['Home']."' selected>".$home['Home']."</option>\");
		                        }else{
		                        	$('#home').append(\"<option value='".$home['Home']."'>".$home['Home']."</option>\");
		                        }
                    			
                    		}
                    	</script>";
	                }
	                echo "</select></th>";
	                echo "<script type=\"text/javascript\">
                        function selectedHome(){
                          var e = document.getElementById(\"home\").value;
                          var checkUrlhome = window.location.search;
                          var i, substringHome = \"home\", finalstring=\"?\";
                          if(checkUrlhome){
                          	var seperateValues = checkUrlhome.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringHome) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"home=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";


	                echo "<th><select id='away' onchange=\"selectedAway();\"><option value='null'></option>";
                    foreach ($data_array_game_price as $away) {
                    	echo "<script type=\"text/javascript\">
                    		if($(\"#away option[value='".$away['Away']."']\").length == 0){
                    			var checkUrlaway = window.location.search;
                    			var flag = null, substringAway = 'away';
                    			if(checkUrlaway){
		                          	var seperateValues = checkUrlaway.substring(1).split('&');
		                          	for(i = 0; i < seperateValues.length; i++){
		                          		if(seperateValues[i].indexOf(substringAway) !== -1){
		                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
		                          		}
		                          	}
		                        }
		                        if('" . $away['Away'] . "' == flag){
		                        	$('#away').append(\"<option value='".$away['Away']."' selected>".$away['Away']."</option>\");
		                        }else{
		                        	$('#away').append(\"<option value='".$away['Away']."'>".$away['Away']."</option>\");
		                        }
                    			
                    		}
                    	</script>";
	                }
	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedAway(){
                          var e = document.getElementById(\"away\").value;
                          var checkUrlaway = window.location.search;
                          var i, substringAway = \"away\", finalstring=\"?\";
                          if(checkUrlaway){
                          	var seperateValues = checkUrlaway.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringAway) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"away=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";

	                echo "<th><select id='date' onchange=\"selectedDate();\"><option value='null'></option>";
                    foreach ($data_array_game_price as $date) {
                    	echo "<script type=\"text/javascript\">
                    		var checkUrldate = window.location.search;
                			var flag = null, substringDate = 'date';
                			if(checkUrldate){
	                          	var seperateValues = checkUrldate.substring(1).split('&');
	                          	for(i = 0; i < seperateValues.length; i++){
	                          		if(seperateValues[i].indexOf(substringDate) !== -1){
	                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
	                          		}
	                          	}
	                        }
	                        if('" . $date['Date'] . "' == flag){
	                        	$('#date').append(\"<option value='".$date['Date']."' selected>".$date['Date']."</option>\");
	                        }else{
	                        	$('#date').append(\"<option value='".$date['Date']."''>".$date['Date']."</option>\");
	                        }
                    	</script>";
	                }
	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedDate(){
                          var e = document.getElementById(\"date\").value;
                          var checkUrldate = window.location.search;
                          var i, substringDate = \"date\", finalstring=\"?\";
                          if(checkUrldate){
                          	var seperateValues = checkUrldate.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringDate) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"date=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";


	                echo "<th><select id='time' onchange=\"selectedTime();\"><option value='null'></option>";
                    foreach ($data_array_game_price as $time) {
                    	echo "<script type=\"text/javascript\">
                    		if($(\"#time option[value='".$time['Time']."']\").length == 0){
                    			var checkUrltime = window.location.search;
                    			var flag = null, substringTime = 'time';
                    			if(checkUrltime){
		                          	var seperateValues = checkUrltime.substring(1).split('&');
		                          	for(i = 0; i < seperateValues.length; i++){
		                          		if(seperateValues[i].indexOf(substringTime) !== -1){
		                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
		                          		}
		                          	}
		                        }
		                        if('" . $time['Time'] . "' == flag){
		                        	$('#time').append(\"<option value='".$time['Time']."' selected>".$time['Time']."</option>\");
		                        }else{
		                        	$('#time').append(\"<option value='".$time['Time']."'>".$time['Time']."</option>\");
		                        }
                    			
                    		}
                    	</script>";
	                }
	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedTime(){
                          var e = document.getElementById(\"time\").value;
                          var checkUrltime = window.location.search;
                          var i, substringTime = \"time\", finalstring=\"?\";
                          if(checkUrltime){
                          	var seperateValues = checkUrltime.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringTime) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"time=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";

	                echo "<th><select id='stadium' onchange=\"selectedStadium();\"><option value='null'></option>";
                    foreach ($data_array_game_price as $stadium) {
                    	echo "<script type=\"text/javascript\">
                    		var fixstadium = \"".$stadium['Stadium']."\".replace(\"'\", \"*\");
                    		if($(\"#stadium option[value='\" + fixstadium + \"']\").length == 0){
                    			var checkUrlstadium = window.location.search;
                    			var flag = null, substringStadium = 'stadium';
                    			if(checkUrlstadium){
		                          	var seperateValues = checkUrlstadium.substring(1).split('&');
		                          	for(i = 0; i < seperateValues.length; i++){
		                          		if(seperateValues[i].indexOf(substringStadium) !== -1){
		                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
		                          		}
		                          	}
		                        }
		                        if(fixstadium == flag){
		                        	$('#stadium').append(\"<option value='\" + fixstadium + \"' selected>".$stadium['Stadium']."</option>\");
		                        }else{
		                        	$('#stadium').append(\"<option value='\" + fixstadium + \"'>".$stadium['Stadium']."</option>\");
		                        }
                    			
                    		}
                    	</script>";
	                }
	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedStadium(){
                          var e = document.getElementById(\"stadium\").value;
                          var checkUrlstadium = window.location.search;
                          var i, substringStadium = \"stadium\", finalstring=\"?\";
                          if(checkUrlstadium){
                          	var seperateValues = checkUrlstadium.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringStadium) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"stadium=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";

	                $queryForPricesection = "SELECT * FROM Section";
                    $resultForPricesection = mysql_query($queryForPricesection, $con);
	                echo "<th><select id='sectionname' onchange=\"selectedSectionname();\"><option value='null'></option>";
                    while($row_price_section = mysql_fetch_assoc($resultForPricesection)){
                    	echo "<script type=\"text/javascript\">
                    		var checkUrlsectionname = window.location.search;
                			var flag = null, substringSectionname = 'sectionname';
                			if(checkUrlsectionname){
	                          	var seperateValues = checkUrlsectionname.substring(1).split('&');
	                          	for(i = 0; i < seperateValues.length; i++){
	                          		if(seperateValues[i].indexOf(substringSectionname) !== -1){
	                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
	                          		}
	                          	}
	                        }
	                        if('" . $row_price_section['Name'] . "' == flag){
	                        	$('#sectionname').append(\"<option value='".$row_price_section['Name']."' selected>".$row_price_section['Name']."</option>\");
	                        }else{
	                        	$('#sectionname').append(\"<option value='".$row_price_section['Name']."'>".$row_price_section['Name']."</option>\");
	                        }
                    	</script>";
	                }
	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedSectionname(){
                          var e = document.getElementById(\"sectionname\").value;
                          var checkUrlsectionname = window.location.search;
                          var i, substringSectionname = \"sectionname\", finalstring=\"?\";
                          if(checkUrlsectionname){
                          	var seperateValues = checkUrlsectionname.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringSectionname) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"sectionname=\" + e + \"#price\";
                          }
                        }
                        </script>";


	                $queryForPriceut = "SELECT * FROM UserType";
                    $resultForPriceut = mysql_query($queryForPriceut, $con);
	                echo "<th><select id='ut' onchange=\"selectedUt();\"><option value='null'></option>";
                    while($row_price_ut = mysql_fetch_assoc($resultForPriceut)){
                    	echo "<script type=\"text/javascript\">
                    		var checkUrlut = window.location.search;
                			var flag = null, substringUt = 'ut';
                			if(checkUrlut){
	                          	var seperateValues = checkUrlut.substring(1).split('&');
	                          	for(i = 0; i < seperateValues.length; i++){
	                          		if(seperateValues[i].indexOf(substringUt) !== -1){
	                          			flag = decodeURI(seperateValues[i].split(\"=\")[1]);
	                          		}
	                          	}
	                        }
	                        if('" . $row_price_ut['Type'] . "' == flag){
	                        	$('#ut').append(\"<option value='".$row_price_ut['Type']."' selected>".$row_price_ut['Type']."</option>\");
	                        }else{
	                        	$('#ut').append(\"<option value='".$row_price_ut['Type']."'>".$row_price_ut['Type']."</option>\");
	                        }
                    	</script>";
	                }

	                echo "</select></th>";

	                echo "<script type=\"text/javascript\">
                        function selectedUt(){
                          var e = document.getElementById(\"ut\").value;
                          var checkUrlut = window.location.search;
                          var i, substringUt = \"ut\", finalstring=\"?\";
                          if(checkUrlut){
                          	var seperateValues = checkUrlut.substring(1).split('&');
                          	for(i = 0; i < seperateValues.length; i++){
                          		if(seperateValues[i].indexOf(substringUt) === -1){
                          			finalstring += seperateValues[i] + '&';
                          		}
                          	}
                          }
                          if(e === 'null'){
                          	if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }else{
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"ut=\" + e + \"#price\";
                          }
                          
                        }
                        </script>";

	                echo "<th id='changePriceoutput'><button id='changePrice' class=\"button button3\" onclick=\"changePrice();\">change</button><button id='resetPrice' class=\"button button3\" style='float:right;' type='button' onclick=\"resetPricetable();\">reset</button></th>";

	                echo "<script type=\"text/javascript\">
                        function changePrice(){
                        	var inputarea=\"<form onsubmit='return false;'><input id='newPrice' type='number' min='0' max='100' step='1' required><button id='submitNewPrice' class='button button2' style='float:right;' onclick='submitPrice();'>submit</button></form>\";
                          	document.getElementById(\"changePriceoutput\").innerHTML = inputarea;
                          }
                        function submitPrice(){
							var e = document.getElementById('newPrice').value;
							var limitmax = parseInt(document.getElementById('newPrice').max);
							var limitmin = parseInt(document.getElementById('newPrice').min);
							if(e !== \"\" && e <= limitmax && e >= limitmin){
								var checkUrl = window.location.search;
								var i, substringNp = \"newPrice\", finalstring=\"?\";
								if(checkUrl){
									var seperateValues = checkUrl.substring(1).split('&');
									for(i = 0; i < seperateValues.length; i++){
										if(seperateValues[i].indexOf(substringNp) === -1){
											finalstring += seperateValues[i] + '&';
										}
									}
								}
								if(e === 'null'){
									if(finalstring.slice(-1) === '&'){
		                          		finalstring = finalstring.slice(0, finalstring.length-1);
		                          	}
		                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
		                        }else{
		                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"newPrice=\" + e + \"#price\";
		                        }	  
	                        }                 	
                          }
                        function resetPricetable(){
                            var checkUrl = window.location.search;
                            var i, j, count=0, substrings = [\"home\",\"away\",\"date\",\"time\",\"stadium\",\"sectionname\", \"ut\"], finalstring=\"?\";
                            if(checkUrl){
                                var seperateValues = checkUrl.substring(1).split('&');
                                for(i = 0; i < seperateValues.length; i++){
                                    for(j = 0; j < substrings.length; j++){
                                        if(seperateValues[i].indexOf(substrings[j]) !== -1){
                                            count++;
                                        }
                                    }
                                    if(count == 0) finalstring += seperateValues[i] + '&';
                                    count = 0;
                                }
                            }
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                        	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
                          }
                        </script>";

	                echo "</tr>";
	                
                	if(isset($_GET['newPrice']) && !empty($_GET['newPrice'])){
						$newPriceGot = $_GET['newPrice'];
						$queryForPricechange = "UPDATE Detail
												JOIN Stock ON Detail.SSId = Stock.SSId
												JOIN UserType ON Detail.UTId = UserType.UTId
												JOIN Game ON Game.GId = Stock.GId
												JOIN Section ON Section.SId = Stock.SId
												SET Detail.Price = '$newPriceGot' ";
						$queryForPricegameCheck = "SELECT GId FROM Game";
						if(isset($_GET['home']) && !empty($_GET['home'])){
							$homePrice = $_GET['home'];
							if(strpos($queryForPricegameCheck, "WHERE") !== false){
								$queryForPricegameCheck .= " AND Home = '$homePrice'";
							}else{
								$queryForPricegameCheck .= " WHERE Home = '$homePrice'";
							}
						}
						if(isset($_GET['away']) && !empty($_GET['away'])){
							$awayPrice = $_GET['away'];
							if(strpos($queryForPricegameCheck, "WHERE") !== false){
								$queryForPricegameCheck .= " AND Away = '$awayPrice'";
							}else{
								$queryForPricegameCheck .= " WHERE Away = '$awayPrice'";
							}

						}
						if(isset($_GET['date']) && !empty($_GET['date'])){
							$datePrice = $_GET['date'];
							if(strpos($queryForPricegameCheck, "WHERE") !== false){
								$queryForPricegameCheck .= " AND Date = '$datePrice'";
							}else{
								$queryForPricegameCheck .= " WHERE Date = '$datePrice'";
							}

						}
						if(isset($_GET['time']) && !empty($_GET['time'])){
							$timePrice = $_GET['time'];
							if(strpos($queryForPricegameCheck, "WHERE") !== false){
								$queryForPricegameCheck .= " AND Time = '$timePrice'";
							}else{
								$queryForPricegameCheck .= " WHERE Time = '$timePrice'";
							}
						}
						if(isset($_GET['stadium']) && !empty($_GET['stadium'])){
							$stadiumPrice = str_replace("*","'",$_GET['stadium']);
							if(strpos($queryForPricegameCheck, "WHERE") !== false){
								$queryForPricegameCheck .= " AND Stadium = \"$stadiumPrice\"";
							}else{
								$queryForPricegameCheck .= " WHERE Stadium = \"$stadiumPrice\"";
							}
						}
						if($queryForPricegameCheck !== "SELECT GId FROM Game"){
							$howManyRow = mysql_query($queryForPricegameCheck, $con);
							$countRow = mysql_num_rows($howManyRow);
							if($countRow == 1){
								$queryForPricechange .= "WHERE Game.GId = (" . $queryForPricegameCheck . ")";
							}else{
								$queryForPricechange .= "WHERE Game.GId IN (" . $queryForPricegameCheck . ")";
							}
						}
							
						if(isset($_GET['sectionname']) && !empty($_GET['sectionname'])){
							$sectionnamePrice = $_GET['sectionname'];
							if(strpos($queryForPricechange, "WHERE") !== false){
								$queryForPricechange .= " AND Section.Name = '$sectionnamePrice'";
							}else{
								$queryForPricechange .= " WHERE Section.Name = '$sectionnamePrice'";
							}
						}
						if(isset($_GET['ut']) && !empty($_GET['ut'])){
							$utPrice = $_GET['ut'];
							if(strpos($queryForPricechange, "WHERE") !== false){
								$queryForPricechange .= " AND UserType.Type = '$utPrice'";
							}else{
								$queryForPricechange .= " WHERE UserType.Type = '$utPrice'";
							}
						}

						mysql_query($queryForPricechange, $con);
						echo "<script type=\"text/javascript\">
							var checkUrl = window.location.search;
							var i, substringNp = \"newPrice\", finalstring=\"?\";
							if(checkUrl){
								var seperateValues = checkUrl.substring(1).split('&');
								for(i = 0; i < seperateValues.length; i++){
									if(seperateValues[i].indexOf(substringNp) === -1){
										finalstring += seperateValues[i] + '&';
									}
								}
							}
							if(finalstring.slice(-1) === '&'){
                          		finalstring = finalstring.slice(0, finalstring.length-1);
                          	}
                          	window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#price\";
							</script>";
						
					}

                    echo "<tr>
                            <th>Home</th>
                            <th>Away</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Stadium</th>
                            <th>Section</th>
                            <th>UserType</th>
                            <th>Price</th>
                          </tr>";
                   
                    $queryForPriceall = "SELECT s.Name, g.Home, g.Away, g.Date, g.Time, g.Stadium, ut.Type, d.Price
                              FROM Game g, Section s, Stock ss, Detail d, UserType ut
                              WHERE g.GId = ss.GId AND
                              s.SId = ss.SId AND
                              d.SSId = ss.SSId AND
                              d.UTId = ut.UTId";


                    if(isset($_GET['home']) && !empty($_GET['home'])){
						$homePrice = $_GET['home'];
						$queryForPriceall .= " AND g.Home = '$homePrice'";						
					}

					if(isset($_GET['away']) && !empty($_GET['away'])){
						$awayPrice = $_GET['away'];
						$queryForPriceall .= " AND g.Away = '$awayPrice'";

					}
					if(isset($_GET['date']) && !empty($_GET['date'])){
						$datePrice = $_GET['date'];
						$queryForPriceall .= " AND g.Date = '$datePrice'";

					}
					if(isset($_GET['time']) && !empty($_GET['time'])){
						$timePrice = $_GET['time'];
						$queryForPriceall .= " AND g.Time = '$timePrice'";

					}
					if(isset($_GET['stadium']) && !empty($_GET['stadium'])){
						$stadiumPrice = str_replace("*","'",$_GET['stadium']);
						$queryForPriceall .= " AND g.Stadium = \"$stadiumPrice\"";

					}
					if(isset($_GET['sectionname']) && !empty($_GET['sectionname'])){
						$sectionnamePrice = $_GET['sectionname'];
						$queryForPriceall .= " AND s.Name = \"$sectionnamePrice\"";

					}
					if(isset($_GET['ut']) && !empty($_GET['ut'])){
						$utPrice = $_GET['ut'];
						$queryForPriceall .= " AND ut.Type = \"$utPrice\"";

					}
                   
					

                    $resultForPriceall = mysql_query($queryForPriceall, $con);
                    while($row_price_output = mysql_fetch_assoc($resultForPriceall)){
                        echo "<tr>";
                        echo "<td>".$row_price_output['Home']."</td>";
                        echo "<td>".$row_price_output['Away']."</td>";
                        echo "<td>".$row_price_output['Date']."</td>";
                        echo "<td>".$row_price_output['Time']."</td>";
                        echo "<td>".$row_price_output['Stadium']."</td>";
                        echo "<td>".$row_price_output['Name']."</td>";
                        echo "<td>".$row_price_output['Type']."</td>";
                        echo "<td>".$row_price_output['Price']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                  }
                ?>
              </div>
            </div>
          </div>
    </section>

    <section id="users">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Manage users</h2>
            <h3 class="section-subheading text-muted">View users' information and manage their tickets</h3>
          </div>
        </div>

        <div class="col-lg-12">	
	   		<div class="container">
	   			<form>
					<select style="border:2px solid #ccc; border-radius: 4px;" id="searchby">
						<option value="UId">UId</option>
						<option value="Username">Username</option>
						<option value="Email">Email</option>
						<option value="Type">User type</option>
					</select>
					<input type="text" id="search" placeholder="Search.." required>
					<button style="border:2px solid #ccc; border-radius: 4px; background-color:white;" type="button" onclick="searchbysth();"><i class="fa fa-search"></i></button>
					<div id='replaceResetTable'><button style="border:2px solid #ccc; border-radius: 4px; background-color:white;float:right;" type="button" onclick="resetUsertable();">Table reset</button></div>
				</form>
				<script type="text/javascript">
					function searchbysth(){
                        var e = document.getElementById("searchby");
                        var a = document.getElementById("search");
                        var searchby = e.options[e.selectedIndex].value;
                        var value = a.value;
                        $.ajax({
                            url: "././specialphp/searchUserbysth.php",
                            type: "POST",
                            data: {
                              searchby: searchby,
                              value:value
                            },
                            cache: false,
                            success: function(data) {
                                if(data.msg == 'success'){
                                    var i, j, severalString="", substringUserID = "selectedUserID", finalstring="?";
                                    var checkUrl = window.location.search;
                                    if(checkUrl){
                                        var seperateValues = checkUrl.substring(1).split('&');
                                        for(i = 0; i < seperateValues.length; i++){
                                            if(seperateValues[i].indexOf(substringUserID) === -1){
                                                finalstring += seperateValues[i] + '&';
                                            }
                                        }
                                    }
                                    if(data.alluid.length == 1) window.location.href="https://people.cs.clemson.edu/~siyunl/4620/project/admin.php"+ finalstring + "selectedUserID=" + data.alluid + "#users";
                                    else{
                                        var arrayGot = (data.alluid).toString().split(",");
                                        for(j = 0; j < arrayGot.length; j++){
                                            if(j == arrayGot.length-1) severalString += arrayGot[j];
                                            else severalString += arrayGot[j] + ",";
                                        }
                                        window.location.href="https://people.cs.clemson.edu/~siyunl/4620/project/admin.php"+ finalstring + "selectedUserID=" + severalString + "#users";
                                    }
                                }else alert(data.msg);
                            }
                        });
                        /*var i, j, count=0, finalstring="?";
                        var e = document.getElementById("searchby");
                        var a = document.getElementById("search");
                        var optionVal = new Array();
                        for (i = 0; i < e.length; i++) { 
                            optionVal.push(e.options[i].text);
                        }
                        var checkUrl = window.location.search;
                        if(checkUrl){
                            var seperateValues = checkUrl.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                for(j = 0; j < optionVal.length; j++){
                                    if(seperateValues[i].indexOf(optionVal[j]) === -1){
                                        count++;
                                    }
                                }
                                if(count == optionVal.length) finalstring += seperateValues[i] + '&';
                            }
                        }
                        if(e === 'null'){
                            if(finalstring.slice(-1) === '&'){
                                finalstring = finalstring.slice(0, finalstring.length-1);
                            }
                            window.location.href="https://people.cs.clemson.edu/~siyunl/4620/project/admin.php"+ finalstring + "#users";
                        }else{
                            window.location.href="https://people.cs.clemson.edu/~siyunl/4620/project/admin.php"+ finalstring + e.options[e.selectedIndex].value + "=" + a.value+"#users";
                        }   */                      
                    }
                    function resetUsertable(){
                        var checkUrl = window.location.search;
                        var i, substrings = "selectedUserID", finalstring="?";
                        if(checkUrl){
                            var seperateValues = checkUrl.substring(1).split('&');
                            for(i = 0; i < seperateValues.length; i++){
                                if(seperateValues[i].indexOf(substrings) === -1){
                                    finalstring += seperateValues[i] + '&';
                                }
                            }
                        }
                        if(finalstring.slice(-1) === '&'){
                            finalstring = finalstring.slice(0, finalstring.length-1);
                        }
                        window.location.href="https://people.cs.clemson.edu/~siyunl/4620/project/admin.php"+ finalstring + "#users";
                    }
                </script>
                <br>
                <br>
                <div class="scroll">
                    <?php
                      if(isset($_SESSION['views'])){
                        $temp = $_SESSION['views'];
                        $queryForUserview = "SELECT * FROM User u, UserType ut WHERE u.UTId = ut.UTId AND u.Email != '$temp'";
                        if(isset($_GET['selectedUserID']) && !empty($_GET['selectedUserID'])){
                            $uidForUserSearch = $_GET['selectedUserID'];
                            $uidPieces = explode(",", $uidForUserSearch);
                            $lengthOfselect = count($uidPieces);
                            if($lengthOfselect == 1) $queryForUserview .= " AND u.UId = '$uidForUserSearch'";
                            else{
                                $finalSearch = "";
                                for($index = 0; $index < $lengthOfselect; $index++){
                                    if($index == $lengthOfselect-1) $finalSearch .= $uidPieces[$index];
                                    else $finalSearch .= $uidPieces[$index] . ",";
                                }
                                $queryForUserview .= " AND u.UId IN (" . $finalSearch . ")";

                            }
                            
                        }/*else if(isset($_GET['Email']) && !empty($_GET['Email'])){
							$emailForUserSearch = $_GET['Email'];
							$queryForUserview .= " AND Email = \"$emailForUserSearch\"";
						}else if(isset($_GET['Username']) && !empty($_GET['Username'])){
							$usernameForUserSearch = $_GET['Username'];
							$queryForUserview .= " AND Username = \"$usernameForUserSearch\"";
						}else if(isset($_GET['Type']) && !empty($_GET['Type'])){
							$typeForUserSearch = $_GET['Type'];
							$queryForUserview .= " AND Type = \"$typeForUserSearch\"";
						}*/
						if(!isset($_GET['uid']) || empty($_GET['uid'])) echo "<span> *only email case sensitive <span>";
	                    $resultForUserview = mysql_query($queryForUserview, $con);
	                    echo "<div id='replaceasUserinfo'><table align=\"center\" id='usersTable'>";
	                    echo "<tr>
	                            <th>UId</th>
	                            <th>Username</th>
	                            <th>Email</th>
	                            <th>User type</th>
	                            <th>Select</th>
	                          </tr>";
	                    while($row_user_output = mysql_fetch_assoc($resultForUserview)){
	                        echo "<tr>";
	                        echo "<td>".$row_user_output['UId']."</td>";
	                        echo "<td>".$row_user_output['Username']."</td>";
	                        echo "<td>".$row_user_output['Email']."</td>";
	                        echo "<td>".$row_user_output['Type']."</td>";
	                        echo "<td><button class='button button3' id='uid".$row_user_output['UId']."' onclick='selectUser(this.id)'>select</button></td>";
	                        echo "</tr>";
	                    }
	                    echo "</table></div>";
	                    echo "<script type=\"text/javascript\">
                                function selectUser(e){
                                    var uid = e.split('uid')[1];
                                    var checkUrl = window.location.search;
									var i, substringUser = \"uid\", finalstring=\"?\";
									if(checkUrl){
										var seperateValues = checkUrl.substring(1).split('&');
										for(i = 0; i < seperateValues.length; i++){
											if(seperateValues[i].indexOf(substringUser) === -1){
												finalstring += seperateValues[i] + '&';
											}
										}
									}
                                    window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"uid=\" + uid + \"#users\"; 
                                }
                            </script>";
                        if(isset($_GET['uid']) && !empty($_GET['uid'])){
                            $uidGet = $_GET['uid'];
                            $queryForSelectedUser = "SELECT t.TId, t.Amount, s.Name, g.Home, g.Away, g.Date, g.Time, g.Stadium
						                              FROM Game g, Section s, Stock ss, Ticket t, User u, Detail d
						                              WHERE g.GId = ss.GId AND
						                              s.SId = ss.SId AND
						                              d.SSId = ss.SSId AND
						                              d.DId = t.DId AND
						                              u.UId = t.UId AND
						                              u.UId = '$uidGet';";
						    $resultForSelectedUser = mysql_query($queryForSelectedUser, $con);
						    $queryForUserEmail = "SELECT Email FROM User WHERE UId = '$uidGet'";
						    $resultForUserEmail = mysql_query($queryForUserEmail, $con);
						    $userEmail = mysql_fetch_assoc($resultForUserEmail);
						    $userInfoTable = "<span> Ticket information for <strong> ".$userEmail['Email']."</span>";
		                    if (mysql_num_rows($resultForSelectedUser) == 0) {
		                        $userInfoTable .= "<h4> No ticket purchased. </h4>";
		                    }else{
								$userInfoTable .= "<table>";
								$userInfoTable .= "<tr><th>Home</th><th>Away</th><th>Date</th><th>Time</th><th>Stadium</th><th>Section</th><th>Amount</th><th>Request</th></tr>";
		                      	while($row_user_table = mysql_fetch_assoc($resultForSelectedUser)){
									$userInfoTable .= "<tr>";
									$userInfoTable .= "<td>".$row_user_table['Home']."</td>";
									$userInfoTable .= "<td>".$row_user_table['Away']."</td>";
									$userInfoTable .= "<td>".$row_user_table['Date']."</td>";
									$userInfoTable .= "<td>".$row_user_table['Time']."</td>";
									$userInfoTable .= "<td>".addslashes($row_user_table['Stadium'])."</td>";
									$userInfoTable .= "<td>".$row_user_table['Name']."</td>";
									$userInfoTable .= "<td>".$row_user_table['Amount']."</td>";
									if(file_exists("./userrequest/".$row_user_table['TId'])){
										$userInfoTable .= "<td><div id='replaceRequestapprove".$row_user_table['TId']."'><button class='button button2' id='approve".$row_user_table['TId']."' onclick='approveRequest(this.id)'>Approve</button><button class='button button2' id='notapprove".$row_user_table['TId']."' onclick='notApproveRequest(this.id)'>Reject</button></div></td>";
									}else{
										$userInfoTable .= "<td><b>None</b></td>";
									}
									$userInfoTable .= "</tr>";
			                    }
			                    $userInfoTable .= "</table>";
			                }
			                 echo "<script type=\"text/javascript\">
			                    		function resetUserInfotable(){
					                        var checkUrl = window.location.search;
					                        var i, substrings = \"uid\", finalstring=\"?\";
					                        if(checkUrl){
					                            var seperateValues = checkUrl.substring(1).split('&');
					                            for(i = 0; i < seperateValues.length; i++){
					                                if(seperateValues[i].indexOf(substrings) === -1){
				                                        finalstring += seperateValues[i] + '&';
				                                    }
					                            }
					                        }
					                        if(finalstring.slice(-1) === '&'){
					                            finalstring = finalstring.slice(0, finalstring.length-1);
					                        }
					                        window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/admin.php\"+ finalstring + \"#users\";
					                    } 
			                   			document.getElementById(\"replaceasUserinfo\").innerHTML = \"".$userInfoTable."\";
			                   			document.getElementById(\"replaceResetTable\").innerHTML = \"<button style='border:2px solid #ccc; border-radius: 4px; background-color:white;float:right;' type='button' onclick='resetUserInfotable();'>Table reset</button>\";

			                   			function approveRequest(e){
                                            var tid = e.split('approve')[1];
                                            var idForApprove = 'approve'+tid;
                                            var idForNotApprove = 'notapprove'+tid;
                                            $.ajax({
                                                url: \"././specialphp/approveRefund.php\",
                                                type: \"POST\",
                                                data: {
                                                  tid: tid
                                                },
                                                cache: false,
                                                success: function(data) {
                                                    if(data.msg == 'success'){
                                                        document.getElementById('replaceRequestapprove'+e.split('approve')[1]).innerHTML = \"<button class='button button2' type='button' id=idForApprove disabled='true'>Refunding</button><button class='button button2' type='button' id=idForNotApprove disabled='true'>Reject</button>\";
                                                        location.reload();
                                                        
                                                    }else alert(data.msg);
                                                }
                                            });
					                    } 
					                    function notApproveRequest(e){
			                   				var tid = e.split('notapprove')[1];
                                            var idForApprove = 'approve'+tid;
                                            var idForNotApprove = 'notapprove'+tid;
                                            $.ajax({
                                                url: \"././specialphp/rejectRefund.php\",
                                                type: \"POST\",
                                                data: {
                                                  tid: tid
                                                },
                                                cache: false,
                                                success: function(data) {
                                                    if(data.msg == 'success'){
                                                        document.getElementById('replaceRequestapprove'+e.split('approve')[1]).innerHTML = \"<button class='button button2' type='button' id=idForApprove disabled='true'>Approve</button><button class='button button2' type='button' id=idForNotApprove disabled='true'>Reject</button>\";
                                                        
                                                    }else alert('Rename error!');
                                                },
                                                error: function(){
                                                    alert('Rename fail!');
                                                }
                                            });
					                        
					                    } 
			                   		 </script> ";
                        }
	                  }
	                ?>
             	</div>
            </div>
		 </div>
    </section>
    
    <section id="backup" style="background-color: #f8f9fa;">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Backup</h2>
            <h3 class="section-subheading text-muted">Backup selected tables from database</h3>
          </div>
        </div>
        <div class="col-lg-12 text-center">
            <div class="container">
                <select style="border:2px solid #ccc; border-radius: 4px;" id="backupTablename">
                    <?php 
                        $queryForTablenames = "SELECT table_name FROM information_schema.tables WHERE table_schema='database4620_g89k'";
                        $resultForTablenames = mysql_query($queryForTablenames, $con);
                        while($row_table_names = mysql_fetch_row($resultForTablenames)){
                            echo "<option value=" . $row_table_names[0] . ">" . $row_table_names[0] . "</option>";
                        }
                    ?>
                </select>
                <button style="border:2px solid #ccc; border-radius: 4px; background-color:white;" onclick="backup();">Backup</button>
                <button style="border:2px solid #ccc; border-radius: 4px; background-color:white;" onclick="location.reload();">Refresh</button>
                <div id='backupInfo'></div>
                <script type="text/javascript">
                    function backup(){
                        var e = document.getElementById("backupTablename");
                        var tableName = e.options[e.selectedIndex].value;
                        $.ajax({
                            url: "././specialphp/backup.php",
                            type: "POST",
                            data: {
                              tableName: tableName
                            },
                            cache: false,
                            success: function(data) {
                                if(data.msg == 'success'){
                                    var output = "<b>"+data.reminder+"</b>";
                                    document.getElementById("backupInfo").innerHTML = output; 
                                }
                            }
                        });
                    }
                </script>
                <br>
                <div class="scroll">
                    <table>
                        <?php
                            if(count(glob('./backuprecord/*.sql')) > 0){
                                echo "<tr><th>Records</th><th>Download</th></tr>";
                            }
                        ?>
                        <?php
                            foreach(glob('./backuprecord/*.sql') as $filename){
                                echo "<tr><td>" . $filename . "</td>
                                        <td><button class='button button3' id='".$filename."' onclick='viewBackup(this.id);'>link</button></td></tr>";
                            }
                        ?>
                    </table>
                    <script type="text/javascript">
                        function viewBackup(e){
                            var link = e.substr(1);
                            window.open("https://people.cs.clemson.edu/~siyunl/4620/project" + link);
                        }
                    </script>
                </div>
            </div>
        </div>
    </section>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <span class="copyright">Copyright &copy; Siyun Lyu 2017</span>
          </div>
          <div class="col-md-6">
            <ul class="list-inline quicklinks">
              <li class="list-inline-item">
                <a href="#">Back to the top</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>


  </body>

</html>
