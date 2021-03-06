<?php
session_start();

if (!isset($_SESSION["Sesija_KorisnickoIme"])) {
    header('Location: prijava.php');
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Kreiraj Lokaciju</title>
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
        <a class="active" href="lokacije.php">Lokacije</a>
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
                <input type="text" id="adresaLokacije" name="adresaLokacije" size="20" maxlength="50" placeholder="Adresa lokacije..." required="required"><br>
            </div>
            <br>
            <div class="divAlign"><br>
                <input type="text" id="kontaktLokacije" name="kontaktLokacije" size="20" maxlength="50" placeholder="Kontakt lokacije..." required="required"><br>
            </div>
            <br>
            <div class="divAlign"><br>
                <input type="email" id="mailLokacije" name="mailLokacije" size="20" maxlength="50" placeholder="Mail..." required="required"><br>
            </div>
            <div class="divAlign"><br>
                <input type="time" id="vrijemeLokacijeO" name="vrijemeLokacijeO" size="20" maxlength="50" placeholder="Radno vrijeme od..." required="required"><br>
            </div>
            <div class="divAlign"><br>
                <input type="time" id="vrijemeLokacijeD" name="vrijemeLokacijeD" size="20" maxlength="50" placeholder="Radno vrijeme do..." required="required"><br>
            </div>
            <br>
            <div class="divAlign"><br>
                <input list="generiraneAutokuceKL" id="generiraneautokuceKL" name="generiraneautokuceKL" placeholder="Odaberite autokucu...">
                <select id="generiraneAutokuceKL" name="generiraneAutokuceKL">
                    <?php
                    require_once "baza.php";
                    $upit = "SELECT Naziv FROM autokuca";
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
                    <button type="submit" id="kreirajAutokucu" name="kreirajAutokucu">Kreiraj Lokaciju</button>
                </div><br>
            </div>
        </form>
       <?php
            require_once "baza.php";

            if(isset($_POST["kreirajAutokucu"])) {
                $adresa = $_POST["adresaLokacije"];
                $kontakt = $_POST["kontaktLokacije"];
                $mail = $_POST["mailLokacije"];
                $od = $_POST["vrijemeLokacijeO"];
                $do = $_POST["vrijemeLokacijeD"];
                $autokuca = $_POST["generiraneAutokuceKL"];

                $upit = "SELECT ID_Autokuca FROM autokuca WHERE Naziv='$autokuca'";
                $rezultat = upit($upit);
                $rezultat = $rezultat->fetch_assoc();
                $idAutokuca = $rezultat["ID_Autokuca"];

                $upit2 = "INSERT INTO lokacija(Adresa, Kontakt_Broj, Mail, Radno_Vrijeme_Od, Radno_Vrijeme_Do, Autokuca_ID) VALUES('$adresa', '$kontakt', '$mail', '$od', '$do', '$idAutokuca')";
                upit($upit2);
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