<?php
session_start();
?>
<!DOCTYPE html>
<html>


<body>
    <h2>Change password:</h2>
    <p>If you want to change your password: fill in the form below.</p>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'passwordsnotequal') {
        echo "<h1>The passwords are not equal.</h1>Fill in your new password again and confirm it again.";
    } elseif (isset($_GET['action']) && $_GET['action'] == 'wrongpassword') {
        echo "<h1>Your (current) password is incorrect</h1>Fill in the form again with your current password in order to set your new password.";
    }
    ?>
    <form action="/login-systeem/changepassword2.php" autocomplete="off" method="post">
        <label for="oldpassword">Old password:</label><br>
        <input type="password" id="oldpassword" name="oldpassword" maxlength="55" autofocus required><br>
        <label for="newpassword">New password:</label><br>
        <input type="password" id="newpassword" name="newpassword" maxlength="55" required><br>
        <label for="confirmnewpassword">Confirm new password:</label><br>
        <input type="password" id="confirmnewpassword" name="confirmnewpassword" maxlength="55" required><br>
        <input type="submit" value="Submit">
    </form>

</body>

</html>