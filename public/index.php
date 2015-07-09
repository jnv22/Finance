<?php

    // configuration
    require("../includes/config.php");
    
    //setup portfolio
    $rows = query("SELECT symbol, shares FROM Holdings WHERE id = ?", $_SESSION["id"]);

    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        //portfolio table
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock ["name"],
                "price" => $stock ["price"],
                "shares" => $row ["shares"],
                "symbol" => $row ["symbol"]  
            ];


        }


    } 

            
            render ("portfolio.php", ["positions" =>$positions, "title" => "Portfolio"]);


?>
