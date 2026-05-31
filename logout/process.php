<?php
session_start();

/* Session destroy */
session_unset();
session_destroy();

/* Redirect to login page*/
header("Location: ../index.php");
exit;
