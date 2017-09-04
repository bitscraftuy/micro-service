<?php
  require_once('define.php');
  require_once('connection.php');

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    //$controller = 'pages';
    //$action     = 'home';

    header("Location: http://URL/");
    die();
  }
  	
  require_once('views/layout.php'); // use as webservice		
  

  

  
  
?>