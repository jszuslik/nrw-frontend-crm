jQuery(document).ready(function($) {
    $(".nrw-admin-form-input input").focus(function () {
        $(this).parent().addClass("nrw-admin-form-input-focused");
    }).blur(function () {
        $(this).parent().removeClass("nrw-admin-form-input-focused");
    })

    $("select").focus(function () {
        $(this).parent().addClass("nrw-admin-form-input-focused");
    }).blur(function () {
        $(this).parent().removeClass("nrw-admin-form-input-focused");
    })

    $(".nrw_phone").mask("(999) 999-9999", {placeholder:"(XXX) XXX-XXXX"});
    $(".nrw_dob").mask("99/99/9999", {placeholder:"mm/dd/yyyy"});

    $("#nrw_account_revenue").autoNumeric('init');

    var post_title = $("#title");
    $("#title-prompt-text").hide();
    post_title.attr("readonly", true);

    var first_name = $("#nrw_first_name");
    var last_name = $("#nrw_last_name");

    first_name.keyup(function(){
        console.log($(this).val() + ' ' + last_name.val());
        post_title.val($(this).val() + ' ' + last_name.val());
    });
    last_name.keyup(function(){
        console.log(first_name.val() + ' ' + $(this).val());
        post_title.val(first_name.val() + ' ' + $(this).val());
    });

    var account_name = $("#nrw_account_name");
    account_name.keyup(function(){
        post_title.val($(this).val());
    });
});