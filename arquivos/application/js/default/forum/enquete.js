reverb.fillPolls = function () {
    $(".poll-item").on("click", function (e) {
        var t = $(this).find("input");
        var n = t.attr("type");
        if (n == "checkbox") {
            var r = t.is(":checked");
            if (r) {
                t.prop("checked", false);
                t.parent().removeClass("active")
            } else {
                t.prop("checked", true);
                t.parent().addClass("active")
            }
        } else if (n == "radio") {
            $(".poll-item-check").removeClass("active").find("input").prop("checked", false);
            t.parent().addClass("active").find("input").prop("checked", true)
        }
    })
};
reverb.validationForm = function () {
    var e = "Campo obrigatório";
    $("#form-irregularidades").validate({
        messages: {
            irregularidadenome: e,
            irregularidademail: e,
            irregularidadetxt: e
        }
    })
};
reverb.results = function () {
    $.each($(".result-bar .progress"), function (e, t) {
        $(this).css("width", $(this).data("value"))
    });
    $(".reply-comment-btn").on("click", function () {
        $(this).toggleClass("active");
        $(this).closest(".comments-item").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
    });
    if (!reverb.isMobile()) {
        tinymce.init({
            selector: ".tynemce-on",
            theme: "modern",
            skin: "light",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    }
};
reverb.polls = function () {
    $("#form-pesquisar-post .search-input").autocomplete({
        source: function (e, t) {
            $.ajax({
                url: document.basePath + "/json/autocompleteenquete/",
                data: {filter: e.term},
                dataType: "json",
                success: function (e) {
                    t(e)
                }
            })
        }, appendTo: "#form-pesquisar-post", delay: 500, minLength: 3
    })
};
reverb.circliful = function() {
    if($( ".resultado").length > 0) {
        $( ".resultado" ).each(function( index ) {
            $('#' + $(this).attr('id')).circliful();
        });
    }
};

$(function () {
    reverb.fillPolls();
    reverb.validationForm();
    reverb.results();
    reverb.polls();
    reverb.circliful();
})