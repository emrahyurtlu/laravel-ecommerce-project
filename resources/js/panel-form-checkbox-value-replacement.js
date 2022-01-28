$(document).ready(function () {
    $(".form-check-input").on("click", function () {
        let $element = $(this);
        if ($element.prop("checked")) {
            $element.attr("value", 1);
        } else {
            $element.attr("value", 0);
        }
    })
})
