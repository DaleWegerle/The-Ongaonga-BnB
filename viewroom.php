<?php
include "header.php";
include "listroomsmenu.php";
echo '<div id="site_content">';
echo '<div id="content" style="width: 100%">';
error_reporting(0);
?>
<!DOCTYPE HTML>
<html><head><title>View Booking</title> </head>
 <body>
 
<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}
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
        echo "<h2>Invalid room ID</h2>"; //simple error feedback
        exit;
    } 
}
 
//the data was sent using a form therefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) 
    and ($_POST['submit'] == 'Delete')) {     
    $error = 0; //clear our error flag
    $msg = 'Error: ';  
//memberID (sent via a form it is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) 
        and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid room ID '; //append error message
       $id = 0;  
    }        
    
//save the member data if the error flag is still clear and member id is > 0
    if ($error == 0 and $id > 0) {
        $query = "DELETE FROM bnb.room WHERE roomID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'i', $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Room details deleted.</h2>";     
        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
}
 
//prepare a query and send it to the server
//NOTE for simplicity purposes ONLY we are not using prepared queries
//make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM bnb.room WHERE roomID='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Booking Details View</h1>
<h2><a href='listrooms.php'>[Return to the room list page]</a></h2>
<?php
 
//makes sure we have the member
if ($rowcount > 0) {  
   echo "<fieldset style='padding: 20px; font-size: 15px; line-height: 30px;'><legend><h3>Room Details #$id</h3></legend><dl>"; 
   $row = mysqli_fetch_assoc($result);
   echo "<dt>Room ID:</dt><dd style= 'padding-left: 20px; color: red;'>".$row['roomID']."</dd>".PHP_EOL;
   echo "<dt>Room Name:</dt><dd style= 'padding-left: 20px; color: red;'>".$row['roomname']."</dd>".PHP_EOL;
   echo "<dt>Discription:</dt><dd style= 'padding-left: 20px; color: red;'>".$row['description']."</dd>".PHP_EOL;
   echo "<dt>Room Type:</dt><dd style= 'padding-left: 20px; color: red;'>".$row['roomtype']."</dd>".PHP_EOL; 
   echo "<dt>Beds:</dt><dd style= 'padding-left: 20px; color: red;'>".$row['beds']."</dd>".PHP_EOL; 
   echo '</dl></fieldset>'.PHP_EOL;  
   ?><form method="POST" action="viewroom.php">
     <h2>Would you like to delete this booking?</h2>
     <input type="hidden" name="id" value="<?php echo $id; ?>">
     <a style="
     margin-right: 10px;
     font-size: 17px;
     color: white;  
     background-color: 	#008000;
     color: white;
     padding: 15px 32px;
     text-align: center;
     text-decoration: none;
     display: inline-block;" href="listrooms.php">Back</a>

     <input style="
     font-size: 20px;
     background-color: #f44336;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;" type="submit" name="submit" value="Delete">
     </form>
<?php    
} else echo "<h2>Room deleted!</h2>"; //suitable feedback
 
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
?>
</table>
</body>
</html>





