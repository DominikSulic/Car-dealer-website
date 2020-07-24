<?php
    session_start();
    
	if($_SESSION["Sesija_Tip"] != 1) {
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
	<title>Dnevnik</title>
    <meta charset="UTF-8">
	<meta name="author" content="Dominik Šulić">
	<meta name="keywords" content="Servisi">
    <meta name="description" content="Popis servisa">

    
    <link rel="stylesheet" type="text/css" href="../css/dsulic.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="../javascript/dsulic.js"></script>
</head>

<body>
    <div class="navbar">
        <a href="index.php"><i class="fa fa-fw fa-home"></i> Index</a>
        <a href="autokuce.php">Autokuće</a>
        <a href="servisi.php">Servisi</a>
        <a href="lokacije.php">Lokacije</a>
        <a href='zahtjevi.php'>Zahtjevi</a>
        <a class="active" href="dnevnik.php">Dnevnik</a>
        <div class="navbar-right">
            <a href="odjava.php">Odjava</a>
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