<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Premjesti korisnika</title>
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
        <a  class="active" href='zahtjevi.php'>Zahtjevi</a>
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

            <div class="divAlign"><b>Postavi novi status korisničkog zahtjeva(opcionalno)</b><br><br>
                <select name="korisnikStatus">
                    <option value="Poslan">Poslan</option>
                    <option value="Odobren">Odobren</option>
                    <option value="Odbijen">Odbijen</option>
                    <option value="Nije došao">Nije došao</option>
                    <option value="Završen">Završen</option>
                </select><br><br>
                <button type="submit" id="postaviStatus" name="postaviStatus">Postavi novi status korisnika</button><br><br>
                    <hr>
            </div>
            <br>
            <br>
            <div class="divAlign"><b>Premjesti korisnika na drugu lokaciju(opcionalno)</b><br><br>
                <select id="generiraneLokacijePK" name="generiraneLokacijePK">
                <?php
                echo '<option value=""></option>';
                    require_once "baza.php";
                    $upit = "SELECT Adresa FROM lokacija";
                    $rezultat = upit($upit);

                    if (mysqli_num_rows($rezultat) > 0) {
                        while ($red = mysqli_fetch_array($rezultat)) {
                            echo '<option value="' . $red["Adresa"] . '">' . $red["Adresa"] . '</option>';
                        }
                    }
                    ?>
                     </select>
            </div>
            <br>
            <br>
            <div class="divAlign"><b>Premjesti korisnika u drugi termin(opcionalno)</button><br><br>
                <select id="generiraniTerminiPK" name="generiraniTerminiPK">
                    <?php
                    echo '<option value=""></option>';
                    require_once "baza.php";
                    $upit = "SELECT Naziv FROM termin";
                    $rezultat = upit($upit);

                    if (mysqli_num_rows($rezultat) > 0) {
                        while ($red = mysqli_fetch_array($rezultat)) {
                            echo '<option value="' . $red["Naziv"] . '">' . $red["Naziv"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <br>
            </div>
            <div class="divAlign"><br>
                <div class="divAlignButton">
                    <button type="submit" id="premjestiKorisnika" name="premjestiKorisnika">Premjesti korisnika</button>
                </div><br>
            </div>
        </form>
       <?php
            require_once "baza.php";

            if(isset($_POST["postaviStatus"])) {
                $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $var = $_SERVER['REQUEST_URI'];
                urldecode($url);
                $id = substr($url, -2);
                $statusZahtjeva = $_POST["korisnikStatus"];


                $upit = "UPDATE Zahtjev SET Status='$statusZahtjeva' WHERE ID_Zahtjev='$id'";
                update($upit);
            }

            if(isset($_POST["premjestiKorisnika"])) {
                if($_POST["generiraneLokacijePK"] != "" && $_POST["generiraniTerminiPK"] != "") {
                    $lokacija = $_POST["generiraneLokacijePK"];
                    $termin = $_POST["generiraniTerminiPK"];
                    $upit1 = "SELECT ID_Lokacija FROM lokacija WHERE Adresa='$lokacija'";
                    
                }
                else if($_POST["generiraneLokacijePK"] != "" ) {

                }
                else if($_POST["generiraniTerminiPK"] != "" ) {

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