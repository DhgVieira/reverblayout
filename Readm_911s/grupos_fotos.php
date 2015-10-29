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
					<?php $idp = request("idp"); ?>
                    <table width="880">
                    	<tr>
                        	<td>
                                 <form action="grupos_fotos2.php" method="post" enctype="multipart/form-data">
                                 <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                                     <fieldset>
                                         <ul class="formularios">
                                           <li>
                                             <label for="nome_noticia">
                                               Nova Imagem:<br />
                                               <input class="form02" type="file" name="FILE1[]" style="width:435px;height:26px;" multiple/>
                                             </label>
                                           </li>
                                           <li>
                                             <label for="legenda">
                                               Legenda:<br />
                                               <input class="form02" type="text" id="legenda" name="legenda" />
                                             </label>
                                           </li>
                                           <li>
                                             <input type="submit" id="postar" name="postar" value="Cadastrar Imagem" />
                                           </li>
                                         </ul>
                                     </fieldset>
                                 </form>
                    		</td>
                         </tr>
                         <tr><td>
                                <ul class="noticias">
                                <form action="grupo_fotos_ordem.php" method="post">
                                <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                                <?php
                                $sql = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, NR_ORDEM_FORC, ZOOM_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $idp
										ORDER BY NR_ORDEM_FORC, NR_SEQ_FOTO_FORC";
                                $st = mysql_query($sql);
                
                                if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)) {
                                        $idfoto = $row[0];
                                        $extens = $row[1];
										$legend = $row[2];
										$posicao = $row[3];
										$zoom	= $row[4];
                                    ?>
                                    <li>
                                      <table width="550">
                                      	<tr>
                                        	<td width="105" align="center">
                                            	<input style="width:30px; margin:0 0 10px 0;" type="text" name="ordem[]" value="<?php echo $posicao; ?>" class="frm_pesq" /><br />
												<input type="hidden" value="<? echo $idfoto;?>" name="fotos[]" />
                                               </td>
                                        	<td width="92">
                                            	<?php if ($extens == "swf") {?>
                                                <object data="../arquivos/uploads/fotosprodutos/<?php echo $idfoto;?>.<?php echo $extens;?>" type="application/x-shockwave-flash" width="82" height="68">
                                                  <param name="quality" value="high" />
                                                  <param name="movie" value="../arquivos/uploads/fotosprodutos/<?php echo $idfoto;?>.<?php echo $extens;?>" />
                                                  <param name="wmode" value="opaque" />
                                                </object>
                                                <?php }else{ ?>
                                                <img src="/thumb/fotosprodutos/1/82/68/<?php echo $idfoto;?>.<?php echo $extens;?>" width="82" height="68" />
                                                <?php }?>
                                                <br />
                                       			<a href="exc_foto.php?id=<?php echo $idfoto;?>&idp=<?php echo $idp;?>&ext=<?php echo $extens;?>">excluir foto</a>
                                            </td>
                                            <td>
                                            	<?php echo $legend ?>
                                                <br />
												<a href="alt_fotos.php?id=<?php echo $idfoto;?>&idp=<?php echo $idp;?>&ext=<?php echo $extens;?>">alterar texto</a>
                                            </td>
                                        </tr>
                                      </table>
                                    </li>
                                    <?
                                    }
                                }
                                mysql_close($con);
                                ?>
                                <input type="submit" value="Altera Ordem das fotos" class="frm_pesq" style="width:150px;" />
                                </form>                                
                                </ul>
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
