reverb.imprensa=function(){var e='<iframe style="height:68px; width:100%;"'+'src="http://www.facebook.com/plugins/like.php?'+"href="+document.URL+"&"+"layout=button_count&"+"show_faces=false&"+"width=450&"+"action=like&"+"colorscheme=light&"+'height=80"'+'scrolling="no"'+'frameborder="0"'+'allowTransparency="true">'+"</iframe>";$(".share-item.facebook").html(e);$(".media-item").on({mouseenter:function(e){var t=$(this);var n=setTimeout(function(){t.addClass("active")},800);t.mouseleave(function(e){clearTimeout(n);$(".media-item").removeClass("active")})}});$("#mySelector").mouseenter(function(){var e=$(this);var t=setTimeout(function(){e.addClass("hasBeen500ms")},500);e.mouseleave(function(){clearTimeout(t);e.removeClass("hasBeen500ms")})});$(".enviar-email").on("click",function(){var e=$(this).data("idimprensa");var t=document.URL+"#"+e;$("#indique_url").val(t)});$("#search-imprensa-form .search-input").autocomplete({source:function(e,t){$.ajax({url:document.basePath+"/json/autocompleteimprensa/",data:{filter:e.term},dataType:"json",success:function(e){t(e)}})},appendTo:"#search-imprensa-form",delay:500,minLength:3})};reverb.lgbox=function(){$.each($(".media-item"),function(e,t){$(".imprensa-lgb-"+e).Chocolat({overlayOpacity:.2,overlayColor:"#000"})})};$(function(){reverb.imprensa();reverb.lgbox()})