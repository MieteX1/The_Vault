User
<?php
session_start();

?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./Looks/look_of_admin_page.css">
    <title>Document</title>
</head>
<body>
<h1>Bank F&J</h1>

<form action="./Scripts/zaloguj.php" method="post">
    ID: <br/><input type="text"name="ID"><br/>
    Hasło: <br/><input type="password"name="haslo"><br/><br/>
    <input type="submit"value="zaloguj"><br/>
    <?php

    if(isset($_SESSION['blad'])){
        echo $_SESSION['blad'];
    }else{
        echo" ";
    }


    ?>
<?php
require_once "./Connect.php";

if($conn->connect_errno!=0){
    echo "error";
}
else{
    $numer=$_POST['Nr_konta'];
    $_SESSION['Nr_konta']=$numer;
    $haslo=$_POST['haslo'];



    $numer = htmlentities($numer,ENT_QUOTES,"UTF-8");


    if ($result = $conn->query(sprintf("SELECT * FROM users WHERE Nr_konta='%s'", mysqli_real_escape_string($conn, $numer)))) {

        $num_of_users = $result->num_rows;
        if ($num_of_users > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($haslo, $row['haslo'])) {

                $_SESSION['zalogowany'] = true;

                $_SESSION['id'] = $row['ID'];
                $_SESSION['name'] = $row['Name'];
                $_SESSION['surname'] = $row['Surname'];
                $_SESSION['hs'] = $row['haslo'];
                $_SESSION['nrkonta'] = $row['Nr_konta'];
                $_SESSION['balance'] = $row['AccountBalance'];
                $_SESSION['adminek'] = $row['admin'];

                unset($_SESSION['blad']);
                if($_SESSION['adminek']==1){
                    header('location: ../Admin.php');
                }else if($_SESSION['adminek']==2){
                    header('location: ./konto_pracownika.php');
                }
                else{
                    header('location: ./konto_uzytkownika.php');
                }
            }
            else {
                session_start();
                $_SESSION['error'] = 'Błędne dane logowania';
                header('location: ../logowanie.php');
            }

        }
        else {
            session_start();
            $_SESSION['error'] = 'Błędne dane logowania';
            header('location: ../logowanie.php');
        }

    }

}

?>