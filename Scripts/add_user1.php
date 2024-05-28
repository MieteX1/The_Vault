<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

foreach ($_POST as $key => $value){
    if (empty($value)){
        $_SESSION["error"] = "Wypełnij wszystkie dane!";
        echo "<script>history.back();</script>";
        exit();
    }
}

require_once "./Connect.php";
$haslo_hash = password_hash($_POST['haslo'],PASSWORD_DEFAULT);
$licznik = RAND();
$sql = "INSERT INTO users (ID,Name, Surname,Nr_konta,haslo,email, AccountBalance,admin,IsVerified,link_weryfikacyjny) VALUES (NULL,'$_POST[Name]', '$_POST[Surname]', $licznik, '$haslo_hash','$_POST[email]',0,'$_POST[Admin]',0,NULL);";

$conn->query($sql);

if ($conn->affected_rows == 1){
    $_SESSION["success"] = "Prawidłowo dodano użytkownika $_POST[firstName] $_POST[lastName]";
}else{
    $_SESSION["success"] = "Nie dodano użytkownika!";
    echo "<script>history.back();</script>";
    exit();
}

header("location: ./konto_pracownika.php");
