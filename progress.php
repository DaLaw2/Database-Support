<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit();
}

$studentName = $_SESSION['studentName'];
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>本週進度匯報</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/progress.css">
    <link rel="stylesheet" href="css/generalStyle.css">
</head>
<body>
<div class="header">
    <div class="left-buttons">
        <button onclick="location.href='dashboard.php'">個人中心</button>
        <button onclick="location.href='browse.html'">瀏覽模式</button>
        <button onclick="location.href='progress.php'">進度繳交</button>
    </div>
    <div class="right-button">
        <button onclick="location.href='logout.php'">登出</button>
        <span><?php echo $studentName; ?></span>
    </div>
</div>
<div class="container mt-5 content">
    <h1 class="mb-4">本週進度匯報</h1>
    <form id="progressForm" action="submitProgress.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="reportTitle">標題</label>
            <input type="text" class="form-control" id="reportTitle" name="reportTitle" placeholder="請輸入標題">
            <div class="error" id="titleError">請輸入標題</div>
        </div>
        <div class="form-group">
            <label for="currentProgress">本週進度</label>
            <textarea class="form-control" id="currentProgress" name="currentProgress" rows="5" placeholder="請輸入本週進度"></textarea>
            <div class="error" id="progressError">請輸入本週進度</div>
        </div>
        <div class="form-group">
            <label for="fileUpload">上傳檔案</label>
            <input type="file" id="fileUpload" name="fileUpload[]" multiple>
            <label for="fileUpload">選擇檔案</label>
            <div class="uploaded-files">
                <label>目前已上傳的檔案:</label>
                <ul id="fileList">
                </ul>
            </div>
        </div>
        <div class="form-group">
            <label for="nextWeekPlan">下週預計進度</label>
            <textarea class="form-control" id="nextWeekPlan" name="nextWeekPlan" rows="5" placeholder="請輸入下週預計進度"></textarea>
            <div class="error" id="nextWeekError">請輸入下週預計進度</div>
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
</div>

<script src="js/progress.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
