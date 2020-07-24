$(document).ready(function () {
    
    
  $("#zahtjevSlika").click(function () {
    $("#formaZahtjev").submit();
    var image_name= $('#fileToUpload').val();
    if(image_name == '') {
        alert("Odaberite sliku!");
        return false;
    }
    else {
        var extension = $('#fileToUpload').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("Format slike nije valjan!");
            $('#fileToUpload').val('');
            return false;
        }
    }
  });


  $("#terminSlika").click(function () {
    $("#formaTermin").submit();
  });


    var option = new Option(" ");
    $('#generiraneAutokuce').append($(option));
    $.ajax({
        url: "../php/autokuceUcitaj.php",
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            for(var i = 0; i < result.length; i++) {
                var option = new Option(result[i].Naziv); 
                $('#generiraneAutokuce').append($(option));
            }
        }
    });


    var generiraneAutokuce = document.getElementById("generiraneAutokuce");
    if (generiraneAutokuce) {
        generiraneAutokuce.addEventListener("change", function (event) {
            var refreshedA = document.getElementById("generiraneAutokuce");
            $('#generiraneLokacije').empty();
            var option = new Option(" ");
            $('#generiraneLokacije').append($(option));
            $.ajax({
                url: "../php/lokacijeZahtjev.php",
                type: 'POST',
                dataType: "json",
                data: { autokuca: refreshedA.value },
                success: function (result) {
                    for (var i = 0; i < result.length; i++) {
                        var option = new Option(result[i].Adresa); 
                        $('#generiraneLokacije').append($(option));
                    }
                }
            });
        }, false);
    }

    var generiraneLokacije = document.getElementById("generiraneLokacije");
    if (generiraneLokacije) {
        generiraneLokacije.addEventListener("change", function (event) {
            var refreshedL = document.getElementById("generiraneLokacije");
            var refreshedA = document.getElementById("generiraneAutokuce");
            $('#generiraniTermini').empty();
            var option = new Option(" ");
            $('#generiraniTermini').append($(option));
            $.ajax({
                url: "../php/terminiZahtjev.php",
                type: 'POST',
                dataType: "json",
                data: { lokacija: refreshedL.value, autokuca: refreshedA.value },
                success: function (result) {
                    for (var i = 0; i < result.length; i++) {
                        var option = new Option(result[i].Od); 
                        $('#generiraniTermini').append($(option));
                    }
                }
            });
        }, false);
    }
})