<?php  
  include("config.php");
  header('Content-type: application/json');
  ini_set('session.save_path', 'tmp'); 
  session_start();

  $con = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
  mysql_select_db(DB_DATABASE,$con);
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = "SELECT Email FROM User WHERE Email = '$email'";
  $result = mysql_query($query, $con);
  $count = mysql_num_rows($result);
  if($count == 0){
    $response['status'] = 'error';  
    $response['message'] = "Email does not exist! Please go to register first :)";
    echo json_encode($response);
    return false;
  }else{
    $query = "SELECT Username FROM User WHERE Email = '$email' AND Password = '$password'";
    $result = mysql_query($query, $con);
    $count = mysql_num_rows($result);
    if($count == 1){
      $_SESSION['views'] = $email;
      $response['status'] = 'success'; 
      if($email == "admin@clemson.edu"){
        $response['message'] = "https://people.cs.clemson.edu/~siyunl/4620/project/admin.php";
      }else{ 
        $response['message'] = "https://people.cs.clemson.edu/~siyunl/4620/project/";
      }
      echo json_encode($response);
      return true;
    }else{
      $response['status'] = 'error';  
      $response['message'] = "Password wrong! Re-enter your password :)";
      echo json_encode($response);
      return false;
    } 
  }
?> 