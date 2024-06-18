<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['isApproval']) && $_SESSION['isApproval'] === true) {
    header("Location: dashboard.html");
    exit();
}
include 'connection.php';
$conn = getDatabaseConnection();
$studentID = $_SESSION['studentID'];

$sql = "SELECT * FROM t10_check WHERE T10_CheSN='$studentID'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $hasSubmitted = true;
} else {
    $hasSubmitted = false;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>審核頁面</title>
    <link href="css/approval.css" rel="stylesheet">
</head>
<body>
<header>
    <div>國立虎尾科技大學</div>
    <div>National Formosa University</div>
</header>
<div class="main-content">
    <?php if ($hasSubmitted): ?>
        <h1>已提交審核，請等待審核完畢</h1>
    <?php else: ?>
        <h1>尚未通過審核</h1>
        <form action="submitApproval.php" method="POST">
            <label for="professorName"><b>指導教授</b></label>
            <input type="text" id="professorName" name="professorName" placeholder="輸入教授姓名" required>
            <label for="selfRecommendation"><b>自薦</b></label>
            <textarea id="selfRecommendation" name="selfRecommendation" placeholder="輸入自薦內容" required></textarea>
            <button type="submit" name="submit">送出審核</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>