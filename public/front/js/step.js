var currentTab = 0;
showTab(currentTab);

function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.pointerEvents = "all";
    x[n].style.display = "block";
    x[n].style.backgroundColor = "white";
    x[n].style.opacity = "inherit";
    x[n].style.cursor = "inherit";
    console.log("CURRENT = " + n);
    for (var i = 0; i < x.length; i++) {
        if (i != n) {
            x[i].removeAttribute('style');
        }
    }
    if (n > 0) {
        /*$('html, body').animate({
            scrollTop: $("#tab-"+n).offset().top ,
        }, 1000);*/
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
        var currentTab = n - 1;
        x[currentTab].style.display = "none";
        x[currentTab].style.pointerEvents = "none";
        x[currentTab].style.backgroundColor = "#dee2e6";
        x[currentTab].style.opacity = "0.5";
        x[currentTab].style.cursor = "not-allowed";
        x[currentTab].style.transition = "height 0.5s linear";
        /*$('html, body').animate({
            scrollTop: '50%'
        }, 1000);*/
    }

    if (n == 0) {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("nextBtn").style.display = "inline";
        $(".btn-ajouter-profil").addClass("display-none");
    }
    if (n === (x.length - 1)) {
        $(".btn-ajouter-profil").removeClass("display-none");
        document.getElementById("nextBtn").style.display = "none";
    } else {
        x[n + 1].style.display = "block";
        //document.getElementById("nextBtn").innerHTML = "Continuer1";
        document.getElementById("nextBtn").style.display = "inline";
    }
}

function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    if (n == 1 && !validateForm()) return false;
    var before = currentTab;
    $("#form-error-" + before).addClass("display-none");
    currentTab = currentTab + n;
    if (before > currentTab) {
        var x, y, i = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab + 1].getElementsByTagName("input");
        z = x[currentTab + 1].getElementsByClassName("step-sub-title");
        for (i = 0; i < y.length; i++) {
            if (y[i].value != "") {
                var classnameInput = y[i].className.split(" invalid");
                y[i].className = classnameInput[0];
            }
        }
    }
    if (currentTab >= x.length) {
        $(".step-navigation").addClass("display-none");
        $("#message-erreur").removeClass("display-none");
        return false;
    }
    showTab(currentTab);
}

function validateForm() {
    var x, y, i, valid = true;
    //radio button
    var isValid = $("input[name=sexe]").is(":checked");
    //radio button
    if(isValid === false){
        $(".radio-sexe").addClass('invalid-text');
        $("#form-error-" + currentTab).removeClass("display-none");
        valid = false;
    }
    else {
        $(".radio-sexe").removeClass('invalid-text');
        $("#form-error-" + currentTab).addClass("display-none");
    }
    /*$("#biographie").val(CKEDITOR.instances.biographiename.getData());*/

    x = document.getElementsByClassName("tab");
    //y = x[currentTab].getElementsByTagName("input");
    y = x[currentTab].querySelectorAll("input.requis");
    y1 = x[currentTab].querySelectorAll("select.requis");
    z = x[currentTab].getElementsByClassName("step-sub-title");
    for (i = 0; i < y1.length; i++) {
        if (y1[i].value == "") {
            var name = "." + y1[i].id;
            if (y1[i].id == "situation") $(name).addClass("button-invalid");
            y1[i].className += " invalid";
            z[i].className += " text-error";
            valid = false;
            $("#form-error-" + currentTab).removeClass("display-none");
        } else {
            var classnameInput = y1[i].className.split(" invalid");
            y1[i].className = classnameInput[0];
            var classnameText = z[i].className.split(" text-error");
            z[i].className = classnameText[0];
        }
    }
    for (i = 0; i < y.length; i++) {
        if (y[i].value == "") {
            var name = "." + y[i].id;
            if (y[i].id == "situation") $(name).addClass("button-invalid");
            y[i].className += " invalid";
            z[i].className += " text-error";
            valid = false;
            $("#form-error-" + currentTab).removeClass("display-none");
        } else {
            var classnameInput = y[i].className.split(" invalid");
            y[i].className = classnameInput[0];
            var classnameText = z[i].className.split(" text-error");
            z[i].className = classnameText[0];
        }
    }
    if (valid) {
    }
    return valid;
}


function openNomDeJeuneFille() {
    var sexe = $("input[type='radio'][name='sexe']:checked").val();
    if (sexe == "Femme") {
        $(".nom-de-jeune-fille").addClass('nom-de-jeune-fille-block');
    } else if (sexe == "Homme") {
        $(".nom-de-jeune-fille").removeClass('nom-de-jeune-fille-block');
    }
}


$('#autre').on('input', function (e) {
    $('#situation').val($('#autre').val());
});

$(document).keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        var x = document.getElementsByClassName("tab");
        if (!validateForm()) {
            return false;
        }
        if (currentTab == x.length - 1) {
            $("#form-ajouter-profil").submit();
            return false;
        }
        x[currentTab].style.display = "none";
        var before = currentTab;
        $("#form-error-" + currentTab).addClass("display-none");
        currentTab = currentTab + 1;
        if (before > currentTab) {
            var x, y, i = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab + 1].getElementsByTagName("input");
            z = x[currentTab + 1].getElementsByClassName("step-sub-title");
            for (i = 0; i < y.length; i++) {
                if (y[i].value != "") {
                    var classnameInput = y[i].className.split(" invalid");
                    y[i].className = classnameInput[0];
                    var classnameText = z[i].className.split(" text-error");
                    z[i].className = classnameText[0];
                }
            }
        }
        if (currentTab >= x.length) {
            $(".step-navigation").addClass("display-none");
            $(".progress-bar").animate({
                width: "100 %"
            }, 200);
            $("#bar-value").html("100 %");
            $("#message-erreur").removeClass("display-none");
            return false;
        }
        showTab(currentTab);
    }
});

function addPhotos() {
    $("#photo-profil")[0].files.length === 0 ? $("#photo-profil-check").hide() : $("#photo-profil-check").show();
}



