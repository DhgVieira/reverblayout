<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$pg = request("pg");
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Blogs</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='blog.php';">Blogs Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Blog</li>
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
						 $idb = request("idb");
						  $sql = "select NR_SEQ_CATEGORIA_BLRC, NR_SEQ_COLUNISTA_BLRC, DS_TITULO_BLRC, DS_TEXTO_BLRC,
                                         DS_YOUTUBE_BLRC, DS_LINKIMAGEM_BLRC, DT_PUBLICACAO_BLRC from blog WHERE NR_SEQ_BLOG_BLRC = $idb";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_categ	   = $row[0];
					         $id_colun	   = $row[1];
							 $ds_titulo	   = $row[2];
							 $ds_texto	   = $row[3];
							 $youtube	   = $row[4];
                             $linkfoto     = $row[5];
                             $datapub      = $row[6];
							}
						  }
						 ?>
                         <form action="blog_alt2.php" method="post" name="myform" enctype="multipart/form-data">
                         <input name="idb" type="hidden" value="<?php echo $idb; ?>" />
                         <input name="pg" type="hidden" value="<?php echo $pg; ?>" />
                            <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="datapub">
                                       Data de Publica&ccedil;&atilde;o:<br />
                                       <input class="form03" type="text" id="datapub" name="datapub" value="<?php echo date("d/m/Y G:i", strtotime($datapub));?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome_post">
                                       T&iacute;tulo da Postagem:<br />
                                       <input class="form02" type="text" id="nome_post" name="nome_post" value="<?php echo $ds_titulo; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                       <label for="Colunista">
                                       Colunista:<br />
                                       <select name="colunista">
                                       <?php
                                       $sql = "select NR_SEQ_COLUNISTA_CORC, DS_COLUNISTA_CORC from colunistas order by DS_COLUNISTA_CORC";
                                       $st = mysql_query($sql);
            
                                       if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $id_col	   = $row[0];
                                         $nome		   = $row[1];
                                        ?>
                                       <option value="<?php echo $id_col;?>"><?php echo $nome;?></option>
                                       <?php
                                         }
                                       }
                                       ?>
                                       </select>
                                       </label>
                                   </li>
                                   <li>
                                       <label for="categoria">
                                       Categoria:<br />
                                       <select name="categoria">
                                       <?php
                                       $sql = "select NR_SEQ_BLOGCAT_BCRC, DS_CATEGORIA_BCRC from blog_categorias order by DS_CATEGORIA_BCRC";
                                       $st = mysql_query($sql);
            
                                       if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $id_cat	   = $row[0];
                                         $nome		   = $row[1];
                                        ?>
                                       <option value="<?php echo $id_cat;?>"><?php echo $nome;?></option>
                                       <?php
                                         }
                                       }
                                       ?>
                                       </select>
                                       </label>
                                   </li>
                                   <li>
                                      <label for="foto">
                                        Alterar Imagem:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                    <li>
                                      <label for="linkfoto">
                                        Link para Imagem (n&atilde;o obrigat&oacute;rio):<br />
                                        <input type="text" name="linkfoto" size="40" class="form02" style="height:25px;" value="<?php echo $linkfoto ?>" />
                                      </label>
                                    </li>
                                   <li>
                                      <label for="foto">
                                        Video do Youtube:<br />
                                        <textarea name="youtube" class="form02"style="height:100px;"><?php echo $youtube;?></textarea>
                                      </label>
                                    </li>
                                   <li>
                                     <label for="blogpost">
                                       Conteúdo:<br />
									   <?php
										$oFCKeditor = new FCKeditor('FCKeditor1') ;
										$oFCKeditor->ToolbarSet = 'MyToolbar';
										$oFCKeditor->BasePath = 'fckeditor/' ;
										$oFCKeditor->Height = 400 ;
										$oFCKeditor->ForceSimpleAmpersand = false ;
										$oFCKeditor->Value = $ds_texto ;
										$oFCKeditor->Create('blogpost');
										?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Post" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    	<script language="JavaScript">
						   document.myform.colunista.value = "<?php echo $id_colun; ?>";
						   document.myform.categoria.value = "<?php echo $id_categ; ?>";
						</script>
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