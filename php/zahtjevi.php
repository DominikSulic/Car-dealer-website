<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Zahtjevi</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Servisi">
    <meta name="description" content="Popis servisa">

    <link rel="stylesheet" type="text/css" href="../css/dsulic.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../javascript/dsulic_jquery.js"></script>
    <script type="text/javascript" src="../javascript/dsulic.js"></script>
</head>

<body>
    <div class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-home"></i> Index</a>
        <a href="autokuce.php">Autokuće</a>
        <a href='servisi.php'>Servisi</a>
        <a class="active" href='zahtjevi.php'>Zahtjevi</a>
        <a href="lokacije.php">Lokacije</a>
        <?php
        if ($_SESSION["Sesija_Tip"] == 1) {
            echo "<a href='dnevnik.php'>Dnevnik</a>";
        }
        ?>
        <div class="navbar-right">
            <?php
            if (isset($_SESSION["Sesija_KorisnickoIme"])) {
                echo "<a href='odjava.php'>Odjava</a>";
            } else {
                echo "<a href='registracija.php'>Registracija</a>
                    <a href='prijava.php'>Prijava</a>";
            }
            ?>
            <a style="width: 25px;" href="#bottom">&#x2193;</a>
        </div>
    </div>

    <div id="zahtjeviContent" class="contentDiv" style="width: 60%; margin-left:20%; margin-right: 20%;">
        <b style="font-size: 30px;">VAŠI SERVISI</b>
        <table id="zahtjeviTable" style="max-height: 100%; text-align: center; width:100%; border: 1px solid white;">
            <tr>
                <th>Naziv</th>
                <th>Opis</th>
                <th>Slika</th>
                <th>Status</th>
                <th>Datum servisa</th>
                <th>Od</th>
                <th>Do</th>
                <th>Adresa</th>
            </tr>
            <?php
            require_once "baza.php";
            $korisnickoIme = $_SESSION["Sesija_KorisnickoIme"];

            $upit = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korisnickoIme'";
            $rezultat = upit($upit);
            $rezultat = mysqli_fetch_assoc($rezultat);
            $korisnikID = $rezultat["ID_Korisnik"];

            $upit2 = "SELECT zahtjev.ID_Zahtjev, zahtjev.Naziv, zahtjev.Opis, zahtjev.Slika, zahtjev.Status, zahtjev.Premjesten, servis.Datum, termin.Od, termin.Do, lokacija.Adresa FROM zahtjev JOIN servis on zahtjev.ID_Zahtjev = servis.Zahtjev_ID JOIN termin ON servis.Termin_Id = termin.ID_Termin JOIN lokacija ON servis.Lokacija_ID = lokacija.ID_Lokacija AND zahtjev.Korisnik_ID = '$korisnikID'";
            $result = upit($upit2);
            $brojRedova = mysqli_num_rows($result);

            if ($brojRedova > 0) {
                while ($red = mysqli_fetch_array($result)) {
                    if ($red['Status'] == "Nije došao" || $red['Premjesten'] == 1) {
                        echo '<tr style="background-color: red;">';
                        echo '<td><a style="color:white;" href="zahtjevi.php?ZahtjevID=' . $red['ID_Zahtjev'] . '">' . $red['Naziv'] . '</td>';
                        echo '<td>' . $red['Opis'] . '</td>';
                        echo '<td><img style="width:100px; height:100px; alt="Ne postoji" src="data:image/jpeg;base64,' . base64_encode($red['Slika']) . '" /></td>';
                        echo '<td>' . $red['Status'] . '</td>';
                        echo '<td>' . $red['Datum'] . '</td>';
                        echo '<td>' . $red['Od'] . '</td>';
                        echo '<td>' . $red['Do'] . '</td>';
                        echo '<td>' . $red['Adresa'] . '</td>';
                        echo '<tr>';
                    } else {
                        echo '<tr>';
                        echo '<td><a style="color:white;" href="zahtjevi.php?ZahtjevID=' . $red['ID_Zahtjev'] . '">' . $red['Naziv'] . '</td>';
                        echo '<td>' . $red['Opis'] . '</td>';
                        echo '<td><img style="width:100px; height:100px; alt="Ne postoji" src="data:image/jpeg;base64,' . base64_encode($red['Slika']) . '" /></td>';
                        echo '<td>' . $red['Status'] . '</td>';
                        echo '<td>' . $red['Datum'] . '</td>';
                        echo '<td>' . $red['Od'] . '</td>';
                        echo '<td>' . $red['Do'] . '</td>';
                        echo '<td>' . $red['Adresa'] . '</td>';
                        echo '<tr>';
                    }
                }
            }


            ?>
        </table><br>

        <table id="evidencijaTable" style="max-height: 100%; text-align: center; width:100%; border: 1px solid white;">
            <tr>
                <th>Datum evidencije</th>
                <th>Napravljeno sve?</th>
                <th>Komentar</th>
            </tr>
            <?php
            require_once "baza.php";
            if (isset($_GET["ZahtjevID"])) {
                $zahtjevID = $_GET["ZahtjevID"];
                $korime = $_SESSION["Sesija_KorisnickoIme"];

                $upit = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korisnickoIme'";
                $rezultat = upit($upit);
                $rezultat = mysqli_fetch_assoc($rezultat);
                $korisnikID = $rezultat["ID_Korisnik"];

                $upit3 = "SELECT evidencija.Datum_Evidencije, evidencija.Sve_Napravljeno, evidencija.Komentar, zahtjev.Korisnik_Dosao FROM zahtjev JOIN servis ON zahtjev.ID_Zahtjev = servis.Zahtjev_ID JOIN evidencija ON servis.ID_Servis = evidencija.Servis_ID AND zahtjev.Korisnik_ID='$korisnikID' AND zahtjev.ID_Zahtjev = '$zahtjevID'";
                $rezultat2 = upit($upit3);
                $redovi = mysqli_num_rows($rezultat2);

                if ($redovi > 0) {
                    while ($red = mysqli_fetch_array($rezultat2)) {
                        if($red["Korisnik_Dosao"] == 1) {
                            echo '<tr>';
                            echo '<td>' . $red['Datum_Evidencije'] . '</td>';
                            echo '<td>' . $red['Sve_Napravljeno'] . '</td>';
                            echo '<td>' . $red['Komentar'] . '</td>';
                            echo '</tr>';
                        }
                        else {
                            echo '<form id="formaEvidentirajServis" method="post" name="formaEvidentirajServis" action="">
                            <button type="submit" id="evidentirajDolazak" name="evidentirajDolazak">Evidentiraj dolazak</button></form>';
                        }
                    }
                } else if ($redovi == 0) {
                    if ($_SESSION["Sesija_Tip"] == 1 || $_SESSION["Sesija_Tip"] == 2) {
                        echo 'Evidencija nije napravljena! Popunite donji formular kako biste evidentirali servis!';
                        echo '<br>';
                        echo '<form id="formaEvidencija" method="post" name="formaEvidencija" action="">';
                        echo '<button type="submit" id="evidentirajServis" name="evidentirajServis">Evidentiraj</button>';
                        echo '<tr>';
                        echo '<td><input type="date" id="datumEvidencije" name="datumEvidencije"></td>';
                        echo '<td><input type="text" id="napravljenoSve" name="napravljenoSve"></td>';
                        echo '<td><input type="text" id="komentar" name="komentar"></td>';
                        echo '</tr>';
                        echo '</form>';
                    }
                    else {
                        if($red["Korisnik_Dosao"] == 1) {
                            echo '<tr>';
                            echo '<td>' . $red['Datum_Evidencije'] . '</td>';
                            echo '<td>' . $red['Sve_Napravljeno'] . '</td>';
                            echo '<td>' . $red['Komentar'] . '</td>';
                            echo '</tr>';
                        }
                        else {
                            echo '<form id="formaEvidentirajServis" method="post" name="formaEvidentirajServis" action="">
                            <button type="submit" id="evidentirajDolazak" name="evidentirajDolazak">Evidentiraj dolazak</button></form>';
                        }
                    }
                }
                if (isset($_POST["evidentirajServis"])) {
                    $zahtjevID = $_GET["ZahtjevID"];
                    $datum = "";
                    $sve = "";
                    $komentar = "nema";
                    if (isset($_POST["datumEvidencije"])) $datum = $_POST["datumEvidencije"];
                    if (isset($_POST["napravljenoSve"])) $sve = $_POST["napravljenoSve"];
                    if (isset($_POST["komentar"])) $komentar = $_POST["komentar"];

                    $korisnickoIme = $_SESSION["Sesija_KorisnickoIme"];

                    $upit4 = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korisnickoIme'";
                    $rezultat4 = upit($upit);
                    $rezultat4 = mysqli_fetch_assoc($rezultat4);
                    $korisnikID = $rezultat4["ID_Korisnik"];

                    $upit5 = "SELECT ID_Servis FROM servis JOIN zahtjev ON servis.Zahtjev_ID = zahtjev.ID_Zahtjev AND zahtjev.Korisnik_ID = '$korisnikID'";
                    $rezultat5 = upit($upit5);
                    $rezultat5 = $rezultat5->fetch_assoc();
                    $servisID = $rezultat5["ID_Servis"];

                    $upit6 = "INSERT INTO evidencija(Datum_Evidencije, Sve_Napravljeno, Komentar, Servis_ID) VALUES('$datum', '$sve', '$komentar', '$servisID')";
                    upit($upit6);

                    $upit7 = "UPDATE zahtjev SET Status='Završen' WHERE ID_Zahtjev='$zahtjevID'";
                    update($upit7);
                }
                if(isset($_POST["evidentirajDolazak"])) {
                    $zahtjevID = $_GET["ZahtjevID"];
                    $korisnickoIme = $_SESSION["Sesija_KorisnickoIme"];

                    $upit = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korisnickoIme'";
                    $rezultat = upit($upit);
                    $rezultat = mysqli_fetch_assoc($rezultat);
                    $korisnikID = $rezultat["ID_Korisnik"];

                    $upit2 = "UPDATE zahtjev SET Korisnik_Dosao='1' WHERE ID_Zahtjev='$zahtjevID' AND Korisnik_ID='$korisnikID'";
                    $rezultat2 = update($upit2);
                    if($rezultat == true) {
                        echo 'uspjesno evidentiranje dolaska';
                    }
                    else {
                        echo  'evidentiranje dolaska nije uspjelo!';
                    }
                }
            }
            ?>
        </table><br>
        <?php
        require_once "baza.php";
        if ($_SESSION["Sesija_Tip"] == 1 || $_SESSION["Sesija_Tip"] == 2) {
            echo '
                <b style="font-size:30px;"> PREGLED SVIH ZAHTJEVA</b>
                <form id="formaOZahtjev" method="post" name="formaOZahtjev" action="">
                    <button type="submit" id="odobriZahtjev" name="odobriZahtjev">Odobri Zahtjev</button>
                    <button type="submit" id="odbijZahtjev" name="odbijZahtjev">Odbij Zahtjev</button>
                    <button type="submit" id="prikaziZavrsene" name="prikaziZavrsene">Prikaži završene koji nisu evidentirani</button>
                    <button type="submit" id="premjestiKorisnika" name="premjestiKorisnika">Premjesti odabranog korisnika</button>';
            echo '
                    </form>
                    <table id="modZahtjeviTable" style="max-height: 100%; text-align: center; width:100%; border: 1px solid white;">
                    <tr>
                        <th>Naziv</th>
                        <th>Tip_Servisa</th>
                        <th>Datum</th>
                        <th>Opis</th>
                        <th>Slika</th>
                        <th>Status</th>
                        <th>Korisnik</th>
                    </tr>';

        if(isset($_POST["premjestiKorisnika"])) {
            if(isset($_GET["Zahtjev"])) {
                $zahtjevId = $_GET["Zahtjev"];
                header("Location: premjestiKorisnika.php?location=".urlencode($_SERVER['HTTP_REFERER']));
            }
        }
        if (isset($_POST["prikaziZavrsene"])) {
            $upit = "SELECT * FROM zahtjev JOIN servis ON zahtjev.ID_Zahtjev = servis.Zahtjev_ID JOIN evidencija ON servis.ID_Servis = evidencija.Servis_ID AND zahtjev.Status='Završen' AND zahtjev.Korisnik_Dosao='0'";
            $rezultat = upit($upit);

            if (mysqli_num_rows($rezultat) > 0) {
                while ($red = mysqli_fetch_array($rezultat)) {
                    echo '<tr>';
                    echo '<td><a style="color:white;" href="evidentirajServise.php?Zahtjev=' . $red['ID_Zahtjev'] . '&Korisnik_ID=' . $red['Korisnik_ID']. '">' . $red['Naziv'] . '</td>';
                    echo '<td>' . $red['Tip_Servisa'] . '</td>';
                    echo '<td>' . $red['Datum'] . '</td>';
                    echo '<td>' . $red['Opis'] . '</td>';
                    echo '<td><img style="width:100px; height:100px; alt="Ne postoji" src="data:image/jpeg;base64,' . base64_encode($red['Slika']) . '" /></td>';
                    echo '<td>' . $red['Status'] . '</td>';
                    echo '<td>' . $red['Korisnik_ID'] . '</td>';
                    echo '</tr>';
                }
            }
            echo '</table>';
        } else {

            $upit = "SELECT * FROM zahtjev WHERE Status='Poslan'";
            $rezultat = upit($upit);

            if (mysqli_num_rows($rezultat) > 0) {
                while ($red = mysqli_fetch_array($rezultat)) {
                    echo '<tr>';
                    echo '<td><a style="color:white;" href="zahtjevi.php?Zahtjev=' . $red['ID_Zahtjev'] . '">' . $red['Naziv'] . '</td>';
                    echo '<td>' . $red['Tip_Servisa'] . '</td>';
                    echo '<td>' . $red['Datum'] . '</td>';
                    echo '<td>' . $red['Opis'] . '</td>';
                    echo '<td><img style="width:100px; height:100px; alt="Ne postoji" src="data:image/jpeg;base64,' . base64_encode($red['Slika']) . '" /></td>';
                    echo '<td>' . $red['Status'] . '</td>';
                    echo '<td>' . $red['Korisnik_ID'] . '</td>';
                    echo '</tr>';
                }
            }
            echo '</table>';

            if (isset($_GET["Zahtjev"])) {
                $zahtjev = $_GET["Zahtjev"];

                if (isset($_POST["odobriZahtjev"])) {
                    $upit = "UPDATE zahtjev SET Status='Odobren' WHERE ID_Zahtjev='$zahtjev'";
                    $rezultat = update($upit);
                    if ($rezultat == true) {
                        echo 'uspjesno ste odobrili zahtjev!';
                    } else {
                        echo 'Zahtjev se nije odobrio';
                    }
                } else if (isset($_POST["odbijZahtjev"])) {
                    $upit = "UPDATE zahtjev SET Status='Odbijen' WHERE ID_Zahtjev='$zahtjev'";
                    $rezultat = update($upit);
                    if ($rezultat == true) {
                        echo 'uspjesno ste odbili zahtjev!';
                    } else {
                        echo 'Zahtjev se nije odbio';
                    }
                }
            }
        }
        }
        ?>
    </div>
    </div>
    <img class="BGimg" src="../multimedija/bgBMW.jpg" alt="" />
    1<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    1


    <footer>

        <div id="bottom" class="navbar">
            <a href="../o_autoru.html">O autoru</a>
            <a href="../dokumentacija.html">Dokumentacija</a>
            <div class="navbar-right">
                <a style="width: 25px;" href="#top">&#x2191;</a>
            </div>
        </div>
    </footer>
</body>

</html>