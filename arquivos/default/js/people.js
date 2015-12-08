
$(document).ready(function () {
// init Masonry
    var $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer',
        gutter: 20
    });
    $(window).load(function ()
    {
        $("html, body").animate({ scrollTop: $(document).height()-$(window).height()-310 });
    });
// layout Isotope after each image loads
//    $grid.imagesLoaded().progress(function () {
//        $grid.masonry();
//    });
//    var page = 2;

//    $('#more').click(function () {
//        $.ajax({
//            url: '/people/ajaxpeople/' + page,
//            success: function (data) {
//                var $data = $.parseHTML(data);
//                $grid.append($data)
//                        // add and lay out newly appended items
//                        .masonry('appended', $data, true);
//            }
//        });
//        page++;
//    });
});
////docReady(function () {
//    var $container = $('#grid');
//
//    $container.imagesLoaded(function () {
//        $container.masonry({
//            itemSelector: '.grid-item',
//            columnWidth: '.grid-sizer',
//            percentPosition: true
//        });
//    });
//
//    $container.infinitescroll({
//        path: '/people/ajaxpeople/',     
//        navSelector  : '.mais',    // selector for the paged navigation 
//        nextSelector: '.mais a', // selector for the NEXT link (to page 2)
//        itemSelector: '.grid-item', // selector for all items you'll retrieve
//        loading: {
//            finishedMsg: 'No more pages to load.',
//            img: 'http://i.imgur.com/6RMhx.gif'
//        }
//    },
//    // trigger Masonry as a callback
//    function (newElements) {
//        // hide new items while they are loading
//        var $newElems = $(newElements).css({opacity: 0});
//        // ensure that images load before adding to masonry layout
//        $newElems.imagesLoaded(function () {
//            // show elems now they're ready
//            $newElems.animate({opacity: 1});
//            $container.masonry('appended', $newElems, true);
//        });
//    }
//    );
// init Isotope
//    var grid = document.querySelector('.grid');
//
//    var msnry = new Masonry(grid, {
//        itemSelector: '.grid-item',
//        columnWidth: '.grid-sizer',
//        percentPosition: true
//    });
//
//    imagesLoaded(grid, function () {
//        // layout Masonry after each image loads
//        msnry.layout();
//    });
//
//    var page = 2;
//
//    $('#more').click(function () {
//        $.ajax({
//            url: '/people/ajaxpeople/' + page,
//            success: function (data) {
//                $('.grid').append(data);
//                var $container = $('#grid');
//                if (page > 2) {
//                    $container.imagesLoaded(function () {
//                        $container.masonry({
//                            itemSelector: '.grid-item',
//                            columnWidth: '.grid-sizer',
//                            percentPosition: true
//                        }).masonry('layout');
//                    });
//                } else {
//                    $container.imagesLoaded(function () {
//                        $container.masonry({
//                            itemSelector: '.grid-item',
//                            columnWidth: '.grid-sizer',
//                            percentPosition: true
//                        });
//                    });
//                }
//            }
//        });
//        page++;
//    });

//});
