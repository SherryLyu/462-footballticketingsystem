<?php ini_set('session.save_path', 'tmp'); session_start();include("config.php"); ?>
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
    <link href="css/test.min.css" rel="stylesheet">

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
            <?php
              if(isset($_SESSION['views'])){
                $con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
                mysql_select_db(DB_DATABASE,$con);
                $temp = $_SESSION['views'];
                $query = "SELECT Username FROM User WHERE Email = '$temp'";
                $result = mysql_query($query, $con);
                $user = mysql_fetch_assoc($result);
                if(isset($_GET['username']) && !empty($_GET['username'])){
                  $username = $_GET['username'];
                }else{
                  $username = $user['Username'];
                }
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


    <section id="ticketPage">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Ticket and Balance Information</h2>
            <h3 class="section-subheading text-muted">Manage your balance and view your ticket(s)</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <div class="team-member">
              <h3>Balance: </h3>
            </div>
          </div>
          <style>
          .button {
              border: none;
              color: white;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              cursor: pointer;
          }
          .button3 {
            background-color: #22598D;
            padding: 8px;
            float: right;
            border-radius: 8px;
          }
          .button4 {
            background-color: #22598D;
            padding: 8px;
            border-radius: 8px;
          }
          .button1 {
            background-color: #FAAC58;
            padding: 8px;
            border-radius: 8px;
          }
          .button2 {
            background-color: #D07432;
            padding: 8px;
            float: right;
            border-radius: 8px;
          }
          </style>
         <!--  style= "padding:15px; border-top:1px solid black; border-left:1px solid black; border-bottom:1px solid black;" -->
          <div class="col-lg-10">
            <div class="container">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Balance from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);
                  echo "<b id='withdrawWarning'></b>";
                  $balance = $user['Balance'];
                  echo "<h3 id=\"changebalance\">";
                  if($balance == null){
                    echo "Modify it";
                  }else{
                    echo $balance;
                  }
                  echo "<button class=\"button button3\" onclick=\"showmoneystep()\">Recharge</button></h3>";
                  echo "<script>
                        function showmoneystep(){
                            var output = \"<select id='money'>\", i, j=20;
							for(i = 0; i < 10; i++){
								output += \"<option value='\" + j + \"'>\" + j + \"</option>\";
								j += 20;
							}
							output += \"</select><button class='button button2' id='quitButton' onclick='submitbQuit()' >Quit</button><button class='button button2' id='withdrawButton' onclick='submitbWithdraw()' >Withdraw</button><button class='button button2' onclick='submitbDeposit()' id='depositButton'>Deposit</button>\";
							document.getElementById(\"changebalance\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submitbDeposit(){
                          var deposit = document.getElementById(\"money\").value;
                          var email = '".$temp."';
                          $(\"#depositButton\").prop('disabled', true);
                          $.ajax({
                                url: \"././specialphp/deposit.php\",
                                type: \"POST\",
                                data: {
                                  deposit: deposit,
                                  email: email
                                },
                                cache: false,
                                success: function(data) {
                                    if(data.msg == 'success') $('#withdrawWarning').html(\"<b style='color:#C0392B;'>Successfully deposit! --> current balance: \").append(data.newbalance).append(\"</b>\");
                                    $(\"#depositButton\").prop('disabled', false);
                                },
                                error: function() {
                                    $('#withdrawWarning').html(\"<b style='color:#C0392B;'> Error </b>\");
                                    $(\"#depositButton\").prop('disabled', false);
                                }
                            });
                        }
                        function submitbWithdraw(){
                          var withdraw = document.getElementById(\"money\").value;
                          var email = '".$temp."';
                          $(\"#withdrawButton\").prop('disabled', true);
                          $.ajax({
                                url: \"././specialphp/withdraw.php\",
                                type: \"POST\",
                                data: {
                                  withdraw: withdraw,
                                  email: email
                                },
                                cache: false,
                                success: function(data) {
                                    if(data.msg == 'success') $('#withdrawWarning').html(\"<b style='color:#C0392B;'>Successfully withdraw! --> current balance: \").append(data.newbalance).append(\"</b>\");
                                    else $('#withdrawWarning').html(\"<b style='color:#C0392B;'>----withdraw below limit! --> current balance: \").append(data.newbalance).append(\"</b>\");
                                    $(\"#withdrawButton\").prop('disabled', false);
                                },
                                error: function() {
                                    $('#withdrawWarning').html(\"<b style='color:#C0392B;'> Error </b>\");
                                    $(\"#withdrawButton\").prop('disabled', false);
                                }
                            }); 
                        }
                        function submitbQuit(){
                          window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/ticket.php\";
                        }
                        </script>";
                }
              ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <div class="team-member">
              <h3>Tickets: </h3>
            </div>
          </div>
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
          </style>
          <div class="col-lg-10">
            <div class="container">
              <div class="scroll">
                <?php
                  if(isset($_SESSION['views'])){
                    $temp = $_SESSION['views'];
                    $query = "SELECT t.TId, t.Amount, s.Name, g.Home, g.Away, g.Date, g.Time, g.Stadium
                              FROM Game g, Section s, Stock ss, Ticket t, User u, Detail d
                              WHERE g.GId = ss.GId AND
                              s.SId = ss.SId AND
                              d.SSId = ss.SSId AND
                              d.DId = t.DId AND
                              u.UId = t.UId AND
                              u.Email = '$temp';";
                    $result = mysql_query($query, $con);
                    if (mysql_num_rows($result) == 0) {
                        echo "<h4> No ticket purchased! Go get one! :) </h4>";
                    }else{
                      echo "<table>";
                      echo "<tr>
                              <th>Home</th>
                              <th>Away</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Stadium</th>
                              <th>Section</th>
                              <th>Amount</th>
                              <th>Request</th>
                            </tr>";
                      while($row = mysql_fetch_assoc($result)){
                          echo "<tr>";
                          echo "<td>".$row['Home']."</td>";
                          echo "<td>".$row['Away']."</td>";
                          echo "<td>".$row['Date']."</td>";
                          echo "<td>".$row['Time']."</td>";
                          echo "<td>".$row['Stadium']."</td>";
                          echo "<td>".$row['Name']."</td>";
                          echo "<td>".$row['Amount']."</td>";
                          if (file_exists("./userrequest/".$row['TId'])){
                            echo "<td><div id='rejectWarning".$row['TId']."'></div><button class='button button1' type='button' id='tid".$row['TId']."' disabled>Pending</button></td>";
                          }else if(file_exists("./userrequest/reject".$row['TId'])){
                            echo "<td><div id='rejectWarning".$row['TId']."'><b>Rejected.</b><br><b>Retry.</b></div><div id='replaceRequest".$row['TId']."'><button class='button button4' id='tid".$row['TId']."' onclick='sentRefundRequest(this.id)'>Refund</button></div></td>";
                          }else{
                            echo "<td><div id='rejectWarning".$row['TId']."'></div><div id='replaceRequest".$row['TId']."'><button class='button button4' id='tid".$row['TId']."' onclick='sentRefundRequest(this.id)'>Refund</button></div></td>";
                          }
                          echo "</tr>";
                      }
                      echo "</table>";
                      echo "<script type=\"text/javascript\">
                                function sentRefundRequest(e){
                                    var tid = e.split('tid')[1];
                                    window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/ticket.php?\"+\"tid=\"+tid; 
                                }
                            </script>";
                        if(isset($_GET['tid'])){
                            $tidGet = $_GET['tid'];
                            $currentPath = getcwd();
                            if(file_exists($currentPath."/userrequest/reject".$tidGet)){
                                $filename = $currentPath."/userrequest/reject".$tidGet;
                                unlink($filename);
                            }
                            $myfile = fopen("./userrequest/".$tidGet, "w") or die("Unable to open file!");
                            fclose($myfile);
                            echo "<script type=\"text/javascript\">
                                    document.getElementById('rejectWarning".$tidGet."').innerHTML = \"\";
                                    document.getElementById('replaceRequest".$tidGet."').innerHTML = \"<button class='button button1' type='button' id='tid".$tidGet."' disabled>Pending</button>\";
                                    window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/ticket.php\"; 
                                    </script>";

                        }
                        
                        
                    }
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
      
    <!-- Footer -->
    <footer style="background-color: #f8f9fa;">
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

   
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>
    <script src="js/stockCheck.js"></script>
    <script src="js/priceCheck.js"></script>
    <script src="js/purchaseTicket.js"></script>
  </body>

</html>
