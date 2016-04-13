$(function () {
    var $container = $('#grid');
    carregaContainer($container);
    var page = 2;
    $('#more').click(function () {
        $('#newaddress-lightbox').attr('style', '');
        $('#newaddress-lightbox').removeClass('md-show');

        $('body').oLoader({
            image: '/arquivos/default/images/loader.gif',
            backgroundColor: '#5fbf98',
            url: '/reverbcycle/ajaxcycle/' + page,
            updateContent: false, //this will not update content in #ajax-example-3-1

            complete:function(data) {
                //$news = $container.html(data);
                var $newElems = $(data);
                $container.append($newElems).masonry('appended', $newElems, true);
                carregaContainer($container);
            },
            hideAfter: 1500
        });
        page++;
    });
});

function carregaContainer($container) {
    $container.imagesLoaded(function () {
        $container.masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer',
            percentPosition: true
        });
    });

}
