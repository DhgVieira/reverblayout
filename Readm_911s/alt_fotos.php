<?php
include 'auth.php';
include 'lib.php';
?>
<? include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Produtos Imagens</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='grupos.php';">Produtos Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Imagens do Produto</li>
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
						$idp = request("idp");
						$id = request("id");
						$ext = request("ext");
					?>
                    <table width="880">
                    	<tr>
                        	<td>
                            	<?
                                $sql = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC FROM fotos WHERE NR_SEQ_FOTO_FORC = $id";
                                $st = mysql_query($sql);
                
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $idfoto = $row[0];
                                    $extens = $row[1];
									$legend = $row[2];
								}
                                ?>
                                <table>
                                	<tr>
                                    	<td width="90">
                                        	<img src="../arquivos/uploads/fotosprodutos/<?php echo $idfoto;?>.<?php echo $extens;?>" />
                                        </td>
                                        <td>
                                        <form action="alt_fotos2.php" method="post" enctype="multipart/form-data">
                                         <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                                         <input name="id" type="hidden" value="<?php echo $id; ?>" />
                                             <fieldset>
                                                 <ul class="formularios">
                                                   <li>
                                                     <label for="legenda">
                                                       Legenda:<br />
                                                       <input class="form02" type="text" id="legenda" name="legenda" value="<?php echo $legend; ?>" />
                                                     </label>
                                                   </li>
                                                   <li>
                                                     <input type="submit" id="postar" name="postar" value="Alterar Texto" />
                                                   </li>
                                                 </ul>
                                             </fieldset>
                                         </form>
                                        </td>
                                    </tr>
                                </table>
                    		</td>
                         </tr>
                    </table>
                    </div> <!-- /criar -->
                    
                    <script>
                      defineAba("abaCriar","Criar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
