<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");

$sql = "select DS_CAMPANHA_CARC from campanhas where NR_SEQ_CAMPANHA_CARC = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$nm_forum = $row[0];
}
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Campanhas</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='campanhas.php'">Campanhas Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Campanha</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                <br />
                            
                    <div id="Criar">
                         <form action="campanhas_alt2.php" method="post">
                         <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Nome da Campanha:<br />
                                       <input class="form02" type="text" name="nome" value="<?php echo $nm_forum; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Campanha" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    	 <?php
                 
						 mysql_close($con);
						 ?>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  <?php if (!$mostrapag) {?>
					  defineAbaAtiva("abaCriar");
					  <?php }else{?>
                      defineAbaAtiva("abaVer");
					  <?php }?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>