<?php
session_start();
?>
<!DOCTYPE html>
<html>

<body>
    <h2>Change account:</h2>
    <p>Check your account in the pre-filled form below and fill in the changes you want to make.</p>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'usernamealreadyexists') {
        echo "<h1>Username already in use.</h1>Please choose another username.";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'wrongpassword') {
        echo "<h1>Invalid password!</h1>Fill in your password and try again.";
    }
    ?>
    <form action="/login-systeem/changeaccount2.php" autocomplete="off" method="post">
        <label for="newusername">Username:</label><br>
        <input type="text" id="newusername" name="newusername" value="<?php if (isset($_GET['action']) && $_GET['action'] == 'usernamealreadyexists') {
            echo ""; //oftewel als de nieuwe username al wordt gebruikt (in de database) wordt na de redirect vanaf changeaccount2 een leeg veld getoond
        } else {
            echo $_SESSION["username"]; //oftewel wanneer het reguliere pad wordt gevolgd (geen redirect van p2), dan wordt de sessie die bij de inlog was ingevuld hier opnieuw ingevuld
        } ?>" maxlength="55" autofocus required><br>
        <label for="email">Email:</label><br>
        <input type="text" id="newemail" name="newemail" value="<?php echo $_SESSION["email"]; ?>" maxlength="55"
            required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="55" required><br>
        <input type="submit" value="Submit">
    </form>

    <h3>Change password:</h3>
    <Change>
        <form action="/login-systeem/changepassword.php" method="post">
            <label for="haveaccount"> If you want to change your password, click </label>
            <input type="submit" value="Change">
        </form>

</body>

</html>