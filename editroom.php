<?php
include "header.php";
include "listroomsmenu.php";
echo '<div id="site_content">';
echo '<div id="content">';
?>

<!DOCTYPE HTML>
<html><head><title>Edit Booking</title>
</head>
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
 
//retrieve the memberid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Room ID</h2>"; //simple error feedback
        exit;
    } 
}
/* the data was sent using a form therefore we use the $_POST instead of $_GET
   check if we are saving data first by checking if the submit button exists in
   the array */
if (isset($_POST['submit']) and !empty($_POST['submit'])
    and ($_POST['submit'] == 'Update')) {
       
/* validate incoming data - only the first field is done for 
   you in this example - rest is up to you do*/
    $error = 0; //clear our error flag
    $msg = 'Error: ';  
     
/* memberID (sent via a form it is a string not a number so we try
   a type conversion!) */
    if (isset($_POST['id']) and !empty($_POST['id']) 
        and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid Booking ID '; //append error message
       $id = 0;  
    }   

      $roomID = cleanInput($_POST['roomID']); 
      $roomname = cleanInput($_POST['roomname']);        
      $description = cleanInput($_POST['description']);
      $roomtype = cleanInput($_POST['roomtype']);
      $beds = cleanInput($_POST['beds']);
    
//save the member data if the error flag is still clear and member id is > 0
    if ($error == 0 and $id > 0) {
        $query = "UPDATE unaux_27944105_bnb.room SET roomID=?,roomname=?,description=?,roomtype=?,beds=? WHERE roomID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'sssssi',$roomID, $roomname,$description,$roomtype,$beds,$id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        //echo "<h2>Member details updated.</h2>";     
        //Header Redirect
        header('Location: http://ongaona.unaux.com/listrooms.php', true, 301);
        die();
        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
 
}
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT roomID,roomname,description,roomtype,beds FROM unaux_27944105_bnb.room WHERE roomID='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
  $row = mysqli_fetch_assoc($result);
?>
<h1>Member update</h1>
<h2><a href='listrooms.php'>[Return to the room list]</a></h2>
 
<form method="POST" action="editroom.php">
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <p>
    <label for="roomID"><strong>Room ID:</strong> </label><br>
    <input type="text" id="roomID" name="roomID" minlength="5" 
           size="50" maxlength="50" required value="<?php echo $row['roomID']; ?>"> 
  </p>  
  <p>  
    <label for="roomname"><strong>Room Name: </strong></label><br>
    <input type="text" id="roomname" name="roomname" maxlength="255" 
           size="50" required value="<?php echo $row['roomname']; ?>"> 
   </p>
  <p>
    <label for="description"><strong>Room Discription:</strong> </label><br>
    <input type="text" id="description" name="description" minlength="8" 
           size="50" maxlength="255" required  value="<?php echo $row['description']; ?>"> 
  </p> 
  <p>
    <label for="roomtype"><strong>Room Type:<strong> </label><br>
    <input type="text" id="roomtype" name="roomtype" minlength="8" 
           size="50" maxlength="10" required  value="<?php echo $row['roomtype']; ?>"> 
  </p> 
  <p>
    <label for="beds"><stong>Beds:</strong> </label><br>
    <input type="text" id="beds" name="beds" minlength="8" 
           size="50" maxlength="10" required  value="<?php echo $row['beds']; ?>"> 
  </p> 
  
   <input type="submit" name="submit" value="Update">
 </form>
<?php 
} else { 
  echo "<h2>Booking not found with that ID</h2>"; //simple error feedback
}
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>
