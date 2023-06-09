<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <?php

        $forgotpasswordErr = "";
        $forgotpassword = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["forgotpassword"])) {
                $forgotpasswordErr = "<h1>Check the correct box!<h1>";
              } else {
                $forgotpassword = test_input($_POST["forgotpassword"]);
              }
            
        }

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }


        ?>
      
      <?php if (isset($forgotpassword) && $forgotpassword=="forgotpassword") {
        echo "ENTER YOUR EMAIL ADRESS<br>";
        echo "Under construction: currently there's no working form to submit your e-mail adres and have a link send to it in order to get a new password.";//HIER MOET EEN HTML FORMULIER KOMEN DAT LINKT MET PHP CODE VOOR HET AUTOMATISCH VERSTUREN VAN EEN LINK VOOR HET AANMAKEN VAN EEN NIEUW WACHTWOORD (GELINKT NAAR EEN FORMULIER MET DUBBEL WACHTWOORD)
      }
        ?>

      
    </body>
</html>