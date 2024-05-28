<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="../Looks/img/The_vault.png">
    <link rel="stylesheet" type="text/css" href="../Looks/style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>The Vault</title>

</head>


<body>
    <style>
        .row{
            margin:auto;
        }
        .back-btn1 {
        display: flex;
        width: 476px;
        justify-content: center;
        align-items: center;
        padding: 10px 12px;
        gap: 10px;
        border-radius: 16px;
        border: 0.5px solid #F4F4F4;
        background: #F4F4F4;
        color: #131F2E;
        font-family: Lato;
        font-size: 28px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        }
        .form-label1 {
        color: #F4F4F4;
        font-family: Inter;
        font-size: 28px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        }
        .left-pane {
            background: url('../Looks/img/background-photo.jpg') repeat fixed;
            background-size:  50%;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <div class="row">
    <div class="col-5 left-pane"></div>
        <div class="col-7 align d-flex justify-content-center">
            <p class="form-label1"style="color:white;text-align:center;">
            Rejestracja przeszła pomyslnie<br><br>
            Przejdź do strony z potwierdzeniem e-mail aby aktywować konto
            </p><br>
            <a href="../test.php"><button class="back-btn1">Przejdź do potwierdzenia e-mail</button></a><br><br>
            <a href="../logowanie.php"><button class="back-btn1">powrót do menu</button></a>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
