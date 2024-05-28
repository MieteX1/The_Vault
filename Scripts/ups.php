<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./Connect.php";
        $sql333= "UPDATE users SET AccountBalance = (AccountBalance + '100'  ) WHERE Nr_konta = '62';";
        $conn->query($sql333);