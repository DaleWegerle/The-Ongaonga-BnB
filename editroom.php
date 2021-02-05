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
<html><head><title>Edit Room</title> </head>
 <body>

<h1 style="margin-top: 20px;"><strong>Room Details Update</strong></h1>


<fieldset style="padding: 10px; margin-top: 50px; font-size: 15px;"><legend><h1><strong>Room detail #$id</strong></h1></legend><dl><br>

  <dt><strong>Name: </strong></dt>
  <dd style="padding-left: 20px;">Extracted Room Name Here</dd><br>

  <dt><strong>Discription: </strong></dt>
  <dd style="padding-left: 20px;">Room Discription here</dd><br>

  <dt><strong>Room Type: </strong></dt>
  <dd style="padding-left: 20px;">D</dd><br>

  <dt><strong>Beds: </strong></dt>
  <dd style="padding-left: 20px;">3</dd>

  </dl></fieldset>

<br><br>
<hr style="border-top: 5px dashed black; ">
<br><br>

<h2><strong>Update<strong></h2>

<form style="font-size: 15px;">
  <p>
    <label for="Room">Room Name:</label>
    <input type="text" name="Room" value="Room Name Here" minlength="8" maxlength="25" required>
  </p>
  <p>
    <label for="Discription">Discription:</label>
    <input type="text" name="Discription" value="Discription Here" minlength="8" maxlength="100" required>
  </p>
  <p>
    <label for="RoomType">Room Type:</label>

    <label for="Single" style="font-weight: initial;">Single: </label>
    <input type="radio" id="Single" name="RoomType" value="S" required>
    
    <label for="Double" style="font-weight: initial;">Double: </label>
    <input type="radio" id="Double" name="RoomType" value="D">
  </p>
  <p>
  <label for="Beds">Beds (1-5):</label>
        <select id="Beds" name="Beds" required >
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
  </p>
  <p>
    <input type="submit" value="Update" style="padding: 10px; margin: 0px 20px 20px 0px;">
    <a href="listrooms.php">Cancel</a>
  </p>
  <a href="listrooms.php" style="font-size: 20px;">Back To List Rooms</a>


</body>
</html>
