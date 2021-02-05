<?php

include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();

$searchresult = "";


$start = $_GET['sq'];
$end = $_GET['sq2'];

if (isset($start) and !empty($start) and strlen($start) == 10 and isset($end) and !empty($end and strlen($end) == 10) and $start < $end){
    
    $query = "SELECT * FROM bnb.room WHERE roomID NOT IN (SELECT roomID FROM bnb.bookings WHERE checkin <= '$start' AND checkout >= '$end')";
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result); 

    if ($rowcount > 0) {  
        $searchresult = '<table border="1"><thead><tr><th>ROOM ID</th><th>ROOM NAME</th><th>DISCRIPTION</th><th>ROOM TYPE</th><th>BEDS</th><th>ACTION</th></tr></thead>';
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['roomID'];	
            $searchresult .= '<tr><td>'.$row['roomID'].'</td><td>'.$row['roomname'].'</td><td>'.$row['description'].'</td><td>'.$row['roomtype'].'</td><td>'.$row['beds'].'</td>';
            $searchresult .= '<td><a href="bookroom.php?id='.$id.'&start='.$start.'&end='.$end.'">[book now]</a>';
            $searchresult .= '</tr>'.PHP_EOL;
        }
        $searchresult .= '</table>';
    } else echo "<tr><td colspan=3><h2>No members found!</h2></td></tr>";
} else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
 
echo  $searchresult;
?>
    

