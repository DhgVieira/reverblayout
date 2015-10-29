<? include 'auth.php'; ?>
<? include 'lib.php'; ?>
<?
$id_spam 	= request("id_spam");
$msg		= request("msg");

$sql = "select count(*) from cadastros where ST_SPAM_CACH = 'S'";
$st = mysql_query($sql);
$row = mysql_fetch_row($st);

$total  = $row[0];

$sql = "select count(*) from Assinante where ST_SPAM_CACH = 'S'";
$st = mysql_query($sql);
$row = mysql_fetch_row($st);

$total  += $row[0];

$str = "update spam set dt_fim = sysdate(), total_enviado = $total, st_status = 'E' where id_spam = $id_spam";
$st = mysql_query($str);
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
                    	
                        <table align="center" class="corpo">
                            <tr>
                                <td align="center"><b><font color="#FF0000"><b>CONTROLE DE NEWSLETTER</font></b><br><br></td>
                            </tr>
                            <tr>
                                <td align="center"><?echo $msg;?> - <b>ENVIO FINALIZADO</b></td>
                            </tr>
                            <tr>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="titulo_categoria_red" align="center"><b>TOTAL DE E-MAILS ENVIADOS: <? echo $total;?></b></td>
                            </tr>
                        </table>
                        <center>
                        <br>
                        <br>
                        <a href="newsletter.php">Clique Aqui para voltar ao Controle de NEWSLETTERS</a>
                        </font>
                        </center>
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
