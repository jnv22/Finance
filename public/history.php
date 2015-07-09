<?php
  require("../includes/config.php");
        
  $rows=query("SELECT * FROM History WHERE id= ?", $_SESSION["id"]);
  $positions = [];
    foreach ($rows as $row)
    {

        if ($row !== false)
        {
            $positions[] = [
                "date" => $row["date"],
                "buy_shares" => $row ["bshares"],
                "buy_quantity" => $row ["bquantity"],
                "sell_shares" => $row ["sshares"],
                "sell_quantity" => $row ["squantity"],
            ];


        }


    }
      render("history_final.php",  ["positions" =>$positions, "title" => "History"]); 



?>
