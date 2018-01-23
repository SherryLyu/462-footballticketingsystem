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

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Easy ticketing</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#portfolio">Games</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
            <?php
              if(isset($_SESSION['views'])){
                $temp = $_SESSION['views'];
                $query = "SELECT Username FROM User WHERE Email = '$temp'";
        				$result = mysql_query($query, $con);
        				$user = mysql_fetch_assoc($result);
        				$username = $user['Username'];
                echo "<li class=\"nav-item\" \"dropdown\">";
                echo "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
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

    <!-- Header -->
    <header class="masthead">
      <div class="container">
        <div class="intro-text">
          <div class="intro-lead-in">Welcome To Easy Football ticketing!</div>
          <div class="intro-heading">It's Nice To Meet You</div>
          <a class="btn btn-xl js-scroll-trigger" href="#portfolio">Purchase Ticket</a>
        </div>
      </div>
    </header>

    <!-- Services -->
    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Services</h2>
            <h3 class="section-subheading text-muted">We have wonderful services.</h3>
          </div>
        </div>
        <p id="service"></p>
        <script>
          var img = ["shopping-cart", "laptop", "lock"];
          var sh = ["Purchase tickets", "Modify profile", "Top service"];
          var tm = ["You can easily charge your balance and purchase tickets online.","You can modify your personal profile quick and easy.","Ask refund anytime you want."]
          var serviceinfo = "", i;
          serviceinfo += "<div class=\"row text-center\"><div class=\"col-md-4\">";
          for (i = 0; i < sh.length; i++){
            serviceinfo = serviceinfo + "<span class=\"fa-stack fa-4x\"><i class=\"fa fa-circle fa-stack-2x text-primary\"></i>";
            serviceinfo = serviceinfo + "<i class=\"fa fa-" + img[i] + " fa-stack-1x fa-inverse\"></i></span>";
            serviceinfo = serviceinfo + "<h4 class=\"service-heading\">" + sh[i] + "</h4>";
            serviceinfo = serviceinfo + "<p class=\"text-muted\">" + tm[i] + "</p></div><div class=\"col-md-4\">";
          }
          serviceinfo += "</div>";
          document.getElementById("service").innerHTML = serviceinfo;
        </script>
      </div>
    </section>

    <!-- portfolio Grid -->
    <section class="bg-light" id="portfolio">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Games</h2>
            <h3 class="section-subheading text-muted">Games 2017 as following.</h3>
          </div>
        </div>
        <p id="gamesinfo"></p>
        <script>
          var modal = ["1","2","3","4","5","6","7","8","9","10","11","12"];
          var schoolImg = ["kvsc", "avsc", "lvsc", "bvsc", "vvsc", "wvsc", "svsc", "gvsc", "nvsc", "fvsc", "cvsc", "scvsc"];
          var school = ["Kent State", "Auburn", "Louisville", "Boston College", "Virginia Tech", "Wake Forest", "Syracuse", "Georgia Tech", "NC State", "Florida State", "Citadel", "South Carolina"];
          var output = "", i;
          output += "<div class=\"row\">";
          for (i = 0; i < modal.length; i++){
            output += "<div class=\"col-md-4 col-sm-6 portfolio-item\">";
            output += "<a class=\"portfolio-link\" data-toggle=\"modal\" href=\"#portfolioModal"+ modal[i] + "\">";
            output += "<div class=\"portfolio-hover\"><div class=\"portfolio-hover-content\"><i class=\"fa fa-plus fa-3x\"></i></div></div>";
            output += "<img class=\"img-fluid\" src=\"img/portfolio/" + schoolImg[i] + ".jpg\" alt=\"\"></a>";
            output += "<div class=\"portfolio-caption\"><h4> Clemson vs " + school[i] + "</h4></div></div>"
          }
          output += "</div>";
          document.getElementById("gamesinfo").innerHTML = output;
        </script>
      </div>
    </section>

    <style>
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 110px;
	  height: 34px;
	}

	.switch input {display:none;}

	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #522D80;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 26px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: #F66733;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #F66733;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(75px);
	  -ms-transform: translateX(75px);
	  transform: translateX(75px);
	}

	.student
	{
	  display: none;
	}

	.student, .faculty
	{
	  color: white;
	  position: absolute;
	  transform: translate(-50%,-50%);
	  top: 50%;
	  left: 50%;
	  font-size: 10px;
	  font-family: Verdana, sans-serif;
	}

	input:checked+ .slider .student
	{display: block;}

	input:checked + .slider .faculty
	{display: none;}


	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}
	</style>
    <!-- Register/Login -->
    <div class="portfolio-modal modal fade" id="signup_login" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <div class="lr">
              <div class="rl"></div>
            </div>
          </div>
	        <div class="row">
	          <div class="col-md-6">
	          	<div class="col-lg-12 text-center">
		          	<h2 class="section-heading">Regitser</h2>
		            <p class="item-intro text-muted">Let's become one of us.</p>
		          </div>
              <div class="col-lg-12">
  	            <form id="registerForm" name="sentRegister" novalidate>
  	              <div class="row">
  	                <div class="col-md-6 col-md-offset-3">
                      <div class="form-group">
                        <input class="form-control" id="firstnameregis" type="text" placeholder="Your Firstname *" required data-validation-required-message="Please enter your firstname.">
                        <p class="help-block text-danger"></p>
                      </div>
  	                  <div class="form-group">
  	                    <input class="form-control" id="lastnameregis" type="text" placeholder="Your Lastname *" required data-validation-required-message="Please enter your lastname.">
  	                    <p class="help-block text-danger"></p>
  	                  </div>
  	                  <div class="form-group">
  	                    <input class="form-control" id="emailregis" type="email" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
  	                    <p class="help-block text-danger"></p>
  	                  </div>          
                      <div class="form-group">
                        <input class="form-control" id="usernameregis" type="text" placeholder="Your Username *" required data-validation-required-message="Please enter your username.">
                        <p class="help-block text-danger"></p>
                      </div>
  	                  <div class="form-group">
  	                    <input class="form-control" id="passwordregis" type="password" placeholder="Your Password *" required data-validation-required-message="Please enter your password.">
  	                    <p class="help-block text-danger"></p>
  	                  </div>
                      <div class="form-group">
                        <input class="form-control" id="passwordmatch" type="password" placeholder="Confirm Your Password *"> 
                        <p class="help-block text-danger"></p>
                      </div>
                      <label class="switch"> 
						  <input type="checkbox" id='usertypeinput'>
						  <div class="slider round" id='usertype'>
						  	<span class="student" id="1">Student</span>
						  	<span class="faculty" id="2">Faculty</span>
						  </div>	  
						</label>
  	                </div>
  	              </div>
  	              <div class="clearfix"></div>
  	              <div class="col-lg-12 text-center">
  	                <div id="successRegister"></div>
  	                <button id="sendRegisterButton" class="btn btn-xl" type="submit">Register</button>
  	              </div>
  	            </form>
              </div>
	          </div>

            <div class="col-md-6">
              <div class="col-lg-12 text-center">
                <h2 class="section-heading">Login</h2>
                <p class="item-intro text-muted">Welcome back.</p>
              </div>
              <div class="col-lg-12">
                <form id="loginForm" name="sentLogin" novalidate>
               <!--  <form action = "loginProcess.php" method = "post"> -->
                  <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                      <div class="form-group">
                        <input class="form-control" id="emaillogin" type="email" placeholder="Your email *" required data-validation-required-message="Please enter your email address.">
                        <p class="help-block text-danger"></p>
                      </div>
                      <div class="form-group">
                        <input class="form-control" id="passwordlogin" type="password" placeholder="Your Password *" required data-validation-required-message="Please enter your password.">
                        <p class="help-block text-danger"></p>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-lg-12 text-center">
                    <div id="Loginoutput"></div>
                    <button class="btn btn-xl" id="sendLoginButton" type="submit">Login</button>
                    <!-- <button class="btn btn-xl" name="login" type="submit">Login</button> -->
                  </div>
                </form>
              </div>
            </div>
	        </div>
        </div>
      </div>
    </div>

    <!-- Contact -->
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Contact Us</h2>
            <h3 class="section-subheading text-muted">Let us know what you think.</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <form id="contactForm" name="sentMessage" novalidate>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control" id="name" type="text" placeholder="Your Name *" required data-validation-required-message="Please enter your name.">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="email" type="email" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="phone" type="tel" placeholder="Your Phone *" required data-validation-required-message="Please enter your phone number.">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Your Message *" required data-validation-required-message="Please enter a message."></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 text-center">
                  <div id="success"></div>
                  <button id="sendMessageButton" class="btn btn-xl" type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <span class="copyright">Copyright &copy; Siyun Lyu 2017</span>
          </div>
<!--           <div class="col-md-4">
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
          </div> -->
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

    <!-- portfolio Modals -->
    <p id="modalsinfo"></p>
    <?php
      $query = "select * from Game";
      $result = mysql_query($query, $con);
      $gametable = array();
      while($game = mysql_fetch_assoc($result)){
        $gametable[] = $game;
      }
      $query_1 = "select * from Section";
      $result_1 = mysql_query($query_1, $con);
      $sectiontable = array();
      while($sec = mysql_fetch_assoc($result_1)){
        $sectiontable[] = $sec;
      }
      $query_2 = "select * from UserType";
      $result_2 = mysql_query($query_2, $con);
      $usertypetable = array();
      while($ut = mysql_fetch_assoc($result_2)){
        $usertypetable[] = $ut;
      }

      if(isset($_SESSION['views'])){
        $temp = $_SESSION['views'];
        $query_3 = "SELECT UId, UTId, Balance FROM User WHERE Email = '$temp'";
        $result_3 = mysql_query($query_3, $con);
        $user = mysql_fetch_assoc($result_3);
        $uid = $user['UId'];
        $utid = $user['UTId'];
        $balance = $user['Balance'];
        $query_4 = "SELECT Type FROM UserType WHERE UTId = '$utid'";
        $result_4 = mysql_query($query_4, $con);
        $usertype = mysql_fetch_assoc($result_4);
        $type = $usertype['Type'];
      }else{
        $uid = NULL;
        $utid = NULL;
        $type = NULL;
        $balance = NULL;
      }
    ?>
    <script>
      var modal = <?php echo json_encode($gametable); ?>//["1","2","3","4","5","6","7","8","9","10","11","12"];
      //var schoolImg = ["01-kvsc", "02-avsc", "03-lvsc", "04-bvsc", "05-vvsc", "06-wvsc", "07-svsc", "08-gvsc", "09-nvsc", "10-fvsc", "11-cvsc", "12-scvsc"];
      //var school = ["Kent State", "Auburn", "Louisville", "Boston College", "Virginia Tech", "Wake Forest", "Syracuse", "Georgia Tech", "NC State", "Florida State", "Citadel", "South Carolina"];
      var sectioninfo = <?php echo json_encode($sectiontable); ?> //["A", "B", "C", "D"];

      var modaloutput = "", k, l;//, s;
      for (k = 0; k < modal.length; k++){
        modaloutput += "<div class=\"portfolio-modal modal fade\" id=\"portfolioModal" + modal[k]['GId'] + "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">";
        modaloutput += "<div class=\"modal-dialog\"><div class=\"modal-content\"><div class=\"close-modal\" data-dismiss=\"modal\"><div class=\"lr\"><div class=\"rl\"></div></div></div>";
        modaloutput += "<div class=\"container\"><div class=\"row\"><div class=\"col-lg-8 mx-auto\"><div class=\"modal-body\">";
        modaloutput += "<h2>Home: " + modal[k]['Home'] + "</h2><h2>Away: " + modal[k]['Away'] + "</h2><img class=\"img-fluid d-block mx-auto\" src=\"img/portfolio/" + modal[k]['Picture'] + ".jpg\" alt=\"\"><img class=\"img-fluid\" src=\"img/portfolio/clemsonmemorialstadium.png\" alt=\"\">";
        modaloutput += "<ul class=\"list-inline\"><li>Date: " + modal[k]['Date'] + "</li><li>Time: " + modal[k]['Time'] + "</li><li>Location: " + modal[k]['Stadium'] + "</li></ul>";
        modaloutput += "<div class=\"col-lg-8 mx-auto\"></div><p>Section: <select id=sectionresult" + k + " onchange=\"getSectionResult(this)\">";
        modaloutput += "<option value=\"0section0\"> </option>";
        for (l = 1; l <= sectioninfo.length; l++){
          modaloutput += "<option value=\"" + k + "section" + l + "\">" + sectioninfo[l-1]['Name'] + "</option>";
        }
        modaloutput += "</select><b id='stockoutput" + k + "'></b></p>";
        modaloutput += "<p id='typeselect" + k + "'></p>";
        function getSectionResult(section){
          var uthtml="", s;
          var outputaddr = "typeselect" + section.id.slice(section.id.indexOf("sectionresult")+13);
          var usertypeinfo = <?php echo json_encode($usertypetable); ?>

          var type = <?php echo json_encode($type); ?> 

          var utid = <?php echo json_encode($utid); ?> 

          if(type == null){
            uthtml +=  "<p>Ticket type: <select id=utresult" + section[section.selectedIndex].value + " onchange=\"getAllResult(this)\">";
            uthtml += "<option value=\"0section0type0\">       </option>";
            for (s = 1; s <= usertypeinfo.length; s++){
              uthtml += "<option value=\"" + section[section.selectedIndex].value + "type" + s + "\">" + usertypeinfo[s-1]['Type'] + "</option>";
            }
            uthtml += "</select><b id='utoutput" + section[section.selectedIndex].value + "'></b></p>";
          }else{
            uthtml += "<p id=\"fixutresult\">Ticket type: <strong>" + type + " <b id='utoutput" + section[section.selectedIndex].value + "'></b></p>";
            var id = "utresult"+ section[section.selectedIndex].value;
            var forcheck = section[section.selectedIndex].value + "type" + utid;
            funPriceForFix(forcheck);
            getAllResult(id);
          }
          document.getElementById(outputaddr).innerHTML = uthtml;
        } 
       /* <p>Ticket type: <select id=utresult" + k + ">";
        modaloutput += "<option value=\"0type0\">       </option>";
        for (s = 1; s <= usertypeinfo.length; s++){
          modaloutput += "<option value=\"" + k + "type" + s + "\">" + usertypeinfo[s-1]['Type'] + "</option>";
        }
        modaloutput += "</select><b id='utoutput" + k + "'></b></p>*/
        /*modaloutput += "<p id=typeselect" + k + "></p><p>Ticket Amount: <input id=\"ticketamount\" type=\"text\" placeholder=\"Amount* \" required data-validation-required-message=\"Please enter ticket amount.\"><p></p></p>";*/
        modaloutput += "<p id='ticketoutput" + k + "'></p>";
        function getAllResult(all){
          var uid = <?php echo json_encode($uid); ?> 

          var utid = <?php echo json_encode($utid); ?> 

          var balance = <?php echo json_encode($balance); ?> 

          var tmhtml="";
          var outputaddr;
          if(uid == null){
            tmhtml += "<b>Welcome you to go to Register/Login to purchase! :)</b>";
            outputaddr = "ticketoutput" + all.id.split("section")[0].slice(all.id.split("section")[0].indexOf("utresult")+8);
          }else{
            outputaddr = "ticketoutput" + all.split("section")[0].slice(all.split("section")[0].indexOf("utresult")+8);
            tmhtml += "<b id='balanceoutput" + all.split("section")[0].slice(all.split("section")[0].indexOf("utresult")+8) + "'><b>Your <span style='color:#C0392B;'>current balance: </span>" + balance + " dollars</b></b><p></p>";
            tmhtml += "<p>Ticket Amount: <input id=\"ticketamount" + all.slice(all.indexOf("utresult")+8) + "type" + utid + "\" type=\"text\" placeholder=\"Amount* \" maxlength='2' size='8' required data-validation-required-message=\"Please enter ticket amount.\" onkeyup=\"purchase(this)\"><b id='howmuchtopay" + all.split("section")[0].slice(all.split("section")[0].indexOf("utresult")+8) + "'></b></p><b id='warning" + all.split("section")[0].slice(all.split("section")[0].indexOf("utresult")+8) + "'></b>";
            tmhtml += "<div id='successPurchase" + all.slice(all.indexOf("utresult")+8) + "type" + utid + "'></div>";
          }
          document.getElementById(outputaddr).innerHTML = tmhtml;
        } 
        modaloutput += "<p id='purchaseoutput" + k + "'></p>";
        function purchase(ticket){
          var uid = <?php echo json_encode($uid); ?> 

          var purchasehtml="";
          var outputaddr = "purchaseoutput" + ticket.id.split("section")[0].slice(ticket.id.split("section")[0].indexOf("ticketamount")+12);
         // var outputaddr = "ticketoutput" + all.id.split("section")[0].slice(all.id.split("section")[0].indexOf("utresult")+8);
          purchasehtml += "<button class=\"btn btn-primary\" id=\"purchaseTicket" + ticket.value + ticket.id + "userid" + uid +  "\" type=\"button\"><i class=\"fa fa-ticket\"></i>Buy</button><p></p>";
          document.getElementById(outputaddr).innerHTML = purchasehtml;
        } 
       /* modaloutput += "<button class=\"btn btn-primary\" id=\"purchaseTicket" + k + "\" data-submit=\"modal\" type=\"button\"><i class=\"fa fa-ticket\"></i>Buy</button><p></p>";*/
        modaloutput += "<div class=\"row\"><div class=\"col-lg-8 mx-auto\"><button class=\"btn btn-primary\" data-dismiss=\"modal\" type=\"button\"><i class=\"fa fa-times\"></i>Close</button></div></div>";
        modaloutput += "</div></div></div>";
        modaloutput += "</div></div></div></div>";
      }
      document.getElementById("modalsinfo").innerHTML = modaloutput;
    </script>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Register form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/registerCheck.js"></script>

    <!-- Login form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/loginCheck.js"></script>

    <!-- Check ticket stock JavaScript -->
    <script src="js/stockCheck.js"></script>

    <!-- Check ticket price JavaScript -->
    <script src="js/priceCheck.js"></script>
    
    <!-- Purchase ticket JavaScript -->
    <script src="js/purchaseTicket.js"></script>

    <!-- Contact form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>

  </body>

</html>
