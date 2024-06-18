<?php
include 'connection.php';
$conn = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $sql = "SELECT T10_Member.*, T10_Information.T10_InfName FROM T10_Member 
            INNER JOIN T10_Information ON T10_Member.T10_MemSN = T10_Information.T10_InfSN 
            WHERE T10_Member.T10_MemSN='$username' AND T10_Member.T10_MemPw='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        session_start();
        $row = $result->fetch_assoc();
        $studentID = $row["T10_MemSN"];
        $studentName = $row["T10_InfName"];
        $_SESSION['studentID'] = $studentID;
        $_SESSION['studentName'] = $studentName;
        $_SESSION["isLogin"] = true;
        echo '<script>window.location.href = "approval.html";</script>';
    } else {
        echo "登入失敗，請檢查帳號和密碼或學生名稱是否存在。";
    }
    $conn->close();
}