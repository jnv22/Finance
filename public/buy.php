<?php
 require("../includes/config.php");
  //if info not supplied, go to proper form
 if($_SERVER["REQUEST_METHOD"]=="GET") {
 render("buy_form.php");
 }
 
 else {
 $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
 $stock=lookup($_POST["symbol"]);
    if($stock==false) {
        apologize ("Please input real stock symbol");
    }
    //checks for non-negative, integer #
    if (preg_match("/^\d+$/",$_POST["shares"]) == false) { 
    
        apologize("Please input positive, whole number");}
    //checks to see if user has enough cash
    if((($stock["price"])*($_POST["shares"])) < ($rows[0]["Cash"])) {
        //check and insert into holdings
        $row = query("SELECT * FROM Holdings WHERE id = ?", $_SESSION["id"]); 
        $row=query("INSERT INTO Holdings (id, symbol, shares) VALUES(?,?,?) ON DUPLICATE KEY UPDATE shares=shares+ VALUES(shares)", $_SESSION["id"], strtoupper($_POST["symbol"]), $_POST["shares"]);
        //check and insert into history
        $history = query("SELECT * FROM History WHERE id = ?", $_SESSION["id"]);
        $history=query("INSERT INTO History (id, bshares, bquantity) VALUES(?, ?,?)", $_SESSION["id"], strtoupper($_POST["symbol"]), $_POST["shares"]);
        $price=(($stock["price"])*($_POST["shares"]));
        //update cash amount
        $rows=query("UPDATE users SET cash = cash-?", $price);

        render("buy_final.php", ["shares"=> $_POST["shares"], "symbol"=>strtoupper($_POST["symbol"])]);
        
    }
    
    else {
        apologize("Please input smaller number");
    
    }

}


?>
