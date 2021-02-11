<?php
//access control


include "header.php";
include "managebookingsmenu.php";
echo '<div id="site_content">';
echo '<div id="content" style="width: 100%">';

include "checksession.php";
checkUser(AC_ADMIN);
loginStatus(); 
error_reporting(0);


?>
<!DOCTYPE html>
<html><head><title>MANAGE BOOKINGS</title> </head>
<body>
<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit;
}
 
$query = 'SELECT bookingID,roomID,roomdetails,customerdetails,checkin,checkout,review FROM bnb.bookings ORDER BY bookingID';
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 

?>


<h1>Booking list</h1>
<h2>Booking count <?php echo $rowcount; ?></h2>
<table border="1" >
<thead><tr><th>Booking ID</th><th>Room ID</th><th>Room Details</th><th>Customer Details</th>
<th>Check-In Date</th><th>Check-Out Date</th><th>Review</th><th>Actions</th></tr></thead>
<?php
 
//makes sure we have members
if ($rowcount > 0) {  //loop though the entire table 
    while ($row = mysqli_fetch_assoc($result)) { //inserts db table into assoc array (key array) row by row

      $id = $row['bookingID'];//extracts member id with use of array key[bookingID] and saved it in $id	
      
      echo '<tr><td>'.$row['bookingID'].'</td><td>'.$row['roomID'].'</td><td>'.$row['roomdetails']
      .'</td><td>'.$row['customerdetails'].'</td><td>'.$row['checkin'].'</td><td>'.$row['checkout'].'</td><td>'.$row['review'];
      echo         '<td> <a href="editbooking.php?id='.$id.'">[edit]</a><br>';
      echo          '<a href="managebookingreview.php?id='.$id.'">[Manage Review]</a>';
      echo          '<a href="deletebooking.php?id='.$id.'">[view/delete]</a> </td>';
      echo     '</tr>'.PHP_EOL;
     
   }
} else echo "<h2>No members found!</h2>"; //suitable feedback
 
mysqli_free_result($result); 
mysqli_close($DBC);
?>
 
</body>
</html>
