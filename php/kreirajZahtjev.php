<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>

<?php
require_once "baza.php";
    if(isset($_FILES["fileToUpload"])) {

    
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
        <form id="formaZahtjev" method="post" name="formaRegistracija" action="" enctype="multipart/form-data">
            <div class="divAlign"><br>
                <input type="text" id="nazivServisa" name="nazivServisa" size="20" maxlength="50" placeholder="Naziv servisa..." autofocus="autofocus" required="required"><br>
            </div>
            <div class="divAlign"><br>
                <input list="generiraneAutokuce" id="generiraneautokuce" name="generiraneautokuce" placeholder="Odaberite autokuću...">
                <select id="generiraneAutokuce" name="generiraneAutokuce"></select><br>
            </div>
            <div class="divAlign"><br>
                <input list="generiraneLokacije" id="generiranelokacije" name="generiranelokacije" placeholder="Odaberite lokaciju...">
                <select id="generiraneLokacije" name="generiraneLokacije"></select><br>
            </div>
            <div class="divAlign"><br>
                <input list="generiraniTermini" id="generiranitermini" name="generiranitermini" placeholder="Odaberite termin...">
                <select id="generiraniTermini" name="generiraniTermini"></select><br>
            </div>
            <div class="divAlign"><br>
                <input type="text" id="tipServisa" name="tipServisa" size="20" maxlength="50" placeholder="Tip servisa(redovni/izvanredni)" required="required"><br>
            </div>
            <br>

            <div class="divAlign">
                <input type="text" id="opis" name="opis" size="20" maxlength="50" placeholder="Opis" required="required"><br>
            </div>
            <br>
            Odaberite sliku za upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <div class="divAlignButton">
                <img onload="zahtjevHover()" id="zahtjevSlika" style="width: 80%;" src="../multimedija/zahtjev.png" />
            </div><br>
        </form>




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