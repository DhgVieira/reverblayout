<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Usu&aacute;rios</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='usuarios.php';">Usu&aacute;rios Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Usu&aacute;rio</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<?
						 $idu = request("idu");
						  $sql = "select DS_LOGIN_USRC, DS_SENHA_USRC, DS_EMAIL_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC = $idu";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $login	   = $row[0];
					         //$senha	   = $row[1];
                             $email	   = $row[2];
                             
                             $email = str_replace("@reverbcity.com","",$email);
							}
						  }
						 ?>
                         <form action="usuario_alt2.php" method="post">
                         	<input name="idu" type="hidden" value="<?php echo $idu ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="login">
                                       Login:<br />
                                       <input class="form00" type="text" id="login" name="login" value="<?php echo $login ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="senha">
                                       Senha:<br />
                                       <input class="form00" type="password" id="senha" name="senha" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email">
                                       E-Mail:<br />
                                       <input class="form00" type="text" id="email" name="email" value="<?php echo $email ?>" maxlength="20" />@reverbcity.com
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Usuario" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
<?php mysql_close($con);?>
