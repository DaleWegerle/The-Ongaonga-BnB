<?php
include "header.php";
include "menu.php";
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
echo "<pre>"; var_dump($_POST); var_dump($_GET);echo "</pre>";
 
//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}
 
//retrieve the memberid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
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
//firstname
       $review = cleanInput($_POST['review']); 

    
//save the member data if the error flag is still clear and member id is > 0
    if ($error == 0 and $id > 0) {
        $query = "UPDATE unaux_27944105_bnb.bookings SET review=? WHERE bookingID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'si',$review,$id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        //echo "<h2>Member details updated.</h2>";     
        //Header Redirect
        header('Location: http://ongaona.unaux.com/managebooking.php', true, 301);
        die();
        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
 
}
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT checkout,review FROM unaux_27944105_bnb.bookings WHERE bookingID='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
$today = date('Y-m-d');



if ($rowcount > 0 ) {
  $row = mysqli_fetch_assoc($result);
  $checkout = $row['checkout'];

  if($checkout < $today){
?>
<h1>Review update</h1>
<h2><a href='managebooking.php'>[Return to the manage bookings]</a></h2>
 
<form method="POST" action="managebookingreview.php">
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <!--<p>
    
    <input style="width: 300px; height: 300px;"type="text" id="review" name="review" minlength="5" row="30"
           maxlength="255" required value="<?php echo $row['review'];?>"><br>  
  </p>-->
  <p>
  <label for="review">review: </label><br>
  <textarea maxlength="500" style="padding: 10px; width: 250px; height: 250px" id="review" name="review" value="<?php echo $row['review'];?>"><?php echo $row['review'];?> </textarea><br>
   <input type="submit" name="submit" value="Update">
   </p>
 </form>
<?php 
}else{

  ?><h2>Please post a review after your checkout date (<?php echo $checkout;?>) has passed!</h2>
  <h2><a href='managebooking.php'>[Return to the manage bookings]</a></h2><?php
}

}else{ 
  echo "<h2>Booking not found with that ID</h2>"; //simple error feedback
}
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>
