<?php
require_once __DIR__ . '/classes/class_database.php';
require_once __DIR__ . '/classes/class_databaseconnection.php';
require_once __DIR__ . '/classes/class_session.php';
$session = new Session();
?>
<!DOCTYPE html>
<html>

<body>

    <?php
    //omdat er 4 pagina's naar deze pagina leiden (makeaccount2; login-check; changeaccount2 en changepassword)
//hieronder 4 versch. welcomes (de actions) via GET methode
//via de url (header) leiden deze pagina's naar resp. ?action=create; ?action=login; ?action=change en ?action=changep(assword)
    if (isset($_GET['action']) && $_GET['action'] == 'login') {
        echo "<h1>Welcome " . $_SESSION["username"] . "! <br> Your Login was succesfull.</h1>";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'create') {
        echo "<h2> Welcome " . $_SESSION["username"] . "! <br> You succesfully created a new account!</h2>";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'change') {
        echo "<h2> Welcome " . $_SESSION["username"] . "! <br> You succesfully changed your account!</h2>";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'changep') {
        echo "<h2> Welcome " . $_SESSION["username"] . "! <br> You succesfully changed your password!</h2>";
    }

    $username = $_SESSION["username"]; //GEBRUIK IK DE SESSIE HIER WEL CORRECT (OOP-STIJL)??? (en hierboven dus ook)
    
    $dbconnection = new DatabaseConnection;
    $pdo = $dbconnection->connection;

    $db = new Database($pdo);
    $user = $db->fetchUser($username);

    echo "<h3>My account:</h3>";
    echo "Username:";
    print_r($user['username']);
    echo "<br>";
    echo "Email:";
    print_r($user['email']);
    echo "<br>";
    echo "<br>";

    $email = $user['email'];
    $session->setEmail($email); //twee regels om één regel session te vervangen EFFICIENT???
    // (en dan hebben we het nog niet eens over de regels in de class)
    // $_SESSION["email"] = $user['email'];
    //deze sessie is voor het automatisch invullen van het formulier changeaccount.php
//de andere 2 sessies zijn bij het inloggen al ingevuld (vanaf makeaccount2.php was al wel een sessie e-mail aangemaakt)
    ?>

    <Change>
        <form action="/login-systeem/changeaccount.php" method="post">
            <label for="haveaccount"> If you want to make changes to your account, click </label>
            <input type="submit" value="Change">
        </form>

        <Logout>
            <form method="post" action="/login-systeem/loginpage.php">
                <input type="submit" value="Logout">
            </form>
</body>

</html>