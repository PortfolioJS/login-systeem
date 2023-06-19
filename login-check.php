<?php
require_once __DIR__ . '/classes/class_databaseconnection.php';
require_once __DIR__ . '/classes/class_database.php';
require_once __DIR__ . '/classes/class_formvalidation.php';
require_once __DIR__ . '/classes/class_session.php';

//de input van het html-formulier komt hier binnen:
$username = $_POST["username"];
$password = $_POST["password"];

//de input wordt hier gevalideerd:
$formValidation = new FormValidation;
$username = $formValidation->form_input($username);
$password = $formValidation->form_input($password);

//de input wordt hier in de sessie gezet:
$session = new Session();
$session->setLogin($username); //$password blijkt in de sessie niet nodig te zijn om in te loggen (zie regel hieronder)
// $session->setLogin($username, $password);

//de pdo connectie (DE PDO AANROEPEN BIJ NEW DATABASE)
$dbconnection = new DatabaseConnection;
$pdo = $dbconnection->connection;

$db = new Database($pdo);
$user = $db->fetchUser($username); //VRAAG: de hele array van de $user wordt hier opgehaald zodat het password hieronder gecheckt kan worden. De hash is op zich veilig, maar kan een hacker aan de hand van deze array op deze manier niet andere gevoelige gegevens van de gebruiker uit de database halen, of heeft hij op geen enkele manier toegang tot deze array?
// print_r($user); //zie VRAAG
// exit;
// implicatie van bovenstaande is ook dat (als) een login succesvol verloopt OOK als bijvoorbeeld op de doelpagina (myaccount) vervolgens geen connectie kan worden gemaakt met de database
// ook wordt op de doelpagina opnieuw de fetchUser() functie aangeroepen (terwijl die array hierboven al is opgehaald); is het niet handiger/efficiënter de array in een Session te zetten en deze op de doelpagina te gebruiken (i.p.v. opnieuw databaseconnectie plus fetchUser())?
//EINDE VRAAG

//onderstaande code zou nog opgesplitst kunnen worden in Post-Redirect-Get-stijl: het formulier dus in een zelfstandig HTML-bestand
if ($user && password_verify($password, $user['password'])) {
    header('Location: /login-systeem/myaccount.php?action=login');
} else { //LET OP: onderstaand formulier zou beter in een eigen bestand kunnen (POST-REDIRECT-GET)
    echo "<h1>Invalid username and/or password!</h1>"; ?>
    <?php
    echo "Enter a correct username and password* below or create an";
    ?>
    <a href="/login-systeem/makeaccount.php">account</a>
    <?php
    echo ".<br>";
    echo "<br>";
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="" maxlength="55" autofocus required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" value="" maxlength="55" required><br>
        <input type="submit" value="Submit">
    </form><br>
    <?php
    echo "*If you already have an account, but you have forgotten your password: check the box below. <br>";
    ?>
    <form action="/login-systeem/forgotpassword.php" method="post">
        <input type="radio" id="forgotpassword" name="forgotpassword" value="forgotpassword">
        <label for="forgotpassword"> I forgot my password</label><br>
        <input type="submit" value="Submit">
    </form>
    <?php
}