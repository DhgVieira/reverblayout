$(function() {
    $(".reply-comment-btn").on("click", function() {
        console.log('click')
        $(this).toggleClass("active");
        $(this).closest(".data-content").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
    });
})