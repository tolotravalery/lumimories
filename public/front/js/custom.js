function toJSONBody(elements) {
    var res = {};
    for (var i = 0; i < elements.length; ++i) {
        var name = elements[i].name;
        if (name) res[name] = elements[i].value;
    }
    return JSON.stringify(res);
}
let nousContacter = function (url, formId) {
    $('#error').html("");
    $('#success').html("");
    const spinner = $(".btn-nous-contacter >.spinner-border").css('display', 'inline-block');
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            if(data.errors){
                jQuery.each(data.errors, function(key, value){
                    $('#error').append(value+'<br/>');
                });
            }
            if(data.success){
                $('#success').append(data.success);
            }
        },
        error:function (data) {
            console.log(data);
        }
    });
};

let contacterAdmin = function (url, formId) {
    $('#error').html("");
    $('#success').html("");
    const spinner = $(".btn-contacter-admin >.spinner-border").css('display', 'inline-block');
    let tableau =$(formId).serializeArray();
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            if(data.errors){
                jQuery.each(data.errors, function(key, value){
                    $('#error').append(value+'<br/>');
                });
            }
            if(data.success){
                $('#success').append(data.success);
            }
        },
        error:function (data) {
            console.log(data);
        }
    });
};

let allumerBougie = function (image, nom, nbreBougie,parent,dateDeces,dateNaissance,id,age, url, formId) {
    document.getElementById('bougie-gif').src='';
    document.getElementById('bougie-gif').src='https://lumimories.com/public/front/img/bougie.gif';
    $("input[name='profil']").val(id);
    modals(image, nom, nbreBougie,parent,dateDeces,dateNaissance,id,age);
    const spinner = $(".btn-allumer >.spinner-border").css('display', 'inline-block');
    const spinner1 = $(".message-step-1").css('display', 'none');
    const spinner2 = $("#tab2").css('display', 'none');
    const spinner3 = $("#tab3").css('display', 'none');
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            if (data.success) {
                var nbre = Number(data.success);
                $('#nbreIncrementeBougie').html(nbre);
                spinner1.css('display', 'block');
                spinner1.css('margin', '15px 0');
                var nbreOne = Number($('.nbreIncrementeBougie-'+id).html()) + 1;
                $('.nbreIncrementeBougie-'+id).html(nbreOne);
            }
        },
        error:function (data) {
            console.log(data)
        }
    });
};
let dedicace = function (url, formId) {
    const spinner = $(".btn-dedicace >.spinner-border").css('display', 'inline-block');
    $("#tab1").addClass("display-none");
    $("#tab3").addClass("display-none");
    let tableau =$(formId).serializeArray();
    let id = tableau[0].value;
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            if (data.success) {
                var nbre = Number($('.nbreIncrementeBougie-'+id).html());
                $('.nbreIncrementeBougie-'+id).html(nbre);
                $('#tab2').css('display', 'none');
                $('#tab3').css('display', 'block');
            }
        },
        error:function (data) {
            console.log(data);
        }
    });
};

let allumerBougieEtape2 = function (url, formId) {
    const spinner = $(".btn-allumer >.spinner-border").css('display', 'inline-block');
    const spinner1 = $(".bougie-allumer").css('display', 'block');
    $("#tab1").addClass("display-none");
    let tableau =$(formId).serializeArray();
    let id = tableau[0].value;
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            spinner1.css('display', 'none');
            if (data.success) {
                var nbre = Number($('.nbreIncrementeBougie-'+id).html()) + 1;
                $('.nbreIncrementeBougie-'+id).html(nbre);
                $('#tab1').addClass("display-none");
                $('#tab2').removeClass("display-none");
            }
        },
        error:function (data) {
            console.log(data);
        }
    });
};

let allumerBougieGeneral = function (url, formId) {
    document.getElementById('bougie-gif-general').src='';
    document.getElementById('bougie-gif-general').src='https://lumimories.com/public/front/img/bougie.gif';
    const spinner = $(".btn-allumer >.spinner-border").css('display', 'inline-block');
    $('#video-allumer').modal('show');
    let tableau =$(formId).serializeArray();
    $.ajax(url, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        contentType: "application/json",
        data: toJSONBody($(formId).serializeArray()),
        success: function (data) {
            spinner.css('display', 'none');
            $('#video-allumer').modal('hide');
            if (data.success) {
                var nbre = Number(data.success);
                $('.nbreIncrementeBougie').html(nbre);
            }
        },
        error:function (data) {
            console.log(data)
        }
    });
};

let modals = function (image, nom, nbreBougie,parent,dateDeces,dateNaissance,id,age) {
    let img = document.getElementsByClassName("photo-profil");
    for (var i = 0; i < img.length; i++) {
        img.item(i).src = image;
    }
    $("#profil-id").val(id);
    $(".nom").html(nom);
    $(".nbre-bougie").html(nbreBougie);
    $("#nbre").html(nbreBougie);
    $(".parent").html(parent);
    $(".date-deces").html(dateDeces);
    $(".date-naissance").html(dateNaissance);
    $('#nbre').addClass('nbreIncrementeBougie-'+id);
    $('.nbreIncrementeBougie-'+id).html($('.nbreIncrementeBougie-'+id).html());
    $('.age').html(age);
    openModals();
};

let openModals = function () {
    $('#allumer-bougie').modal('show');
    /*$('#tab1').removeClass("display-none");*//*
    $(".bougie-allumer").addClass("display-none");*/
    $('#tab2').addClass("display-none");
    $('#tab3').addClass("display-none");
    return false;
};
var nbre = 0;
$('#Suivre').mouseover(function() {
    if(nbre==0) $('#modal-suivre').modal('show');
    nbre++;
});
$('#Follow').mouseover(function() {
    if(nbre==0) $('#modal-suivre').modal('show');
    nbre++;
});

function dedication() {
    $("#tab1").css('display', 'none');
    $("#tab2").css('display', 'block');
    $("#tab3").css('display', 'none');
}

function share() {
    $("#tab1").css('display', 'none');
    $("#tab2").css('display', 'none');
    $("#tab3").css('display', 'block');
}