<?php
    require_once "baza.php";

    $upit = "SELECT Naziv FROM autokuca";
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