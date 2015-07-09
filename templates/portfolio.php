
    <table class="table table-condensed">
        <thead>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Current Price</th>
            
         <tbody>

            <?php

                foreach ($positions as $position)
                {   
                
                    
                    
                    if ($position["shares"]>0)
                    {
                        print("<tr>");
                        print("<td>{$position["symbol"]}</td>");
                        print("<td>{$position["shares"]}</td>");
                        print("<td>{$position["price"]}</td>");
                        print("</tr>");                                   
                    }     
                    if($position["shares"]==0)
                    {
                        unset($position);
                    }                                           
                } 
            ?>

           </tbody> 
        </table> 
        <?php $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
 ?>
 <p>You have $<?=$rows[0]["Cash"] ?> to spend! </p>

   <div>     

    
  </div> 
  
 
    
<div id="logout">
    <a href="logout.php">Log Out</a>
</div>

