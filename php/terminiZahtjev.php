<?php
    require_once "baza.php";

    $lokacija =  $_POST['lokacija'];
    $autokucaNaziv = $_POST['autokuca'];

    $upit = "SELECT ID_Autokuca FROM autokuca WHERE Naziv='$autokucaNaziv'";
    $rezultat = upit($upit);
    $prviRed = $rezultat->fetch_assoc();
    $vratiID = $prviRed["ID_Autokuca"];


    $upit1 = "SELECT DISTINCT ID_Lokacija FROM lokacija WHERE Autokuca_ID='$vratiID' AND Adresa = '$lokacija'";
    $rezultat2 = upit($upit1);
    $prviRed1 = $rezultat2->fetch_assoc();
    $lokacijaID = $prviRed1["ID_Lokacija"];

    

    $upit2 = "SELECT zahtjev.ID_Zahtjev FROM servis JOIN zahtjev on servis.Zahtjev_ID = zahtjev.ID_Zahtjev WHERE servis.Lokacija_ID='$lokacijaID' AND zahtjev.Status='Odobren'";
    $rezultat3 = upit($upit2);
    $brojOdobrenihZahtjeva = mysqli_num_rows($rezultat3);

    $upit3 = "SELECT termin.Od, termin.Do FROM servis JOIN termin on servis.Termin_ID = termin.ID_Termin WHERE servis.Lokacija_ID='$lokacijaID' AND termin.Broj_Mjesta > '$brojOdobrenihZahtjeva'";
    $rezultat3 = upit($upit3);

    $array = array();
    
    if(mysqli_num_rows($rezultat3)>0) {
        $broj = 0;
        while($red = mysqli_fetch_array($rezultat3)) {
            $array[$broj] = $red;
            $broj = $broj+1;
        }
    }
    echo json_encode($array);
?>