<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit();
}

$studentName = $_SESSION['studentName'];
$studentID = $_SESSION['studentID'];
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人中心</title>
    <link rel="stylesheet" href="css/generalStyle.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="header">
    <div class="left-buttons">
        <button onclick="location.href='dashboard.php'">個人中心</button>
        <button onclick="location.href='browse.html'">瀏覽模式</button>
        <button onclick="location.href='uploadProgress.html'">進度繳交</button>
    </div>
    <div class="right-button">
        <button onclick="location.href='logout.php'">登出</button>
        <span><?php echo $studentName; ?></span>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="left-column">
            <h2>個人資訊</h2>
            <div class="box fixed-box personal-info-box">
                <p>學號: <?php echo $studentID; ?></p>
                <p>姓名: <?php echo $studentName; ?></p>
                <!-- 其他個人資訊 -->
            </div>

            <h2>歷史上傳檔案</h2>
            <div class="box fixed-box upload-history-box">
                <!-- 歷史上傳檔案列表 -->
                <ul>
                    <!-- 示例項目 -->
                    <li><a href="#">檔案1</a></li>
                    <li><a href="#">檔案2</a></li>
                    <li><a href="#">檔案3</a></li>
                </ul>
            </div>
        </div>
        <div class="right-column">
            <h2>進度提交歷史</h2>
            <div class="box fixed-box progress-history-box">
                <!-- 進度提交歷史列表 -->
                <ul>
                    <!-- 示例項目 -->
                    <li>進度1: 已提交</li>
                    <li>進度2: 已提交</li>
                    <li>進度3: 已提交</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
