<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Páginas</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos.php?aba==3';">Categorias Cadastradas</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Categoria</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						 <?php
						  $idc = request("idc");
                          $sql = "select DS_CATEGORIA_PTRC, DS_NCM_PTRC from produtos_tipo WHERE NR_SEQ_CATEGPRO_PTRC = $idc";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	 $row = mysql_fetch_row($st);
					         $titulo	   = $row[0];
							 $ds_texto	   = $row[1];
						 ?>
                         <form action="prod_tipo_alt2.php" method="post">
                         <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_cat">
                                       Tipo:<br />
                                       <input class="form02" type="text" id="nome_cat" name="nome_cat" value="<?php echo $titulo; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="ncm">
                                       C&oacute;digo NCM:<br />
                                       <input class="form01" type="text" id="ncm" name="ncm" value="<?php echo $ds_texto; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Tipo" />
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
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>