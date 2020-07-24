<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Prijava</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Prijava, login">
    <meta name="description" content="Stranica za prijavu">

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
        <?php
        if (isset($_SESSION["Sesija_KorisnickoIme"]) && isset($_SESSION["Sesija_Tip"])) {
            if ($_SESSION["Sesija_Tip"] == 1 || $_SESSION["Sesija_Tip"] == 2 || $_SESSION["Sesija_Tip"] == 3) {
                echo "<a href='servisi.php'>Servisi</a>";
            }
        }
        ?>
        <a href="lokacije.php">Lokacije</a>
        <?php
        if (isset($_SESSION["Sesija_KorisnickoIme"]) && isset($_SESSION["Sesija_Tip"])) {
            if ($_SESSION["Sesija_Tip"] == 1) {
                echo "<a href='dnevnik.php'>Dnevnik</a>";
            }
        }
        ?>
        <div class="navbar-right">
            <a href="registracija.php">Registracija</a>
            <a class="active" href="prijava.php">Prijava</a>
            <a style="width: 25px;" href="#bottom">&#x2193;</a>
        </div>
    </div>

    <div class="contentDiv" style="width: 25%; margin-left: 37.5%; margin-top: 10%;">
        <form id="formaPrijava" method="post" name="formaPrijava" action="prijava.php"><br>
            <div class="divAlign">
                <?php
                if(isset($_POST["korisnickoIme"])) {
                    if ($_COOKIE["Korisnik"] != $_POST["korisnickoIme"]) {
                        echo "<input type='text' id='korisnickoIme' value='' name='korisnickoIme' maxlength='50' placeholder='Korisničko ime' required='required'/>";
                    }
                    else {
                        $ime = $_COOKIE["Korisnik"];
                        echo "<input type='text' id='korisnickoIme' value='$ime' name='korisnickoIme' maxlength='50' placeholder='Korisničko ime' required='required'><br>";
                    }
                }
                else {
                    if(isset($_COOKIE["Korisnik"])) {
                        $ime = $_COOKIE["Korisnik"];
                        echo "<input type='text' id='korisnickoIme' value='$ime' name='korisnickoIme' maxlength='50' placeholder='Korisničko ime' required='required'><br>";
                    }
                    else {
                        echo "<input type='text' id='korisnickoIme' value='' name='korisnickoIme' maxlength='50' placeholder='Korisničko ime' required='required'/>";
                    }
                   
                }
                ?>
            </div>

            <div class="divAlign"><br>
                <input type="password" id="lozinka" name="lozinka" placeholder="Lozinka" required="required"><br>
            </div>
            <br>
           
            <div class="divAlign">
                <img onload="prijavaHover()" id="prijavaSlika" style="width: 80%; height: 65px;" src="../multimedija/prijava.png" />
            </div>
            <div class="divAlign"><br>
                <a style="color:white;" href="zaboravljenaLozinka.php">Zaboravljena lozinka?</a>
            </div>
            <br>
        </form>
        <?php
        require_once "baza.php";

        if (isset($_POST["korisnickoIme"]) && isset($_POST["lozinka"])) {

            $korIme = $_POST['korisnickoIme'];
            $lozinka = $_POST['lozinka'];
            $upit = "SELECT * FROM korisnik WHERE Korisnicko_Ime='$korIme' AND Lozinka='$lozinka'";
            $rezultat = upit($upit);

            if (mysqli_num_rows($rezultat) == 1) {
                $prviRed = $rezultat->fetch_assoc();
                if ($prviRed["Zakljucan"] == 1 || $prviRed["Aktiviran"] == 0) {
                    echo "<script language='javascript'>";
                    echo "alert('Vaš korisnički račun je zaključan ili ga niste aktivirali! Molimo vas kontaktirajte administratora u slučaju da ste već aktivirali račun!')";
                    echo "</script>";
                } else {
                    $upit = "UPDATE korisnik SET Neuspjesni_Pokusaji=0 WHERE Korisnicko_Ime='$korIme'";
                    upit($upit);
                    $_SESSION["Sesija_KorisnickoIme"] = $prviRed["Korisnicko_Ime"];
                    $_SESSION["Sesija_Tip"] = $prviRed["Tip_Korisnika_ID"];
                    $Cookie_Ime = "Korisnik";
                    $Cookie_Vrijednost = $prviRed["Korisnicko_Ime"];
                    setcookie($Cookie_Ime, $Cookie_Vrijednost, time() + (86400 * 30), "/"); // 86400 = 1 day
                    header('Location: index.php');
                }
            } else {
                $upit = "SELECT * FROM korisnik WHERE Korisnicko_Ime='$korIme'";
                $dohvaceno = upit($upit);
                $red = $dohvaceno->fetch_assoc();
                $ime = $red["Korisnicko_Ime"];
                if ($red["Neuspjesni_Pokusaji"] == 3) {
                    $upit = "UPDATE korisnik SET Zakljucan=1 WHERE Korisnicko_Ime='$ime'";
                    upit($upit);
                    $upit = "UPDATE korisnik SET Neuspjesni_Pokusaji=Neuspjesni_Pokusaji+1 WHERE Korisnicko_Ime='$ime'";
                    upit($upit);
                } else {
                    $upit = "UPDATE korisnik SET Neuspjesni_Pokusaji=Neuspjesni_Pokusaji+1 WHERE Korisnicko_Ime='$ime'";
                    upit($upit);
                    $upit = "SELECT * FROM korisnik WHERE Korisnicko_Ime='$ime'";
                    $pokusaji = upit($upit);
                    $red = $pokusaji->fetch_assoc();
                    if($red["Neuspjesni_Pokusaji"] == 3) {
                        $upit = "UPDATE korisnik SET Zakljucan=1 WHERE Korisnicko_Ime='$ime'";
                        upit($upit);
                    }
                    echo "<script language='javascript'>";
                    echo "alert('Pogrešno korisničko ime ili lozinka!')";
                    echo "</script>";  
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