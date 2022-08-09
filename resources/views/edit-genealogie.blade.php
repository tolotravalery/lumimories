@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="step-block" style="height: auto!important;">
                        <form id="form-modifier-genealogie" action="{{ route('modifier-genealogie') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $profil->id }}">
                            @if (session('message'))
                                <p class="step-title text-center text-{{ session('css') }}">{{ session('message') }}</p>
                            @endif
                            <div class="tab" id="tab-0">
                                <p class="step-title text-center">{{ __('website.his-genealogy')." ".__('website.of')." ".$profil->nomFirstProfil() }}</p>
                                <p class="step-sub-title text-center">{{ __('website.list-family-members') }}</p>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-father') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomPere" name="nomPere" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[0]) == true ? "" : $genealogie[0][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomPereNumber" id="nomPereNumber" value="{{ empty($genealogie[0]) == true ? "" : $genealogie[0][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-mother') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomMere" name="nomMere" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[1]) == true ? "" : $genealogie[1][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomMereNumber" id="nomMereNumber" value="{{ empty($genealogie[1]) == true ? "" : $genealogie[1][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.husbands-name')  }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCH" name="nomCH" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[4]) == true ? "" : $genealogie[4][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomCHNumber" id="nomCHNumber" value="{{ empty($genealogie[4]) == true ? "" : $genealogie[4][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.wifes-name') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCF" name="nomCF" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[5]) == true ? "" : $genealogie[5][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomCFNumber" id="nomCFNumber" value="{{ empty($genealogie[5]) == true ? "" : $genealogie[5][0][0] }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-brothers') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter">
                                        <input type="text" id="nomFreres0" name="nomFreres[]" class="not-required highlight-input-text recherche mb-moin-10" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomFreresNumber[]" id="nomFreres0Number" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][0][0] }}">
                                        @for($i = 1 ; $i< count($genealogie[2]); $i++)
                                            <input type="text" id="nomFreres{{ $i }}" name="nomFreres[]" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][$i][1] }}">
                                            <input type="hidden" name="nomFreresNumber[]" id="nomFreres{{ $i }}Number" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][$i][0] }}">
                                        @endfor
                                        <button class="btn-supl" id="ajouter-frere" onclick="ajouterFrere()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-brother') }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-sisters') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter1">
                                        <input type="text" id="nomSoeurs0" name="nomSoeurs[]" class="not-required highlight-input-text recherche mb-moin-10" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs0Number" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][0][0] }}">
                                        @for($i = 1 ; $i< count($genealogie[3]); $i++)
                                            <input type="text" id="nomSoeurs{{ $i }}" name="nomSoeurs[]" class="not-required highlight-input-text recherche" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][$i][1] }}">
                                            <input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs{{ $i }}Number" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][$i][0] }}">
                                        @endfor
                                        <button class="btn-supl" id="ajouter-soeur" onclick="ajouterSoeur()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-sister') }}</button>
                                    </div>
                                </div>
                                <div class="new-input">
                                    <input type="hidden" value="1" id="total-input-text">
                                </div>
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-4">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="submit" class="btn btn-common btn-modifier-genealogie">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.edit-modif') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sexe">
@endsection
@section('custom-js')
    <script src="{{ asset("public/front/js/step.js") }}"></script>
    <script>
        function changeSexe(value){
            $('#sexe').val(value)
        }
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = "{{ route('autocomplete') }}";
        function extractLast( term ) {
            return split( term ).pop();
        }
        function split( val ) {
            return val.split( /,\s*!/ );
        }
        var urlAutre = "{{ route('autocompleteautre') }}";

        $(".recherche").each(function() {
            $(this).autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url, {
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            term: extractLast(request.term),
                            sexe: $('#sexe').val()

                        }),
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    terms.pop();
                    terms.push(ui.item.label);
                    terms.push("");
                    this.value = terms.join("");
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#" + status + "Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    $("#" + status + "Number").val("");
                    $(this).removeClass("highlight-input-text");
                } else {
                    console.log("not deete")
                }
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li><div><img src='" + item.image + "'><span>" + item.label + "</span></div></li>").appendTo(ul);
            };
        });

        var wrapper = $(".field-ajouter");
        var wrapper1 = $(".field-ajouter1");
        var x = {{ count($genealogie[2]) == 0 ? 1 :  count($genealogie[2])}};
        var y = {{ count($genealogie[3]) == 0 ? 1 :  count($genealogie[3])}};
        function ajouterFrere() {
            $(wrapper).append('<div class="display-flex"><input type="text" name="nomFreres[]" id="nomFreres'+x+'" class="not-required recherche nomFreres"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomFreresNumber[]" id="nomFreres'+x+'Number"></div>');
            $('.nomFreres').on('input',function (e) {
                $('#sexe').val("Homme")
            })
            $(".recherche").autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url,{
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            term: extractLast(request.term),
                            sexe: $('#sexe').val()
                        }),
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function() {
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    terms.pop();
                    terms.push( ui.item.label );
                    terms.push("");
                    this.value = terms.join( "" );
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val("");
                    $(this).removeClass("highlight-input-text");
                } else {
                    console.log("not deete")
                } });
            x++;
        }
        $(wrapper).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        function ajouterSoeur() {
            $(wrapper1).append('<div class="display-flex"><input type="text" name="nomSoeurs[]" id="nomSoeurs'+y+'" class="not-required recherche nomSoeurs"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs'+y+'Number"></div>');
            $('.nomSoeurs').on('input',function (e) {
                $('#sexe').val("Femme")
            })
            $(".recherche").autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url,{
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            term: extractLast(request.term),
                            sexe: $('#sexe').val()
                        }),
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function() {
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    terms.pop();
                    terms.push( ui.item.label );
                    terms.push("");
                    this.value = terms.join( "" );
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val("");
                    $(this).removeClass("highlight-input-text");
                } else {
                    console.log("not deete")
                } });
            y++;
        }
        $(wrapper1).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        function remove(wrapper) {
            $(wrapper).on("click", ".remove_field", function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
            });
        }

    </script>
@endsection
