<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="abaGraficos" class="abaativa">GR&Aacute;FICOS</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas" style="width: 100%;">
                      <li id="menuDepo" class="abainativa" onMouseOver='trataMouseAba(this);' onclick="document.location.href='graficos.php'">Atividade M&ecirc;s atual</li>
                      <li id="menuDepo" class="abainativa" onMouseOver='trataMouseAba(this);' onclick="document.location.href='grafico_ticketmed.php'">Cadastros x Ticket</li>
                      <li id="menuDepo" class="abaativa">Prim. Compra x Ticket</li>
                    </ul>
                </td>
                <td height="20" align="right" valign="middle">
                	&nbsp;
                </td>
            </tr>
            <tr>
            	<td align="left" bgcolor="#FFFFFF" colspan="2">
                <p>&nbsp;</p>
                <img src="grafico_primeiracompra.php?ano=<?php echo date('Y'); ?>" />
                </td>
            </tr>
        </table>
    
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>