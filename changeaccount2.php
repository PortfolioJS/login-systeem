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

$id = $user['id']; //nodig voor update username/email en ook (!) om te checken of de nieuwe $username al elders in de database staat (zie hieronder)

//de input van het html-formulier komt hier binnen:
$newusername = $_POST["newusername"];
$email = $_POST["newemail"];
$password = $_POST['password'];

//de input wordt hier gevalideerd:
$formValidation = new FormValidation;
$newusername = $formValidation->form_input($newusername);
$email = $formValidation->form_input($email);
$password = $formValidation->form_input($password);

$session = new Session();
//$session->setLogin($newusername); //de oude sessie moet nog niet overschreven worden, want die is hieronder nog nodig
$session->setEmail($email); //nodig voor autoaanvullen bij redirect naar changeaccount

//de pdo connectie (die wordt aangeroepen bij het creëren van een nieuw database-object)
$dbconnection = new DatabaseConnection;
$pdo = $dbconnection->connection;

$db = new Database($pdo);
$user = $db->fetchUser($newusername); //eerst wordt gecheckt of de (new)$username al bestaat in de database...

//... als de $username al bestaat (i.c.m. een ANDER $user['id'] dan het $id, want als $user alleen het emailadres wil veranderen, willen we geen foutmelding): redirect naar changeaccount.php + melding 'choose another username')
if ($user == True && $id != $user['id']) {
    header('Location: /login-systeem/changeaccount.php?action=usernamealreadyexists');
    exit;
} else if ($user == True && $id == $user['id']) {
    if (password_verify($password, $user['password'])) { //als het wachtwoord klopt:
        //de (resterende) input wordt hier in de sessie gezet:
        // $session = new Session();
        // $session->setLogin($username);//HIER NIET NODIG: de nieuwe $username is dezelfde als de bestaande in de session
        // $session->setEmail($email);
        //de gegevens worden in de database geüpdatet (aan de hand van het $id):

        //de pdo connectie is hierboven al geopend (dus hieronder weg gecomment)
        // $dbconnection = new DatabaseConnection;
        // $pdo = $dbconnection->connection;

        // $db = new Database($pdo);
        $db->updateUser($newusername, $email, $id);
    } else {
        header('Location: /login-systeem/changeaccount.php?action=wrongpassword');
        exit;
    }
} else { //als de nieuwe gebruikersnaam niet bestaat wordt de array $user opgehaald aan de hand van het $id:
    $user = $db->fetchUserviaID($id);

    if (password_verify($password, $user['password'])) { //als het wachtwoord klopt:
        //de (resterende) input wordt hier in de sessie gezet:
        // $session = new Session();
        $session->setLogin($newusername); //de nieuwe $username
        // $session->setEmail($email);
        //de gegevens worden in de database geüpdatet (aan de hand van het $id):

        //de pdo connectie is hierboven al geopend (dus hieronder weg gecomment)
        // $dbconnection = new DatabaseConnection;
        // $pdo = $dbconnection->connection;

        // $db = new Database($pdo);
        $db->updateUser($newusername, $email, $id);
    } else {
        $_SESSION["newusername"] = $newusername; // is nodig voor autoaanvullen changeaccount
        header('Location: /login-systeem/changeaccount.php?action=wrongpassword');
        exit;
    }
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