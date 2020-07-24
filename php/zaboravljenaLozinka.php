<!DOCTYPE html>
<html lang="hr">

<head>

    <title>Zaboravljena Lozinka</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dominik Šulić">
    <meta name="keywords" content="Zaboravljena lozinka, mail">
    <meta name="description" content="Stranica za zaboravljenu lozinku">

    <link rel="stylesheet" type="text/css" href="../css/dsulic.css" />

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../javascript/dsulic_jquery.js"></script>
    <script type="text/javascript" src="../javascript/dsulic.js"></script>
</head>

<body>
    <div class="contentDiv" style="width: 25%; margin-left: 37.5%; margin-top: 10%;">
        <form id="formaZaboravljenaLozinka" method="post" name="formaZaboravljenaLozinka" action="zaboravljenaLozinka.php"><br>
            <div class="divAlign"><br>
                <input type="email" id="eMailZL" name="eMailZL" placeholder="Unesite vaš mail..." required="required"><br><br>
            </div>
            <div class="divAlign">
                <img onload="zaboravljenaLozinkaHover()" id="zaboravljenaLozinkaSlika" style="width: 80%; height: 65px;" src="../multimedija/zaboravljenaLozinka.png" />
            </div>
        </form>
        <?php
        if(isset($_POST["eMailZL"])) {
            $to = $_POST["eMailZL"];
            $subject = "Zaboravljena Lozinka";
            $headers = "From: autokuca@foi.hr" . "\r\n" .
                "CC: somebodyelse@example.com";

            $generatedPassword = "";
            for ($i = 0; $i < 8; $i++) {
                $generatedPassword .= random_int(0, 9);
            }

            $txt = "Poštovani, zatražili ste novu lozinku." . "Vaša nova lozinka je:  '$generatedPassword'";

            require_once "baza.php";
            $upit = "UPDATE korisnik SET Lozinka='$generatedPassword' WHERE Mail='$to'";
            $rezultat = update($upit);

            if ($rezultat === true) {
                mail($to, $subject, $txt, $headers);
                echo "<script language='javascript'>";
                echo "alert('Mail je uspješno poslan!')";
                echo "</script>";
            } else {
                echo "<script language='javascript'>";
                echo "alert('Mail nije poslan!')";
                echo "</script>";
            }
        }
        ?>
    </div>
    <img class="BGimg" src="../multimedija/bgBMW.jpg" alt="" />

</body>
</html>