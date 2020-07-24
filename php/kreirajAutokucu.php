<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Kreiraj Autokuću</title>
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
        <a class="active" href="autokuce.php">Autokuće</a>
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
                <input type="text" id="nazivAutokuce" name="nazivAutokuce" size="20" maxlength="50" placeholder="Naziv autokuce..." required="required"><br>
            </div>
            <br>
            <div class="divAlign"><br>
                <input list="generiraniModeratori" id="generiranimoderatori" name="generiranimoderatori" placeholder="Odaberite moderatore...">
                <select id="generiraniModeratori" name="generiraniModeratori[]" multiple>
                    <?php
                    require_once "baza.php";
                    $upit = "SELECT Korisnicko_Ime FROM korisnik WHERE Tip_Korisnika_ID='2'";
                    $rezultat = upit($upit);

                    if (mysqli_num_rows($rezultat) > 0) {
                        while ($red = mysqli_fetch_array($rezultat)) {
                            echo '<option value="' . $red["Korisnicko_Ime"] . '">' . $red["Korisnicko_Ime"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <br>
            </div>
            <div class="divAlign"><br>
                <div class="divAlignButton">
                    <button type="submit" id="kreirajAutokucu" name="kreirajAutokucu">Kreiraj Autokuću</button>
                </div><br>
            </div>
        </form>
        <?php
        require_once "baza.php";
        if ($_SESSION["Sesija_Tip"] == 1) {
            if (isset($_POST["kreirajAutokucu"])) {
                $vlasnik = $_SESSION["Sesija_KorisnickoIme"];

                $upit = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$vlasnik'";
                $rezultat = upit($upit);
                $rezultat = mysqli_fetch_assoc($rezultat);
                $korisnikID = $rezultat["ID_Korisnik"];
                $naziv = $_POST["nazivAutokuce"];

                $upit2 = "INSERT INTO autokuca(Naziv, Vlasnik_ID) VALUES('$naziv', '$korisnikID')";
                upit($upit2);
                $upit3 = "SELECT ID_Autokuca FROM autokuca WHERE Naziv='$naziv'";
                $rezultat2 = upit($upit3);
                $rezultat2 = $rezultat2->fetch_assoc();
                $autokucaID = $rezultat2["ID_Autokuca"];

                foreach ($_POST['generiraniModeratori'] as $moderatorKorime) {
                    $upit4 = "SELECT ID_Korisnik FROM korisnik WHERE Korisnicko_Ime='$moderatorKorime'";
                    $rezultat4 = upit($upit4);
                    $rezultat4 = mysqli_fetch_assoc($rezultat4);
                    $moderatorID = $rezultat4["ID_Korisnik"];

                    $upit5 = "INSERT INTO sudjeluje(Korisnik_ID, Autokuca_ID) VALUES('$moderatorID', '$autokucaID')";
                    upit($upit5);
                }
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