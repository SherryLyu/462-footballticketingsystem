<?php  
  ini_set('session.save_path', 'tmp');
  session_start();
  unset($_SESSION['views']);
  header("location:https://people.cs.clemson.edu/~siyunl/4620/project/");
?> 