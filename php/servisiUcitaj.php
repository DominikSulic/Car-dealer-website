<?php
    session_start();
    require_once "baza.php";

    $korIme = $_SESSION["Sesija_KorisnickoIme"];
    $korisnikID = "";
    $upit1 = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korIme'";
    $rezultat1 = upit($upit1);

    if(mysqli_num_rows($rezultat1) == 1) {
        $rezultat1 = $rezultat1->fetch_array();
        $korisnikID = $rezultat1["ID_Korisnik"];
    }

    $upit2 = "SELECT servis.Datum, servis.Cijena, servis.Status FROM servis JOIN zahtjev ON servis.Zahtjev_ID = zahtjev.ID_Zahtjev and zahtjev.Korisnik_ID='$korisnikID'";
    $rezultat2 = upit($upit2);
    $vrati = "";
    $array = array();

    if(mysqli_num_rows($rezultat2) > 0) {
        $broj = 0;
        while($red = mysqli_fetch_array($rezultat2)) {
            $array[$broj] = $red;
            $broj = $broj + 1;
        }
        echo json_encode($array);
    }
    else {
        $vrati = "Učitavanje podataka nije uspjelo!";
        echo $vrati;
    }
?>