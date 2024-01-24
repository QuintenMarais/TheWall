<?php
session_start();
unset($_SESSION['msatg']);
session_destroy();

header('Location: ../index.php'); // Redirect to the login page after logout
exit;
?>
