<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Kreiraj Termin</title>
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
        <a href='zahtjevi.php'>Zahtjevi</a>
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
        <form id="formaTermin" method="post" name="formaTermin" action="" enctype="multipart/form-data">
            <div class="divAlign"><br>
                <input list="generiraneLokacijeKT" id="generiranelokacijeKT" name="generiranelokacijeKT" placeholder="Odaberite lokaciju...">
                <select id="generiraneLokacijeKT" name="generiraneLokacijeKT">
                <?php
                    require_once "baza.php";
                    $upit = "SELECT Adresa FROM lokacija";
                    $rezultat = upit($upit);
                    
                    if(mysqli_num_rows($rezultat) > 0) {
                        while($red = mysqli_fetch_array($rezultat)) {
                            echo '<option value="' . $red["Adresa"] . '">' . $red["Adresa"] . '</option>';
                        }
                    }
                ?>
                </select>
                    <br>
            </div>
            <div class="divAlign"><br>
                <input type="text" id="nazivTermina" name="nazivTermina" size="20" maxlength="50" placeholder="Naziv termina..." required="required"><br>
            </div>
            <br>
            Vrijeme početka
            <div class="divAlign">
                <input type="time" id="vrijemePoc" name="vrijemePoc" size="20" maxlength="50" placeholder="Broj mjesta...." required="required"><br>
            </div>
            Vrijeme završetka
            <div class="divAlign">
                <input type="time" id="vrijemeZav" name="vrijemeZav" size="20" maxlength="50" placeholder="Broj mjesta...." required="required"><br>
            </div>
            <br>
            <div class="divAlign">
                <input type="number" id="brojMjesta" name="brojMjesta" placeholder="Broj mjesta...." required="required"><br>
            </div>
            <br>
            <div class="divAlignButton">
                <img onload="zahtjevHover()" id="terminSlika" name="terminSlika" style="width: 80%;" src="../multimedija/zahtjev.png" />
            </div><br>
        </form>
        <?php
            if(isset($_POST["vrijemePoc"]) && isset($_POST["vrijemeZav"])) {
            
                $lokacija = $_POST["generiraneLokacijeKT"];
                $naziv = $_POST["nazivTermina"];
                $vrijemePoc = $_POST["vrijemePoc"];
                $vrijemeZav = $_POST["vrijemeZav"];
                $brojMjesta = $_POST["brojMjesta"];

                $upit = "INSERT INTO termin(Naziv, Broj_Mjesta, Od, Do) VALUES('$naziv', '$brojMjesta', '$vrijemePoc', '$vrijemeZav')";
                upit($upit);
                $upit1 = "SELECT ID_Termin FROM termin WHERE Naziv='$naziv' AND Broj_Mjesta='$brojMjesta' AND Od='$vrijemePoc' AND Do='$vrijemeZav'";
                $rezultat1 = upit($upit1);
                $rezultat1 = $rezultat1->fetch_assoc();
                $idTermin = $rezultat1["ID_Termin"];

                $upit2 = "SELECT ID_Lokacija FROM lokacija WHERE Adresa = '$lokacija'";
                $rezultat2 = upit($upit2);
                $rezultat2 = $rezultat2->fetch_assoc();
                $idLokacija = $rezultat2["ID_Lokacija"];

                $upit3 = "INSERT INTO termini_lokacija(Termin_ID, Lokacija_ID) VALUES('$idTermin', '$idLokacija')";
                upit($upit3);

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