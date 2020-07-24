<?php
session_start();
?>


<?php
require_once "baza.php";

if (isset($_GET["kod"])) {
    $kod = $_GET["kod"];
    $upit = "SELECT * FROM korisnik WHERE Aktivacijski_Kod='$kod'";
    $aktivacija = upit($upit);
    $aktivacija = $aktivacija->fetch_assoc();
    $vrijeme = $aktivacija["Istek_Koda"];
    date_default_timezone_set('Europe/Zagreb');
    $sad = date('Y-m-d H:i:s');
    if ($sad > $vrijeme) {
        echo "<script language='javascript'>";
        echo "alert('Link za aktivaciju je istekao!')";
        echo "</script>";
    } else {
        $upit2 = "UPDATE korisnik SET Aktiviran=1 WHERE Aktivacijski_Kod='$kod'";
        upit($upit2);
        echo "<script language='javascript'>";
        echo "alert('Vaš korisnički račun je aktiviran!')";
        echo "</script>";
    }
}
?>


<?php
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

    $kljuc = '6LehIagUAAAAAF-fBv2Dl9yCx3l7xFgEBVHvZrFk';
    $odgovor = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $kljuc . '&response=' . $_POST['g-recaptcha-response']);
    $odgovorPodaci = json_decode($odgovor);

    if ($odgovorPodaci->success) {
        $poruka = 'Uspjeh';
    } 
    else {
        $poruka = 'Potvrda nije uspjela.';
    } 
}   
else {
    $poruka = 'Please click on the reCAPTCHA box.';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $imeGreska = $prezimeGreska = $mailGreska = $datumGreska = $korImeGreska = $lozinkaGreska = "";
    $ime = $prezime = $mail = $datum = $korIme = $lozinka = "";

    if (empty($_POST["ime"])) {
        $imeGreska = "Niste upisali vaše ime!";
    } else {
        $ime = testiraj($_POST["ime"]);
    }

    if (empty($_POST["prezime"])) {
        $prezimeGreska = "Niste upisali vaše prezime!";
    } else {
        $prezime = testiraj($_POST["prezime"]);
    }

    if (empty($_POST["eMail"])) {
        $mailGreska = "Niste upisali vaš mail!";
    } else {
        $mail = testiraj($_POST["eMail"]);
        // check if e-mail address is well-formed
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mailGreska = "Vaš mail nije valjanog formata!";
        }
    }

    if (empty($_POST["datum"])) {
        $datumGreska = "Niste odabrali datum rođenja!";
    } else {
        if ((date('Y-m-d H:i:s') - $_POST["datum"]) < 18) {
            $datumGreska = "Maloljetnicima registracija nije dopuštena!";
        }
    }

    if (empty($_POST["korisnickoImeR"])) {
        $korImeGreska = "Niste unijeli korisnicko ime!";
    } else {
        $ime = testiraj($_POST["ime"]);
        if (strlen($korIme) < 8) {
            $korImeGreska = "Korisničko ime mora imati minimalno 8 znakova!";
        }
    }
}

function testiraj($podatak)
{
    $podatak = trim($podatak);
    $podatak = stripslashes($podatak);
    $podatak = htmlspecialchars($podatak);
    return $podatak;
}
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Registracija</title>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body onload="dogadaji()">
    <div class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-home"></i> Index</a>
        <a href="autokuce.php">Autokuće</a>
        <?php
        if (isset($_SESSION["Sesija_KorisnickoIme"])) {
            if ($_SESSION["Sesija_Tip"] == 1 || $_SESSION["Sesija_Tip"] == 2 || $_SESSION["Sesija_Tip"] == 3) {
                echo "<a href='servisi.php'>Servisi</a>";
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
            <!--<a><input type="text" placeholder="Search..""></a>-->
            <a class="active" href="registracija.php">Registracija</a>
            <a href="prijava.php">Prijava</a>
            <a style="width: 25px;" href="#bottom">&#x2193;</a>
        </div>
    </div>

    <div class="contentDiv" style="width: 25%; margin-left: 37.5%; margin-top: 7%;">

        <form id="formaRegistracija" method="post" name="formaRegistracija" action="<?php
                                                                                    echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="divAlign"><br>
                <input type="text" id="ime" name="ime" size="20" maxlength="50" placeholder="Ime..." autofocus="autofocus" required="required"><br>* <?php if (isset($imeGreska)) echo $imeGreska; ?>
            </div>
            <br>

            <div class="divAlign">
                <input type="text" id="prezime" name="prezime" size="20" maxlength="50" placeholder="Prezime..." required="required"><br>* <?php if (isset($prezimeGreska)) echo $prezimeGreska; ?>
            </div>
            <br>
            <div class="divAlign">
                <input type="date" id="datRod" name="datRod" placeholder="Datum rođenja" required="required"><br><?php if (isset($datumGreska)) echo $datumGreska; ?>
            </div>
            <br>
            <div class="divAlign">
                <input type="text" id="korisnickoImeR" name="korisnickoImeR" maxlength="50" placeholder="Korisničko ime..." required="required"><br><?php if (isset($korImeGreska)) echo $korImeGreska; ?>
            </div>
            <br>
            <div class="divAlign">
                <input type="email" id="eMail" name="eMail" placeholder="Mail..." required="required"><br><?php if (isset($mailGreska)) echo $mailGreska; ?>
            </div>
            <br>
            <div class="divAlign">
                <input type="password" id="lozinkaR" name="lozinkaR" placeholder="Lozinka..." required="required"><br><?php if (isset($lozinkaGreska)) echo $lozinkaGreska ?>
            </div>
            <br>
            <div class="divAlign">
                <input type="password" id="ponovljenaLozinka" name="ponovljenaLozinka" placeholder="Ponovi lozinku..." required="required"><br>
            </div>
            <br>
            <div class="g-recaptcha" data-sitekey="6LehIagUAAAAAAIuPJuaHycwB2rRSOXs2DAe3npZ"></div>
            <div class="divAlignButton">
                <img onload="registracijaHover()" id="registracijaSlika" style="width: 80%;" src="../multimedija/registracija.png" />
            </div><br>
        </form>
        <?php
        require_once "baza.php";

        if (isset($_POST["korisnickoImeR"]) && isset($_POST["lozinkaR"])) {
            $ime = $_POST["ime"];
            $prezime = $_POST["prezime"];
            $datum = $_POST["datRod"];
            $korIme = $_POST["korisnickoImeR"];
            $mail = $_POST["eMail"];
            $lozinka = $_POST["lozinkaR"];

            $sol = substr(md5(microtime()), rand(0, 26), 10);
            $kriptiranaLozinka = hash('sha256', $lozinka . $sol);
            $aktivacijskiKod = substr(md5(microtime()), rand(0, 26), 15);
            date_default_timezone_set('Europe/Zagreb');
            $trenutnoVrijeme = date('Y-m-d H:i:s', time() + 86400);

            $upit = "INSERT INTO korisnik(Ime, Prezime, Datum_Rodjenja, Korisnicko_Ime, Mail, Lozinka, Kriptirana_Lozinka, Tip_Korisnika_ID, Zakljucan, Aktiviran, Neuspjesni_Pokusaji, Aktivacijski_Kod, Istek_Koda) VALUES('$ime', '$prezime', '$datum', '$korIme', '$mail', '$lozinka', '$kriptiranaLozinka', '3', '0', '0', '0', '$aktivacijskiKod', '$trenutnoVrijeme')";
            upit($upit);

            $to = $_POST["eMail"];
            $subject = "Aktivacijski link";
            $headers = "From: autokuca@foi.hr" . "\r\n" .
                "CC: somebodyelse@example.com";
            $txt = "Poštovani, kliknite na sljedeći link kako bi aktivirali vaš korisnički račun. " . "http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x135/php/registracija.php?kod=$aktivacijskiKod";

            mail($to, $subject, $txt, $headers);

            echo "<script language='javascript'>";
            echo "alert('Poslan vam je mail s aktivacijskim linkom!')";
            echo "</script>";
        }
        ?>
    </div>
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