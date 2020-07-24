function zakljucajOtkljucajKor($trenutniStatus,$idKorisnika){
    $.ajax({
        url: "../php/zakljucajOtkljucaj.php",
        type: 'POST',
        data: { status: $trenutniStatus, idKor:$idKorisnika },
        success: function (result) {
          location.reload();
        }
      });
  }



function dogadaji() {

    var korime = document.getElementById("korisnickoImeR");
    var lozinka = document.getElementById("lozinkaR");
    var ponovljenaLozinka = document.getElementById("ponovljenaLozinka");
    var eMail = document.getElementById("eMail");
    var godiste = document.getElementById("datRod");

    korime.addEventListener("change", function (event) {
        provjeraKorisnickoIme();
    })
    lozinka.addEventListener("change", function (event) {
        provjeraLozinka();
    })
    ponovljenaLozinka.addEventListener("change", function (event) {
        provjeraPonovljenaLozinka();
    })
    eMail.addEventListener("change", function (event) {
        provjeraMail();
    })
    godiste.addEventListener("change", function (event) {
        provjeraGodiste();
    })
}

function provjeraKorisnickoIme() {
    var korime = document.getElementById("korisnickoImeR");

    if (korime.value.length < 3) {
        alert("Korisnicko ime mora imati minimalno 3 znaka!");
    }
}

function provjeraLozinka() {
    var lozinka = document.getElementById("lozinkaR");

    if (lozinka.value.length < 8) {
        alert("Lozinka mora imati minimalno 8 znakova!");
    }
}

function provjeraPonovljenaLozinka() {
    var lozinka = document.getElementById("lozinkaR");
    var ponovljenaLozinka = document.getElementById("ponovljenaLozinka");

    if (lozinka.value !== ponovljenaLozinka.value) {
        alert("Lozinke se ne poklapaju");
    }
}

function provjeraMail() {
    var email = document.getElementById("eMail");
    var regex = new RegExp("([A-Za-z0-9]\.{0,1}){1,}@(([A-Za-z0-9]{2,}\.){1,})[A-Za-z0-9]{1,}");

    if (regex.test(String(email.value)) === true) {
        alert("Mail je valjan");
    }
    else {
        alert("Mail nije valjan");
    }
}

function provjeraGodiste() {
    var godiste = document.getElementById("datRod");
    ageMS = Date.parse(Date()) - Date.parse(godiste.value);
    age = new Date();
    age.setTime(ageMS);
    ageYear = age.getFullYear() - 1970;

    if (ageYear < 18) {
        alert("morate biti stariji od 18 godina");
    }


}



function prijavaHover() {
    var prijava = document.getElementById("prijavaSlika");

    prijava.addEventListener("mouseenter", function (event) {
        prijava.src = "../multimedija/prijavaHover.png";
    }, false);

    prijava.addEventListener("mouseleave", function (event) {
        prijava.src = "../multimedija/prijava.png";
    }, false);
}

function registracijaHover() {
    var registracija = document.getElementById("registracijaSlika");

    registracija.addEventListener("mouseenter", function (event) {
        registracija.src = "../multimedija/registracijaHover.png";
    }, false);

    registracija.addEventListener("mouseleave", function (event) {
        registracija.src = "../multimedija/registracija.png";
    }, false);
}


function zahtjevHover() {
    var zahtjev = document.getElementById("zahtjevSlika");

    zahtjev.addEventListener("mouseenter", function (event) {
        zahtjev.src = "../multimedija/zahtjevHover.png";
    }, false);

    zahtjev.addEventListener("mouseleave", function (event) {
        zahtjev.src = "../multimedija/zahtjev.png";
    }, false);
}
function zaboravljenaLozinkaHover() {
    var zaboravljenaLozinka = document.getElementById("zaboravljenaLozinkaSlika");

    zaboravljenaLozinka.addEventListener("mouseenter", function (event) {
        zaboravljenaLozinka.src = "../multimedija/zaboravljenaLozinkaHover.png";
    }, false);

    zaboravljenaLozinka.addEventListener("mouseleave", function (event) {
        zaboravljenaLozinka.src = "../multimedija/zaboravljenaLozinka.png";
    }, false);
}



function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}


function on() {
    document.getElementById("overlay").style.display = "block";
  }
  
  function off() {
    document.getElementById("overlay").style.display = "none";
  }