<?php
session_start();
session_unset();
session_destroy();

// Clear the "Remember Me" cookie
setcookie("remember_me", "", time() - 3600, "/");

// Redirect to the login page
header('Location: login.php');
exit();
?>
