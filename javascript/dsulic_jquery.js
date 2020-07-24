$(document).ready(function () {
  $.ajax({
    url: "../php/autokuceUcitaj.php",
    type: 'POST',
    dataType: 'json',
    success: function (result) {
      for (var i = 0; i < result.length; i++) {
        $("#generiranaImena").append('<option value=' + result[i].Naziv + '/>');
      }
    }
  });



  $("#prijavaSlika").click(function () {
    $("#formaPrijava").submit();
  });

  $("#registracijaSlika").click(function () {
    $("#formaRegistracija").submit();
  });

  $('#formaRegistracija').click(function(){
    if($('#prezime').val() == ''){
      event.preventDefault();
       alert('Morate unijeti prezime!');
    }
 });

 $('#formaRegistracija').click(function(){
  if($('#ime').val() == ''){
    event.preventDefault();
     alert('morate unijeti ime!');
  }
});

  $("#zaboravljenaLozinkaSlika").click(function () {
    $("#formaZaboravljenaLozinka").submit();
  });


  var registracijaKorisnickoIme = document.getElementById("korisnickoImeR");

  if (registracijaKorisnickoIme) {
    registracijaKorisnickoIme.addEventListener("blur", function (event) {
      event.preventDefault();
      var korisnickoIme = document.getElementById("korisnickoImeR");
      $.ajax({
        url: "../php/registracijaProvjera.php", //the page containing php script
        type: "post", //request type,
        dataType: 'text',
        data: { "korisnickoImeR": korisnickoIme.value },
        success: function (result) {
          alert(result);
        }
      });
    }, false);
  }



  var sortirajNazivA = document.getElementById("sortirajNazivA");
  var sortiranje = "ASC";

  if (sortirajNazivA) {
    sortirajNazivA.addEventListener("click", function (event) {
      $.ajax({
        url: "../php/autokuceUcitaj.php",
        type: "post",
        dataType: 'json',
        data: { "nacinSortiranja": sortiranje },
        success: function (result) {
          if (sortiranje == "ASC") sortiranje = "DESC";
          else if (sortiranje == "DESC") sortiranje = "ASC";
          kreirajTablicuA(result);
        }
      })
    }, false);
  }



  var brojStranice = 0;
  var zadnjaStranica;

  // ZA STRANICU AUTOKUCE ------------------------------------------------------------

  $("#autokuceButton").click(function () {
    ucitajAutokuce();
    brojStranice = 1;
  });

  $("#prvihDesetA").click(function () {
    ucitajAutokuce();
    brojStranice = 1;
  });

  $("#proslihDesetA").click(function () {
    ucitajAutokuce();
    brojStranice = brojStranice - 1;
  });


  $("#sljedecihDesetA").click(function () {
    ucitajAutokuce();
    brojStranice = brojStranice + 1;
  });


  $("#zadnjihDesetA").click(function () {
    ucitajAutokuce();
    brojStranice = zadnjaStranica;
  });







  // ZA STRANICU LOKACIJE ------------------------------------------------------------


  $("#lokacijeButton").click(function () {
    ucitajLokacije();
    brojStranice = 1;
  });

  $("#prvihDesetL").click(function () {
    ucitajLokacije();
    brojStranice = 1;
  });

  $("#proslihDesetL").click(function () {
    ucitajLokacije();
    brojStranice = brojStranice - 1;
  });


  $("#sljedecihDesetL").click(function () {
    ucitajLokacije();
    brojStranice = brojStranice + 1;
  });


  $("#zadnjihDesetL").click(function () {
    ucitajLokacije();
    brojStranice = zadnjaStranica;
  });






  // ZA STRANICU SERVISI ------------------------------------------------------------

  $("#servisiButton").click(function () {
    ucitajServise();
    brojStranice = 1;
  });


  $("#prvihDesetS").click(function () {
    ucitajServise();
    brojStranice = 1;
  });

  $("#proslihDesetS").click(function () {
    ucitajServise();
    brojStranice = brojStranice - 1;
  });


  $("#sljedecihDesetS").click(function () {
    ucitajServise();
    brojStranice = brojStranice + 1;
  });


  $("#zadnjihDesetS").click(function () {
    ucitajServise();
    brojStranice = zadnjaStranica;
  });





  function ucitajAutokuce() {
    $.ajax({
      url: "../php/autokuceUcitaj.php",
      type: "post",
      dataType: 'json',
      success: function (result) {
        kreirajTablicuA(result);
      }
    })
  }

  function ucitajLokacije() {
    $.ajax({
      url: "../php/lokacijeUcitaj.php",
      type: "post",
      dataType: 'json',
      success: function (result) {
        kreirajTablicuL(result);
      }
    })
  }

  function ucitajServise() {
    $.ajax({
      url: "../php/servisiUcitaj.php",
      type: "post",
      dataType: 'json',
      success: function (result) {
        kreirajTablicuS(result);
      }
    })
  }



  function kreirajTablicuA(array) {
    var table = document.getElementById("autokuceTable");
    var row;
    var cell1;
    var cell2;
    zadnjaStranica = Math.ceil(array.length / 10);
    var ispisBroja = document.getElementById("ispisStraniceA");
    if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
    else if (brojStranice <= 1) brojStranice = 1;
    ispisBroja.innerHTML = "Broj stranice: " + brojStranice;

    for (var i = table.rows.length - 1; i > 0; i--) {
      table.deleteRow(i);
    }

    // ak je prva stranica - zanemari, ak je druga stranica, ispisuje 10-20....
    if (brojStranice == 1) {
      for (var i = 0; i < 10; i++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell1.innerHTML = array[i].Naziv;
        cell2.innerHTML = array[i].Vlasnik_ID;
      }
    }
    else if (brojStranice == -1) {
      var i = 0;
      var broj = Math.ceil(array.length / 10) - 1;

      if (array.length % 10 != 0) {
        for (var j = broj * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell1.innerHTML = array[j].Naziv;
          cell2.innerHTML = array[j].Vlasnik_ID;
        }
        brojStranice = broj;
      }
      else {
        for (var j = (broj + 1) * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell1.innerHTML = array[j].Naziv;
          cell2.innerHTML = array[j].Vlasnik_ID;
        }
        brojStranice = broj + 1;
      }
    }
    else if (brojStranice == 0) {
      for (var i = 0; i < 10; i++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell1.innerHTML = array[i].Naziv;
        cell2.innerHTML = array[i].Vlasnik_ID;
      }
      brojStranice = 1;
    }
    else {
      var i = 0;
      if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
      var offset = (brojStranice - 1) * 10;
      for (offset; offset < array.length; offset++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell1.innerHTML = array[offset].Naziv;
        cell2.innerHTML = array[offset].Vlasnik_ID;
        i++;
      }
    }
  }

  function kreirajTablicuL(array) {
    var table = document.getElementById("lokacijeTable");
    var row;
    var cell1;
    var cell2;

    var brojacLokacija = 0;
    var arrayVrijednosti = new Array();
    var vrijednost = document.getElementById("generiranaimena");


    if (vrijednost.value == "") {
      for (var i = 0; i < array.length; i++) {
        arrayVrijednosti[brojacLokacija] = array[i];
        brojacLokacija = brojacLokacija + 1;
      }
    }
    else {
      for (var i = 0; i < array.length; i++) {
        if (array[i].Naziv.includes(vrijednost.value)) {
          arrayVrijednosti[brojacLokacija] = array[i];
          brojacLokacija = brojacLokacija + 1;
        }
      }
    }
    zadnjaStranica = Math.ceil(brojacLokacija / 10);
    var ispisBroja = document.getElementById("ispisStraniceL");

    if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
    else if (brojStranice <= 1) brojStranice = 1;
    ispisBroja.innerHTML = "Broj stranice: " + brojStranice;

    for (var i = table.rows.length - 1; i > 0; i--) {
      table.deleteRow(i);
    }



    if (brojStranice == 1) {
      if (brojacLokacija > 10) {
        for (var i = 0; i < 10; i++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell4 = row.insertCell(3);
          cell5 = row.insertCell(4);
          cell1.innerHTML = arrayVrijednosti[i].Naziv;
          cell2.innerHTML = arrayVrijednosti[i].Adresa;
          cell3.innerHTML = arrayVrijednosti[i].Kontakt_Broj;
          cell4.innerHTML = arrayVrijednosti[i].Mail;
          var string = arrayVrijednosti[i].Radno_Vrijeme_Od;
          var string1 = " - ";
          var string2 = arrayVrijednosti[i].Radno_Vrijeme_Do;
          cell5.innerHTML = string.concat(string1, string2);
        }
      }
      else {
        for (var i = 0; i < brojacLokacija; i++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell4 = row.insertCell(3);
          cell5 = row.insertCell(4);
          cell1.innerHTML = arrayVrijednosti[i].Naziv;
          cell2.innerHTML = arrayVrijednosti[i].Adresa;
          cell3.innerHTML = arrayVrijednosti[i].Kontakt_Broj;
          cell4.innerHTML = arrayVrijednosti[i].Mail;
          var string = arrayVrijednosti[i].Radno_Vrijeme_Od;
          var string1 = " - ";
          var string2 = arrayVrijednosti[i].Radno_Vrijeme_Do;
          cell5.innerHTML = string.concat(string1, string2);
        }
      }

    }
    else if (brojStranice == -1) {
      var i = 0;
      var broj = Math.ceil(brojacLokacija / 10) - 1;

      if (array.length % 10 != 0) {
        for (var j = broj * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell4 = row.insertCell(3);
          cell5 = row.insertCell(4);
          cell1.innerHTML = arrayVrijednosti[j].Naziv;
          cell2.innerHTML = arrayVrijednosti[j].Adresa;
          cell3.innerHTML = arrayVrijednosti[j].Kontakt_Broj;
          cell4.innerHTML = arrayVrijednosti[j].Mail;
          var string = arrayVrijednosti[j].Radno_Vrijeme_Od;
          var string1 = " - ";
          var string2 = arrayVrijednosti[j].Radno_Vrijeme_Do;
          cell5.innerHTML = string.concat(string1, string2);
        }
        brojStranice = broj + 1;
      }
      else {
        for (var j = (broj + 1) * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell4 = row.insertCell(3);
          cell5 = row.insertCell(4);
          cell1.innerHTML = arrayVrijednosti[j].Naziv;
          cell2.innerHTML = arrayVrijednosti[j].Adresa;
          cell3.innerHTML = arrayVrijednosti[j].Kontakt_Broj;
          cell4.innerHTML = arrayVrijednosti[j].Mail;
          var string = arrayVrijednosti[j].Radno_Vrijeme_Od;
          var string1 = " - ";
          var string2 = arrayVrijednosti[j].Radno_Vrijeme_Do;
          cell5.innerHTML = string.concat(string1, string2);
        }
        brojStranice = broj + 1;
      }
    }
    else if (brojStranice == 0) {
      for (var i = 0; i < 10; i++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell4 = row.insertCell(3);
        cell5 = row.insertCell(4);
        cell1.innerHTML = arrayVrijednosti[i].Naziv;
        cell2.innerHTML = arrayVrijednosti[i].Adresa;
        cell3.innerHTML = arrayVrijednosti[i].Kontakt_Broj;
        cell4.innerHTML = arrayVrijednosti[i].Mail;
        var string = arrayVrijednosti[i].Radno_Vrijeme_Od;
        var string1 = " - ";
        var string2 = arrayVrijednosti[i].Radno_Vrijeme_Do;
        cell5.innerHTML = string.concat(string1, string2);
      }
      brojStranice = 1;
    }
    else {
      var i = 0;
      if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
      var offset = (brojStranice - 1) * 10;
      for (offset; offset < array.length; offset++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell4 = row.insertCell(3);
        cell5 = row.insertCell(4);
        cell1.innerHTML = arrayVrijednosti[offset].Naziv;
        cell2.innerHTML = arrayVrijednosti[offset].Adresa;
        cell3.innerHTML = arrayVrijednosti[offset].Kontakt_Broj;
        cell4.innerHTML = arrayVrijednosti[offset].Mail;
        var string = arrayVrijednosti[offset].Radno_Vrijeme_Od;
        var string1 = " - ";
        var string2 = arrayVrijednosti[offset].Radno_Vrijeme_Do;
        cell5.innerHTML = string.concat(string1, string2);
      }
    }
  }

  function kreirajTablicuS(array) {
    var table = document.getElementById("servisiTable");
    var row;
    var cell1;
    var cell2;
    zadnjaStranica = Math.ceil(array.length / 10);
    var ispisBroja = document.getElementById("ispisStraniceS");
    if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
    else if (brojStranice <= 1) brojStranice = 1;
    ispisBroja.innerHTML = "Broj stranice: " + brojStranice;

    for (var i = table.rows.length - 1; i > 0; i--) {
      table.deleteRow(i);
    }

    // ak je prva stranica - zanemari, ak je druga stranica, ispisuje 10-20....
    if (brojStranice == 1) {
      for (var i = 0; i < 10; i++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell1.innerHTML = array[i].Datum;
        cell2.innerHTML = array[i].Cijena;
        cell3.innerHTML = array[i].Status;
      }
    }
    else if (brojStranice == -1) {
      var i = 0;
      var broj = Math.ceil(array.length / 10) - 1;

      if (array.length % 10 != 0) {
        for (var j = broj * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell1.innerHTML = array[j].Datum;
          cell2.innerHTML = array[j].Cijena;
          cell3.innerHTML = array[j].Status;
        }
        brojStranice = broj;
      }
      else {
        for (var j = (broj + 1) * 10; j < array.length; j++) {
          row = table.insertRow(i + 1);
          cell1 = row.insertCell(0);
          cell2 = row.insertCell(1);
          cell3 = row.insertCell(2);
          cell1.innerHTML = array[j].Datum;
          cell2.innerHTML = array[j].Cijena;
          cell3.innerHTML = array[j].Status;
        }
        brojStranice = broj + 1;
      }
    }
    else if (brojStranice == 0) {
      for (var i = 0; i < 10; i++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell1.innerHTML = array[i].Datum;
        cell2.innerHTML = array[i].Cijena;
        cell3.innerHTML = array[i].Status;
      }
      brojStranice = 1;
    }
    else {
      var i = 0;
      if (brojStranice >= zadnjaStranica) brojStranice = zadnjaStranica;
      var offset = (brojStranice - 1) * 10;
      for (offset; offset < array.length; offset++) {
        row = table.insertRow(i + 1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell1.innerHTML = array[offset].Datum;
        cell2.innerHTML = array[offset].Cijena;
        cell3.innerHTML = array[offset].Status;
      }
    }
  }



  var search = document.getElementById("pretraziNaziv");
  if (search) {
    search.addEventListener("click", function (event) {
      var tekst = document.getElementById("searchBox")
      $.ajax({
        url: "../php/lokacijeSearch.php",
        type: 'POST',
        dataType: "json",
        data: { mjesto: tekst.value },
        success: function (result) {
          brojStranice = 1;
          kreirajTablicuL(result);
        }
      });
    })
  }
})