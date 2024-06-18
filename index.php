<?php
session_start();

if ($_SESSION['studentID'] ?? false)
    header("Location: dashboard.php");
else
    header("Location: login.html");
exit();
