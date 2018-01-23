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
    <!-- <link href="css/test.min.css" rel="stylesheet"> -->

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

    <!-- Profile -->
    <section id="profile">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Personal Information</h2>
            <h3 class="section-subheading text-muted">Manage this basic information — your name, email, address and phone number</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="team-member">
              <img class="mx-auto rounded-circle" src="img/person-icon.png" alt="">
              <!-- <h4>Personal image</h4>
              <p class="text-muted">Edit image</p> -->
              <ul class="list-inline social-buttons">
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fa fa-facebook"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <i class="fa fa-linkedin"></i>
                  </a>
                </li>
              </ul>
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
          .button2 {
            background-color: #D07432;
            padding: 8px;
            float: right;
            border-radius: 8px;
          }
          </style>
         <!--  style= "padding:15px; border-top:1px solid black; border-left:1px solid black; border-bottom:1px solid black;" -->
          <div class="col-lg-8">
            <div class="container" style= "padding:20px;">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Username from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);

                  if(isset($_GET['username']) && !empty($_GET['username'])){
                    $username = $_GET['username'];
                  }else{
                    $username = $user['Username'];
                  }
                  echo "<h4 id=\"changeusername\">Username: ";
                  if($username == null){
                    echo "Add one...";
                  }else{
                    echo $username;
                  }
                  echo "<button class=\"button button3\" onclick=\"showinputboxu()\">Change</button></h4>";
                  echo "<script>
                        function showinputboxu(){
                          var output = \"\";
                          output += '<h4>Username: <input id=\"newusername\" type=\"text\" placeholder=\"new username *\">';
                          output += '<button class=\"button button2\" onclick=\"submituchanges()\" >submit</button></h4>';
                          document.getElementById(\"changeusername\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submituchanges(){
                          var e = document.getElementById(\"newusername\").value;
                          window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/profile.php?username=\"+ e;
                        }
                        </script>";
                  if(isset($_GET['username']) && !empty($_GET['username'])){
                    $username = addslashes($_GET['username']);
                    $query = "update User set Username = '$username' where Email = '$temp'";
                    $result = mysql_query($query, $con);
                  }
                }
              ?>
            </div>
            <div class="container" style= "padding:20px;">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Firstname from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);
                  if(isset($_GET['firstname']) && !empty($_GET['firstname'])){
                    $firstname = $_GET['firstname'];
                  }else{
                    $firstname = $user['Firstname'];
                  }
                  echo "<h4 id=\"changefirstname\">Firstname: ";
                  echo  $firstname;
                  echo "<button class=\"button button3\" onclick=\"showinputboxf()\">Change</button></h4>";
                  echo "<script>
                        function showinputboxf(){
                          var output = \"\";
                          output += '<h4>Firstname: <input id=\"newfirstname\" type=\"text\" placeholder=\"new firstname *\">';
                          output += '<button class=\"button button2\" onclick=\"submitfchanges()\" >submit</button></h4>';
                          document.getElementById(\"changefirstname\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submitfchanges(){
                          var e = document.getElementById(\"newfirstname\").value;
                          window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/profile.php?firstname=\"+ e;
                        }
                        </script>";
                  if(isset($_GET['firstname']) && !empty($_GET['firstname'])){
                    $firstname = addslashes($_GET['firstname']);
                    $query = "update User set Firstname = '$firstname' where Email = '$temp'";
                    $result = mysql_query($query, $con);
                  }
                }
              ?>
            </div>
            <div class="container" style= "padding:20px;">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Lastname from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);
                  if(isset($_GET['lastname']) && !empty($_GET['lastname'])){
                    $lastname = $_GET['lastname'];
                  }else{
                    $lastname = $user['Lastname'];
                  }
                  echo "<h4 id=\"changelastname\">Lastname: ";
                  echo  $lastname;
                  echo "<button class=\"button button3\" onclick=\"showinputboxl()\">Change</button></h4>";
                  echo "<script>
                        function showinputboxl(){
                          var output = \"\";
                          output += '<h4>Lastname: <input id=\"newlastname\" type=\"text\" placeholder=\"new lastname *\">';
                          output += '<button class=\"button button2\" onclick=\"submitlchanges()\" >submit</button></h4>';
                          document.getElementById(\"changelastname\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submitlchanges(){
                          var e = document.getElementById(\"newlastname\").value;
                          window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/profile.php?lastname=\"+ e;
                        }
                        </script>";
                  if(isset($_GET['lastname']) && !empty($_GET['lastname'])){
                    $lastname = addslashes($_GET['lastname']);
                    $query = "update User set Lastname = '$lastname' where Email = '$temp'";
                    $result = mysql_query($query, $con);
                  }
                }
              ?>
            </div>
            <div class="container" style= "padding:20px">
              <?php
                if(isset($_SESSION['views'])){
                  echo "<h4>Email: ";
                  echo $_SESSION['views'];
                  echo "<button class=\"button button3\" disabled>Not changable</button></h4>";
                }
              ?>
            </div>
            <div class="container" style= "padding:20px;">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Phone from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);
                  if(isset($_GET['phone']) && !empty($_GET['phone'])){
                    $phone = $_GET['phone'];
                  }else{
                    $phone = $user['Phone'];
                  }
                  echo "<h4 id=\"changephone\">Phone: ";
                  if($phone == null){
                    echo "Add one...";
                  }else{
                    echo $phone;
                  }
                  echo "<button class=\"button button3\" onclick=\"showinputboxp()\">Change</button></h4>";
                  echo "<script>
                        function showinputboxp(){
                          var output = \"\";
                          output += '<h4>Phone: <input id=\"newphone\" type=\"text\" placeholder=\"new phone number *\">';
                          output += '<button class=\"button button2\" onclick=\"submitpchanges()\" >submit</button></h4>';
                          document.getElementById(\"changephone\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submitpchanges(){
                          var e = document.getElementById(\"newphone\").value;
                          console.log(!isNaN(parseFloat(e)) && isFinite(e));
                          if(!isNaN(parseFloat(e)) && isFinite(e)) window.location.href=\"https://webapp.cs.clemson.edu/~siyunl/4620/project/profile.php?phone=\"+ e;
                          else alert('Not a valid phone number');
                        }
                        </script>";
                  if(isset($_GET['phone']) && !empty($_GET['phone'])){
                    $phone = $_GET['phone'];
                    $query = "update User set Phone = '$phone' where Email = '$temp'";
                    $result = mysql_query($query, $con);
                  }
                }
              ?>
            </div>
            <div class="container" style= "padding:20px;">
              <?php
                if(isset($_SESSION['views'])){
                  $temp = $_SESSION['views'];
                  $query = "select Address from User where Email = '$temp'";
                  $result = mysql_query($query, $con);
                  $user = mysql_fetch_assoc($result);

                  if(isset($_GET['address']) && !empty($_GET['address'])){
                    $address = $_GET['address'];
                  }else{
                    $address = $user['Address'];
                  }
                  echo "<h4 id=\"changeaddress\">Address: ";
                  if($address == null){
                    echo "Add one...";
                  }else{
                    echo $address;
                  }
                  echo "<button class=\"button button3\" onclick=\"showinputboxa()\">Change</button></h4>";
                  echo "<script>
                        function showinputboxa(){
                          var output = \"\";
                          output += '<h4>Address: <input id=\"newaddress\" type=\"text\" placeholder=\"new address *\">';
                          output += '<button class=\"button button2\" onclick=\"submitachanges()\" >submit</button></h4>';
                          document.getElementById(\"changeaddress\").innerHTML = output;
                        }
                        </script>";
                  echo "<script type=\"text/javascript\">
                        function submitachanges(){
                          var e = document.getElementById(\"newaddress\").value;
                          window.location.href=\"https://people.cs.clemson.edu/~siyunl/4620/project/profile.php?address=\"+ e;
                        }
                        </script>";
                  if(isset($_GET['address']) && !empty($_GET['address'])){
                    $address = addslashes($_GET['address']);
                    $query = "update User set Address = '$address' where Email = '$temp'";
                    $result = mysql_query($query, $con);
                  }
                }
              ?>
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

  </body>

</html>
