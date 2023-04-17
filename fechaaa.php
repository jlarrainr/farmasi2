 
 <?php
  for ($i = 1; $i <= 3; $i++) {
                    
                    //$fechaPago=;
                    $date1=date('Y-m-d');
                    $fechaPago = date("Y-m-d", strtotime($date1 . "+ $i month"));
                    echo 'fecha = '. $fechaPago."<br>";
                     
                    
                }