<?php
session_start();

require_once "./Connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ilosc = $_POST["ilosc"];
    $idOdbiorcy = $_POST["ID1"];
    $idNadawcy = $_SESSION["nrkonta"];

    if ($ilosc < 0) {
        header("Refresh:0; url=./konto_uzytkownika.php");
        exit();
    } else {
        if ($idOdbiorcy == $idNadawcy) {
            $_SESSION['error'] = 'Nie możesz przelać środków na swoje konto!';
            header("Refresh:0; url=./konto_uzytkownika.php");
            exit();
        }

        $sql = "SELECT * FROM users WHERE Nr_konta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $idOdbiorcy);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $balanceQuery = "SELECT AccountBalance FROM users WHERE Nr_konta = ?";
            $stmtBalance = $conn->prepare($balanceQuery);
            $stmtBalance->bind_param("s", $idNadawcy);
            $stmtBalance->execute();
            $resultBalance = $stmtBalance->get_result();

            if ($resultBalance->num_rows > 0) {
                $rowBalance = $resultBalance->fetch_assoc();
                $balance = $rowBalance["AccountBalance"];

                if ($ilosc > 0 && $balance >= $ilosc) {
                    $sql333 = "UPDATE users SET AccountBalance = AccountBalance + ? WHERE Nr_konta = ?";
                    $stmt333 = $conn->prepare($sql333);
                    $stmt333->bind_param("ss", $ilosc, $idOdbiorcy);
                    $stmt333->execute();

                    $sql1 = "UPDATE users SET AccountBalance = AccountBalance - ? WHERE Nr_konta = ?";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->bind_param("ss", $ilosc, $idNadawcy);
                    $stmt1->execute();

                    $newBalance = $balance - $ilosc;
                    if ($newBalance >= 0) {
                        $sql2 = "INSERT INTO `historia_przelewow` (`id_przelewu`, `nr_klienta_wysyla`, `nr_klienta_odbiera`, `kwota_wysyla`, `kwota_odbiera`, `Data_przelewu`) VALUES (NULL, ?, ?, ?, ?, NOW())";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bind_param("ssss", $idNadawcy, $idOdbiorcy, $ilosc, $ilosc);
                        $stmt2->execute();

                        if ($stmt333->affected_rows > 0 && $stmt1->affected_rows > 0 && $stmt2->affected_rows > 0) {
                            header("Refresh:0; url=./konto_uzytkownika.php");
                        } else {
                            $_SESSION['error'] = 'Błąd podczas przetwarzania przelewu.';
                            header("Refresh:0; url=./konto_uzytkownika.php");
                        }
                    } else {
                        $_SESSION['error'] = 'Niewystarczające środki na koncie!';
                        header("Refresh:0; url=./konto_uzytkownika.php");
                    }
                } else {
                    $_SESSION['error'] = 'Kwota się nie zgadza lub nie masz wystarczającej ilości środków!';
                    header("Refresh:0; url=./konto_uzytkownika.php");
                }
            } else {
                $_SESSION['error'] = 'Błąd podczas pobierania salda konta.';
                header("Refresh:0; url=./konto_uzytkownika.php");
            }
            $stmtBalance->close();
        } else {
            $_SESSION['error'] = 'Konto z takim numerem nie istnieje!';
            header("Refresh:1; url=./konto_uzytkownika.php");
        }
        $stmt->close();
    }
}
?>
