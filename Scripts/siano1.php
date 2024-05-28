<?php
session_start();

foreach ($_POST as $key => $value) {
    if (empty($value)) {
        $_SESSION["error"] = "Błąd";
        echo "<script>history.back();</script>";
        exit();
    }
}

require_once "./Connect.php";
$sql = "UPDATE  users SET AccountBalance = ('$_POST[Name]'+AccountBalance) WHERE ID = $_POST[ID];";

$conn->query($sql);

if ($conn->affected_rows != 0){
    header("location: ./konto_pracownika.php?infoUserDelete=1");
}else{
    header("location: ./konto_pracownika.php?infoUserDelete=0");
}


