<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<? include 'topo.php'; ?>
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
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='paginas.php';">Páginas Cadastradas</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterar Página</li>
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
                          $sql = "select DS_TITULO_PASA, DS_TEXTO_PASA from paginas WHERE NR_SEQ_PAGINA_PASA = $idp";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	 $row = mysql_fetch_row($st);
					         $titulo	   = $row[0];
							 $ds_texto	   = $row[1];
						 ?>
                         <form action="paginas_alt2.php" method="post">
                         <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Título da página:<br />
                                       <input class="form02" type="text" id="nome_noticia" name="nome_noticia" value="<?php echo $titulo; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="pagina">
                                       Página Conteúdo:<br />
									   <?php
										$oFCKeditor = new FCKeditor('FCKeditor1') ;
										$oFCKeditor->ToolbarSet = 'MyToolbar';
										$oFCKeditor->BasePath = 'fckeditor/' ;
										$oFCKeditor->Height = 400 ;
										$oFCKeditor->ForceSimpleAmpersand = false ;
										$oFCKeditor->Value = $ds_texto;
										$oFCKeditor->Create('pagina');
										?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar pagina" />
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
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
