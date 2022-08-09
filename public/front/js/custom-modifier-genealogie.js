function toJSONBody(elements) {
    var res = {};
    for (var i = 0; i < elements.length; ++i) {
        var name = elements[i].name;
        if (name) res[name] = elements[i].value;
    }
    return JSON.stringify(res);
}
let modifierGenealogie = function (url, formId) {
    $('#error').html("");
    $('#success').html("");
    const spinner = $(".btn-modifier-genealogie >.spinner-border").css('display', 'inline-block');
    console.log(toJSONBody($(formId).serializeArray()))
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
                    $('#success').css('display','none');
                    $('#error').css('display','block');
                });
            }
            if(data.success){
                $('#success').append(data.success);
                $('#error').css('display','none');
                $('#success').css('display','block');
            }
        },
        error:function (data) {
            console.log(data);
        }
    });
};