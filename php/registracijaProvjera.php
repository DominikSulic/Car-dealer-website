<?php
    require_once "baza.php";

    $korime = $_POST['korisnickoImeR'];
    $upit = "SELECT * FROM korisnik WHERE Korisnicko_Ime='$korime'";
    $rezultat = upit($upit);

    if(mysqli_num_rows($rezultat) == 1) {
        echo "Korisničko ime već postoji!";
    }
    else {
        echo "Korisničko ime nije zauzeto!";
    }
?>