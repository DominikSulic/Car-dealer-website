<?php
    require_once "baza.php";

    $autokucaNaziv = $_POST['autokuca'];
    $upit = "SELECT ID_Autokuca FROM autokuca WHERE Naziv='$autokucaNaziv'";
    $rezultat = upit($upit);
    $prviRed = $rezultat->fetch_assoc();

    $vratiID = $prviRed["ID_Autokuca"];

    $upit1 = "SELECT DISTINCT Adresa FROM lokacija WHERE Autokuca_ID='$vratiID'";
    $rezultat2 = upit($upit1);
    $polje = array();
    
    if(mysqli_num_rows($rezultat2) > 0) {
        $broj = 0;
        while($red = mysqli_fetch_array($rezultat2)) {
            $polje[$broj] = $red;
            $broj = $broj + 1;
        }
        echo json_encode($polje);
    }

?>