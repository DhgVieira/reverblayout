reverb.errorPage=function(){function t(){var t=Math.floor(Math.random()*2);var n=$(".rvb-toy img").attr("data-src")+e[t];$(".rvb-toy img").attr("src",n);$(".rvb-toy img").reflect({height:76})}var e=["boy.png","girl.png"];t()};$(function(){reverb.errorPage()})