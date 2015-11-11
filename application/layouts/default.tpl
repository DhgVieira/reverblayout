{strip}
<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
<head>
	{$this->headMeta()}
	{if $title}
	<title>{$title}</title>
	{else}
	{$this->headTitle()}
	{/if}
	{literal}
	<style>
	a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,table,tbody,td,tfoot,th,thead,time,tr,tt,u,ul,var,video{margin: 0;padding: 0;border: 0;vertical-align: baseline;font: inherit;font-size: 100%}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display: block}input,textarea{border-radius: 0!important}*{-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box}body{height: 100%}ol,ul{list-style: none}strong{font-weight: 700}blockquote,q{quotes: none}blockquote:after,blockquote:before,q:after,q:before{content: none}table{border-spacing: 0;border-collapse: collapse}a{color: inherit;text-decoration: none}@font-face{font-weight:400;font-style:normal;font-family:Andes-Regular;src:url(/arquivos/default/fonts/andes-regular.svg) format("svg"),url(/arquivos/default/fonts/andes-regular.ttf) format("truetype"),url(/arquivos/default/fonts/andes-regular.otf) format("opentype"),url(/arquivos/default/fonts/andes-regular.woff) format("woff")}@font-face{font-weight:400;font-style:normal;font-family:Andes-Bold;src:url(/arquivos/default/fonts/andes-bold.svg) format("svg"),url(/arquivos/default/fonts/andes-bold.ttf) format("truetype"),url(/arquivos/default/fonts/andes-bold.otf) format("opentype"),url(/arquivos/default/fonts/andes-bold.woff) format("woff")}@font-face{font-weight:400;font-style:normal;font-family:Hernandez-Bold;src:url(/arquivos/default/fonts/hernandez.svg) format("svg"),url(/arquivos/default/fonts/hernandez.ttf) format("truetype"),url(/arquivos/default/fonts/hernandez.otf) format("opentype"),url(/arquivos/default/fonts/hernandez.woff) format("woff")}@font-face{font-weight:400;font-style:normal;font-family:Dinnextltpro-Bold;src:url(/arquivos/default/fonts/dinnextltpro-bold.svg) format("svg"),url(/arquivos/default/fonts/dinnextltpro-bold.ttf) format("truetype"),url(/arquivos/default/fonts/dinnextltpro-bold.otf) format("opentype"),url(/arquivos/default/fonts/dinnextltpro-bold.woff) format("woff")}.ir{display: block;overflow: hidden;text-indent: 100%;white-space: nowrap}.hidden{display: none!important;visibility: hidden}.visuallyhidden{position: absolute;overflow: hidden;clip: rect(0 0 0 0);margin: -1px;padding: 0;width: 1px;height: 1px;border: 0}.visuallyhidden.focusable:active,.visuallyhidden.focusable:focus{position: static;overflow: visible;clip: auto;margin: 0;width: auto;height: auto}.invisible{visibility: hidden}.clearfix:after,.clearfix:before{display: table;content: " "}.clearfix:after{clear: both}.lightbox-button{margin: 0;padding: 4px 10px;border: 1px solid #5dbf98;sborder-radius: 4px;background-color: transparent;color: #5dbf98;font-weight: 700;font-size: 11px;cursor: pointer}.simple-anchor:hover{text-decoration: underline}.mt{margin-top: 5px}.mr{margin-right: 5px}.mb{margin-bottom: 5px}.ml{margin-left: 5px}.muted{color: #999}a.muted:focus,a.muted:hover{color: gray}.text-warning{color: #c09853}a.text-warning:focus,a.text-warning:hover{color: #a47e3c}.text-error{color: #b94a48}a.text-error:focus,a.text-error:hover{color: #953b39}.text-info{color: #3a87ad}a.text-info:focus,a.text-info:hover{color: #2d6987}.text-success{color: #468847}a.text-success:focus,a.text-success:hover{color: #356635}.text-left{text-align: left}.text-right{text-align: right}.text-center{text-align: center}.noscript{display: block;position: fixed;z-index: 10;bottom: 0;left: 0;width: 100%;height: 54px;text-align: center;background-color: #f05626}.noscript a{width: 100%;height: 100%;display: block;color: #fff;text-align: center;text-transform: uppercase;font-weight: 700;font-size: 11px;font-family: Verdana,Arial,sans-serif;line-height: 24px}.noscript:hover{background-color: #F78A69}.noscript:hover a{color: #313131}#full-loader{width: 100%;height: 100%;position: fixed;left: 0;top: 0;background-color: rgba(0,0,0,.5);z-index: 999999;display: none}.has-tooltip{position: relative}.tooltip{position: absolute;top: -135px;left: -60px;width: 210px;border-radius: 4px;background-color: #000;color: #fff;text-align: justify;font-size: 9px;font-family: Verdana,sans-serif;line-height: 1.5;margin-top: -5px;padding: 5px 10px;opacity: 0;-webkit-transition: opacity .5s;-moz-transition: opacity .5s;-ms-transition: opacity .5s;-o-transition: opacity .5s;transition: opacity .5s;visibility: hidden}.has-tooltip.active .tooltip{opacity: 1;visibility: visible;-webkit-transition: opacity .5s;-moz-transition: opacity .5s;-ms-transition: opacity .5s;-o-transition: opacity .5s;transition: opacity .5s}.tooltip:after{position: absolute;bottom: -5px;left: 110px;width: 0;height: 0;border-top: 5px solid #000;border-right: 5px solid transparent;border-left: 5px solid transparent;content: ""}.tooltip-link{float: left;clear: both;margin-top: 15px;margin-bottom: 10px;font-weight: 700}.logo-footer{background-image: url(/arquivos/default/images/sprites/logos.png);background-repeat: no-repeat}.logo-topo{background-image: url(/arquivos/default/images/logo_flat.png);background-repeat: no-repeat}.logo-topo.cycle{background: url(/arquivos/default/images/reverb-cycle-logo.png) 0/100% no-repeat}.pagination{float: left;margin-top: 10px;clear: both}.pagination .item{float: left;margin-right: 10px}.pagination a{margin: 0;padding: 8px 11px;background-color: #e7e7e7;color: #929293;font-weight: 700;font-size: 11px}.pagination a.active,.pagination a:focus,.pagination a:hover{background-color: #5fbf98;color: #fff}a,body,button,h1,h2,h3,h4,h5,h6,input,select,textarea{font-family: Verdana,sans-serif;border-radius: 0;box-shadow: none}button:focus,input:focus,select:focus,textarea:focus{outline: 0}body{background-color: #e7e7e7;color: #666;font-size: 100%;line-height: 1.5}.container{margin: 0 auto;padding: 0 20px;width: 980px}.rvb-column{float: left;margin-bottom: 20px;width: 460px}.rvb-column.right{margin-left: 20px}.rvb-footer-item>p,.rvb-header-item h2,.rvb-header-item>p{text-indent: 10px}.rvb-footer-item,.rvb-header-item{width: 100%;float: left;position: relative;padding: 0;height: 30px;line-height: 30px;color: #fff;text-transform: uppercase;font-size: 11px}.rvb-header-item{background-color: #5fbf98}.rvb-footer-item{margin-top: -10px;margin-bottom: 10px;background-color: #666}.rvb-content-item{float: left;position: relative;margin-bottom: 10px;padding: 20px 10px 10px;background-color: #e8e8e8;color: #666;width: 100%}.rvb-content-item .send-button{margin-right: 0}#msg-box{display: none;float: left;clear: both;margin: 10px 0;width: 100%;min-height: 24px;text-align: center}#msg-box.fixed{position: fixed;margin: 0;top: 0;left: 0;z-index: 9999;z-index: 9999999}#msg-box p{display: inline-block;text-align: center;text-transform: uppercase;font-weight: 700;font-size: 11px;font-family: Verdana,Arial,sans-serif;line-height: 40px}#msg-box.msg-error p{color: #f05626}#msg-box.msg-success p{color: #5fc19a}#msg-box .rvb-icon{float: left;width: 30px;height: 30px}.msg-success{background-color: #f2f2f2}.msg-success .rvb-icon{background: url(/arquivos/default/images/icon/success-icon.png) center center no-repeat #5fc19a;-moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius: 15px;margin: 5px 5px 0 0}.msg-error{background-color: #f2f2f2}.msg-error .rvb-icon{background: url(/arquivos/default/images/icon/error-icon.png) center center no-repeat #f05626;-moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius: 15px;margin: 5px 5px 0 0}header[role=banner]{height: 98px}.header.container{height: 58px;background-color: #fff}#mobile-header{display: none}#top-bar{width: 100%;height: 40px;background-color: #414042;transition: all .25s ease-in-out}#top-bar.fixed{position: fixed}.logo-topo{float: left;margin: 10px 20px 0 0;width: 88px;height: 88px}.logo-topo a{display: block}#top-bar .left-side{width: 150px;height: 40px;float: left}#top-bar .right-side{float: right}.actions-site,.actions-user,.topbar-search{float: left}.actions-site{margin-right: 7px}.actions-site>li,.actions-user>li{position: relative;display: inline-block}.actions-site .international,.actions-site .my-cart,.actions-user .reverb-button,.search-icon{background-image: url(/arquivos/default/images/sprites/buttons.png);background-position: 0 0;background-repeat: no-repeat}.actions-site .international,.actions-site .my-cart,.actions-user .reverb-button{position: relative;width: 31px;height: 31px}.actions-user .reverb-button.user{background-position: 3px 10px}.actions-user .reverb-button.messages{background-position: -30px 10px}.actions-user .reverb-button.notifications{background-position: -61px 10px}.actions-user .accessible-elem{position: absolute;overflow: hidden;clip: rect(1px,1px,1px,1px);width: 1px;height: 1px}.reverb-count{position: absolute;top: 5px;right: 0;border-radius: 10px;color: #fff;font-weight: 700;font-size: 8px;cursor: pointer}.reverb-count.green span{border-top: 1px solid #4c997a;border-bottom: 1px solid #49997a;background-color: #5fbf98}.reverb-count.red span{border-top: 1px solid #e23923;border-bottom: 1px solid #c0311e;background-color: #e75238}.reverb-count span{padding: 0 3px 1px;border: none;border-radius: 10px;box-shadow: 0 -1px 0 rgba(0,0,0,.7);text-shadow: 0 -1px 0 rgba(0,0,0,.4)}.reverb-flyout .thumb{float: left;margin-right: 10px;border: 1px solid #fff}.reverb-flyout .request-item{display: block;padding: 14px 0;border-bottom: 1px solid #e7e7e7}.reverb-flyout .button,.reverb-flyout .name{text-transform: uppercase;font-weight: 700}.reverb-flyout .date,.reverb-flyout .message,.reverb-flyout .name{color: #414042;font-size: 10px}.reverb-flyout .buttons,.reverb-flyout .message{padding-left: 53px}.reverb-flyout .button{padding: 4px;border-radius: 4px;background-color: #fff;font-size: 7px}.reverb-flyout .button:focus,.reverb-flyout .button:hover{color: #fff}.reverb-flyout .accept{border: 1px solid #5fbf98;color: #5fbf98}.reverb-flyout .accept:focus,.reverb-flyout .accept:hover{background-color: #5fbf98}.reverb-flyout .decline{border: 1px solid #e75238;color: #e75238}.reverb-flyout .decline:focus,.reverb-flyout .decline:hover{background-color: #e75238}.reverb-flyout .details-column-left{float: left;width: 53px}.reverb-flyout .date{color: #b6b6b6;font-size: 8px;clear: both;display: block;line-height: 20px}.reverb-flyout .friend-requests .buttons,.reverb-flyout .friend-requests .message{padding-left: 48px}.private-messages .name,.scrap-wall .name{margin-bottom: 10px}.actions-site{width: auto;height: 40px;text-transform: uppercase;font-weight: 700;font-size: 8px}.actions-site .reverb-flyout{top: 0;width: 234px}.actions-site .reverb-flyout.cart{top: 20px;left: -50px}.actions-site>li{float: left;margin-top: 15px;padding: 0 6px 0 3px;border-right: 1px solid #b9bbbd}.actions-site>li.cart{margin-top: 11px}.actions-site>li.international{margin: 10px 4px 0;padding-left: 0}.actions-site .no-border{padding-right: 0;border-right: none}.actions-site>li a{color: #b9bbbd}.actions-site li>.opened,.actions-site li>a:focus,.actions-site li>a:hover{color: #fff;position: relative;z-index: 300}.actions-site .international,.actions-site .my-cart{width: auto;height: 20px;line-height: 20px}.actions-site .my-cart{display: block;padding-right: 40px;background-position: 82px -30px}.actions-site .my-cart:focus,.actions-site .my-cart:hover,.actions-site .opened.my-cart{background-position: 82px -57px}.actions-site .my-cart .reverb-count{top: -10px;right: 15px}.actions-site .international{width: 29px;background-position: -26px -29px}.actions-site .international:focus,.actions-site .international:hover{background-position: -26px -56px}.reverb-flyout.cart .total{text-transform: uppercase;margin-top: 17px;clear: both;color: #5fbf98;font-size: 10px;font-weight: 700;line-height: 12px;text-align: center;display: block}.reverb-flyout.cart .see-more{color: #e75238;font-size: 10px;font-weight: 700;line-height: 12px;text-align: center;display: block}.flyout-list.my-cart-items{display: table;width: 100%}.reverb-flyout.cart .flyout-title{text-transform: none}.my-cart-items li:first-child{padding-top: 6px}.my-cart-items li:last-child{border-bottom: none;padding-bottom: 0}.my-cart-items li{float: left;width: 100%;clear: left;border-bottom: 1px solid #e7e7e7;padding: 11px 0;position: relative;font-size: 9px}.my-cart-product-thumb{float: left;width: 54px;height: 62px;margin: 0 8px}.actions-site .my-cart-product-name{font-size: 10px;color: #5fbf98}.my-cart-product-description span{display: block;color: #b6b6b6}.my-cart-remove-item{position: absolute;right: 0;top: 20%;background: url(/arquivos/default/images/icon/remove-red.png) no-repeat;width: 20px;height: 20px;margin-top: -10px}.my-cart-close{position: absolute;right: 3%;top: 5%;background: url(/arquivos/default/images/icon/remove-red.png) no-repeat;width: 20px;height: 20px;margin-top: -10px}.actions-site li>.my-cart-remove-item:focus,.actions-site li>.my-cart-remove-item:hover{position: absolute}.topbar-search{position: relative;margin-top: 6px;width: 221px}.input-box{float: left;padding: 0 5px;width: 195px;height: 26px;border: none;background-color: #fff;color: #8b8b8b;text-transform: uppercase;font-size: 10px;font-family: Verdana;line-height: 26px}.input-box:focus,.input-box:hover{border: 0}.topbar-search .submit{position: relative;float: left;margin: 0;padding: 0;width: 26px;height: 26px;border: none;background-color: #5fbf98;background-position: 4px -84px;cursor: pointer;color: transparent}.topbar-search .submit:after{position: absolute;top: 50%;right: 26px;margin-top: -6px;border-top: 6px solid transparent;border-right: 6px solid #5fbf98;border-bottom: 6px solid transparent;content: " "}.ui-menu .ui-menu-item a{width: 100%;height: 20px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-size: 12px;}#site-menu,.menu-item{float: left}.menu-item.home{width: 53px}.menu-item.loja{width: 48px}.menu-item.wholesale{width: 78px}.menu-item.reverbme{width: 82px}.menu-item.blog{width: 52px}.menu-item.forum{width: 60px}.menu-item.imprensa{width: 80px}.menu-item.quem-somos{width: 100px}.menu-item.contato{width: 77px}.menu-item-link{color: #5fbf98;text-transform: uppercase;font-size: 11px}.menu-item-link.active,.menu-item-link:focus,.menu-item-link:hover{font-weight: 700}.dropdown{position: relative}.dropdown-menu:before{position: absolute;top: -7px;left: 7px;width: 0;height: 0;border-right: 7px solid transparent;border-bottom: 7px solid #818081;border-left: 7px solid transparent;content: " "}.dropdown-menu{position: absolute;top: 30px;left: 0;visibility: hidden;background-color: #818081;opacity: 0;filter: alpha(opacity=0);font-family: sans-serif}.dropdown-menu.drop-loja{width: 520px}.dropdown-menu.drop-reverbme{width: 235px}.dropdown-menu.active{visibility: visible;opacity: 1;filter: alpha(opacity=100)}.dropdown-menu .submenu-item{margin: 3px 7px 5px 6px;line-height: 1em;float: left}.dropdown-menu .submenu-item.last{margin-right: 0}.dropdown-menu .menu-item-link{color: #ECECEC;font-weight: 700;font-size: 9px}.dropdown-menu .menu-item-link:focus,.dropdown-menu .menu-item-link:hover{color: #fff}#sac{float: right;margin-top: 8px;text-align: right}#sac p{color: #414042;font-size: 11px;font-family: Arial,sans-serif}#base-bar{float: left;padding: 15px 0;width: 100%;background-color: #414042;color: #fff;font-size: 10px;font-family: Arial}#base-bar .container{padding: 0}#base-bar a{color: #fff;transition: color .15s ease-in-out}#base-bar a:focus,#base-bar a:hover{color: #cbcbcb}#base-bar a:active{color: #f05626}#base-bar .selo,.footer-newsletter,.links-footer,.links-information,.links-nav-footer,.links-social,.payments{float: left}#base-bar .selo{margin: 10px 0 0 42px;background-color: #fff;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;padding: 3px}#base-bar .selo img{display: block}#sustainable_website{width: 142px;height: 40px;float: left;margin: 10px 25px}.links-information{width: 196px;text-align: center;margin-right: 30px}.links-information a,.links-information p{font-size: 10px;font-family: Arial,sans-serif}.logo-footer{margin-bottom: 15px;margin-left: auto;margin-right: auto;width: 64px;height: 68px;background-position: 0 -62px;background-size: 64px 126px}.security{padding-top: 10x}.links-nav-footer{padding-left: 19px;width: 169px;border-left: 1px solid #79797a;font-family: Verdana,sans-serif}.links-nav-footer.first{padding: 0;width: 130px;border: none}.links-nav-footer .title{margin-bottom: 25px;color: #cbcbcb;text-transform: uppercase;font-size: 12px}.links-nav-footer li{margin-bottom: 15px;font-size: 11px}.links-social,.payments{width: 220px}.links-social ul li{display: inline-block;margin-right: 2px}.links-social .last{margin: 0}.links-social .icon{width: 27px;height: 27px;border-radius: 4px;background-color: #fff;background-image: url(/arquivos/default/images/sprites/socials.png);background-repeat: no-repeat}.links-social .icon:focus,.links-social .icon:hover{background-color: #cbcbcb}.links-social .icon:active{background-color: #f05626}.links-social .facebook{background-position: 8px 4px}.links-social .facebook:hover{background-position: 8px -27px}.links-social .twitter{background-position: -27px 4px}.links-social .twitter:hover{background-position: -27px -27px}.links-social .tumblr{background-position: -60px 4px}.links-social .tumblr:hover{background-position: -60px -27px}.links-social .flickr{background-position: -94px 3px}.links-social .flickr:hover{background-position: -94px -27px}.links-social .youtube{background-position: -125px 2px}.links-social .youtube:hover{background-position: -125px -27px}.links-social .instagram{background-position: -158px 2px}.links-social .instagram:hover{background-position: -158px -27px}.links-social .pinterest{background-position: -191px 2px}.links-social .pinterest:hover{background-position: -191px -27px}.payments{margin-top: 2px;height: 28px;background: url(/arquivos/default/images/sprites/payments.png) no-repeat}.form-field{float: left;margin: 3px 0}.form-field input{float: left;margin: 0 5px 0 0;padding: 0 5px;width: 165px;height: 23px;border: none;border-bottom: 1px solid #fff;font-weight: 700;font-size: 10px;line-height: 24px}.form-field button{float: left;padding: 0 4px;height: 23px;border: 1px solid #fff;border-radius: 4px;background-color: #666;color: #fff;text-transform: uppercase;font-size: 10px;font-family: Arial,sans-serif;line-height: 23px;cursor: pointer}.footer-newsletter{margin-top: 15px;width: 220px}.footer-newsletter p{font-size: 10px}.footer-newsletter .title{color: #cbcbcb;text-transform: uppercase}.footer-newsletter .subtitle{clear: both;color: #959595}.footer-newsletter address{margin-top: 25px;font-size: 10px;font-family: sans-serif;line-height: 2;width: 290px;float: left}.footer-newsletter address span{display: block}.footer-newsletter address .large{width: 280px}.footer-newsletter address .x-large{width: 305px}.rvb-form{padding: 30px 10px;background-color: #f1f1f1}.rvb-label{margin-right: 15px;color: #646464;text-transform: uppercase;font-weight: 700;font-size: 9px;line-height: 15px;float: left}.rvb-input-txt{padding: 5px;border: 1px solid #c1c1c1;color: #646464;font-size: 9px;font-family: Verdana,sans-serif}input.error,select.error,textarea.error{border: 1px solid #e85238!important}label.error{position: absolute;background-color: #fff;color: #e85238;text-transform: uppercase;font-size: 10px;font-family: Verdana,sans-serif}input.error:focus+label.error,input.error:hover+label.error,select.error:focus+label.error,select.error:hover+label.error,textarea.error:focus+label.error,textarea.error:hover+label.error{display: none!important}.send-button{float: right;margin: 10px 20px 0 0;text-align: right}.send-button.left{float: left;margin: 10px 0 0 20px}.send-button.no-margin{margin-right: 0!important;margin-left: 0!important}.send-button .btn{display: inline-block;padding: 0 20px;height: 20px;line-height: 19px;border: 1px solid #62c29c;border-radius: 4px;background-color: #fff;color: #62c29c;text-align: center;text-transform: uppercase;font-weight: 700;font-size: 10px;font-family: Sans-serif;cursor: pointer}.send-button .btn.bold{height: 25px;line-height: 23px}.send-button .btn:focus,.send-button .btn:hover{border: 1px solid #616161;color: #616161}.back-button{float: left;margin-left: 20px;margin-top: 10px;text-align: left}.back-button .btn{display: inline-block;padding: 0 20px;height: 20px;line-height: 20px;border: 1px solid #f05626;border-radius: 4px;background-color: #fff;color: #f05626;text-align: center;text-transform: uppercase;font-weight: 700;font-size: 10px;font-family: Verdana,sans-serif;cursor: pointer}.back-button .btn:focus,.back-button .btn:hover{border: 1px solid #616161;color: #616161}#main-content{display: table;background-color: #fff;font-size: 11px;padding-bottom: 20px}.selo-google{display: block; margin-top: 10px;}.selo-google img {background-color: white;}.selo-trustsign img {margin-top: 13px;} .c-orange{color: #F05626 !important;} .menu-item.sale{width: 45px;} .bg-orange{background-color: #F05626 !important;} .c-white{color: #ffffff;}
	</style>
	{/literal}
	<!-- teste123 -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' /><![endif]-->

	{*        {assign var=basePath value="/reverbcity.com"}*}
	<script type="text/javascript">
	document.basePath = '{$basePath}';
	</script>
	
	
	<meta property="fb:app_id" content="713473752042540" />
	<meta property="fb:admins" content="100000451099995"/>
	<meta property="og:title" content="{$title}"/>
	{if $currentController == 'loja'}
	<meta property="og:type" content="product"/>
	{else}
	<meta property="og:type" content="Website"/>
	{/if}

	{if $currentController == 'blog' && $currentAction == 'post'}
	{assign var="foto" value="{$blog->NR_SEQ_BLOG_BLRC}"}
	{assign var="extensao" value="{$blog->DS_EXT_BLRC}"}
	{assign var="foto_completa" value="{$foto}.{$extensao}"}

	<meta property="og:url" content="{$_pagina_atual}"/>
	<meta property="og:image" content="https://www.reverbcity.com{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>0, 'altura'=>0, 'imagem'=>$foto_completa], "imagem", TRUE)}"/>
	<meta property="og:description" content="{$description}" />
	{else}
	<meta property="og:url" content="{$_pagina_atual}"/>
	<meta property="og:image" content="https://www.reverbcity.com/arquivos/default/images/logos/facebook.png"/>
	<meta property="og:description" content="{$description}" />
	{/if}

	<meta name="google-site-verification" content="WJxo-ptNAStuP27bFhQ9LtNos15iL--lJUCGwUta5ro" />
	<meta name="robots" content="index, follow, all" />
	{if $currentController == 'loja' && $currentAction == 'produto'}
		{if $produto->NR_SEQ_TIPO_PRRC == 6}
			{assign var=preTitle value='Camiseta '}
		{else}
			{assign var=preTitle value=''}
		{/if}
		{assign var=ds_produto_prrc value=' - '|explode:$produto->DS_PRODUTO_PRRC}
		{assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
		{assign var=urlCanonical value="https://www.reverbcity.com/produto/{$this->createslug($slug)}/{$produto->NR_SEQ_PRODUTO_PRRC}"}

		<link rel="canonical" href="{$urlCanonical}" />
		<link rel="alternate" href="{$urlCanonical}" hreflang="pt-br" />
	{else}
		{if $currentController == 'index' && $currentAction == 'index'}
			<link rel="canonical" href="https://www.reverbcity.com/inicio" />
			<link rel="alternate" href="{$_pagina_atual}" hreflang="pt-br" />
		{else}
			<link rel="canonical" href="{$_pagina_atual}" />
			<link rel="alternate" href="{$_pagina_atual}" hreflang="pt-br" />
		{/if}
	{/if}

	{if $currentController == 'loja' && $currentAction == 'index'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{elseif $currentController == 'loja' && $currentAction == 'todos-produtos'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{elseif $currentController == 'index' && $currentAction == 'inicio'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{/if}

	<meta name="viewport" content="width=device-width, user-scalable=no" />

	<meta name="description" content="{$description}" />
	<meta name="keywords" content="{$keywords}" />
	<!-- Le fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-144-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-114-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-72-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-57-precomposed.png" />
	<link rel="shortcut icon" href="{$basePath}/arquivos/default/images/favicons/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="{$basePath}/arquivos/default/images/favicons/favicon.ico" type="image/x-icon" />

        <!--[if lt IE 9]>
        <script type="text/javascript" src="{$basePath}/arquivos/default/js/libs/html5shiv.min.js"> </script>
        <![endif]-->

    {$this->headLink()}

    
	
        	</head>
        	<body>

        		{if $_isMobile eq 1}
        		<header id="mobile-header" role="banner">
        			<div id="top-bar">        				
        				{* LOAD DINAMIC *}
        			</div>
        		</header>
        		{else}
        		<header id="desktop-header" role="banner">
        				<div id="top-bar">
        					{* LOAD DINAMIC *}
        				</div>
        				<div id="site-menu" class="hidden" role="navigation">
        					<ul>
        						<li class="menu-item home">
        							<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'inicio', TRUE)}">Home</a>
        						</li>
        						<li class="menu-item loja dropdown">
        							<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Loja</a>
        							<ul class="dropdown-menu drop-loja">
        								{*<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'lollapalooza', TRUE)}" style="color: #5fbf98;">Lollapalooza 2015</a></h2></li>*}
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'novidades', TRUE)}">Novidades</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'masculino', TRUE)}">Masculino</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'feminino', TRUE)}">Feminino</a></h2></li>
        								<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'acessorios', TRUE)}">Acessórios</a></li> -->

        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'casa', TRUE)}">Casa</a></h2></li>
        								<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'converse', TRUE)}">Converse</a></li> -->
        								<!-- <li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'sale', TRUE)}">Sale</a></h2></li> -->
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'valepresente', TRUE)}">Vale Presente</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'avisame', TRUE)}">Avise-me</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'colecoesantigas', TRUE)}">Classics</a></h2></li>
        								{*<li class="submenu-item last"><h2><a class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Todos Produtos</a></h2></li>*}
        							</ul>
        						</li>
        						<li class="menu-item sale">
        							<a class="menu-item-link home c-orange" href="{$this->url([], 'sale', TRUE)}">Sale</a>
        						</li>
        						<li class="menu-item reverbme dropdown">
        							<a class="menu-item-link" href="{$this->url([], 'reverbme', TRUE)}" rel="nofollow">Reverbme</a>
        							<ul class="dropdown-menu drop-reverbme">
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'reverbmedetalhe', TRUE)}" rel="nofollow">Perfil</a></h2></li>
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'people', TRUE)}" rel="nofollow">Reverbpeople</a></h2></li>
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'reverbcycle', TRUE)}" rel="nofollow">Reverbcycle</a></h2></li>
        							</ul>
        						</li>
        						<li class="menu-item blog">
        							<a class="menu-item-link" href="{$this->url([], 'blog', TRUE)}" rel="nofollow">Blog</a>
        						</li>
        						<li class="menu-item forum">
        							<a class="menu-item-link" href="{$this->url([], 'forum', TRUE)}" rel="nofollow">Forum</a>
        						</li>
        						<li class="menu-item wholesale">
        							<a class="menu-item-link" href="{$this->url([], 'cadastrolojista', TRUE)}" rel="nofollow">Atacado</a>
        						</li>
        						<li class="menu-item imprensa">
        							<a class="menu-item-link" href="{$this->url([], 'imprensa', TRUE)}" rel="nofollow">Imprensa</a>
        						</li>
        						<li class="menu-item quem-somos">
        							<a class="menu-item-link" href="{$this->url([], 'quemsomos', TRUE)}" rel="nofollow">Quem somos</a>
        						</li>
        						<li class="menu-item contato">
        							<a class="menu-item-link" href="{$this->url([], 'contato', TRUE)}" rel="nofollow">Contato</a>
        						</li>
        					</ul>
        				</div>
        				<div class="header container">
        					<div id="sac">
        						<p>SAC | seg-sex - 8:30 -17:30<br>
        							Fone: (43) 3322-8852 <br>
        							{if substr_count($_email_usuario, "@reverbcity.com")}
        							Usuários online: {$_totalusers}
                                                                {else}
                                                                
        							{/if}
        						</p>
        					</div>
        				</div>
        			</header>
        			{/if}
        			<div id="main-content" role="main" class="container">
        				{if $success|default:"" != ""}
        				<!-- mensagem de sucesso -->
        				<div id="msg-box" class="msg-success">
        					<p><i class="rvb-icon"></i> {$success}</p>
        				</div>
        				{/if}
        				{if $error|default:"" != ""}
        				<!-- mensagem de erro -->
        				<div id="msg-box" class="msg-error">
        					<p><i class="rvb-icon"></i> {$error}</p>
        				</div>
        				{/if}
        				{$opennedController}
        				{$this->layout()->content}
        			</div>
        			<footer role="contentinfo">
        				{*{if $_isMobile neq 1}*}
        				{*{if $_chat_online eq 1}*}
        				{*<div class="chat_fixo" style="bottom: 0px; right: 0px; position: fixed; z-index: 99999; width: 80px; height: 185px ; background-color: #5fbf98; margin-bottom: 360px;-moz-border-radius: 10px;">*}
        				{*<a href="javascript:void(window.open('https://reverbcity.com/livezilla/chat.php?a=bc2a1','','width=590,height=760,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))" style="text-align:center; text-decoration: none; vertical-align: middle; color: #FFF; font-size: 11px; transform: rotate(90deg); transform-origin: left top 0; float: left; margin-left: 78px; margin-top: 50px;">*}
        				{*<img src="{$basePath}/arquivos/default/images/chat_icon.png" alt="Chat">   *}
        				{*ATENDIMENTO ONLINE*}
        				{*</a>*}
        				{*</div>*}
        				{*<!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">*}
        				{*var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "https://www.reverbcity.com/livezilla/server.php?a=bc2a1&request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img pagespeed_no_transform src="https://www.reverbcity.com/livezilla/server.php?a=bc2a1&amp;request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt="Chat" title="Chat"></noscript><!-- http://www.LiveZilla.net Tracking Code -->*}
        				{*{else}*}
        				{*<div class="chat_fixo" style="bottom: 0px; right: 0px; position: fixed; z-index: 99999; width: 80px; height: 185px ; background-color: #8f8f8f; margin-bottom: 360px;-moz-border-radius: 10px;">*}
        				{*<a href="javascript:void(window.open('https://reverbcity.com/livezilla/chat.php?a=bc2a1','','width=590,height=760,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))" style="text-align:center; text-decoration: none; vertical-align: middle; color: #FFF; font-size: 11px; transform: rotate(90deg); transform-origin: left top 0; float: left; margin-left: 78px; margin-top: 50px;">*}
        				{*<img src="{$basePath}/arquivos/default/images/chat_icon_off.png"  alt="Chat">   *}
        				{*ATENDIMENTO OFFLINE*}
        				{*</a>*}
        				{*</div>*}
        				{*{/if}*}
        				{*{/if}*}
        				<div id="base-bar">
        					<div class="container">
        						<div class="links-information">
        							<a href="{$this->url([], 'inicio', TRUE)}" title="Reverbcity" class="logo-footer ir" rel="nofollow">Reverbcity</a>
        							<a href="{$this->url([], "politicaprivacidade", TRUE)}" class="footer-link" rel="nofollow">Política de privacidade |</a>
        							<a href="{$this->url([], "termosuso", TRUE)}" class="footer-link" rel="nofollow">Termos de uso</a>
        							<p>&copy; {$smarty.now|date_format:"%Y"}, Reverbcity. All rights reserved.</p>
        							<a class="selo-trustsign" href="https://security.trustsign.com.br/?url=www.reverbcity.com" target="_blank">
        								<img name="trustseal" alt="Site Autêntico" src="https://security.trustsign.com.br/static/seals/selo-basic-98f7ad5ed4f3ef46935c5790190e837e-pt.png" border="0" title="Clique para Validar"/>
        							</a>
        							<a class="selo-google" href="https://google.com/safebrowsing/diagnostic?hl=pt-PT&site=reverbcity.com" target="_blank">
        								<img name="selo-google" alt="Site Autêntico" src="{$basePath}/arquivos/default/images/google-safe-browsing.png" border="0" title="Clique para Validar"/>
        							</a>
        							{*<div id="sustainable_website"></div>*}
        						</div>
        						<div id="links-footer">
        							<div class="links-nav-footer first">
        								<p class="title">Home</p>
        								<ul>
        									<li><a href="{$this->url([], 'inicio', TRUE)}" rel="nofollow">Loja</a></li>
        									<li><a href="{$this->url([], 'colecoesantigas', TRUE)}" rel="nofollow">Classics</a></li>
        									<li><a href="{$this->url([], 'valepresente', TRUE)}" rel="nofollow">Vale-presente</a></li>
        									<li><a href="#" class="md-trigger" data-modal="tracking-lightbox" rel="nofollow">Rastreamento</a></li>
        									<li><a href="{$this->url([], 'avisame', TRUE)}" rel="nofollow">Avise-me</a></li>
        									<li><a href="{$this->url([], 'atacado', TRUE)}" rel="nofollow">Atacado</a></li>
        								</ul>
        							</div>
        							<div class="links-nav-footer">
        								<p class="title">Reverb Me</p>
        								<ul>
        									<li><a href="{$this->url([], 'novome', TRUE)}" rel="nofollow">Rede Social</a></li>
        									<li><a href="{$this->url([], 'blog', TRUE)}" rel="nofollow">Blog</a></li>
        									<li><a href="{$this->url([], 'forum', TRUE)}" rel="nofollow">Fórum</a></li>
        									<li><a href="{$this->url([], 'reverbcycle', TRUE)}" rel="nofollow">Reverbcycle</a></li>
        									<li><a href="{$this->url([], 'people', TRUE)}" rel="nofollow">Reverb People</a></li>
        								</ul>
        							</div>
        							<div class="links-nav-footer">
        								<p class="title">Info</p>
        								<ul>
        									<li><a href="{$this->url([], 'ajuda', TRUE)}" rel="nofollow">Ajuda</a></li>
        									<li><a href="{$this->url([], 'contato', TRUE)}" rel="nofollow">Contato</a></li>
        									<li><a href="{$this->url([], 'quemsomos', TRUE)}" rel="nofollow">Quem Somos</a></li>
        									<li><a href="{$this->url([], 'imprensa', TRUE)}" rel="nofollow">Imprensa</a></li>
        									<li class="has-tooltip">
        										<a href="#" class="hover-me">Trocas &amp; Devoluções</a>
        										<div class="tooltip">
        											A Reverbcity garante a troca de qualquer um de seus produtos,
        											sem ônus para o cliente, caso seja constatado defeito na peça.
        											Se o cliente quiser trocar uma peça (sem uso) por qualquer
        											outro motivo, ele deverá cobrir despesas de frete.
        											<a class="tooltip-link" href="{$this->url([], 'contato', TRUE)}">Clique aqui em fale conosco.</a>
        										</div>
        									</li>
        								</ul>
        							</div>
        							<div class="links-social">
        								<ul class="clearfix">
        									<li>
        										<a href="https://www.facebook.com/Reverbcity" title="Abrir a página de Facebook" target="_blank" class="icon facebook ir">Facebook</a>
        									</li>
        									<li>
        										<a href="https://twitter.com/reverbcity" title="Abrir a página de Twitter" target="_blank" class="icon twitter ir">Twitter</a>
        									</li>
        									<li>
        										<a href="http://reverbcity.tumblr.com/" title="Abrir a página de Tumblr" target="_blank" class="icon tumblr ir">Tumblr</a>
        									</li>
        									<li>
        										<a href="https://plus.google.com/+reverbcity" rel="publisher" title="Abrir a página de Flickr" target="_blank" class="icon flickr ir">Google+</a>
        									</li>
        									<li>
        										<a href="https://www.youtube.com/user/reverbcity" title="Abrir a página de Youtube" target="_blank" class="icon youtube ir">Youtube</a>
        									</li>
        									<li>
        										<a href="https://instagram.com/reverbcity" title="Abrir a página de Instagram" target="_blank" class="icon instagram ir">Instagram</a>
        									</li>
        									<li class="last">
        										<a href="https://pinterest.com/reverbcity/" title="Abrir a página de Pinterest" target="_blank" class="icon pinterest ir">Pinterest</a>
        									</li>
        								</ul>
        							</div>
        							<div class="payments ir" style="margin-top: 7px;">
        								Aceitamos Cartões Visa, MasterCard, American Express, Dinner e Boleto.
        							</div>
        							<div class="footer-newsletter clearfix">
        								<p class="title">Novidades</p>
        								<form action="{$this->url([], 'assinanews', TRUE)}" method="POST">
        									<div class="form-field" >
        										<input type="email" name="newsletter-email" id="newsletter-email" placeholder="E-MAIL">
        										<button type="submit" class="btn">Assine</button>
        									</div>
        								</form>
        								<p class="subtitle">Receba notícias, novidades, promoções...</p>
        								<address class="clearfix">
        									<span>Rua Ibiporã, 995 Jardim Aurora</span>
        									<span>CEP:  86060-510 Londrina/PR – F: (43) 3322-8852</span>
        									<span>CNPJ: 08.345.875/0001-37 | Insc. Est.: 90385677-70</span>
                                                                                <span>WhatsApp: (43) 9834-4166</span>
        								</address>
        							</div>
        						</div>
        					</div>
        				</div>
        			</footer>
        			<!-- lightbox de compras internacionais -->
        			<div class="md-modal md-effect-1" id="international-purchases-lightbox">
        				<div class="md-content">
        					<p class="md-title">For international purchase, contact us:</p>
        					<div class="mg-bg">
        						<button class="md-close ir">Fechar</button>
        						<p>Fill up the form for international purchase</p>
        						<form action="{$this->url([], 'international', TRUE)}" method="post" id="form-international-purchases">
        							<div class="input-text left">
        								<input type="text" name="name-ip" id="name-ip" placeholder="Name" required>
        							</div>
        							<div class="input-text right">
        								<input type="email" name="email-ip" id="email-ip" placeholder="E-mail" required>
        							</div>
        							<div class="input-text left">
        								<input type="text" name="country-ip" id="country-ip" placeholder="Country" required>
        							</div>
        							<div class="input-text right">
        								<input type="text" name="city-ip" id="city-ip" placeholder="City" required>
        							</div>
        							<div class="text-box">
        								<textarea name="message-ip" id="message-ip" cols="1" rows="5" placeholder="Message" required></textarea>
        							</div>
        							{*<div class="insert-captcha">*}
        							{*<label>*}
        							{*<img src="{$basePath}/thumb/captcha/1/115/45/{$this->idCaptcha}.png" alt="captcha" height="45" width="115">*}
        							{*<!--  <input class="input-box" type="text" id="contato-captcha-code" name="captcha"> -->*}
        							{*<input name="captcha[input]" type="text" class="input-box" maxlength="3" title="Digite os caracteres da imagem" id="contato-captcha-code">*}
        							{*</label>*}
        							{*<input id="captcha" name="captcha[id]" value="{$this->idCaptcha}" type="hidden">*}
        							{*<span>Captcha</span>*}
        							{*</div>*}
        							<div class="send-button">
        								<button type="submit" class="btn">Send</button>
        							</div>
        						</form>
        					</div>
        				</div>
        			</div>
        			<!-- lightbox de rastreamento -->
        			<div class="md-modal md-effect-1" id="tracking-lightbox">
        				<div class="md-content">
        					<p class="md-title">Rastreamento de pedidos</p>
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<p>Quer saber onde anda o seu pedido antes de chegar na sua casa? Digite o código de rastreamento no campo abaixo para descobrir:</p>
        						<form action="https://www.correios.com.br/servicos/rastreamento/remoto.cfm" name="rastreamento" target="_blank" method="post" id="form-rastreamento" class="md-bg" >
        							<label class="rvb-label" for="codigo-rastreamento">Código dos correios</label>
        							<input class="rvb-input-txt" name="p_codigo" id="codigo-rastreamento" type="text" required>
        							<p class="tam-p">Se o seu pedido for <b style="color: #5fbf98; font-weight: bold;">TAM</b>, <a href="https://www.tamcargo.com.br/vgn/v/index.jsp?vgnextoid=151b0943ede32310VgnVCM1000009508020aRCRD" target="_blank">clique aqui</a></p>
        							<div class="send-button">
        								<button type="submit" class="btn">Rastrear</button>
        							</div>
        						</form>
        						<p>Caso haja algum problema, entre em contato através do <a class="simple-anchor" href="mailto:atendimento@reverbcity.com">atendimento@reverbcity.com</a></p>
        					</div>
        				</div>
        			</div>
        			<!-- lightbox recuperar senha -->
        			<div class="md-modal md-effect-1" id="lightbox-recuperar-senha">
        				<div class="md-content">
        					<p class="md-title">Recuperar senha</p>
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<p>Digite seu email receber uma nova senha:</p>
        						<form action="{$this->url([], "recuperarsenha", TRUE)}" name="recuperarsenha" method="post" id="form-recuperar" class="rvb-form" >
        							<label class="rvb-label" for="recuperar_email">Email:</label>
        							<input class="rvb-input-txt" name="email" id="recuperar_email" type="text" required>
        							<div class="send-button">
        								<button type="submit" class="btn">Recuperar</button>
        							</div>
        						</form>
        						<p>Caso haja algum problema, entre em contato através do atendimento@reverbcity.com</p>
        					</div>
        				</div>
        			</div>
        			{$this->headScript()}

        			{if $popupNiver}
        			<!-- lightbox aniversariante -->
        			<div class="md-modal md-effect-1" id="lightbox-aniversariante">
        				<div class="md-content" style="width: 503px;">
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<a href="{$basePath}/todos-produtos">
        							<img src="{$basePath}/arquivos/default/images/banner_niver.jpg" />
        						</a>
        					</div>
        				</div>
        			</div>
        			<a href="#" id="md-aniversariante" data-modal="lightbox-aniversariante" class="md-trigger"></a>
        			<script type="text/javascript">
        			$(window).load(function(){
        				if(/bot|googlebot|crawler|spider|robot|crawling/i.test(navigator.userAgent) == false){
        					$('#md-aniversariante').click();
        				}
        			});
        			</script>
        			{/if}

        			<!-- lightbox primera -->
        <!-- {if $popupPrimeira}
            <div class="md-modal md-effect-1" id="lightbox-primeira">
                <div class="md-content" style="width: auto;">
                    <div>
                        <button class="md-close ir">Fechar</button>
                        <img src="{$basePath}/arquivos/default/images/banner_primeira.png" style="width: 100%" />
                        <form action="{$this->url([], 'assinanews', TRUE)}" method="POST">
                            <input type="email" required placeholder="E-MAIL" name="newsletter-email" style="position: absolute;margin-left: 25%;bottom: 20px;width: 25%;;height: 30px;" />
                            <button type="submit" style="position: absolute;margin-left: 51%;bottom: 20px;width: 165px;height: 30px;background-color: #000000;color: #ffffff; border: solid 1px #55bf9d;-webkit-border-radius: 7px;-moz-border-radius: 7px;border-radius: 7px; font-weight: bold; cursor: pointer;">QUERO ME CADASTRAR!</button>
                        </form>
                    </div>
                </div>
            </div>
            <a href="#" id="md-primeira" data-modal="lightbox-primeira" class="md-trigger"></a>
            <script type="text/javascript">
                $(window).load(function(){
                    if(/bot|googlebot|crawler|spider|robot|crawling/i.test(navigator.userAgent) == false) {
                        $('#md-primeira').click();
                    }
                });
            </script>
            {/if} -->

            <div class="md-overlay"></div>
            <!-- scripts -->
            {*<script type="text/javascript" src="//selo.sitesustentavel.com.br/selo_sustentavel.js"></script>*}
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
            	var js, fjs = d.getElementsByTagName(s)[0];
            	if (d.getElementById(id)) return;
            	js = d.createElement(s); js.id = id;
            	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=237745386316222";
            	fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <script type="text/javascript">
          // document.basePath = '{$basePath}';
          //document.basePath = '/reverbcity';
          </script>

          {*<script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-1277643-30']);
          _gaq.push(['_trackPageview']);
          _gaq('require', 'displayfeatures');

          (function() {
          	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
          	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
      </script>*}
      {if $currentController == 'loja' && $currentAction == 'produto'}
      <script type="text/javascript">
      var google_tag_params = {
      	ecomm_prodid: "{$produto->NR_SEQ_PRODUTO_PRRC}",
      	ecomm_pagetype: "product",
      	ecomm_totalvalue: "{$produto->VL_PRODUTO_PRRC}"
      };
      </script>
      {/if}
      {literal}
      <script>
      (function() {
      	var _fbq = window._fbq || (window._fbq = []);
      	if (!_fbq.loaded) {
      		var fbds = document.createElement('script');
      		fbds.async = true;
      		fbds.src = '//connect.facebook.net/en_US/fbds.js';
      		var s = document.getElementsByTagName('script')[0];
      		s.parentNode.insertBefore(fbds, s);
      		_fbq.loaded = true;
      	}
      	_fbq.push(['addPixelId', '533464170121834']);
      })();
      window._fbq = window._fbq || [];
      window._fbq.push(['track', 'PixelInitialized', {}]);
      </script>
      <noscript>
      	<img height="1" width="1" alt="Facebook Pixel" style="display:none" src="https://www.facebook.com/tr?id=533464170121834&amp;ev=PixelInitialized" />
      </noscript>
      <script type="text/javascript">
      /* <![CDATA[ */
      var google_conversion_id = 1047813471;
      var google_custom_params = window.google_tag_params;
      var google_remarketing_only = true;
      /* ]]> */
      </script>
      {/literal}
      {*<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">*}
      {*</script>*}
      {*<noscript>*}
      {*<div style="display:inline;">*}
      {*<img height="1" width="1" style="border-style:none;" alt="Double Click" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1047813471/?value=0&amp;guid=ON&amp;script=0"/>*}
      {*</div>*}
      {*</noscript>*}

      {*<script type="text/javascript" src="https://reverbcity.com/clickheat/js/clickheat.js"></script><script type="text/javascript"><!--*}
      {*clickHeatSite = 'www.reverbcity.com';*}
      {*clickHeatGroup = '{$currentController}/{$currentAction}';*}
            {*clickHeatServer = 'https://reverbcity.com/clickheat/click.php';initClickHeat(); //-->*}
            {*</script>*}
            <!-- Código do Google para tag de remarketing teste-->
        <!--------------------------------------------------
        As tags de remarketing não podem ser associadas a informações pessoais de identificação nem inseridas em páginas relacionadas a categorias de confidencialidade. Veja mais informações e instruções sobre como configurar a tag em: http://google.com/ads/remarketingsetup
        --------------------------------------------------->

        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1047813471;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1047813471/?value=0&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
        <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
        <script type="text/javascript">twttr.conversion.trackPid('l5zln', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
        <noscript>
            <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l5zln&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
            <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l5zln&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
        </noscript>
		

		{if $_isMobile neq 1}
	        {literal}
	        <!--Start of Zopim Live Chat Script-->
	        <script type="text/javascript">
	        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	        	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	        		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
	        		$.src='//v2.zopim.com/?2Z58nkKSaFYfK6W9xTVaK5iULjxTJQTu';z.t=+new Date;$.
	        		type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
			</script>
			<!--End of Zopim Live Chat Script-->
			{/literal}

			{if $_logado}
			<script>
	        		$zopim(function(){
	        			$zopim.livechat.setName('{$_nome_usuario}');
	        			$zopim.livechat.setEmail('{$_email_usuario}');
	        		});
			</script>
			{/if}
		{/if}
		
		{literal}
		<!-- GOOGLE ANALITYCS -->
		<script type="text/javascript">
        		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        		ga('create', 'UA-38700671-1', 'auto');
        		ga('require', 'displayfeatures');
        		ga('require', 'ecommerce');
        		ga('require', 'linkid', 'linkid.js');
        		ga('send', 'pageview');

		</script>
		{/literal}
		{if $currentAction eq "finalizar" and ($compra->ST_COMPRA_COSO == 'A' or $compra->ST_COMPRA_COSO == 'P')}
			{literal}
			<script>
	        		ga('ecommerce:addTransaction', {
	        			'id': '{$compra->NR_SEQ_COMPRA_COSO}',
	        			'affiliation': 'Reverbcity.com',
	        			'revenue': '{$compra->VL_TOTAL_COSO}',
	        			'shipping': '{$compra->VL_FRETE_COSO}',
	        			'tax': '0'
	        		});

	        		{foreach from=$carrinho item=dadosProduto}
	        		ga('ecommerce:addItem', {
	        			'id': '{$compra->NR_SEQ_COMPRA_COSO}',
	        			'name': '{$dadosProduto['nome']}',
	        			'sku': '{$dadosProduto['codigo']}',
	        			'price': '{$dadosProduto['valor']|number_format:2:".":""}',
	        			'quantity': '{$dadosProduto['quantidade']}'
	        		});
	        		{/foreach}
	        		ga('ecommerce:send');
			</script>

			<script type="text/javascript">
				document.valorCompra = '{$compra->VL_TOTAL_COSO}';
			</script>
	        <script type="text/javascript">
	    		(function() {
	    			var _fbq = window._fbq || (window._fbq = []);
	    			if (!_fbq.loaded) {
	    				var fbds = document.createElement('script');
	    				fbds.async = true;
	    				fbds.src = '//connect.facebook.net/en_US/fbds.js';
	    				var s = document.getElementsByTagName('script')[0];
	    				s.parentNode.insertBefore(fbds, s);
	    				_fbq.loaded = true;
	    			}
	    		})();
	    		window._fbq = window._fbq || [];
	    		window._fbq.push(['track', '6007459841147', {'value':document.valorCompra,'currency':'BRL'}]);
			</script>
			<noscript>
				<img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6007459841147&amp;cd[value]={$compra->VL_TOTAL_COSO}&amp;cd[currency]=BRL&amp;noscript=1" />
			</noscript>	
	     	{/literal}
		{/if}

		{* BUSCAR O MENU TOPO *}
		
		<script type="text/javascript">
			var isMobile = {if $_isMobile eq 1} 1 {else} 0 {/if}
			{literal}			
			$.get('/topbar?isMobile=' + isMobile.toString(), function (response) {
				$('#top-bar').html(response);
			});
			{/literal}
		</script>		
		

    </body>
</html>
{/strip}