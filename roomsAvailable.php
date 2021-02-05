<?php
include "header.php";
include "menu.php";
echo '<div id="site_content">';

echo '<div id="content">';


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
<head></head>
<body>
    <h1>Make a booking</h1>
    <h2><a href='bookinglist.php'>View Bookings</a></h2>
    <form method = "POST" action="booking.php">
    <p>
        <label for="Room">Room (Name, Type, Beds):</label>
        <select id="Room" name="Room" placeholder=" please select room"required >
            <option value="1">Kellie,S,5</option>
            <option value="2">Herman,D,5</option>
            <option value="3">Scarlett,D,2</option>
            <option value="4">Jelani,S,2</option>
            <option value="5">Sonya,S,5</option>
            <option value="6">Miranda,S,4</option>
            <option value="7">Helen,S,2</option>
            <option value="8">Octavia,D,3</option>
            <option value="9">Gretchen,D,3</option>
            <option value="10">Bernard,S,5</option>
            <option value="11">Dacey,D,2</option>
            <option value="12">Preston,D,2</option>
            <option value="13">Dane,S,4</option>
            <option value="14">Cole,S,1</option>
        </select>
    </p>
    <p>
        <label for="CheckInDate">Check In Date:</label>
        <input type="inDate" id="CheckInDate" name="CheckInDate" placeholder="eg: yyyy-mm-dd" required>
    </p>
    <p>
        <label for="CheckOutDate">Check Out Date:</label>
        <input type="outDate" id="CheckOutDate" name="CheckOutDate" placeholder="eg: yyyy-mm-dd" required>
    </p>
    <p>
        <label for="contactNumber">Contact Number:</label>
        <input type="tel" id="contactNumber" name="contactNumber" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="eg: (123) 123 1234" required>
    </p>
    <p>
        <label for="bookingExtras">Booking Extras:</label>
        <textarea id="bookingExtras" name="bookingExtras" rows="4" cols="50" placeholder=" Please enter any additional services you might need">
        </textarea>
    </p>
    <p>
    <input type="submit" value="Submit">
    </p>

    </form>
</body>


</html>
