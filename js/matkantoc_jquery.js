/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function tablicaDnevnik(){
    $(document).ready(function () {
        tablicadnevnik();
    });
function tablicadnevnik() {
        var tablica = "<thead><tr><th>ID dnevnik</th><th>ID korisnik</th><th>Datum</th><th>Opis radnje</th></tr></thead>";
        $(".tablica_klasa1").empty();
        $.ajax({
            type: "GET",
            url: "kreiraj_dnevnik.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $(".tablica_klasa1").empty();
                $.each(data, function () {
                    tablica += '<tr><td>' + this.id_dnevnikrada + '</td><td>' + this.id_korisnik + '</td><td>' + this.datum + '</td><td>' + this.opis_radnje + '</td></tr>';
                }
                        );
                $('.tablica_klasa1').append(tablica);
                $('.tablica_klasa1').dataTable();
            }
            
        }
                );
        
    }
    }
function kreirajTablice(){
    
    $('#odaberi').on('change',function () {
        if ($("#odaberi").val() == 'aktiviraj') {
        tablica();
        $('#odaberi1').css("visibility", "visible");
        $('#odaberi1').on('change',function () {
        if($("#odaberi1").val() == 'insert'){
              $('#aktiviraj_forma').css("display", "inline");
              $("#aktiviraj_forma").on("submit", function(event) {     
        $("#pogreskakorime1").html("");
        $("#pogreskalozinka1").html("");
        $("#pogreskarodendan").html("");
        $("#pogreskatel").html("");
        $("#pogreskamail").html("");
        
        if($("#tip").val().length===0){
           $("#tip").css('border', '3px #C33 solid');
        }
        else{
            $("#tip").css('border', '3px #090 solid');
        }
        if($("#ime").val().length===0){
           $("#ime").css('border', '3px #C33 solid');
        }
        else{
            $("#ime").css('border', '3px #090 solid');
        }
        if($("#prezime").val().length===0){
           $("#prezime").css('border', '3px #C33 solid');
        }
        else{
            $("#prezime").css('border', '3px #090 solid');
        }
        if ($("#korime").attr("type") !== "text")
        {
            $("#pogreskakorime1").append("Korisnicko ime nije tipa (text)!<br>");
            event.preventDefault();
            return;
        }
        pocetno1 = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/; 

        if (!pocetno1.test($("#korime").val())) {
            event.preventDefault();
        }

        if(($("#korime").attr("type") !== "text") || (!pocetno1.test($("#korime").val())))
        {
            $("#korime").css('border', '3px #C33 solid');
        }
        else {
            $("#korime").css('border', '3px #090 solid');
        }
        if ($("#lozinka1").attr("type") !== "password")
        {
            $("#pogreskalozinka1").append("Lozinka nije tipa (password)!<br>");
            event.preventDefault();
            return;
        }
        mslovo = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;
        if (!mslovo.test($("#lozinka1").val())) {
            event.preventDefault();
        }
        if(($("#lozinka1").attr("type") !== "password") || (!mslovo.test($("#lozinka1").val())))
        {
            $("#lozinka1").css('border', '3px #C33 solid');
        }
        else {
            $("#lozinka1").css('border', '3px #090 solid');
        }
        
        if ($("#rođendan").attr("type") !== "number")
        {
            $("#pogreskarodendan").append("->Dan nije tipa (number)!<br>");
            event.preventDefault();
            return;
        }
        if ($("#rođendan").val() < 1 || $("#rođendan").val() > 31)
        {
            $("#rođendan").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#rođendan").css('border', '3px #090 solid');
        }
        if ($("#godina").attr("type") !== "number")
        {
            $("#pogreskarodendan").append("Godina nije tipa (number)!<br>");
            event.preventDefault();
            return;
        }
        if ($("#godina").val() > 2015 || $("#godina").val() < 1930)
        {
            $("#godina").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#godina").css('border', '3px #090 solid');            
        }
        if($("#mjesec1").val()<1){
            $("#mjesec1").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#mjesec1").css('border', '3px #090 solid');            
        }
        if ($("#email").attr("type") !== "email")
        {
            $("#pogreskamail").append("Adresa nije tipa (email)!<br>");
            event.preventDefault();
            return;
        }
        adresa = /[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]{2,3}/;
        if (!adresa.test($("#email").val()))    
        {
            $("#email").css('border', '3px #C33 solid');
            event.preventDefault();
        } 
        else{
            $("#email").css('border', '3px #090 solid');  
            
        }

    });
    

        }
        else{
              $('#aktiviraj_forma').css("display", "none");
        }
        
        
        if($("#odaberi1").val() == 'update'){
              $('#update_form').css("display", "inline");
              $(document).ready(function () {
                            update();
                        });
                        function update() {
                            $("#update_select").empty();
                            $('#update_select').append("<option>...Ucitaj...</option>");
                            $.ajax({
                                type: "GET",
                                url: "baza_update.php",
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",
                                success: function (data) {
                                    $("#update_select").empty();
                                    $("#update_select").append("<option value='0'>--Odaberite korisnika--</option>");
                                    $.each(data, function () {
                                        $('#update_select').append('<option value="' + this.id_korisnik + ' ">' + this.korime + '</option>');
                                    });         
                                }
                            });
                        }
            $('#update_select').on('change',function () {
                id=$('#update_select').val();
                $(document).ready(function () {
                            posalji();
                        });
                        function posalji() {
                            $.ajax({
                                type: "GET",
                                url: "baza_update1.php",
                                data:{'id_select': id},
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",
                                success: function (data) {
                                    $.each(data, function () {
                                        $('#tip1').val(this.id_tip);
                                        $('#ime1').val(this.ime);
                                        $('#prezime1').val(this.prezime);
                                        $('#korime1').val(this.korime);
                                        $('#lozinka2').val(this.lozinka);
                                        $('#rođendan1').val(this.dan_rodenja);
                                        $('#mjesec2').val(this.mjesec_rodenja);
                                        $('#godina1').val(this.godina_rodenja);
                                        $('#email1').val(this.email);
                                    });         
                                }
                            });
                        }
                                        });            

              $("#update_form").on("submit", function(event) {
                 if($('#tip1').val()==0){
                     $("#tip1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#tip1").css('border', '3px #090 solid');  
                 }
                 if($('#ime1').val()==0){
                     $("#ime1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#ime1").css('border', '3px #090 solid');  
                 }
                 if($('#prezime1').val()==0){
                     $("#prezime1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#prezime1").css('border', '3px #090 solid');  
                 }
                 if($('#korime1').val()==0){
                     $("#korime1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#korime1").css('border', '3px #090 solid');  
                 }
                 if($('#lozinka2').val()==0){
                     $("#lozinka2").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#lozinka2").css('border', '3px #090 solid');  
                 }
                 if($('#rođendan1').val()==0){
                     $("#rođendan1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#rođendan1").css('border', '3px #090 solid');  
                 }if($('#tip1').val()==0){
                     $("#tip1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#tip1").css('border', '3px #090 solid');  
                 }
                 if($('#mjesec2').val()==0){
                     $("#mjesec2").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#mjesec2").css('border', '3px #090 solid');  
                 }
                 if($('#godina1').val()==0){
                     $("#godina1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#godina1").css('border', '3px #090 solid');  
                 }
                 if($('#email1').val()==0){
                     $("#email1").css('border', '3px #C33 solid');
                     event.preventDefault();
                 }
                 else{
                     $("#email1").css('border', '3px #090 solid');  
                 }
                 
                  
        

    });
    

        }
        else{
               $('#update_form').css("display", "none");
        }
                if ($("#odaberi1").val() == 'delete') {
                    $('#delete_form').css("display", "inline");
                    $(document).ready(function () {
                        delete1();
                    });
                    function delete1() {
                        $("#update_select1").empty();
                        $('#update_select1').append("<option>...Ucitaj...</option>");
                        $.ajax({
                            type: "GET",
                            url: "baza_update.php",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function (data) {
                                $("#update_select1").empty();
                                $("#update_select1").append("<option value='0'>--Odaberite korisnika--</option>");
                                $.each(data, function () {
                                    $('#update_select1').append('<option value="' + this.id_korisnik + ' ">' + this.korime + '</option>');
                                });
                            }
                        });
                    }
                } else {
                    $('#delete_form').css("display", "none");
                }
        });
        }
        
    });
    function tablica() {
        var tablica = "<thead><tr><th>ID_korisnik</th><th>ID_tip</th><th>Ime</th><th>Prezime</th><th>Korime</th><th>Lozinka</th><th>Dan rođenja</th><th>Mjesec rođenja</th><th>Godina rođenja</th><th>Email</th><th>Broj pogrešaka</th><th>Zaključan/odključan korisnički račun</th></tr></thead>";
        $(".tablica_klasa").empty();
        $.ajax({
            type: "GET",
            url: "kreiraj_tablicu.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $(".tablica_klasa").empty();
                $.each(data, function () {
                    tablica += '<tr><td>' + this.id_korisnik + '</td><td>' + this.id_tip + '</td><td>' + this.ime + '</td><td>' + this.prezime + '</td><td>' + this.korime + '</td><td>' + this.lozinka + '</td><td>' + this.dan_rodenja + '</td><td>' + this.mjesec_rodenja + '</td><td>' + this.godina_rodenja + '</td><td>' + this.email + '</td><td>'+ this.broj_pogresaka + '</td><td>' + this.status_zakljucan + '</td></tr>';
                }
                        );
                $('.tablica_klasa').append(tablica);
                $('.tablica_klasa').dataTable();
            }
            
        }
                );
        
    }

}


function statistika(){
    var canvas;
    var context;
    var Val_Max;
    var sections;
    var xScale;
    var yScale;
    var y;    
    $(document).ready(function () {
        init();
    });
    function init() {
        $.ajax({
            type: "GET",
            url: "statistika_broji.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $.each(data, function () {
                    var itemName = ["Index", "DodajU", "Uređaji", "Aktivacija", "O autoru"];
                    var itemValue = [this.index, this.dodaj_uredaj, this.uredaji, this.aktivacija, this.o_autoru];
                    sections = 5;
                    Val_Max = 400;
                    var stepSize = 20;
                    var columnSize = 50;
                    var rowSize = 60;
                    var margin = 10;
                    var header = "Broj posjeta"
                    canvas = document.getElementById("myCanvas");
                    context = canvas.getContext("2d");
                    context.fillStyle = "#000;"
                    yScale = (canvas.height - columnSize - margin) / (Val_Max);
                    xScale = (canvas.width - rowSize) / (sections + 1);
                    context.strokeStyle = "#000;";
                    context.beginPath();
                    // imena stupaca
                    context.font = "19 pt Arial;"
                    context.fillText(header, 0, columnSize - margin);
                    // linije u pozadini
                    context.font = "16 pt Helvetica"
                    var count = 0;
                    for (scale = Val_Max; scale >= 0; scale = scale - stepSize) {
                        y = columnSize + (yScale * count * stepSize);
                        context.fillText(scale, margin, y + margin);
                        context.moveTo(rowSize, y)
                        context.lineTo(canvas.width, y)
                        count++;
                    }
                    context.stroke();
                    // imena stupaca
                    context.font = "20 pt Verdana";
                    context.textBaseline = "bottom";
                    for (i = 0; i < 5; i++) {
                        computeHeight(itemValue[i]);
                        context.fillText(itemName[i], xScale * (i + 1), y - margin);
                    }
                    // sijena
                    context.fillStyle = "#9933FF;";
                    context.shadowColor = 'rgba(128,128,128, 0.5)';
                    context.shadowOffsetX = 9;
                    context.shadowOffsetY = 3;
                    context.translate(0, canvas.height - margin);
                    context.scale(xScale, -1 * yScale);
                    // nacrtaj graf	
                    for (i = 0; i < 5; i++) {
                        context.fillRect(i + 1, 0, 0.3, itemValue[i]);
                    }
                    function computeHeight(value) {
                        y = canvas.height - value * yScale;
                    }
                });
            }
        });
        
    }
    $(document).ready(function () {
        init1();
    });
    function init1() {
        $.ajax({
            type: "GET",
            url: "statistika_broji1.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $.each(data, function () {
                    var itemName = ["Desc", "Filter", "Zakljucaj", "Odkljucaj"];
                    var itemValue = [this.filter, this.desc, this.zakljucaj, this.odkljucaj];
                    sections = 5;
                    Val_Max = 40;
                    var stepSize = 2;
                    var columnSize = 40;
                    var rowSize = 30;
                    var margin = 10;
                    var header = "Broj upita"
                    canvas = document.getElementById("myCanvas1");
                    context = canvas.getContext("2d");
                    context.fillStyle = "#000;"
                    yScale = (canvas.height - columnSize - margin) / (Val_Max);
                    xScale = (canvas.width - rowSize) / (sections + 1);
                    context.strokeStyle = "#000;";
                    context.beginPath();
                    // imena stupaca
                    context.font = "19 pt Arial;"
                    context.fillText(header, 0, columnSize - margin);
                    // linije u pozadini
                    context.font = "16 pt Helvetica"
                    var count = 0;
                    for (scale = Val_Max; scale >= 0; scale = scale - stepSize) {
                        y = columnSize + (yScale * count * stepSize);
                        context.fillText(scale, margin, y + margin);
                        context.moveTo(rowSize, y)
                        context.lineTo(canvas.width, y)
                        count++;
                    }
                    context.stroke();
                    // imena stupaca
                    context.font = "20 pt Verdana";
                    context.textBaseline = "bottom";
                    for (i = 0; i < 4; i++) {
                        computeHeight(itemValue[i]);
                        context.fillText(itemName[i], xScale * (i + 1), y - margin);
                    }
                    // sijena
                    context.fillStyle = "#9933FF;";
                    context.shadowColor = 'rgba(128,128,128, 0.5)';
                    context.shadowOffsetX = 9;
                    context.shadowOffsetY = 3;
                    context.translate(0, canvas.height - margin);
                    context.scale(xScale, -1 * yScale);
                    // nacrtaj graf	
                    for (i = 0; i < 4; i++) {
                        context.fillRect(i + 1, 0, 0.3, itemValue[i]);
                    }
                    function computeHeight(value) {
                        y = canvas.height - value * yScale;
                    }
                });
            }
        });
        
    }

    

}

function dodajSliku(){
    $(document).ready(function () {
        slika();
    });
    function slika() {
        $("#mob_uredaj").empty();
        $('#mob_uredaj').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "slike_odaberi.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#mob_uredaj").empty();
                $("#mob_uredaj").append("<option value='0'>--Odaberite uredaj--</option>");
                $.each(data, function () {
                    $('#mob_uredaj').append('<option value="' + this.id_uređaji + ' ">' + this.naziv_uređaja + '</option>');
                });
            }
        });
    }
}

function dodajUredaj(){
    $(document).ready(function () {
        kategorija_dodaj();
    });
    function kategorija_dodaj() {
        $("#kategorija_reg").empty();
        $('#kategorija_reg').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "lokacija_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#kategorija_reg").empty();
                $("#kategorija_reg").append("<option value='0'>--Odaberite kategoriju--</option>");
                $.each(data, function () {
                    $('#kategorija_reg').append('<option value="' + this.id_kategorija + ' ">' + this.Naziv + '</option>');
                });
            }
        });
    }
    $("#posalji").on("submit", function (event) {
        $("#pogreskanazivuredaja").html("");
        if ($("#nazivuredaja").val() == 0) {
            $("#pogreskanazivuredaja").append("Niste unijeli naziv uredaja!<br>")
            $("#nazivuredaja").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#nazivuredaja").css('border', '3px #090 solid');  
                 }
        $("#pogreskacijenauredaja").html("");
        if ($("#cijenauredaja").val() == 0) {
            $("#pogreskacijenauredaja").append("Niste unijeli cijenu uredaja!<br>")
            $("#cijenauredaja").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#cijenauredaja").css('border', '3px #090 solid');  
                 }
        $("#pogreskakamera").html("");
        if ($("#kamera").val() == 0) {
            $("#pogreskakamera").append("Niste unijeli rezoluciju kamere!<br>")
            $("#kamera").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#kamera").css('border', '3px #090 solid');  
                 }
        $("#pogreskagprs").html("");
        if ($("#gprs").val() == 0) {
            $("#pogreskagprs").append("Niste unijeli da li mobilni uredaj ima GPRS!<br>")
            $("#gprs").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#gprs").css('border', '3px #090 solid');  
                 }
        $("#pogreskabluetooth").html("");
        if ($("#bluetooth").val() == 0) {
            $("#pogreskabluetooth").append("Niste unijeli da li mobilni uredaj ima Bluetooth!<br>")
            $("#bluetooth").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#bluetooth").css('border', '3px #090 solid');  
                 }
        $("#pogreskabaterija").html("");
        if ($("#baterija").val() == 0) {
            $("#pogreskabaterija").append("Niste unijeli vrijednost baterije!<br>")
            $("#baterija").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
                $("#baterija").css('border', '3px #090 solid');  
                 }
    });
            
}
    
            
function kreirajTablicu(){
    $(document).ready(function () {
        tablica();
    });
    function tablica() {
        var tablica = "<thead><tr><th>ID_korisnik</th><th>ID_tip</th><th>Ime</th><th>Prezime</th><th>Korime</th><th>Lozinka</th><th>Dan rođenja</th><th>Mjesec rođenja</th><th>Godina rođenja</th><th>Broj pogrešaka</th><th>Zaključan/odključan korisnički račun</th></tr></thead>";
        $(".tablica_klasa").empty();
        $.ajax({
            type: "GET",
            url: "kreiraj_tablicu.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $(".tablica_klasa").empty();
                $.each(data, function () {
                    tablica += '<tr><td>' + this.id_korisnik + '</td><td>' + this.id_tip + '</td><td>' + this.ime + '</td><td>' + this.prezime + '</td><td>' + this.korime + '</td><td>' + this.lozinka + '</td><td>' + this.dan_rodenja + '</td><td>' + this.mjesec_rodenja + '</td><td>' + this.godina_rodenja + '</td><td>' + this.broj_pogresaka + '</td><td>' + this.status_zakljucan + '</td></tr>';
                }
                        );
                $('.tablica_klasa').append(tablica);
                $('.tablica_klasa').dataTable();
            }
            
        }
                );
        
    }
    $(document).ready(function () {
        lock();
    });
    function lock() {
        $("#lock").empty();
        $('#lock').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "zakljucaj_odkljucaj_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#lock").empty();
                $("#lock").append("<option value='0'>--Odaberite korisnika--</option>");
                $.each(data, function () {
                    $('#lock').append('<option value="' + this.id_korisnik + ' ">' + this.ime + '</option>');
                });
            }
        });
    }
    $(document).ready(function () {
        unlock();
    });
    function unlock() {
        $("#unlock").empty();
        $('#unlock').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "odkljucaj_zakljucaj_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#unlock").empty();
                $("#unlock").append("<option value='0'>--Odaberite korisnika--</option>");
                $.each(data, function () {
                    $('#unlock').append('<option value="' + this.id_korisnik + ' ">' + this.ime + '</option>');
                });
            }
        });
    }
    $("#formaodkljucaj").on("submit", function (event) {
        $("#pogreskalock").html("");
        if ($("#lock").val() == 0) {
            $("#pogreskalock").append("Niste odabrali korisnika!<br>")
            $("#lock").css('border', '3px #C33 solid');
            event.preventDefault();
        }
    });
    $("#formazakljucaj").on("submit", function (event) {
        $("#pogreskaunlock").html("");
        if ($("#unlock").val() == 0) {
            $("#pogreskaunlock").append("Niste odabrali korisnika!<br>")
            $("#unlock").css('border', '3px #C33 solid');
            event.preventDefault();
        }
    });
}

function moderatorFunkcija() {
    $(document).ready(function () {
        moderator();
    });
    function moderator() {
        $("#moderator").empty();
        $('#moderator').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "moderator_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#moderator").empty();
                $("#moderator").append("<option value='0'>--Odaberite moderatora--</option>");
                $.each(data, function () {
                    $('#moderator').append('<option value="' + this.id_korisnik + ' ">' + this.ime + '</option>');
                });
            }
        });
    }
    $(document).ready(function () {
        kategorija();
    });
    function kategorija() {
        $("#kategorija").empty();
        $('#kategorija').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "lokacija_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#kategorija").empty();
                $("#kategorija").append("<option value='0'>--Odaberite kategoriju--</option>");
                $.each(data, function () {
                    $('#kategorija').append('<option value="' + this.id_kategorija + ' ">' + this.Naziv + '</option>');
                });
            }
        });
    }
    $(document).ready(function () {
        kategorijaanketa();
    });
    function kategorijaanketa() {
        $("#kategorijaanketa").empty();
        $('#kategorijaanketa').append("<option>...Ucitaj...</option>");
        $.ajax({
            type: "GET",
            url: "lokacija_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $("#kategorijaanketa").empty();
                $("#kategorijaanketa").append("<option value='0'>--Odaberite kategoriju--</option>");
                $.each(data, function () {
                    $('#kategorijaanketa').append('<option value="' + this.id_kategorija + ' ">' + this.Naziv + '</option>');
                });
            }
        });
    }
    $("#forma3").on("submit", function (event) {
        $("#pogreskanaziv").html("");
        $("#pogreskamoderator").html("");
        if ($("#naziv_kategorije").val() == 0)
        {
            $("#pogreskanaziv").append("Niste unijeli naziv kategorije!<br>");
            $("#naziv_kategorije").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#naziv_kategorije").css('border', '3px #090 solid');
        }
        

        if ($("#moderator").val() == 0) {
            $("#pogreskamoderator").append("Niste odabrali moderatora!<br>")
            $("#moderator").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#moderator").css('border', '3px #090 solid');
        }
    });
    $("#forma4").on("submit", function (event) {
        $("#pogreskalokacija").html("");
        $("#pogreskakategorija").html("");  
        $("#pogreskaulice").html("");       
        $("#pogreskabroj").html("");        
        $("#pogreskakategorija").html("");    
        $("#pogreskalatitude").html("");    
        $("#pogreskalongitude").html("");     
        $("#pogreskagrad").html("");        
        if ($("#nazivlokacije").val() == 0)
        {
            $("#pogreskalokacija").append("Niste unijeli drzavu!<br>");
            $("#nazivlokacije").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#nazivlokacije").css('border', '3px #090 solid');
        }
        if ($("#nazivgrada").val() == 0)
        {
            $("#pogreskagrad").append("Niste unijeli grad!<br>");
            $("#nazivgrada").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#nazivgrada").css('border', '3px #090 solid');
        }
        if ($("#nazivulice").val() == 0)
        {
            $("#pogreskaulice").append("Niste unijeli ulicu!<br>");
            $("#nazivulice").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#nazivulice").css('border', '3px #090 solid');
        }
        if ($("#nazivbroj").val() == 0)
        {
            $("#pogreskabroj").append("Niste unijeli broj ulice!<br>");
            $("#nazivbroj").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#nazivbroj").css('border', '3px #090 solid');
        }

        if ($("#kategorija").val() == 0) {
            $("#pogreskakategorija").append("Niste odabrali kategoriju uredaja!<br>")
            $("#kategorija").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#kategorija").css('border', '3px #090 solid');
        }
        latitude = /^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/;
        if (!latitude.test($("#latitude").val())) {
            $("#pogreskalatitude").append("Unijeli ste nepostojeci latitude!<br>");
            $("#latitude").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#latitude").css('border', '3px #090 solid');
        }
        longitude = /^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/;
        if (!longitude.test($("#longitude").val())) {
            $("#pogreskalongitude").append("Unijeli ste nepostojeci longitude!<br>");
            $("#longitude").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#longitude").css('border', '3px #090 solid');
        }

    });
    $("#forma5").on("submit", function (event) {
        $("#pogreskaanketa").html("");
        $("#pogreskakategorijaanketa").html("");
        $("#pogreskaopis").html("");
        if ($("#naziv_ankete").val() == 0)
        {
            $("#pogreskaanketa").append("Niste upisali naziv ankete!<br>");
            $("#naziv_ankete").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#naziv_ankete").css('border', '3px #090 solid');
        }

        if ($("#kategorijaanketa").val() == 0) {
            $("#pogreskakategorijaanketa").append("Niste odabrali kategoriju uredaja za anketu!<br>")
            $("#kategorijaanketa").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#kategorijaanketa").css('border', '3px #090 solid');
        }
        if ($("#opis").val() == 0)
        {
            $("#pogreskaopis").append("Niste opisali anketu!<br>");
            $("#opis").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#opis").css('border', '3px #090 solid');
        }
    });
}
                     

function registracijaFunkcija(){
    $(document).ready(function(){
    $('#korime').keyup(provjeriKorime);
        });
        function provjeriKorime(){
        $("#pogreskakorime2").html("");
        var korime = $('#korime').val();
        jQuery.ajax({
        type:'POST',
                url: 'provjera_korime.php' ,
                data: 'korime=' + korime,
                cache: false,
                success: function(response){
                if (response == 1){
                $('#korime').css('border', '3px #C33 solid');
                $("#pogreskakorime2").append("Korisnicko ime nije slobodno!");
                } else{
                $('#korime').css('border', '3px #090 solid');
                $("#pogreskakorime2").append("Korisnicko ime slobodno!");
                }
                }
        });
        }

    
    $("#forma2").on("submit", function(event) {     
        $("#pogreskakorime1").html("");
        $("#pogreskalozinka1").html("");
        $("#pogreskalozinka2").html("");
        $("#pogreskarodendan").html("");
        $("#pogreskatel").html("");
        $("#pogreskamail").html("");
        $("#svipodaci1").html("");
        $("#pogreskalokacija").html("");
        
        
        if($("#ime").val().length===0){
           $("#ime").css('border', '3px #C33 solid');
        }
        else{
            $("#ime").css('border', '3px #090 solid');
        }
        if($("#prezime").val().length===0){
           $("#prezime").css('border', '3px #C33 solid');
        }
        else{
            $("#prezime").css('border', '3px #090 solid');
        }
        if ($("#korime").attr("type") !== "text")
        {
            $("#pogreskakorime1").append("Korisnicko ime nije tipa (text)!<br>");
            event.preventDefault();
            return;
        }
        pocetno1 = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/; 

        if (!pocetno1.test($("#korime").val())) {
            $("#pogreskakorime1").append("Korisnicko ime mora sadrzavati jedno malo i veliko slovo, jedan broj te jedan specijalni znak!<br>");
            event.preventDefault();
        }

        if(($("#korime").attr("type") !== "text") || (!pocetno1.test($("#korime").val())))
        {
            $("#korime").css('border', '3px #C33 solid');
        }
        else {
            $("#korime").css('border', '3px #090 solid');
        }
        if ($("#lozinka1").attr("type") !== "password")
        {
            $("#pogreskalozinka1").append("Lozinka nije tipa (password)!<br>");
            event.preventDefault();
            return;
        }
        mslovo = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;
        if (!mslovo.test($("#lozinka1").val())) {
            $("#pogreskalozinka1").append("Lozinka mora sadrzavati jedno malo i veliko slovo, jedan broj te jedan specijalni znak!<br>");
            event.preventDefault();
        }
        if(($("#lozinka1").attr("type") !== "password") || (!mslovo.test($("#lozinka1").val())))
        {
            $("#lozinka1").css('border', '3px #C33 solid');
        }
        else {
            $("#lozinka1").css('border', '3px #090 solid');
        }
        if ($("#lozinka1").val() !== $("#lozinka2").val() || $("#lozinka2").val().length===0)
        {
            $("#pogreskalozinka2").append("Lozinke se ne podudaraju!<br>");
            $("#lozinka2").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#lozinka2").css('border', '3px #090 solid');
 
        }
        if ($("#rođendan").attr("type") !== "number")
        {
            $("#pogreskarodendan").append("->Dan nije tipa (number)!<br>");
            event.preventDefault();
            return;
        }
        if ($("#rođendan").val() < 1 || $("#rođendan").val() > 31)
        {
            $("#pogreskarodendan").append("Unijeli ste negativnu vrijednost!<br>");
            $("#rođendan").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#rođendan").css('border', '3px #090 solid');
        }
        if ($("#godina").attr("type") !== "number")
        {
            $("#pogreskarodendan").append("Godina nije tipa (number)!<br>");
            event.preventDefault();
            return;
        }
        if ($("#godina").val() > 2015 || $("#godina").val() < 1930)
        {
            $("#pogreskarodendan").append("Godina mora biti između 1930 i 2015!<br>");
            $("#godina").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#godina").css('border', '3px #090 solid');            
        }
        if($("#mjesec1").val()<1){
            $("#pogreskarodendan").append("Niste unijeli mjesec rodenja!");
            $("#mjesec1").css('border', '3px #C33 solid');
            event.preventDefault();
        }
        else{
            $("#mjesec1").css('border', '3px #090 solid');            
        }
        if ($("#email").attr("type") !== "email")
        {
            $("#pogreskamail").append("Adresa nije tipa (email)!<br>");
            event.preventDefault();
            return;
        }
        adresa = /[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]{2,3}/;
        if (!adresa.test($("#email").val()))    
        {
            $("#pogreskamail").append("Email mora biti tipa: (nesto@nesto.nesto)!<br>"); 
            $("#email").css('border', '3px #C33 solid');
            event.preventDefault();
        } 
        else{
            $("#email").css('border', '3px #090 solid');                                    
        }

    });
}
