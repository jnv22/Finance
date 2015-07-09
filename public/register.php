<?php

 // configuration
 
require("../includes/config.php");
  
// if user reached page via GET (as by clicking a link or via redirect)
   
if ($_SERVER["REQUEST_METHOD"] == "GET")
    
{
     
// else render form
      
render("register_form.php", ["title" => "Register"]);
       
}
        
// else if user reached page via POST (as by submitting a form via POST)
         
else if ($_SERVER["REQUEST_METHOD"] == "POST")
          
{

if(empty($_POST["username"])) {
    apologize ("Please provide Username");
}

else if (empty($_POST["password"])) {
    apologize ("Please provide Password");
}

if ($_POST["password"] !== $_POST["confirmation"]) {
    apologize ("Password and confirmation do not match");
}

else {
    $result= query("INSERT INTO users (username, hash, cash) VALUES (?, ?, 10000)", $_POST["username"], crypt($_POST["password"]));
    if ( $result===false) {
        apologize("User Name already exists");
    }
    
    else {
    
    $rows = query("SELECT LAST_INSERT_ID() AS id");
    $id = $rows[0]["id"];
    // remember that user's now logged in by storing user's ID in session
     $_SESSION["id"] = $id;
     redirect("/");

    }

}
            
}
             
?>
