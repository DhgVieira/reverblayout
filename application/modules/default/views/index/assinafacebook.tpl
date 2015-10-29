<div id="fb-root"></div>
<link href="https://www.reverbcity.com/arquivos/default/css/default.css" media="screen" rel="stylesheet" type="text/css">
<link href="https://www.reverbcity.com/arquivos/application/css/default/index/assinafacebook.css" media="screen" rel="stylesheet" type="text/css">
<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId  : 118127565046708,
            status : true,
            cookie : true,
            xfbml  : true 
        });
        FB.Canvas.setAutoResize(); //set size according to iframe content size
    };
    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
    <div style="width: 100%; background-color: #63be99; height: 38px; position: relative;"></div>
	<div style="position: relative; width: 605px; margin-left: -302px; left: 50%;">
    <div style="background: url(images/topo_newsfb.png); width: 605px; height: 168px; position: relative;">
        <p style="margin-top: 115px; margin-left: 15px; color: #414042; width: 460px; position: absolute;"><strong>Inscreva-se na nossa newsletter e fique sabendo como se faz o rock and roll aqui na Reverbcity!</strong></p>
    </div>
    <div style="height: 394px; background-color: #414042; width: 605px; position: relative;">
        <form id="form1" name="form1" method="post" action="{$this->url([], 'assinanews', TRUE)}" style="margin: 74px 0 0 35px; position: absolute;">
            <input id="nome" onfocus="" onblur="" name="nome" type="text" style="background:#FFFFFF; width:521px; height: 48px; border:0; color: #414042; padding-left: 10px;" placeholder="NOME" />
            <br />
            <input onfocus="" onblur="" name="newsletter-email" id="email" type="text" style="background:#FFFFFF; width:521px; height: 48px; border:0; color: #414042; margin-top: 45px; padding-left: 10px;" placeholder="E-MAIL" />
            <br />
            <button name="btsubmt" id="btsubmt" type="submit" style="color: #FFFFFF; border:0; background:#63be99; width:210px; height: 48px; margin-top: 60px; margin-left: 160px;"><strong>LET'S ROCK</strong></button>
        </form>
    </div>
    </div>