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
        <link rel="stylesheet" href="../Looks/look_of_admin_page.css">
        <title>Document</title>
    </head>
    <body>
    <h1>Bank F&J</h1>
<?php

if (isset($_GET["search"])){
    require_once "./Connect.php";
    $sql = "SELECT * FROM `users` WHERE `ID` = '$_POST[search]'";

    $result = $conn->query($sql);

    echo <<< TABLE
      <table>
        <tr>
          <th>ID</th>
          <th>Imię</th>
          <th>Nazwisko</th>    
          <th>Stan Konta</th>
          
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
              <td>$user[AccountBalance]</td>
              
                     
            </tr>
USERS;
        }
    }
}else{
    echo "<script>history.back();</script>";
}
