var countPrenom= 2;
function ajouterPrenom() {
    var wrapper = $(".field-ajouter-prenom");
    $(wrapper).append('<div class="display-flex"><input type="text" name="prenom'+countPrenom+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
    countPrenom++;
    remove(wrapper);
}
var countVille= 2;
function ajouterVille() {
    var wrapper = $(".field-ajouter-ville");
    $(wrapper).append('<div class="display-flex"><input type="text" name="villesHabitee'+countVille+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
    countVille++;
    remove(wrapper);
}
var countSurnom = 2;
function ajouterSurnom() {
    var wrapper = $(".field-ajouter-surnom");
    $(wrapper).append('<div class="display-flex"><input type="text" name="surnom'+countSurnom+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
    countSurnom++;
    remove(wrapper);
}
function remove(wrapper) {
    $(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });
}
