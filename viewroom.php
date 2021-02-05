<?php
include "header.php";
include "menu.php";
echo '<div id="site_content">';

echo '<div id="content">';

include "checksession.php";
checkUser();
loginStatus(); 


include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

?>

<!DOCTYPE HTML>
<html>
  
<head><title>Browse rooms</title> 
<link rel = "stylesheet" type = "text/css" href = "style/style.css"/>
</head>
<body>

<fieldset style="padding: 10px; font-size: 15px; margin-top: 50px; margin-bottom: 30px;"><legend><h2><strong>Room detail #$id</strong></h2></legend><dl><br>

  <dt><strong>Name: </strong></dt>
  <dd style="padding-left: 20px;">Extracted Room Name Here</dd><br>

  <dt><strong>Discription: </strong></dt>
  <dd style="padding-left: 20px;">Extracted Room Discription here</dd><br>

  <dt><strong>Room Type: </strong></dt>
  <dd style="padding-left: 20px;">D</dd><br>

  <dt><strong>Beds: </strong></dt>
  <dd style="padding-left: 20px;">3</dd>

  </dl></fieldset>

  <a href="listrooms.php" style="font-size: 20px;">Back To List Rooms</a>

</body>
</html>






