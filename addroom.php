<?php

include "header.php";
include "listroomsmenu.php";
echo '<div id="site_content">';
echo '<div id="content">';
?>


<!DOCTYPE HTML>
<html><head><title>Edit Member</title> </head>
<body>

<?php


include "config.php"; //load in any variables
$DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE) or die();
 
if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};
 
//this line is for debugging purposes so that we can see the actual POST/GET data
//echo "<pre>"; var_dump($_POST); var_dump($_GET);echo "</pre>";
 
//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}
 
error_reporting(0);


/* the data was sent using a form therefore we use the $_POST instead of $_GET
   check if we are saving data first by checking if the submit button exists in
   the array */
   if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
    //if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
        include "config.php"; //load in any variables
        $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
     
        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
            header('Location: http://ongaona.unaux.com/listrooms.php', true, 301);
        };

       
     
    //validate incoming data - only the first field is done for you in this example - rest is up to you to do
    //firstname
        /*$error = 0; //clear our error flag
        $msg = 'Error: ';
        if (isset($_POST['firstname']) and !empty($_POST['firstname']) 
            and is_string($_POST['firstname'])) {
           $fn = cleanInput($_POST['firstname']); 
     //check length and clip if too big
           $firstname = (strlen($fn) > 50)?substr($fn,1,50):$fn; 
           //we would also do context checking here for contents, etc           
        } else {
           $error++; //bump the error flag
           $msg .= 'Invalid firstname '; //append error message
           $firstname = '';  
        } */
    

    $roomname = cleanInput($_POST['roomname']);        
    $description = cleanInput($_POST['description']);
    $roomtype = cleanInput($_POST['roomtype']);
    $beds = cleanInput($_POST['beds']);          
           
    //save the member data if the error flag is still clear
            $error = 0;
        if ($error == 0) {
            $query = "INSERT INTO bnb.room (roomname,description,roomtype,beds) VALUES (?,?,?,?)";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'ssss',$roomname,$description,$roomtype,$beds); 
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);    
            echo "<h2>Your Room Has Been Booked! See You Soon!</h2>";
            header('Location: http://ongaona.unaux.com/listrooms.php', true, 301);        
        } 
        mysqli_close($DBC); //close the connection once done
    }
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data

?>
<h1>Add A New Room</h1>
<h2><a href='listrooms.php'>[Return to the available room listing]</a></h2>
 
<form id="myForm" method="POST" action="addroom.php" >
  <p>
    <label for="roomname"><strong>Room Name:<strong></label><br>
    <input type="text" id="roomname" name="roomname" size="50"
            placeholder="Please enter the room name" required> 
  </p>  
  <p>
    <label for="description"><strong>Last-Name:<strong></label><br>
    <input type="text" id="description" name="description" size="50"
            placeholder="Please enter the rooms discription" required> 
  </p> 
  <p>
  <label for="roomtype"><strong>Room Type:<strong></label><br>
  <select name="roomtype" id="roomtype">
    <option value="S">S</option>
    <option value="D">D</option>
  </select>
  </p>
  <p>
  <label for="Beds"><strong>Beds:<strong></label><br>
  <select name="beds" id="beds">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
  </select>
  </p>
   <input type="submit" name="submit" value="Update">
 </form>
 <?php 
 echo "<h2 id='fname' style='color: red;'></h2>";

mysqli_close($DBC); //close the connection once done
?>
</body>
</html>