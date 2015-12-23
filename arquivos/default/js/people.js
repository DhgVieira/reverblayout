$(document).ready(function () {

    var $container = $('#grid');

    $container.masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        gutter: 20
    });

    container.infinitescroll({
            debug        : true,
            navSelector  : '.pagination',
            nextSelector : '.pagination a.next',
            itemSelector : '.grid-item',
            loading: {
                finishedMsg: 'No more pages to load.',
                img: 'http://i.imgur.com/6RMhx.gif'
            }
        },
        function( newElements ) {
            var $newElems = $( $newElements ).css({ opacity: 0 });
            $newElems.animate({ opacity: 1 });
            $container.masonry( 'appended', $newElements, true );
        }
    );
});