<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Newsletter</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abaativa">Enviando Newsletter</li>
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='newsletter.php'">Newsletters Cadastrados</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">
                    	 
                        <form action="adminSpam_env1.php" method="post" name="frmmail" id="frmmail">
                        <input type="hidden" name="id_spam" value="<? echo request("id");?>">
                        <input type="hidden" name="nome" value="<? echo request("nome");?>">
                        <input type="hidden" name="data" value="<? echo date;?>">
                        
                        <table align="center" class="corpo" width="810">
                            <tr>
                                <td align="left"><b><font color="#FF0000"><b>ENVIANDO NEWSLETTER - <? echo request("nome");?></font></b><br><br></td>
                            </tr>
                          	<tr>
                                <td><b>Escolha a forma de envio:</b><br><br></td>
                            </tr>
                            <tr>
                                <td align="left" height="30"><b>Enviar E-mails para:</b> <input type="radio" name="tipo" value="0" checked /> Todos <input type="radio" name="tipo" value="1" /> Grupos de E-mail</td>
                            </tr>
                            <tr>
                                <td align="left" height="40">Para o envio a grupos de e-mails selecione os grupos desejados:</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left"><input type="checkbox" name="grupo[]" value="0" onclick="document.frmmail.tipo[1].checked = true;" />&nbsp;&nbsp;<b>Cadastros do Site</b></td>
                             </tr>
                            <?php
                            $sql = "select IdGrupo, Nome from Grupo order by Nome";
                        	$st = mysql_query($sql);
							if (mysql_num_rows($st) > 0) {
                            while($row = mysql_fetch_row($st)) {
                             $idgrupo	   = $row[0];
                             $dsgrupo	   = $row[1];
							?>
                             <tr>
                                <td colspan="2" align="left"><input type="checkbox" name="grupo[]" value="<?php echo $idgrupo; ?>" onclick="document.frmmail.tipo[1].checked = true;" />&nbsp;&nbsp;<b><?php echo $dsgrupo; ?></b></td>
                             </tr>
                             <?php
                             }
							 }else{
							 ?>
                            <tr>
                                <td align="left" height="50">Nenhum grupo de E-mail Cadastrado</td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="left"><input type="submit" value="Clique aqui para Iniciar o Envio" class="form01" style="height:25px;"></td>
                            </tr>
                        </table>
                        </form>
                        <br>
                        <font class="corpo"><b>ATENCAO:</b> Apos o inicio do NEWSLETTER So feche o navegador quando a mensagem:<br>
                        <br>
                        <b>ENVIO FINALIZADO aparecer, caso contrario o envio nao sera completo.</b>
                        <br>
                        </font>
                        <br>
                    <br>
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
