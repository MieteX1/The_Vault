<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./Scripts/Connect.php";

$recaptchaSecretKey = '6LeBVmEpAAAAAJWHAOmFRqNl3JvjK-8dt1xhYrqx';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse
    ];

    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResultJson = json_decode($recaptchaResult, true);

    if (!$recaptchaResultJson['success']) {
        $_SESSION['error']='Weryfikacja reCAPTCHA nie powiodła się.';
    } else {


        $conn = new mysqli($host, $uzytkownik, $haslo, $baza_danych);

        $existingEmail = $_POST['email'];
        $checkEmailQuery = "SELECT COUNT(*) as count FROM users WHERE email = '$existingEmail'";
        $emailResult = $conn->query($checkEmailQuery);
        $emailCount = $emailResult->fetch_assoc()['count'];

        if ($emailCount > 0) {
            $sql = "SELECT Nr_konta FROM users WHERE email = '$existingEmail'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $numerKonta = $row["Nr_konta"];

            $to = $_POST["email"];
            $subject = "Potwierdzenie konta";
            $verificationLink = generateVerificationLink();
            saveVerificationLink($to, $verificationLink, $host, $uzytkownik, $haslo, $baza_danych);
            $message = "Witaj!\n\nKliknij poniższy link, aby potwierdzić swoje konto:\n\n";
            $message .= "https://juliuszdrojecki.pl/projekt_php_studia/The_Vault/potwierdz.php?link=" . urlencode($verificationLink);
            $headers = "From: twojadomena.com \r\n";
            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['success']='Wiadomość została wysłana na adres:' .$to;
            } else {
                $_SESSION['error']='Weryfikacja reCAPTCHA nie powiodła się.';
            }
        } else {
            $_SESSION['error']='Podany adres e-mail nie istnieje w bazie danych.';
        }
    }
}
function generateVerificationLink() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $verificationLink = '';
    for ($i = 0; $i < 10; $i++) {
        $verificationLink .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $verificationLink;
}

function saveVerificationLink($email, $link, $host, $uzytkownik, $haslo, $baza_danych) {
    $conn = new mysqli($host, $uzytkownik, $haslo, $baza_danych);
    if ($conn->connect_error) {
        die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET link_weryfikacyjny = '$link' WHERE email = '$email'";
    if ($conn->query($sql) !== TRUE) {
        echo "Wystąpił błąd podczas zapisywania linku w bazie danych: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="./Looks/img/The_vault.png">
    <title>Formularz wysyłania e-maila - The Vault</title>
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
        <div class="col-7 align d-flex justify-content-center" style="">
            <div id="title2" class="text-wrapper"style="">The Vault</div>
        <h2 id="formularz">Formularz potwierdzenia konta</h2>
        <form method="POST"style="text-align: center;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email" class="form-label">Adres e-mail:</label><br>
        <input type="email" id="email" name="email" placeholder="Wpisz swój adres e-mail" required>

        <div class="g-recaptcha" data-sitekey="6LeBVmEpAAAAAJy2-_CyNpDnImLfbmAzhCju1lXa"></div>

            <?php
            if (isset($_SESSION['error'])) {
                $error = $_SESSION['error'];
                echo '<p class="error">'   . $error . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <?php
            if (isset($_SESSION['success'])) {
                $success = $_SESSION['success'];
                echo '<p class="success">'   . $success . '</p>';
                unset($_SESSION['success']);
            }
            ?>

        <input type="submit" id="send-btn" value="Wyślij">
    
        </form>
<br><a href="./logowanie.php"><button id="back-btn">Powrót do menu</button></a>
</div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
