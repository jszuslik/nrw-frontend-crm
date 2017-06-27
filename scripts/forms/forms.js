jQuery(document).ready(function($) {
    $("input").focus(function () {
        $(this).parent().addClass("nrw-admin-form-input-focused");
    }).blur(function () {
        $(this).parent().removeClass("nrw-admin-form-input-focused");
    })

    $("select").focus(function () {
        $(this).parent().addClass("nrw-admin-form-input-focused");
    }).blur(function () {
        $(this).parent().removeClass("nrw-admin-form-input-focused");
    })
});