<?php
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="robots" content="noarchive" />
    <link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />

        
    <title>Reverbcity</title>

</head>

<body>

	<div class="tudo">
    
        <img src="img/login_admin.png" />
    
    	<div class="quadro">
        
             <form action="valida.php" method="post">
                 
                 <div class="nmcpo">LOGIN</div>
                 <div class="inpcpo"><input class="form00" style="margin-left: 1px;" type="text" id="login" name="login" /></div>
                 
                 <div style="clear: both; margin-bottom: 7px;"></div>
                 
                 <div class="nmcpo">SENHA</div>
                 <div class="inpcpo"><input class="form00" type="password" id="senha" name="senha" /></div>
                 
                 <div style="clear: both; margin-bottom: 15px;"></div>
                 
                 <div class="logar">Ip de Acesso: <?php echo get_ip() ?></div>
                 <div class="submit"><input type="image" src="img/bt_login.png" id="entrar" /></div>
                 
                      
             </form>
        
        </div>
            
    </div>

</body>

</html>
<?php
mysql_close($con);
?>