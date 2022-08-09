(function ($) {
    "use strict";
    $(window).on('load', function () {
        $('#preloader').fadeOut();
    });
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            $(".sticky-menu").addClass("hidden")
        }
        else{
            $(".sticky-menu").removeClass("hidden")
        }
    });
    var owl = $("#reccomended");
    owl.owlCarousel({
        center: true,
        items: 2,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {0: {items: 1}, 600: {items: 2}, 1000: {items: 4}}
    });
    var owl1 = $("#anecdote-carousel");
    owl1.owlCarousel({
        center: true,
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        dots: false,
        nav:true,
        navText: ["<i class='fa fa-3x fa-angle-left'></i>","<i class='fa fa-3x fa-angle-right'></i>"],
        responsive: {0: {items: 1}, 600: {items: 1}, 1000: {items: 1}}
    });


}(jQuery));

$(document).ready(function(){
    $(".collapse.show").each(function(){
        $(this).prev(".card-header").find(".fa-angle-down").addClass("fa-angle-down").removeClass("fa-angle-right");
    });
    $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa-angle-right").removeClass("fa-angle-right").addClass("fa-angle-down");
    }).on('hide.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-right");
    });
});

function scrollRecherche(){
    $('html, body').animate({
        scrollTop: $("#recherche").offset().top - 100
    }, 1000);
}

function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

function boutonHandicape() {
    if ($(".menu-container").hasClass("hidden") == true) {
        $(".menu-container").removeClass("hidden");
        $(".menu-container").addClass("visible");
    } else {
        $(".menu-container").removeClass("visible");
        $(".menu-container").addClass("hidden");
    }
}

if (sessionStorage.getItem("zoom-in") == "active") {
    zoomIn();
}

function zoomIn() {
    if ($("#zoom-in").hasClass("active") == false) {
        sessionStorage.setItem("zoom-in", "active");
        $("#page").animate({'zoom': 1.2}, 400);
        $("#zoom-in").addClass("active");
    } else {
        sessionStorage.setItem("zoom-in", "not-active");
        $("#page").animate({'zoom': 1.0}, 400);
        $("#zoom-in").removeClass("active");
    }
}

if (sessionStorage.getItem("larger-zoom") == "active") {
    largerZoom();
}

function largerZoom() {
    if ($("#larger-zoom").hasClass("active") == false) {
        sessionStorage.setItem("larger-zoom", "active");
        $("#page").animate({'zoom': 1.4}, 400);
        $("#larger-zoom").addClass("active");
    } else {
        sessionStorage.setItem("larger-zoom", "not-active");
        $("#page").animate({'zoom': 1.0}, 400);
        $("#larger-zoom").removeClass("active");
    }
}

function normalZoom() {
    $("#page").animate({'zoom': 1.0}, 400);
    $("#larger-zoom").removeClass("active");
    $("#zoom-in").removeClass("active");
}

function fermerBoutonHandicape() {
    $(".menu-container").removeClass("visible");
    $(".menu-container").addClass("hidden");
}

if (sessionStorage.getItem("stop-animation") == "active") {
    stopAnimation();
}

function stopAnimation() {
    if ($("#stop-animation").hasClass("active") == false) {
        sessionStorage.setItem("stop-animation", "active");
        $("#reccomended").trigger('stop.owl.autoplay');
        $("#anecdote-carousel").trigger('stop.owl.autoplay');
        $("#stop-animation").addClass("active");
    } else {
        sessionStorage.setItem("stop-animation", "not-active");
        $("#reccomended").trigger('play.owl.autoplay');
        $("#anecdote-carousel").trigger('play.owl.autoplay');
        $("#stop-animation").removeClass("active");
    }
}

if (sessionStorage.getItem("underline-links") == "active") {
    underlineLinks();
}

function underlineLinks() {
    if ($("#underline-links").hasClass("active") == false) {
        sessionStorage.setItem("underline-links", "active");
        $("#underline-links").addClass("active");
        $("a").addClass("underline");
        $("button").addClass("underline");
    } else {
        sessionStorage.setItem("underline-links", "not-active");
        $("#underline-links").removeClass("active");
        $("a").removeClass("underline");
        $("button").removeClass("underline");
    }
}

if (sessionStorage.getItem("high-contrast") == "active") {
    highContrast();
}

function highContrast() {
    if ($("#high-contrast").hasClass("active") == false) {
        sessionStorage.setItem("high-contrast", "active");
        $("#high-contrast").addClass("active");
        $("#main-body").addClass("high-contrast");
        $("h1,h2,h3,h4,h5,h6,header,footer,p,nav,main,div,a,button,label").addClass("high-contrast");
        $("i").addClass("high-contrast-i");
    } else {
        sessionStorage.setItem("high-contrast", "not-active");
        $("#high-contrast").removeClass("active");
        $("#main-body").removeClass("high-contrast");
        $("h1,h2,h3,h4,h5,h6,header,footer,p,nav,main,div,a,button,label").removeClass("high-contrast");
        $("i").removeClass("high-contrast-i");
    }
}

if (sessionStorage.getItem("readable-font") == "active") {
    readableFont();
}

function readableFont() {
    if ($("#readable-font").hasClass("active") == false) {
        sessionStorage.setItem("readable-font", "active");
        $("#readable-font").addClass("active");
        $("body").addClass("readable-font");
    } else {
        sessionStorage.setItem("readable-font", "not-active");
        $("#readable-font").removeClass("active");
        $("body").removeClass("readable-font");
    }
}
$(window).scroll(function(){
    var y = $(window).scrollTop();
    if(y > 0){
        $('.header_sticky').css({'position': 'fixed'});
        $('main').css({'padding-top': '5%'});
    } else{
        $('.header_sticky').css({'position': 'relative'});
        $('main').css({'padding-top': '0'});
    }
});
function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
        $("#eye").removeClass("fa-eye");
        $("#eye").addClass("fa-eye-slash");
    } else {
        x.type = "password";
        $("#eye").addClass("fa-eye");
        $("#eye").removeClass("fa-eye-slash");
    }
}
function showPassword1() {
    var x = document.getElementById("password1");
    if (x.type === "password") {
        x.type = "text";
        $("#eye1").removeClass("fa-eye");
        $("#eye1").addClass("fa-eye-slash");
    } else {
        x.type = "password";
        $("#eye1").addClass("fa-eye");
        $("#eye1").removeClass("fa-eye-slash");
    }
}
var check = 2;
function seemore(nbreLigne) {
    $(".afficher-"+nbreLigne).removeClass("hidden");
    $t = nbreLigne-1;
    $(".bouton-"+ $t).addClass("hidden");
    if(check === nbreLigne){
        $(".bouton-"+ nbreLigne).removeClass("hidden");
        check++;
    }
}
function showListBy(gender) {
    if(gender === "Tous"){
        $('.Homme').removeClass("hidden");
        $('.Femme').removeClass("hidden");
        return false;
    }
    var nogender = "";
    if(gender === "Homme") nogender = "Femme";
    else if(gender === "Femme") nogender = "Homme";
    $("."+nogender).addClass("hidden");
    $("."+gender).removeClass("hidden");
}
