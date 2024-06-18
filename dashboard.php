<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit();
}

$studentName = $_SESSION['studentName'];
$studentID = $_SESSION['studentID'];
$teamNumber = $_SESSION['studentTeam'];
$labNumber = $_SESSION['studentLab'];

include 'connection.php';
$conn = getDatabaseConnection();

$sql_team = "SELECT T10_TeamName FROM T10_Team WHERE T10_TeamNum='$teamNumber'";
$result_team = $conn->query($sql_team);
$teamName = "";
if ($result_team->num_rows == 1) {
    $row_team = $result_team->fetch_assoc();
    $teamName = $row_team['T10_TeamName'];
}

$sql_members = "SELECT T10_InfName FROM T10_Information WHERE T10_InfTeam='$teamNumber'";
$result_members = $conn->query($sql_members);
$members = [];
while ($row_members = $result_members->fetch_assoc()) {
    $members[] = $row_members['T10_InfName'];
}

$sql_lab = "SELECT T10_LabName, T10_InfPN FROM T10_Lab WHERE T10_LabTN='$labNumber'";
$result_lab = $conn->query($sql_lab);
$labName = "";
$professorName = "";
if ($result_lab->num_rows == 1) {
    $row_lab = $result_lab->fetch_assoc();
    $labName = $row_lab['T10_LabName'];
    $professorName = $row_lab['T10_InfPN'];
}

$conn->close();
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
            <h2>組別資訊</h2>
            <div class="box fixed-box personal-info-box">
                <p>組別名稱：<?php echo $teamName; ?></p>
                <p>組員：</p>
                <ul>
                    <?php foreach ($members as $member) {
                        echo "<li>$member</li>";
                    } ?>
                </ul>
                <p>指導教授：<?php echo $professorName; ?></p>
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
