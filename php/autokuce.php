<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Autokuće</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Autokuće">
    <meta name="description" content="Pregled autokuća">

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
        <a class="active" href="autokuce.php">Autokuće</a>
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

    <div id="autokuceContent" class="contentDiv" style="width: 60%; margin-left:20%; margin-right: 20%;">
        <button id="autokuceButton">učitaj Autokuće</button>
        <button id="prvihDesetA"><<</button>
        <button id="proslihDesetA"><</button>
        <button id="sljedecihDesetA">></button>
        <button id="zadnjihDesetA">>></button>
        <button id="sortirajNazivA">Sortiraj po nazivu</button>
        <?php
         if(isset($_SESSION["Sesija_Tip"])) {
            if($_SESSION["Sesija_Tip"] == 1) {
                echo "<a href='kreirajAutokucu.php'><button>Kreiraj Autokuću</button></a>";
            }
        }
        ?>
        <div style="float:right;" id="ispisStraniceA"></div>
        <table id="autokuceTable" style="max-height: 100%; text-align: center; width:100%; border: 1px solid white;">
        <tr>
            <th>Naziv</th>
            <th>Vlasnik</th>
        </tr>
        </table>
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