<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.html");
    exit();
}

$studentName = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>瀏覽模式</title>
    <link href="css/generalStyle.css" rel="stylesheet">
    <link href="css/browse.css" rel="stylesheet">
</head>
<body>
<div class="header">
    <div class="left-buttons">
        <button onclick="location.href='dashboard.php'">個人中心</button>
        <button onclick="location.href='browse.php'">瀏覽模式</button>
        <button onclick="location.href='progress.php'">進度繳交</button>
    </div>
    <div class="right-button">
        <button onclick="location.href='logout.php'">登出</button>
        <span><?php echo $studentName; ?></span>
    </div>
</div>
<div id="calendar-container">
    <div id="calendar">
        <div class="month">
            <span id="prevMonth" style="cursor:pointer;">&lt;</span>
            <h2 id="monthYear"></h2>
            <span id="nextMonth" style="cursor:pointer;">&gt;</span>
        </div>
        <div class="days"></div>
    </div>
    <div id="details">
        <h3>Details:</h3>
        <div id="detailsContent"></div>
    </div>
</div>
<script src="js/calendar.js"></script>
</body>
</html>
