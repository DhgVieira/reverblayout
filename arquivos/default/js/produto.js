$(function () {

    $('.btn-vermais button').click(function () {
        $(this).hide();
        $('.comments-item.hide').show();
    });

    $('#hide-thumbnails').jcarousel();
    $('.jcarousel-prev').click(function () {
        $('#hide-thumbnails').jcarousel('scroll', '-=1');
    });

    $('.jcarousel-next').click(function () {
        $('#hide-thumbnails').jcarousel('scroll', '+=1');
    });

});