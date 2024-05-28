<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET["userDeleteId"])) {
    require_once "./Connect.php";
    $userId = $_GET["userDeleteId"];
    $sql = "DELETE FROM `users` WHERE `ID` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    if ($stmt->affected_rows != 0) {
        header("location: ../Admin.php?infoUserDelete=1");
    } else {
        header("location: ../Admin.php?infoUserDelete=0");
    }
} else {
    echo "<script>history.back();</script>";
}