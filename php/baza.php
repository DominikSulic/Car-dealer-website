<?php
    const server = "localhost";
    const korisnik = "root";
    const lozinka = "";
    const baza = "mydb";
  
    function upit($upit) {
        $konekcija = new mysqli(server, korisnik, lozinka, baza);
        $konekcija->set_charset("utf8");

        if ($konekcija->connect_error) {
            die("Connection failed: " . $konekcija->connect_error);
        }

        $rezultat = $konekcija->query($upit);
        $konekcija->close();
      
        return $rezultat;
    }

    function update($upit) {
        $konekcija = new mysqli(server, korisnik, lozinka, baza);
        $konekcija->set_charset("utf8");

        if ($konekcija->connect_error) {
            die("Connection failed: " . $konekcija->connect_error);
        }

        if ($konekcija->query($upit) === TRUE) {
            $konekcija->close();
            return true;
        } else {
            $konekcija->close();
            return false;
        }
    }
?>