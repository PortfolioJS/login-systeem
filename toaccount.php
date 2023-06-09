<?php
// session_start();
//HEEFT HET ZIN OM HIER AL EEN SESSION TE STARTEN (er zijn immers nog geen persoonlijke gegevens ingevoerd)?
//Ja, dat heeft zin, want dan kan ik het voorgaande formulier uitbreiden met een vink-optie voor het volgen van het OOP-pad (OOP in SESSION),
//zodat elk formulier ofwel naar het procedurele validatiepad leidt, ofwel naar het OOP-validatiepad,
//afhankelijk van de SESSION (LET OP: nog niet alle php-pagina's hebben een OOP-variant, waarbij de objecten uit de classes worden aangeroepen)
?>

<!DOCTYPE html>
<html>

<body>
  <?php

  $haveaccountErr = "";
  $haveaccount = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["haveaccount"])) {
      $haveaccountErr = "<h1>Check the correct box!<h1>";
    } else {
      $haveaccount = test_input($_POST["haveaccount"]);
    }

  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


  ?>

  <?php if (isset($haveaccount) && $haveaccount == "haveaccount") {
    header('Location: /login-systeem/loginpage.php');
    exit;
  } ?>
  <?php if (isset($haveaccount) && $haveaccount == "noaccount") {
    header('Location: /login-systeem/makeaccount.php');
    exit;
  }
  //hieronder staat de code voor wanneer het HTML-formulier niet is ingevuld/niets is aangevinkt
  ?>
  <span class="error">
    <?php echo $haveaccountErr; ?>
  </span>

</body>

</html>