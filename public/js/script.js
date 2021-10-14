$(function () {
    $("#delete-confirmation").on("show.bs.modal", function(e) {
        $(this).find(".btn-success").attr("href", $(e.relatedTarget).attr("href"));
    });

    // just to be sure nothing is left behind
    $("#delete-confirmation").on("hide.bs.modal", function(e) {
        $(this).find(".btn-success").attr("href", "#");
    });

    // create ad / homepage filters
    (function () {
        var categories = $("#ad-id-category"),
            isInitialCategory = !!categories.val(),
            subcategories = $("#ad-id-subcategory");

        if (typeof tinymce !== "undefined") {
            tinymce.init({
                selector: "textarea",
                branding: false
            });
        }

        subcategories.find("option[value!='']").hide();

        categories.on("change", function () {
            var category = $.trim($(this).val());

            if (!isInitialCategory) {
                subcategories.find("option[value!='']").removeAttr("selected").hide();
                subcategories.val("");
            }

            subcategories.find("option[data-category='" + category + "']").show();
        });

        if (categories.val()) {
            categories.trigger("change");
            isInitialCategory = false;
        }
    }());
});
