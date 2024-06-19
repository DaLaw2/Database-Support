<?php
if (isset($_POST['username']) && isset($_POST['action']) && isset($_POST['student_name']) && isset($_POST['teacher_name'])) {
    $username = $_POST['username'];
    $action = $_POST['action'];
    $studentName = $_POST['student_name'];
    $teacherName = $_POST['teacher_name'];

    include 'connection.php';
    $conn = getDatabaseConnection();

    if ($action == 'accept') {
        $stmt = $conn->prepare("SELECT T10_LabTN FROM T10_Lab WHERE T10_LabPN = ?");
        $stmt->bind_param("s", $teacherName);
        $stmt->execute();
        $result = $stmt->get_result();
        $lab = $result->fetch_assoc();
        if ($lab && isset($lab['T10_LabTN'])) {
            $labID = $lab['T10_LabTN'];
            $stmt = $conn->prepare("SELECT T10_CheN FROM T10_Check WHERE T10_CheSN = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $student = $result->fetch_assoc();
            $stmt = $conn->prepare("INSERT INTO T10_Information (T10_InfSN, T10_InfName, T10_InfLab) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $student['T10_CheN'], $labID);
            $stmt->execute();
        } else {
            echo 'error: no lab found for the teacher';
            exit;
        }
        $stmt = $conn->prepare("UPDATE T10_member SET T10_MemPass = 1 WHERE T10_MemSN = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM T10_Check WHERE T10_CheSN = ?");
        $stmt->bind_param("s", $username);
    } else if ($action == 'reject') {
        $stmt = $conn->prepare("DELETE FROM T10_Check WHERE T10_CheSN = ?");
        $stmt->bind_param("s", $username);
    }
    if ($stmt->execute()) {
        header("Location: adminDashboard.php");
        exit;
    } else {
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error: missing username or action';
}
