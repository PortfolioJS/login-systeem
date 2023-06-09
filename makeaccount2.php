<?php
require_once __DIR__ . '/classes/class_databaseconnection.php';
require_once __DIR__ . '/classes/class_database.php';
require_once __DIR__ . '/classes/class_formvalidation.php';
require_once __DIR__ . '/classes/class_session.php';

//de input van het html-formulier komt hier binnen:
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmpassword = $_POST["confirmpassword"];

//de input wordt hier gevalideerd:
$formValidation = new FormValidation;
$username = $formValidation->form_input($username);
$email = $formValidation->form_input($email);
$password = $formValidation->form_input($password);
$confirmpassword = $formValidation->form_input($confirmpassword);

//de input wordt hier in de sessie gezet:
$session = new Session();
$session->setLogin($username);
$session->setEmail($email); //nodig voor auto-aanvullen wanneer voorgaande formulier opnieuw moet worden ingevuld (bij niet-matchende wachtwoorden)

//als de ingevulde wachtwoorden niet overeenstemmen volgt een foutmelding en redirect:
$equalpasswords = false;

if ($password === $confirmpassword) {
  $equalpasswords = true;
} else {
  $equalpasswords = false;
}

if ($equalpasswords === false) {
  header('Location: /login-systeem/makeaccount.php?action=passwordsunequal');
  exit;
} elseif ($equalpasswords === true) { //als de ingevulde wachtwoorden overeenstemmen wordt het proces vervolgd

  //de pdo connectie (die wordt aangeroepen bij het creëren van een nieuw database-object)
  $dbconnection = new DatabaseConnection;
  $pdo = $dbconnection->connection;

  $db = new Database($pdo);
  $user = $db->fetchUser($username); //eerst wordt gecheckt of de (new)$username al bestaat in de database...

  //... als de $username al bestaat: redirect naar makeaccount.php + melding 'choose another username')
  if ($user == True) {
    header('Location: /login-systeem/makeaccount.php?action=usernamealreadyexists');
    exit;
  } else if ($user == False) {
    //het ingevulde wachtwoord wordt gehasht (als de $username uniek is - en beide wachtwoorden identiek zijn):
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // PDO-CONNECTIE IS HIERBOVEN AL GEMAAKT (BIJ CHECK USERNAME)
    // $dbconnection = new DatabaseConnection;
    // $pdo = $dbconnection->connection;

    // $db = new Database($pdo);
    $db->insertUser($username, $email, $passwordHash); //de ingevulde gegevens worden samen met de hash in de database gezet EN de View myaccount wordt geopend (zie hieronder)
    // header('Location: /login-systeem/myaccount.php?action=create'); LET OP: deze header staat in de class Database in de insertUser() functie

  }
}