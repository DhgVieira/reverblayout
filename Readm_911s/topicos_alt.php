<?php
include 'auth.php';
include 'lib.php';

$idf = request("idf");

$sql = "select DS_FORUM_FOSO from foruns where NR_SEQ_FORUM_FOSO = $idf";
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
                      <li id="menuDepo" class="abaativa">Topicos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='topicos.php?idf=<?php echo $idf; ?>'">Topicos Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Topico</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                <br />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forum do Topico: <strong><?php echo $nm_forum; ?></strong>
                
                    <div id="Criar">
						 <?php
						  $idt = request("idt");
                          $sql = "select DS_TOPICO_TOSO, DS_NOME_CASO from topicos, cadastros where NR_SEQ_CADASTRO_TOSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_TOPICO_TOSO = $idt";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						     $row = mysql_fetch_row($st);
					         $ds_topico	   = $row[0];
							 $ds_nome	   = $row[1];
						 ?>
                         <form action="topicos_alt2.php" method="post">
                         <input name="idf" type="hidden" value="<?php echo $idf; ?>" />
                         <input name="idt" type="hidden" value="<?php echo $idt; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Autor:<br />
                                       <strong><?php echo $ds_nome; ?></strong>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome_noticia">
                                       Nome do Topico:<br />
                                       <input class="form02" type="text" name="nome" value="<?php echo $ds_topico; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar topico" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    	 <?php
                         }
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
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
