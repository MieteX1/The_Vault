<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header('location: ../logowanie.php');
    exit();
}
require_once "./Connect.php";

$loggedUserId = $_SESSION['id'];

$sqlAdminCheck = "SELECT admin FROM `users` WHERE ID = $loggedUserId";
$resultAdminCheck = $conn->query($sqlAdminCheck);

if ($resultAdminCheck) {
    $rowAdminCheck = $resultAdminCheck->fetch_assoc();
    if (!$rowAdminCheck || $rowAdminCheck['admin'] == 1) {
        header('location: ../Admin.php');
        exit();
    }
     else if (!$rowAdminCheck || $rowAdminCheck['admin'] == 3){
        header('location: ./konto_uzytkownika.php');
        exit();
     }
     else{
     }
    }
?>
<!doctype html>

<!doctype html>
<html lang="pl">
<head>
    <link rel="shortcut icon" type="image/jpg" sizes="16x16" href="../Looks/img/The_vault.png">
    <link rel="canonical" href="/">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../Looks/style2.css">
    <title>Panel pracownika - The Vault</title>
</head>

<body>
<div class="row" style="margin-top: 1%;"><div class="col-11" style="text-align:center;">
<h1>Panel pracownika</h1></div>
<div class="col-1"><button type="button" class="btn logout-btn"><a style="color: inherit;" href=./wyloguj.php>Wyloguj</a></button>
  </div>
  </div>
  <div class="row margin">
      <div class="col-6" style="text-align:center;" id="add-user">

<?php
    echo <<< ADDUSERFORM
      <h4>Dodawanie użytkownika</h4>
      <form action="./add_user.php" method="post">
        <input class="jeden" type="text" name="Name" placeholder="Podaj imię"><br><br>
        <input class="jeden" type="text" name="Surname" placeholder="Podaj nazwisko"><br><br>
        <input class="jeden" type="text" name="email" placeholder="Podaj adres e-mail"><br><br>
        <input class="jeden" type="text" name="haslo" placeholder="Podaj hasło"><br><br>
        <select class="form-select" aria-label="Default select example" name="Admin">
            <option selected>Wybierz uprawnienia</option>
            <option value="1">Admin</option>
            <option value="2">Pracownik</option>
            <option value="3">Użytkownik</option>
        </select>

        
ADDUSERFORM;

    echo <<< ADDUSERFORM
        </select><br><br>
        <input type="submit" class="btn add-user-btn" value="Dodaj użytkownika">
      </form>
ADDUSERFORM;
?> 
        </div>

      <div class="col-6 mx-auto" style="text-align:center;" id="edit">
<?php

    echo <<< ADDUSERFORM
      <h4>Edycja Salda</h4>   
        <form action="./siano.php?userId=userId" method="post">  
        <input class="dwa" type="text" name="Name" class="account-nr" class="text-wrapper-2" placeholder="'-' odejmuje środki"><br>
        <input class="dwa" type="number" name="ID" placeholder="Wpisz ID klienta">
  
ADDUSERFORM;
    echo <<< ADDUSERFORM
        </select><br><br>
       
        <input type="submit" class="btn edit-money-btn" value="Aktualizuj">
      </form>
ADDUSERFORM;

?> 
  </div></div>
<?php
if (isset($_SESSION["error"])){
    echo "<h4>".$_SESSION["error"]."</h4>";
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])){
    echo "<h4>".$_SESSION["success"]."</h4>";
    unset($_SESSION["success"]);
}
require_once "../Scripts/Connect.php";

$sql ="SELECT * FROM `users`";
$result = $conn->query($sql);

?>
 <div class="row margin">
    <div class="col-md-6 table-view p-3"  style="text-align:center; scrollbar-width:none;">
        <?php
        echo <<< TABLE
            <table class="table table-secondary table-hover table-sm" style="margin: 0 auto ;">
                <tr class="table table-dark table-hover">
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>E-mail</th>               
                    <th>Stan Konta</th>
                    <th>Nr_konta</th>
                    <th>Admin</th>
                </tr>
TABLE;

        if($result->num_rows == 0){
            echo "<tr><td colspan='4'>Brak rekordów do wyświetlenia!</td></tr>";
        }else{
            while ($user = $result->fetch_assoc()){
                echo <<< USERS
                <tr>
                    <td>$user[ID]</td>
                    <td>$user[Name]</td>
                    <td>$user[Surname]</td>
                    <td>$user[email]</td>
                    <td>$user[AccountBalance]</td>
                    <td>$user[Nr_konta]</td>
                    <td>$user[admin]</td>          
                </tr>
USERS;
            }
        }
        ?> </table>
    </div>
    <div class="col-md-6 table-view p-3" style="text-align:center; scrollbar-width:none;">
        <?php
        $sql1 ="SELECT * FROM `historia_przelewow`";
        $result1 = $conn->query($sql1);
        echo <<< TABLE1
            <table class="table table-secondary table-hover table-sm " style="margin: 0 auto; ">
                <tr class="table table-dark table-hover">
                    <th class="smaller-cell">Nadawca</th>
                    <th class="smaller-cell">Odbiorca</th>
                    <th class="smaller-cell">Kwota</th>
                    <th class="smaller-cell">Data</th>
                </tr>
TABLE1;

        if($result1->num_rows == 0){
            echo "<tr><td colspan='4'>Brak rekordów do wyświetlenia!</td></tr>";
        }else {
            while ($user1 = $result1->fetch_assoc()) {
                echo <<< USERS1
                <tr>
                    <td>$user1[nr_klienta_wysyla]</td>
                    <td>$user1[nr_klienta_odbiera]</td>
                    <td>$user1[kwota_wysyla]</td>
                    <td>$user1[Data_przelewu]</td>
                </tr>
USERS1;
            }
        }
        ?> 
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>