<?php
include "header.php";
include "bookingmenu.php";
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
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Select a Date Range</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  

 
 <script>

      $(function() {

        checkin = $( "#datepicker" ).datepicker({
          dateFormat: "yy-mm-dd",
        });

        $("#datepicker").on("change",function(){
          var checkin = $(this).val();
          return checkin;
        });
     

        checkout = $( "#datepicker2" ).datepicker({
          dateFormat: "yy-mm-dd",
        });

        $("#datepicker2").on("change",function(){
          var checkout = $(this).val();
          return checkout;
        });
      });


      function searchResult(searchstr,searchstr2) {

        if(searchstr == "" || searchstr2 == ""){

          alert("Please fill in both dates");
          return false;
        }else{
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                  document.getElementById("roomlist").innerHTML=this.responseText;
          }
        }
        xmlhttp.open("GET","roomsearch.php?sq="+searchstr+"&sq2="+searchstr2,true);
        xmlhttp.send();
        }
      }

</script>

</head>

<body>

<h2><strong>Search For Room Availability<strong></h2>

<form id="dateRange">
<label for="datepicker">Check-In Date:  </label>
    <input type="text" id="datepicker" name="datepicker" required />
<label for="datepicker2">Check-In Date:  </label>
    <input type="text" id="datepicker2" name="datepicker2" required /><br><br>
<input type="button" onclick="searchResult($('#datepicker').val(),$('#datepicker2').val())" value="Search Rooms">
</form>

<div id="roomlist" style="padding: 10px;"></div>
</body>


</html>
