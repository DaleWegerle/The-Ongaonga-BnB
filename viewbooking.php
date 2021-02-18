<?php
include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';

include "checksession.php";
checkUser();
loginStatus(); 


include "config.php"; //load in any variables
$DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE) or die();

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

<fieldset style="padding: 10px; font-size: 15px; margin-top: 50px; margin-bottom: 30px;"><legend><h2><strong>Booking details #$id</strong></h2></legend><dl><br>

  <dt  style="color: grey;"><strong>Room Name: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Room Name Here</dd><br>

  <dt  style="color: grey;"><strong>Check-In Date: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Date Here</dd><br>

  <dt  style="color: grey;"><strong>Check-Out Date: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Date Here</dd><br>

  <dt  style="color: grey;"><strong>Contact Number: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Number Here</dd><br>

  <dt  style="color: grey;"><strong>Extras: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Extras Here</dd><br>

  <dt  style="color: grey;"><strong>Room Review: </strong></dt><br>
  <dd style="padding-left: 20px;">Extracted Review Here</dd><br>

  </dl></fieldset>

  <a href="managebooking.php" style="font-size: 20px;">Back To Manage Bookings</a>

 

</body>
</html>






