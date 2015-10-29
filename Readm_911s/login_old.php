<?php
include 'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>

	<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.3)">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
    <title>Sistema Administrativo</title>
    <link rel="stylesheet" href="css/estilos.css" type="text/css" media="screen" />

</head>

<body>

	<div id="tudo">
    
    	<div id="corpo">

        	<div id="conteudo_index">
            
            	<h2>Reverb City Administração</h2>
                Aqui você poderá gerenciar o conteúdo de seu Website...
                
                <p>Você poderá navegar pelo menu principal e acessar todas as funcionalidades do seu sistema.</p>
                
                <h2>Login</h2>
                Digite seu login e senha nos campos abaixo para logar.
                
                 <form action="valida.php" method="post">
                     <fieldset>
                         <ul class="formularios">
                           <li>
                             <label for="login">
                               Login:<br />
                               <input class="form00" style="width:120px;" type="text" id="login" name="login" />
                             </label>
                           </li>
                           <li>
                             <label for="senha">
                               Senha:<br />
                               <input class="form00" style="width:120px;" type="password" id="senha" name="senha" />
                             </label>
                           </li>
                           <li>
                             <input type="submit" id="entrar" name="entrar" value="entrar" />
                           </li>
                           <li>
                                <br />
                                Ip de Acesso: <?php echo get_ip() ?>
                           </li>
                         </ul>
                     </fieldset>
                 </form>
            
            </div> <!-- /conteudo -->
        
        </div> <!-- /corpo -->
            
    </div> <!-- /tudo -->

</body>

</html>
<?php
mysql_close($con);
?>