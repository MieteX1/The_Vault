<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="./Looks/img/The_vault.png">
    <title>Udane potwierdzenie - The Vault</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Looks/style1.css">
</head>
<style>
    .container-fluid{
        margin:auto;
    }
    .left-pane {
        background: url('./Looks/img/background-photo.jpg') repeat fixed;
        background-size:  50%;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    
</style>
<body>
<div class="container-fluid text-white">
    <div class="row">
        <div class="col-5 left-pane"></div>
        <div class="col-7 align d-flex justify-content-center" style="text-align:center; font-size:24px; font-weight:bold;">
            <div id="title2" class="text-wrapper"style="">The Vault</div>
            <?php
                require_once "./Scripts/Connect.php";

                $conn = new mysqli($host, $uzytkownik, $haslo, $baza_danych);
                if ($conn->connect_error) {
                    die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
                }
                if (isset($_GET['link'])) {
                    $verificationLink = $_GET['link'];

                    $sql = "SELECT email, Nr_konta FROM users WHERE link_weryfikacyjny = '$verificationLink'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $email = $row['email'];
                        $numerKonta = $row['Nr_konta'];

                        $updateSql = "UPDATE users SET IsVerified = 1 WHERE email = '$email'";
                        if ($conn->query($updateSql) === TRUE) {
                            echo "Adres e-mail $email został pomyślnie zweryfikowany. <br><br> Numer Twojego konta do zalogowania to: " . $numerKonta . "<br>";
                        } else {
                            echo "Wystąpił błąd podczas weryfikacji adresu e-mail: " . $conn->error;
                        }
                    } else {
                        echo "Nieprawidłowy link weryfikacyjny.";
                    }
                } else {
                    echo "Brak parametru 'link' w adresie URL.";
                }

                $conn->close();
                ?>
            <br><a href="./logowanie.php"><button id="back-btn">Powrót do menu</button></a>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>