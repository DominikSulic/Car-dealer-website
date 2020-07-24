<?php
    session_start();
    
	if(!isset($_SESSION["Sesija_KorisnickoIme"])) {
		header('Location: prijava.php');
    }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
	<title>Servisi</title>
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
        <a class="active" href='servisi.php'>Servisi</a>
        <a href="lokacije.php">Lokacije</a>
        <?php
            if(isset($_SESSION["Sesija_KorisnickoIme"])) {

                if($_SESSION["Sesija_Tip"] == 1) {
                    echo "<a href='zahtjevi.php'>Zahtjevi</a>";
                    echo "<a href='dnevnik.php'>Dnevnik</a>";
                }
                else if ($_SESSION["Sesija_Tip"] == 2 || $_SESSION["Sesija_Tip"] == 3) {
                    echo "<a href='zahtjevi.php'>Zahtjevi</a>";
                }
            }
            
        ?>
        <div class="navbar-right">
            <?php
                if(isset($_SESSION["Sesija_KorisnickoIme"])) {
                    echo "<a href='odjava.php'>Odjava</a>";
                }
                else {
                    echo "<a href='registracija.php'>Registracija</a>
                    <a href='prijava.php'>Prijava</a>";
                }
            ?>
            <a style="width: 25px;" href="#bottom">&#x2193;</a>
        </div>
    </div>
    <div id="servisiContent" class="contentDiv" style="width: 60%; margin-left:20%; margin-right: 20%;">
        <button id="servisiButton">učitaj Servise</button>
        <button id="prvihDesetS"><<</button>
        <button id="proslihDesetS"><</button>
        <button id="sljedecihDesetS">></button>
        <button id="zadnjihDesetS">>></button>
        <button id="sortirajNazivS">Sortiraj po datumu</button>
        <a href="kreirajZahtjev.php"><button id="kreirajZahtjev" >Kreiraj zahtjev za servis</button></a>
        <?php
        if($_SESSION["Sesija_Tip"] == 2 || $_SESSION["Sesija_Tip"] == 1) {
            echo '<a href="kreirajTermin.php"><button>Kreiraj Termin</button></a>';
            echo '<a href="evidentirajServise.php"><button>Evidentiraj servis</button></a>';
        }
        ?>
        <div style="float:right;" id="ispisStraniceS"></div>
        <table id="servisiTable" style="max-height: 100%; text-align: center; width:100%; border: 1px solid white;">
        <tr>
            <th>Datum</th>
            <th>Cijena(kn)</th>
            <th>Status</th>
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