<?php

include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

$start = $_GET['start'];
$end = $_GET['end'];

echo $start;
echo $end;

?>

<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php
    echo $start;
    echo $end;
?>
 

  
</body>
</html>