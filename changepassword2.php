<?php
require_once __DIR__ . '/classes/class_databaseconnection.php';
require_once __DIR__ . '/classes/class_database.php';
require_once __DIR__ . '/classes/class_formvalidation.php';
require_once __DIR__ . '/classes/class_session.php';

session_start();
$username = $_SESSION["username"]; //is al eerder bij de inlog gevalideerd (dus kan zo richting database)

//de pdo connectie (die wordt aangeroepen bij het creëren van een nieuw database-object)
$dbconnection = new DatabaseConnection;
$pdo = $dbconnection->connection;

$db = new Database($pdo);
$user = $db->fetchUser($username);

$id = $user['id']; //nodig voor update password (zie hieronder)

//de input van het html-formulier komt hier binnen:
$oldpassword = $_POST["oldpassword"];
$newpassword = $_POST["newpassword"];
$confirmnewpassword = $_POST["confirmnewpassword"];

//de input wordt hier gevalideerd:
$formValidation = new FormValidation;
$oldpassword = $formValidation->form_input($oldpassword);
$newpassword = $formValidation->form_input($newpassword);
$confirmnewpassword = $formValidation->form_input($confirmnewpassword);

//gecheckt wordt of wachtwoord correct is ingevuld...:
$equalpasswords = false;

if ($newpassword === $confirmnewpassword) {
  $equalpasswords = true;
} else {
  $equalpasswords = false;
}

//... als dat het geval is (true) wordt het oude wachtwoord vergeleken met de oude passwordhash in de database (alvorens de nieuwe hash wordt gemaakt)
if ($equalpasswords === false) { //password_verify weggelaten omdat het formulier toch opnieuw moet worden ingevuld)
  header('Location: /login-systeem/changepassword.php?action=passwordsnotequal');
  exit;
} elseif ($equalpasswords === true && $user && password_verify($_POST['oldpassword'], $user['password'])) {
  $newpasswordHash = password_hash($newpassword, PASSWORD_BCRYPT);

  //de pdo connectie (die wordt aangeroepen bij het creëren van een nieuw database-object)
  $dbconnection = new DatabaseConnection;
  $pdo = $dbconnection->connection;

  $db = new Database($pdo);
  //de gegevens worden in de database geüpdatet (aan de hand van het $id):
  $db->updatePassword($newpasswordHash, $id);

} else {
  header('Location: /login-systeem/changepassword.php?action=wrongpassword');
  exit;
}

// //TEST
// $user = $db->fetchUser($username);
// echo "<h3>My account:</h3>";
// echo "Username:";
// print_r($user['username']);
// echo "<br>";
// echo "Email:";
// print_r($user['email']);
// echo "<br>";
// echo "ID:";
// print_r($user['id']);
// echo "<br>";
// echo "<br>";