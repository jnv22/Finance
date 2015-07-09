<?php
 require("../includes/config.php"); 
 //if info not supplied, go to proper form
 if ($_SERVER["REQUEST_METHOD"] == "GET") {
 
    render("../templates/sell_form.php");
 
 }

 
 else {
     $stock=lookup($_POST["symbol"]);
    if ($stock==false) {
        apologize("Please input a valid symbol");
    }

    $rows = query("SELECT * FROM Holdings WHERE id = ? AND symbol=?", $_SESSION["id"], strtoupper($_POST["symbol"]));

        if(count($rows)==0) {
            apologize ("Please input a stock you own");
            }
    
        else {
        
        if($_POST["shares"]>$rows[0]["shares"]) {
            apologize ("Please input less than or equal to what you own");
             echo($rows[0]["shares"]);
        }

    $stocks= ($_POST["shares"])*($stock["price"]);
    //update holdings
    $row=query("UPDATE Holdings SET shares=shares-? WHERE id=? AND symbol=?", $_POST["shares"],  $_SESSION["id"], strtoupper($_POST["symbol"]));
    //update users
    $row=query("UPDATE users SET cash=cash+? WHERE id = ?", $stocks, $_SESSION["id"]);
    //insert into history
    $history = query("SELECT * FROM History WHERE id = ?", $_SESSION["id"]);
    $history=query("INSERT INTO History (id, sshares, squantity) VALUES(?, ?,?)", $_SESSION["id"], strtoupper($_POST["symbol"]),  $_POST["shares"]);
    render ("sell_final.php", ["symbol" => $stock ["symbol"],"shares" => $_POST["shares"], ]);
    }
    }
    
 ?>
