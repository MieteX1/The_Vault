<?php
session_start();
require_once "./Connect.php";
if(isset($_POST['imie2'])){
    $wypelnienie = true;
    $imie=$_POST['imie2'];
    if(strlen($imie)<2 || strlen($imie)>15){
        $wypelnienie = false;
        $_SESSION['e_imie']="";

    }
    if (!preg_match("#^[a-zA-ZęĘóÓąĄśŚłŁżŻźŹćĆńŃ]+$#", $imie)) {
        $wypelnienie = false;
        $_SESSION['e_imie']="";
    }

    $nazwisko=$_POST['nazwisko2'];
    if(strlen($nazwisko)<2 || strlen($nazwisko)>30){
        $wypelnienie = false;
        $_SESSION['e_nazwisko']="Nazwisko musi mieć od 2 do 30 liter";
    }
    if (!preg_match("#^[a-zA-ZęĘóÓąĄśŚłŁżŻźŹćĆńŃ]+$#", $nazwisko)) {
        $wypelnienie = false;
        $_SESSION['e_nazwisko']="Nazwisko nie może zawierać cyfr";
    }
    $email=$_POST['email2'];
    $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
    if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email)){
        $wypelnienie = false;
        $_SESSION['e_email']= "Podaj poprawny adres e-mail";
    }
    $haslo1 = $_POST['haslo2'];
    $haslo2 = $_POST['haslo3'];
    if(strlen($haslo1)<8||strlen($haslo1)>20){
        $wypelnienie = false;
        $_SESSION['e_haslo']= "Hasło musi mieć od 8 do 20 znaków";
    }if($haslo1!=$haslo2){
        $wypelnienie = false;
        $_SESSION['e_haslo1']= "Hasła muszą być te same";
    }
    $haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);
    $recaptcha_secret = "6LeBVmEpAAAAAJWHAOmFRqNl3JvjK-8dt1xhYrqx";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
    $recaptcha_data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );

    $recaptcha_options = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($recaptcha_data)
        )
    );

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result, true);

    if (!$recaptcha_json['success']) {
        $wypelnienie = false;
        $_SESSION['e_recaptcha'] = "Potwierdź, że nie jesteś robotem";
    }
    if(!isset($_POST['regulamin'])){
        $wypelnienie = false;
        $_SESSION['e_regulamin']= "Musisz potwierdzić zapoznanie się z regulaminem";
    }
    

    $sql = "SELECT id FROM `users` WHERE email='$email'";
    $result = $conn->query($sql);
    $maile = $result->num_rows;
    if($maile>0){
        $wypelnienie = false;
        $_SESSION['e_email']= "Na podanym e-mailu jest już założone konto";
    }

    if($wypelnienie==true){
        $licznik = RAND();
        $sql1 = "INSERT INTO `users` VALUES (NULL,'$imie','$nazwisko', '$licznik','$haslo_hash','$emailB','100','3','0',NULL)";
        $conn->query($sql1);
        $to = $emailB;

        header('location: ./udana_rejestracja.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="../Looks/img/The_vault.png">
    <title>Rejestracja - The Vault</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" type="text/css" href="../Looks/style1.css">
</head>
<style>
    .container-fluid{
        margin:auto;
    }
    .left-pane {
        background: url('../Looks/img/background-photo.jpg') repeat fixed;
        background-size:  50%;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    
    .idc1 {
        display: flex;
        justify-content: left;
        font-size: 20px;
        color: white;
    }
    .invis {
        display: none !important;
    }

</style>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-5 left-pane"></div>
        <div class="col-7 align d-flex justify-content-center">
            <div id="title3" class="text-wrapper">The Vault</div>
            <form method="post">
                <label class="form-label">
                    Imię<span class="<?php echo isset($_SESSION['e_imie']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wpisz poprawne imię</span>
                </label>
                <input class="form-control"type="text" name="imie2" id="input-rejestracja" placeholder="Wpisz swoje imię"><br>
                <?php
                if(isset($_SESSION['e_imie'])){
                    unset($_SESSION['e_imie']);
                }
                ?>
                <label class="form-label">
                   Nazwisko<span class="<?php echo isset($_SESSION['e_nazwisko']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wpisz poprawne nazwisko</span>
                </label><input class="form-control"type="text" name="nazwisko2"id="input-rejestracja" placeholder="Wpisz swoje nazwisko"><br>
                <?php
                if(isset($_SESSION['e_nazwisko'])){
                    unset($_SESSION['e_nazwisko']);
                }
                ?>
                <label class="form-label">
                    Adres e-mail<span class="<?php echo isset($_SESSION['e_email']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Podaj poprawny adres e-mail</span>
                </label><input class="form-control"type="text" name="email2"id="input-rejestracja" placeholder="Wpisz swój adres e-mail"><br>
                <?php
                if(isset($_SESSION['e_email'])){
                    unset($_SESSION['e_email']);
                }
                ?>
                <label class="form-label">
                    Hasło<span class="<?php echo isset($_SESSION['e_haslo']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasło musi mieć od 8 do 20 znaków</span>
                </label><input class="form-control"type="password" name="haslo2"id="input-rejestracja" placeholder="Wpisz hasło"><br>
                <?php
                if(isset($_SESSION['e_haslo'])){
                    unset($_SESSION['e_haslo']);
                }
                ?>
                <label class="form-label">
                   Powtórz hasło<span class="<?php echo isset($_SESSION['e_haslo1']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasła muszą być te same</span>
                </label><input class="form-control"type="password" name="haslo3"id="input-rejestracja" placeholder="Powtórz hasło"><br><?php
                if(isset($_SESSION['e_haslo1'])){
                    unset($_SESSION['e_haslo1']);
                }
                ?><br>

                <div class="mb-3 idc1"style="display: flex">
                <label style="display: contents">
                    <input type="checkbox"name="regulamin" class="regulamin">Akceptuję regulamin<span class="<?php echo isset($_SESSION['e_regulamin']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;display: contents;">&nbsp;&nbsp;&nbsp;&nbsp;Zaakceptuj regulamin</span>
                </label>
                </div>
                <?php
                if(isset($_SESSION['e_regulamin'])){
                    unset($_SESSION['e_regulamin']);
                }
                ?>
                <div class="row">
                    <div class="g-recaptcha idc1 col-8" data-sitekey="6LeBVmEpAAAAAJy2-_CyNpDnImLfbmAzhCju1lXa">
                        
                    </div>
                    <span class="col-4 <?php echo isset($_SESSION['e_recaptcha']) ? '' : 'invis'; ?>" style="color:red; font-size:16px;display: flex;margin: auto;">Potwierdź Recaptcha</span>
                </div>
                <?php
                if(isset($_SESSION['e_recaptcha'])){
                    unset($_SESSION['e_recaptcha']);
                }
                ?>
                
                <input type="submit"value="Zarejestruj sie" id="register-btn">


            </form>

            <br><a href="../logowanie.php"><button id="back-btn">Powrót do menu</button></a>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>