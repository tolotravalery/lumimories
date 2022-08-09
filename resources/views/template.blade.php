<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="keywords" content="{{$meta_keywords}}">
    <meta name="author" content="Raphael Zini">

    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:url" content="{{ URL::full() }}"/>
    <meta property="og:description" content="{{ $meta_description }}">
    <meta property="og:image" content="{{ $meta_image }}">

    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset("public/front/img/favicon.ico") }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link href="{{ asset("public/front/css/bootstrap.min.css") }}" rel="stylesheet">
    <link id="css-style" href="{{ asset("public/front/css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("public/front/css/menu.css") }}" rel="stylesheet">
    <link href="{{ asset("public/front/css/vendors.css") }}" rel="stylesheet">
    <link href="{{ asset("public/front/css/icon_fonts/css/all_icons_min.css") }}" rel="stylesheet">
    <link href="{{ asset("public/front/css/custom.css") }}" rel="stylesheet">
    <link href="{{ asset("public/front/css/jquery-ui.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("public/front/css/font-awesome.min.css") }}">
    @yield("custom-css")
</head>

<body id="main-body">
@yield("facebook-js")
<div id="preloader" class="Fixed">
    <div data-loader="circle-side"></div>
</div>
<div id="page">
    <header class="header_sticky">
        <a class="btn_mobile" onclick="openNav()">
            <div class="hamburger hamburger--spin" id="hamburger">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
        </a>
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <nav id="menu" class="main-menu float-left">
                        <ul id="top_access">
                            <li><h1><a href="{{ url('/') }}" title="lumimories">Lumimories</a></h1></li>
                            <li><a href="{{ url('/ajout-profil') }}"
                                   class="btn-header white display-inherit"><i class="fa fa-plus-square-o"></i> <span class="font-weight-bold">{{ __('website.register-a-loved-one') }}</span> </a></li>
                            <li><a href="{{ url('/') }}" class="page-scroll display-inherit surligne-hover"><i class="fa fa-search"></i> <span class="font-weight-bold"> {{ __('website.search') }} </span> </a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-5">
                    <nav id="menu" class="main-menu height-100-100">
                        <ul id="top_access" class="height-100-100">
                            @if(Config::get('app.locale')!="en")
                                <li class="text-center">
                                    <a href="{{ url('/locale/en') }}" class="surligne-hover">
                                        <i class="fa fa-globe"></i>
                                        English</a>
                                </li>
                            @endif
                            @if(Config::get('app.locale')!="fr")
                                <li class="text-center">
                                    <a href="{{ url('/locale/fr') }}" class="surligne-hover">
                                        <i class="fa fa-globe"></i>Français</a>
                                </li>
                            @endif
                            <li class="text-center">
                                <a href="{{ route('mes-proches') }}" class="surligne-hover">
                                    <i class="fa fa-heart"></i>
                                    {{ __('website.my-relatives') }}
                                </a>
                            </li>
                            @if(Auth::check())
                                <li class="text-center">
                                    <a class="surligne-hover dropdown dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><span>
                                            @if(Auth::user()->name == null && Auth::user()->prenom == null)
                                                {{ Auth::user()->email }}
                                            @elseif(Auth::user()->name != null && Auth::user()->prenom == null)
                                                {{ Auth::user()->name }}
                                            @elseif(Auth::user()->prenom != null  && Auth::user()->name == null)
                                                {{ Auth::user()->prenom }}
                                            @elseif(Auth::user()->name != null && Auth::user()->prenom != null)
                                                {{ Auth::user()->prenom }}
                                            @endif
                                            <i class="fa fa-caret-down"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('mon-compte-get') }}">
                                            {{ __('website.my-account') }}
                                        </a>
                                        <div class="divider-extra"></div>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">{{ __('website.sign-out') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endif
                            @if(Auth::check()==false)
                                <li class="text-center">
                                    <a href="{{ url('/login-front') }}" class="surligne-hover">
                                        <i class="fa fa-user"></i>{{ __('website.sign-in') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-12" id="logo-mobile">
                    <h1 id="logo-mobile-h1"><a href="{{ url('/') }}" title="lumimories">Lumimories</a></h1>
                </div>
                {{--<div class="col-lg-3 col-6">
                    <div id="logo_home">
                        <h1><a href="{{ url('/') }}" title="lumimories">Lumimories</a></h1>
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <nav id="menu" class="main-menu">
                        <ul id="top_access">
                            <li><h1><a href="{{ url('/') }}" title="lumimories">Lumimories</a></h1></li>
                            <li><a href="{{ url('/ajout-profil') }}"
                                   class="btn-header"><i class="fa fa-2x fa-plus-square-o"></i> {{ __('website.register-a-loved-one') }} </a></li>
                            <li><a href="{{ url('/ajout-profil') }}"><i class="fa fa-2x fa-search"></i> {{ __('website.register-a-loved-one') }} </a></li>
                            @if(Auth::check())
                                <li><a>{{ Auth::user()->email }}</a></li>
                                <li><a data-toggle="modal" data-target="#logoutModal"><i
                                            class="pe-7s-power font-size-34"></i></a></li>
                            @endif
                            @if(Auth::check()==false)
                                <li><a href="{{ url('/login-front') }}">{{ __('website.sign-in') }}</a></li>
                            @endif
                            @if(Config::get('app.locale')!="en")
                                <li><a href="{{ url('/locale/en') }}">English</a></li>
                            @endif
                            @if(Config::get('app.locale')!="fr")
                                <li><a href="{{ url('/locale/fr') }}">Français</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>--}}
                <div id="mySidebar" class="sidebar">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                    @if(Auth::check())
                        {{ Auth::user()->email }}
                    @endif
                    <a href="{{ url('/ajout-profil') }}" class="btn-header">{{ __('website.register-a-loved-one') }} <i
                            class="pe-7s-plus font-weight-bolder"></i></a>
                    @if(Auth::check()==false)
                        <a href="{{ url('/login-front') }}">{{ __('website.sign-in') }}</a>
                    @endif
                    @if(Config::get('app.locale')!="en")
                        <a href="{{ url('/locale/en') }}">English</a>
                    @endif
                    @if(Config::get('app.locale')!="fr")
                        <a href="{{ url('/locale/fr') }}">Français</a>
                    @endif
                    <a href="{{ route('mes-proches') }}">{{ __('website.my-relatives') }}</a>
                    @if(Auth::check())
                        <a data-toggle="modal" data-target="#logoutModal"><i class="pe-7s-power font-size-34"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <main>
        <div id="bouton-handicape">
            <div class="icone" onclick="boutonHandicape()">
                <img src="{{ asset("public/front/img/negishut-left.png") }}" alt="wheelchair" id="icone-handicape">
            </div>
            <div class="menu-container hidden">
                <ul>
                    <li id="high-contrast" onclick="highContrast()"><span>{{ __('website.high-contrast') }} <i
                                class="fa fa-adjust"></i></span></li>
                    <li id="mono-chrome" onclick="monoChrome()"><span>{{ __('website.mono-chrome') }} <i
                                class="fa fa-pencil"></i></span></li>
                    <li id="underline-links" onclick="underlineLinks()"><span>{{ __('website.underline-links') }} <i
                                class="fa fa-link"></i></span></li>
                    <li id="zoom-in" onclick="zoomIn()"><span>{{ __('website.zoom-in') }} <i
                                class="fa fa-font"></i></span></li>
                    <li id="larger-zoom" onclick="largerZoom()"><span>{{ __('website.larger-zoom') }} <i
                                class="fa fa-font"></i></span></li>
                    <li id="normal-zoom" onclick="normalZoom()"><span>{{ __('website.normal-zoom') }} <i
                                class="fa fa-font"></i></span></li>
                    <li id="readable-font" onclick="readableFont()"><span>{{ __('website.readable-font') }} <i
                                class="fa fa-link"></i></span></li>
                    <li id="stop-animation" onclick="stopAnimation()"><span>{{ __('website.stop-animation') }} <i
                                class="fa fa-stop-circle-o"></i></span></li>
                    <li id="clear-settings" onclick="clearSettings()"><span>{{ __('website.clear-accessibility-settings') }} <i
                                class="fa fa-recycle"></i></span></li>
                    <li id="accessibility-statement"><span>{{ __('website.accessibility-statement') }} <i
                                class="fa fa-stop-circle-o"></i></span></li>
                    <li id="fermer-bouton-handicape" onclick="fermerBoutonHandicape()"><span>{{ __('website.close-accessibility-menu') }} <i
                                class="fa fa-window-close"></i></span></li>
                </ul>
            </div>
        </div>
        @yield("content")
    </main>
    <footer>
        <div class="container margin_60_35">
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <ul id="additional_links">
                        <li><a href="#0">Terms and conditions</a></li>
                        <li><a href="#0">Privacy</a></li>
                        <li><a href="{{ url('/nous-contacter') }}">{{ __('website.contact-us') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div id="copy">© Copyright by L'atelier du net - 2021</div>
                </div>
            </div>
        </div>
    </footer>
</div>
<div id="toTop"></div>
@yield("modal")
@if(Auth::check())
    @include('modals.modal-logout')
@endif
<script src="{{ asset("public/front/js/jquery-3.5.1.min.js") }}"></script>
{{--<script src="{{ asset("public/front/js/jquery-1.12.4.js") }}"></script>--}}
<script src="{{ asset("public/front/js/jquery-ui.js") }}"></script>
<script src="{{ asset("public/front/js/recherche.js") }}"></script>
<script src="{{ asset("public/front/js/common_scripts.min.js") }}"></script>
<script src="{{ asset("public/front/js/function.js") }}"></script>
{{--<script src="{{ asset("public/front/js/wow.js") }}"></script>--}}
<script>
    if (sessionStorage.getItem("mono-chrome") == "active") {
        monoChrome();
    }

    function monoChrome() {
        if ($("#mono-chrome").hasClass("active") == false) {
            sessionStorage.setItem("mono-chrome", "active");
            $("#mono-chrome").addClass("active");
            $("#css-style").attr("href", "{{ asset('public/front/css/style-monochrome.css') }}");
            $("#icone-handicape").addClass("monochrome");
        } else {
            sessionStorage.setItem("mono-chrome", "not-active");
            $("#mono-chrome").removeClass("active");
            $("#css-style").attr("href", "{{ asset('public/front/css/style.css') }}");
            $("#icone-handicape").removeClass("monochrome");
        }
    }

    function clearSettings() {
        sessionStorage.clear();
        $("#page").animate({'zoom': 1.0}, 400);
        $("#zoom-in").removeClass("active");
        $("#larger-zoom").removeClass("active");
        $("#reccomended").trigger('play.owl.autoplay');
        $("#anecdote-carousel").trigger('play.owl.autoplay');
        $("#stop-animation").removeClass("active");
        $("#underline-links").removeClass("active");
        $("a").removeClass("underline");
        $("button").removeClass("underline");
        $("#high-contrast").removeClass("active");
        $("#main-body").removeClass("high-contrast");
        $("h1,h2,h3,h4,h5,h6,header,footer,p,nav,main,div,a,button,label").removeClass("high-contrast");
        $("i").removeClass("high-contrast-i");
        $("#readable-font").removeClass("active");
        $("body").removeClass("readable-font");
        $("#mono-chrome").removeClass("active");
        $("#css-style").attr("href", "{{ asset('public/front/css/style.css') }}");
    }
</script>
@yield("custom-js")
</body>
</html>
