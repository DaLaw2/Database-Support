<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.html");
    exit();
}

include 'connection.php';
$conn = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_SESSION['id'];
    $studentName = $_SESSION['name'];
    $professorName = $conn->real_escape_string($_POST['professorName']);
    $selfRecommendation = $conn->real_escape_string($_POST['selfRecommendation']);

    $sql = "SELECT * FROM t10_check WHERE T10_CheSN='$studentID'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $sql = "INSERT INTO t10_check (T10_CheSN, T10_CheN, T10_CheW, T10_ChePN) VALUES ('$studentID', '$studentName', '$selfRecommendation', '$professorName')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['isApproval'] = false;
            header("Location: approval.php");
        } else {
            echo "提交審核時發生錯誤：" . $conn->error;
        }
    } else {
        echo "您已提交過審核，請等待審核完畢。";
    }
}

$conn->close();

