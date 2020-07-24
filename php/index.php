<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Index</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Index, Homepage">
    <meta name="description" content="Početna stranica">

    <link rel="stylesheet" type="text/css" href="../css/dsulic.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="../javascript/dsulic.js"></script>
</head>

<body onload="on()">

<?php  require("kolacic.php") ?>

    <div class="navbar">
        <a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Index</a>
        <a href="autokuce.php">Autokuće</a>
        <?php
        if (isset($_SESSION["Sesija_KorisnickoIme"])) {
            if ($_SESSION["Sesija_Tip"] == 1 || $_SESSION["Sesija_Tip"] == 2 || $_SESSION["Sesija_Tip"] == 3) {
                echo "<a href='servisi.php'>Servisi</a>";
                echo "<a href='zahtjevi.php'>Zahtjevi</a>";
            }
        }
        ?>
        <a href="lokacije.php">Lokacije</a>
        <?php
        if (isset($_SESSION["Sesija_KorisnickoIme"])) {
            if ($_SESSION["Sesija_Tip"] == 1) {
                echo "<a href='dnevnik.php'>Dnevnik</a>";
                echo "<a href='korisnici.php'>Korisnici</a>";
            }
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

    <div class="contentDiv">
        sdasdasdasdasdasdasdasd<br>
        dfgdfgdfg
        dfgdfgdfggd
        fgetcdfg
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