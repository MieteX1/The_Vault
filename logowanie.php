<?php
session_start();
if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)){
    header('location: ./Scripts/konto_uzytkownika.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="./Looks/img/The_vault.png">
    <link rel="canonical" href="/">
    <title>Logowanie - The Vault</title>
    <link rel="stylesheet" type="text/css" href="Looks/style1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
<form action="Scripts/login.php" method="post">
    <?php
    if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>

        <?php
    } ?>
<div class="container-fluid text-white">
    <div class="row">
        <div class="col-5 left-pane"></div>
        <div class="col-7 idk d-flex justify-content-center" style="">
            
            
                    <div id="title" class="text-wrapper"style="">The Vault</div>
                    <div class="mb-3">
                    <label class="form-label">
                        Numer konta
                    </label>
                        <input type="text" name="Nr_konta" placeholder="Wpisz swój numer konta" class="account-nr text-wrapper-2">

                    </div>
                    <div class="mb-3">
                    <label class="form-label">
                        Hasło
                    </label>
                    <input type="password" name="haslo" placeholder="Wpisz swoje hasło" class="account-nr text-wrapper-2">
                    </div>
                    <div class="mb-3">
                       <a class="forgot-passwd text-wrapper-3" href="">Nie pamiętasz hasła?</a>
                    </div>
                    <button type="submit" class="pay-btn text-wrapper-3" id="login-btn">Zaloguj</button>
                    <?php
                        if (isset($_SESSION['error'])) {
                            $error = $_SESSION['error'];
                            echo '<p style="color: red; font-size: 28px;">'   . $error . '</p>';
                            unset($_SESSION['error']);
                        }
                    ?>
                    <a class="rejestracja pay-btn text-wrapper-3" id="sign-in-btn" href="./Scripts/rejestracja.php">Nie masz konta? Zarejestruj się</a>
                    <a class="rejestracja pay-btn text-wrapper-3" id="verify-email-btn" href="./test.php">Potwierdź email</a>
            
        </div>
    </div>
</div>
</form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
