reverb.blog=function(){$("#categorias .vejamais").on("click",function(e){e.preventDefault();$("#categorias ul").toggleClass("opened");var t=$("#categorias ul").is(".opened")?"veja menos -":"veja mais +";$(this).text(t)});$("#forum .vejamais").on("click",function(e){e.preventDefault();$("#forum ul").toggleClass("opened");var t=$("#forum ul").is(".opened")?"veja menos -":"veja mais +";$(this).text(t)});$("#search-blog-form .search-input").autocomplete({source:function(e,t){$.ajax({url:document.basePath+"/json/autocompleteblog/",data:{filter:e.term},dataType:"json",success:function(e){t(e)}})},appendTo:"#search-blog-form",delay:500,minLength:3})};jQuery(document).ready(function(e){reverb.blog()})