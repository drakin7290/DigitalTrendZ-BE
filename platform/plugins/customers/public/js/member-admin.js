$(document).ready((function () {
    console.log("HI");
    $(document).on("click", "#is_change_password", (function (e) {
        $(e.currentTarget).is(":checked") ? $("input[type=password]").closest(".form-group").removeClass("hidden").fadeIn() : $("input[type=password]").closest(".form-group").addClass("hidden").fadeOut()
    }))
}));