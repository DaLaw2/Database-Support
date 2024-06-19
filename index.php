<?php
session_start();

if ($_SESSION['isLogin'] !== true)
    header("Location: dashboard.php");
else
    header("Location: dashboard.php");
exit();
