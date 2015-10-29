<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pg");
$idp = request("idp");
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc) {
	var confirma = confirm("Confirma a exclusao desse comentario?")
	if ( confirma ){
		document.location.href='classics_coments_del.php?idc='+idc+'&idp=<?php echo $idp; ?>';
	} else {
		return false
	} 
}
</script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Classics</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='classics.php?pagina=<?php echo $pagina; ?>';">Classics Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Comentarios</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						
                        <ul class="noticias">
                          	   <li>
                               <table width="860" class="noticias">
                                    <tr>
                                        <td width="110" align="center"><strong>Data</strong></td>
                                        <td><strong>Post</strong></td>
                                        <td width="20" align="center"><strong>ST</strong></td>
                                        <td width="140"><strong>Autor</strong></td>
                                        <td width="20" align="center">&nbsp;</td>
                                        <td width="20" align="center">&nbsp;</td>
                                    </tr>
                                </table>
                               </li>
                            <?
                              $sql = "select NR_SEQ_COMENTARIO_CLRC, DS_NOME_CASO, DS_TEXTO_CLRC, DT_CADASTRO_CLRC, DS_STATUS_CLRC from classics_coments, cadastros WHERE NR_SEQ_CADASTRO_CLRC = NR_SEQ_CADASTRO_CASO and NR_SEQ_PRODUTO_CLRC = $idp order by DT_CADASTRO_CLRC desc";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_coment	   = $row[0];
                                 $nm_post	   = $row[1];
                                 $ds_texto	   = $row[2];
								 $dt_post	   = $row[3];
								 $st_post	   = $row[4];
                                ?>
                                <li>
                                <table width="860" class="noticias">
                                    <tr>
                                        <td width="110" align="center"><strong><?php echo date("d/m/Y G:i", strtotime($dt_post));?></strong></td>
                                        <td><?php echo $ds_texto;?></td>
                                        <td width="20" align="center"><strong><?php echo $st_post; ?></strong></td>
                                        <td width="140"><?php echo $nm_post; ?></td>
                                        <td width="20" align="center"><a href="classics_coments_sta.php?st=<?php echo $st_post; ?>&idc=<? echo $id_coment;?>&idp=<?php echo $idp; ?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                        <td width="20" align="center"><a href="#" title="deletar comentario" onclick="confirma(<?php echo $id_coment; ?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    </tr>
                                </table>
                                </li>
                                <?
                                }
                              }
                            ?>
                          </ul>
                        
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
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
