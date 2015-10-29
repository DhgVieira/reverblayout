$(function() // Register the menu
      {
// Add the click event handler on the list item with sub list
$('li:has(ul)') 
               .click(function(event){
                if (this == event.target) {
                   // Hide all the children of the other lists
                   $('li:has(ul)').children().hide('slow'); 
                   // Make the animation
                   $(this).children().animate({opacity:'toggle',height:'toggle'},'slow'); 
                                          }
                         return false;
                                     }
                       )
                // Change the cusrsor.
               .css({cursor:'pointer'})
               // Hide all the nested lists (on the first tinm only).
               .children().hide();
       }
 );
    