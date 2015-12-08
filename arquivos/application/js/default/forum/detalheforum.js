reverb.detalheForum = function() {
    if (!reverb.isMobile()) {
        tinymce.init({
            theme: "modern",
            skin: "light",
            selector: "textarea.message-box",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    } else {
        tinymce.init({
            theme: "modern",
            skin: "light",
            selector: "textarea.message-box",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    }
    $(".reply-comment-btn").on("click", function() {
        $(this).toggleClass("active");
        $(this).closest(".about-this-post").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
    });
    $("#form-pesquisar-post .search-input").autocomplete({
        source: function(e, t) {
            $.ajax({
                url: document.basePath + "/json/autocompleteforum/",
                data: {
                    filter: e.term
                },
                dataType: "json",
                success: function(e) {
                    t(e)
                }
            })
        },
        delay: 500,
        minLength: 3
    })
};

reverb.timeAgo = function() {
    $("abbr.timeago").timeago();
};
$(function() {
    reverb.detalheForum();
    reverb.timeAgo();
});
