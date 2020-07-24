<?php
    require_once "baza.php";

    $upit = "SELECT lokacija.Adresa, lokacija.Kontakt_Broj, lokacija.Mail, lokacija.Radno_Vrijeme_Od, lokacija.Radno_Vrijeme_Do, autokuca.Naziv FROM lokacija JOIN autokuca on lokacija.Autokuca_ID = autokuca.ID_Autokuca";
    $rezultat = upit($upit);
    $vrati = "";
    $array = array();

    if(mysqli_num_rows($rezultat) > 0) {
        $broj = 0;
        while($red = mysqli_fetch_array($rezultat)) {
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