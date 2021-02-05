<?php

include "header.php";
include "bookingmenu.php";
echo '<div id="site_content">';
echo '<div id="content">';
?>


<!DOCTYPE HTML>
<html><head><title>Edit Member</title> </head>
<script>

	function myFunction(){
    
        var fname = document.getElementById("myForm").elements[1].value;
        var lname = document.getElementById("myForm").elements[2].value;
        var email = document.getElementById("myForm").elements[3].value;
        var comma = ", "
        var space = " "
        var customerdetails = fname.concat(space, lname, comma, email);
        //var customerdetails = fname.concat(lname, email);

        document.getElementById("customerdetails").value = customerdetails;


        return customerdetails;
	}

</script>
<body>

<?php


include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 
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

//retrieve the memberid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $checkin = $_GET['start'];
    $checkout = $_GET['end'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid room ID</h2>"; //simple error feedback
        exit;
    } 
}

/* the data was sent using a form therefore we use the $_POST instead of $_GET
   check if we are saving data first by checking if the submit button exists in
   the array */
   if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Book')) {
    //if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
        include "config.php"; //load in any variables
        $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
     
        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
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
    //lastname
           $roomID = cleanInput($_POST['roomID']);      
    //email
           $customerdetails = cleanInput($_POST['customerdetails']);
    //username
           $roomdetails = cleanInput($_POST['roomdetails']);        
    //password    
           $checkin = cleanInput($_POST['checkin']);   
    //role
           $checkout = cleanInput($_POST['checkout']);            
           
    //save the member data if the error flag is still clear
            $error = 0;
        if ($error == 0) {
            $query = "INSERT INTO bnb.bookings (roomID,customerdetails,roomdetails,checkin,checkout) VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'sssss',$roomID,$customerdetails,$roomdetails,$checkin,$checkout); 
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);    
            echo "<h2>Your Room Has Been Booked! See You Soon!</h2>";        
        } 
        mysqli_close($DBC); //close the connection once done
    }
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT roomname,description,roomtype,beds FROM bnb.room WHERE roomID='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
  $row = mysqli_fetch_assoc($result);
?>
<h1>Member update</h1>
<h2><a href='booking.php'>[Return to the available room listing]</a></h2>
 
<form id="myForm" method="POST" action="bookroom.php" onsubmit="myFunction()">
  <input type="hidden" id="roomID" name="roomID" value="<?php echo $id;?>">
  <p>
    <label for="fname"><strong>First-Name:<strong></label><br>
    <input type="text" id="fname" name="fname" size="50"
            placeholder="Please enter the guests first name" required> 
  </p>  
  <p>
    <label for="lname"><strong>Last-Name:<strong></label><br>
    <input type="text" id="lname" name="lname" size="50"
            placeholder="Please enter the guests last name" required> 
  </p> 
  <p>
    <label for="email"><strong>Email:<strong></label><br>
    <input type="email" id="email" name="email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" 
    placeholder="Please enter the guests email address" required>         
    <input type="hidden" id="customerdetails" name="customerdetails" value="">
  </p>
  <p>
    <label for="roomdetails"><strong>Room Details:</strong></label><br>
    <input type="text" id="roomdetails" name="roomdetails" size="50" 
            value="<?php echo $row['roomname'].", ".$row['description'].", ".$row['roomtype'].", ".$row['beds'];?>" readonly> 
  </p> 
  <p>
    <label for="checkin"><strong>Check-In:</strong></label><br>
    <input type="text" id="checkin" name="checkin"  
            value="<?php echo $checkin;?>" readonly> 
  </p>  
  <p>
    <label for="checkout"><strong>Check-Out:<strong></label><br>
    <input type="text" id="checkout" name="checkout" 
            value="<?php echo $checkout;?>" readonly> 
  </p>
   <input type="submit" name="submit" value="Book" onclick="myFunction()">
 </form>
 <?php 
 echo "<h2 id='fname' style='color: red;'></h2>";
} 
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>