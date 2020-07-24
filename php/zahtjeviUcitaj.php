<?php
    session_start();
    require_once "baza.php";
    $korisnickoIme = $_SESSION["Sesija_KorisnickoIme"];

    $upit = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korisnickoIme'";
    $rezultat = upit($upit);
    $rezultat = $rezultat->fetch_assoc();
    $korisnikID = $rezultat["ID_Korisnik"];

    $upit2 = "SELECT zahtjev.Naziv, zahtjev.Opis, zahtjev.Slika, zahtjev.Status, servis.Datum, termin.Od, termin.Do, lokacija.Adresa FROM zahtjev JOIN servis on zahtjev.ID_Zahtjev = servis.Zahtjev_ID JOIN termin ON servis.Termin_Id = termin.ID_Termin JOIN lokacija ON servis.Lokacija_ID = lokacija.ID_Lokacija AND zahtjev.Korisnik_ID = '$korisnikID'";
    $result = upit($upit2);
    $array = array();

    if(mysqli_num_rows($result) > 0) {
        $broj = 0;
        while($red = mysqli_fetch_array($result)) {
            $array[$broj] = $red;
            $broj = $broj + 1;
        }
    }

    echo json_encode($array);
?>