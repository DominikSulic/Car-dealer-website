<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>

<?php
require_once "baza.php";
if (isset($_FILES["fileToUpload"])) {


    $file = addslashes(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));

    $naziv = $_POST["nazivServisa"];
    $tipServisa = $_POST["tipServisa"];
    $opis = $_POST["opis"];
    $status = "Poslan";
    date_default_timezone_set('Europe/Zagreb');
    $trenutnoVrijeme = date('Y-m-d H:i:s');
    $korime = $_SESSION["Sesija_KorisnickoIme"];
    $upit2 = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$korime'";
    $rezultat = upit($upit2);
    $rezultat = $rezultat->fetch_assoc();
    $korisnikID = $rezultat["ID_Korisnik"];

    $upit = "INSERT INTO zahtjev(Naziv, Tip_Servisa, Datum, Opis, Slika, Status, Korisnik_ID) VALUES('$naziv', '$tipServisa', '$trenutnoVrijeme', '$opis', '$file', '$status', '$korisnikID')";
    upit($upit);

    echo $upit;
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Kreiraj Zahtjev</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Servisi">
    <meta name="description" content="Popis servisa">

    <link rel="stylesheet" type="text/css" href="../css/dsulic.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../javascript/dsulic_jquery2.js"></script>
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



    <div class="contentDiv" style="width: 25%; margin-left: 37.5%; margin-top: 7%;">
        <?php
        require_once "baza.php";
        echo '<form id="formaEvidentirajServis" method="post" name="formaEvidentirajServis" action="">
        <div class="divAlign">
        <input type="date" id="datumEvidencije" name="datumEvidencije" size="20" maxlength="50" placeholder="Datum" required="required"><br>
        </div>
        <br>
        <div class="divAlign">
        <input type="text" id="sveNapravljeno" name="sveNapravljeno" placeholder="Napravljeno sve?" required="required"><br>
        </div><br>
        <div class="divAlign">
        <input type="text" id="komentar" name="komentar" placeholder="Komentar..." required="required"><br>
        </div><br>
        <div class="divAlign">
        <button type="submit" id="evidentirajServis" name="evidentirajServis">Evidentiraj servis</button>
        </div>
        </form>';

        if (isset($_GET["Zahtjev"])) {
            $zahtjev = $_GET["Zahtjev"];
            $korisnik = $_GET["Korisnik_ID"];
            if (isset($_POST["evidentirajServis"])) {
                $datum = $_POST["datumEvidencije"];
                $sve = $_POST["sveNapravljeno"];
                $komentar = $_POST["komentar"];
                echo 'tu';

                $upit = "SELECT servis.ID_Servis FROM zahtjev JOIN servis ON zahtjev.ID_Zahtjev = servis.Zahtjev_ID AND zahtjev.Korisnik_ID = '$korisnik'";
                $rezultat = upit($upit);
                $rezultat = $rezultat->fetch_assoc();
                $ServisID = $rezultat["ID_Servis"];

                $upit2 = "INSERT INTO evidencija(Datum_Evidencije, Sve_Napravljeno, Komentar, Servis_ID) VALUES('$datum', '$sve', '$komentar', '$ServisID')";
                upit($upit2);
            }
        }

        ?>
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