$(function () {

    var $container = $('#grid');
    carregaContainer($container);

    //$container.infinitescroll({
    //        navSelector  : '#more-nav',    // selector for the paged navigation
    //        nextSelector : '#more-nav a',  // selector for the NEXT link (to page 2)
    //        itemSelector : '.grid-item',     // selector for all items you'll retrieve
    //        loading: {
    //            finishedMsg: 'No more pages to load.',
    //            img: 'http://i.imgur.com/6RMhx.gif'
    //        }
    //    },
    //function( newElements ) {
    //        var $newElems = $( newElements ).css({ opacity: 0 });
    //        $newElems.imagesLoaded(function(){
    //            $newElems.animate({ opacity: 1 });
    //            $container.masonry( 'appended', $newElems, true );
    //        });
    //    }
    //);
    var page = 2;
    $('#more').click(function () {
        $('#newaddress-lightbox').attr('style', '');
        $('#newaddress-lightbox').removeClass('md-show');

        $('body').oLoader({
            image: '/arquivos/default/images/loader.gif',
            backgroundColor: '#5fbf98',
            url: '/avisa-me/ajaxaviseme/' + page,
            updateContent: false, //this will not update content in #ajax-example-3-1

            complete:function(data) {
                //$news = $container.html(data);
                var $newElems = $(data);
                $container.append($newElems).masonry('appended', $newElems, true);
                carregaContainer($container);
            },
            hideAfter: 1500
        });
        //
        //$.ajax({
        //    url: '/people/ajaxpeople/page/' + page,
        //    success: function (data) {
        //        //$news = $container.html(data);
        //        setTimeout(function() {
        //            $('body').attr('backgroundColor', '#5fbf98')
        //        }, 9000);
        //        var $newElems = $(data);
        //        $container.append($newElems).masonry('appended', $newElems, true);
        //        carregaContainer($container);
        //
        //    }
        //});
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
