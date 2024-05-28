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
     else if (!$rowAdminCheck || $rowAdminCheck['admin'] == 2){
        header('location: ./konto_pracownika.php');
        exit();
     }
     else{
     }
    }
?>
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
        <link rel="stylesheet" href="../Looks/style.css">
        <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds; 

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    window.location.href = './wyloguj.php';
                }
            }, 1000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            var tenMinutes = 60 * 10,
                display = document.querySelector('#timer'); 

            startTimer(tenMinutes, display);
        });
    </script>
        <title>The Vault</title>
        <style>
            .table-view {
                max-height: 360px;
                overflow-y: auto;
                margin-bottom: 24px;
            }
        </style>    
    </head>
    <body>
    <div class="row" style="margin-top: 3%;"><div class="col-3" style="padding-left: 5%;">
        Witaj, 
        <?php
            $sql3 = "SELECT `Name` FROM `users` WHERE '$_SESSION[nrkonta]'= `Nr_konta`";
            $result3 = $conn->query($sql3);
            if ($result3) {
                $row = $result3->fetch_assoc();
                if ($row) {
                    echo $_SESSION['name'];
                }
            }
        ?>
        </div>
        <div class="col-7" style="opacity: 0.5">
            Twoja sesja wygaśnie za: <span id="timer">10:00</span>
        </div>
        <div class="col-2" style="text-align:center;">
            <a href=./wyloguj.php>Wyloguj
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="row" style="margin-top: 6%; height: 25%">
        <div class="col-4" style="padding-left: 5%;">
            Saldo<br><div style="font-size: 64px; margin-top: 2%;">
            <?php
            $sql4 = "SELECT `AccountBalance` FROM `users` WHERE '$_SESSION[nrkonta]'= `Nr_konta`";
            $result4 = $conn->query($sql4);
            if ($result4) {
                $row = $result4->fetch_assoc();
                if ($row) {
                    echo $row['AccountBalance'];
                }
            }
        ?><style="font-size: 26px;"> ZŁ </> </div>
        </div>
        <div class="col-4">
            Ostatnie 30 dni 

            <?php
                $dni = 0;
                $sql10 = "SELECT * FROM `historia_przelewow` WHERE (`nr_klienta_wysyla` = '$_SESSION[nrkonta]' OR `nr_klienta_odbiera` = '$_SESSION[nrkonta]') AND `data_przelewu` >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                $result10 = $conn->query($sql10);
                if ($result10) {
                    while ($row = $result10->fetch_assoc()) {
                        if ($row['nr_klienta_wysyla'] == $_SESSION['nrkonta']) {
                            $dni -= $row['kwota_wysyla'];
                        } else {
                            $dni += $row['kwota_wysyla'];
                        }
                    }
                if($dni < 0 ){
                    $Kolor = "red";
                }else{
                    $Kolor = "green";
                }
            ?><br><?php
                    echo "<div style=\"color: " . htmlspecialchars($Kolor) . "; font-size:64px;\">$dni";
                }
            ?><style="font-size: 26px;"> ZŁ </></div>


        </div>
        <div class="col-4 box">
            <div class="rectangle">
                <div class="cip">
                </div>
                <div class="dane">
                <?php
            $sql5 = "SELECT `Name` FROM `users` WHERE '$_SESSION[nrkonta]'= `Nr_konta`";
            $result5 = $conn->query($sql5);
            if ($result5) {
                $row = $result5->fetch_assoc();
                if ($row) {
                    echo $_SESSION['name'];
                    echo " ". $_SESSION['surname'];
                    echo "<br>". $_SESSION['nrkonta'];
                }
            }
        ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 3%;">
        <div class="col-8 table-view p-3" style="text-align:center; scrollbar-width:none;">
            <?php            
            $sql1 = "SELECT * FROM `historia_przelewow` WHERE `nr_klienta_wysyla` = '$_SESSION[nrkonta]' OR `nr_klienta_odbiera` = '$_SESSION[nrkonta]' ORDER BY `data_przelewu` DESC";
            
            $result1 = $conn->query($sql1);
            echo <<< TABLE1
                  <table class="table table-secondary table-hover table-sm " style="margin: 0 auto;">
                    <tr class="table table-dark table-hover">
                      <th>Nadawca</th>
                      <th>Odbiorca</th>
                      <th>Kwota</th>
                      <th>Data</th>
                      
                      
                    </tr>
                  
            TABLE1;
            
            
            if($result1->num_rows == 0){
                echo "<tr><td colspan='4'>Historia przelewow</td></tr>";
            }else {
                while ($user1 = $result1->fetch_assoc()) {
                    if($user1['nr_klienta_wysyla'] == $_SESSION['nrkonta']){
                        $Kolor = "red";
                        $znak = "-";
                    }else{
                        $Kolor = "green";
                        $znak = "";
                    }
                    echo <<< USERS1
                        <tr>
                          <td style="color:black;">$user1[nr_klienta_wysyla]</td>
                          <td style="color:black;">$user1[nr_klienta_odbiera]</td>
                          <td style="color:$Kolor">$znak$user1[kwota_wysyla] PLN</td>
                          <td style="color:black;">$user1[Data_przelewu]</td>
                        </tr>
            USERS1;
                }
            }
            ?></table>
        </div>
        <div class="col-4" >
        <div style="opacity: 0.5"> Nowy przelew </div>
            <?php
                  echo <<< ADDUSERFORM
                    <h4></h4>   
                    <form action="./przelew.php?przelew=18" method="post">  
                    <input type="text" class="jedenjeden" style="width:75%;" name="ID1" placeholder="Numer konta odbiorcy"><br>
                    <input type="text" class="jedenjeden" style="width:50%;" name="ilosc" placeholder="Kwota">
              
            ADDUSERFORM;
                echo <<< ADDUSERFORM
                    </select><br>
                    <input type="submit" class="btn btn-light" style="width:35%;" value="Zatwierdź">
                  </form>
            ADDUSERFORM;
            if (isset($_SESSION['error'])) {
                $error = $_SESSION['error'];
                echo '<p style="color: red;">'   . $error . '</p>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>

<?php




if (isset($_GET["przelew"])) {

    echo <<< ADDUSERFORM
      <h4>Przelew</h4>   
        <form action="./przelew.php?przelew=18" method="post">  
        <input type="text" name="ilosc" placeholder="kwota"><br>
        <input type="text" name="ID1" placeholder="Nr konta odbioru">
  
ADDUSERFORM;
    echo <<< ADDUSERFORM
        </select><br><br>
       
        <input type="submit" value="Przelej">
      </form>
ADDUSERFORM;
}
else {


}
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>