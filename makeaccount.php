<?php
session_start();
?>
<!DOCTYPE html>
<html>

<body>
    <h1>Make account:</h1>
    <form action="/login-systeem/makeaccount2.php" autocomplete="off" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php if (isset($_GET['action']) && $_GET['action'] == 'passwordsunequal') {
            echo $_SESSION["username"];
        } else {
            echo "";
        } ?>" maxlength="55" autofocus required><br>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php if (!isset($_GET['action'])) {
            echo ""; //deze if staat hier omdat de sessie hieronder (afhankelijk van pad) ook leeg kan zijn, ter voorkoming van melding 'undefined array key' ('email') in formulier (bij alle paden naar deze pagina is de sessie 'username' hierboven al ingevuld, dus daar stuit de if-else niet op een 'undefined array key')
        } else if (isset($_GET['action']) && $_GET['action'] == 'passwordsunequal' or 'usernamealreadyexists') {
            echo $_SESSION["email"];
        } ?>" maxlength="55" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="55" required><br>
        <label for="confirmpassword">Confirm password:</label><br>
        <input type="password" id="confirmpassword" name="confirmpassword" maxlength="55" required><br>
        <input type="submit" value="Submit">
    </form>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'passwordsunequal') {
        echo "<h1>The passwords are not equal.</h1>Fill in your new password again and confirm it again.";
    } else if (isset($_GET['action']) && $_GET['action'] == 'usernamealreadyexists') {
        echo "<h1>Username already in use.</h1>Please choose another username.<br>Or, if you already have an account:";
        ?>
            <a href="/login-systeem/loginpage.php">login</a>
            <?php
            echo ". If you forgot your password, click";
            ?>
            <a href="/login-systeem/forgotpassword.php">here</a>
            <?php
            echo ".<br>";
            echo "<br>";

    }
    ?>

</body>

</html>