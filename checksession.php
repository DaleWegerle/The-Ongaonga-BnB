<?php
session_start();
error_reporting(0);
 
//function to check if the user is logged else send to the login page 
function checkUser() {
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       $_SESSION['URI'] = 'http://localhost'.$_SERVER['REQUEST_URI']; //save current url for redirect     
       header('Location: http://ongaona.unaux.com/login.php', true, 303);       
    }       
}
 
//just to show we are logged in
function loginStatus() {
    $un = $_SESSION['username'];
    if ($_SESSION['loggedin'] == 1)     
        echo "<h2>Logged in as $un</h2>";
    else
        echo "<h2>Admin Log In Required To View This Page</h2>";            
}
 
//log a user in
function login($id,$username) {
   //simple redirect if a user tries to access a page they have not logged in to
   if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URI']))        
        $uri = $_SESSION['URI'];          
   else { 
     $_SESSION['URI'] =  'http://ongaona.unaux.com/index.php';         
     $uri = $_SESSION['URI'];           
   }  
   
   $_SESSION['loggedin'] = 1;        
   $_SESSION['userid'] = $id;   
   $_SESSION['username'] = $username; 
   $_SESSION['URI'] = ''; 
   header('Location: '.$uri, true, 303);        
}
 
//simple logout function
function logout(){
  $_SESSION['loggedin'] = 0;
  $_SESSION['userid'] = -1;        
  $_SESSION['username'] = '';
  $_SESSION['URI'] = '';
  header('Location: http://ongaona.unaux.com/login.php', true, 303);    
}
?>