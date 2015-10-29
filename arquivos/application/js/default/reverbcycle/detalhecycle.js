reverb.cycle = function() {
    $("#carousel-cycle").owlCarousel({
        paginationSpeed: 400,
        lazyLoad: true,
        navigation: true,
        slideSpeed: 400,
        singleItem: true,
        autoPlay: 6e3
    })
};
$(function() {
    reverb.cycle()
    $(".reply-comment-btn").on("click", function() {
        console.log('click')
        $(this).toggleClass("active");
        $(this).closest(".data-content").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
    });
})