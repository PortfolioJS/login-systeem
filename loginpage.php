<!DOCTYPE html>
<html>
<?php
require_once __DIR__ . '/classes/class_session.php';
$session = new Session();
?>

<body>
    <form action="/login-systeem/login-check.php" autocomplete="off" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php if (isset($_SESSION["username"])) {
            echo $_SESSION["username"];
        } else {
            echo "";
        } ?>" maxlength="55" autofocus required><br>
        <!-- <input type="text" id="username" name="username" maxlength="55" autofocus required><br> -->
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="55" required><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>