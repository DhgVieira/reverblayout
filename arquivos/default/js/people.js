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
        $.ajax({
            url: '/people/ajaxpeople/' + page,
            success: function (data) {
                //$news = $container.html(data);
                var $newElems = $(data);
                $container.append($newElems).masonry('appended', $newElems, true);
                carregaContainer($container);

            }
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
            percentPosition: true,
        });
    });

}
