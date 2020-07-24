<?php
    require_once "baza.php";

    $naziv = $_POST['mjesto'];
    $upit = "SELECT Adresa, Kontakt_Broj, Mail, Radno_Vrijeme_Od, Radno_Vrijeme_Do FROM lokacija WHERE Adresa LIKE '%$naziv%'";
    $rezultat = upit($upit);
    $polje = array();

    if(mysqli_num_rows($rezultat) > 0) {
        $broj = 0;
        while($red = mysqli_fetch_array($rezultat)) {
            $polje[$broj] = $red;
            $broj = $broj + 1;
        }
    }
    echo json_encode($polje);

?>