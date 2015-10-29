<?php 
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");
$PHP_SELF = "blog.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idp) {
	var confirma = confirm("Confirma a Exclusao dessa Postagem e seus comentarios?")
	if ( confirma ){
		document.location.href='blog_del.php?pg=<?php echo $pagina; ?>&idp='+idp;
	} else {
		return false
	} 
}

function confirma_col(idc) {
	var confirma = confirm("Confirma a Exclusao dessa Colunista?")
	if ( confirma ){
		document.location.href='colunista_del.php?&idc='+idc;
	} else {
		return false
	} 
}

function confirma_cat(idc) {
	var confirma = confirm("Confirma a Exclusao dessa Categoria?")
	if ( confirma ){
		document.location.href='blog_cat_del.php?&idc='+idc;
	} else {
		return false
	} 
}

function Visualiza(){
    document.frmblog.action = 'blog_visualiza.php';
    document.frmblog.target = '_blank';
    document.frmblog.submit();
}

function Envia(){
    document.frmblog.action = 'blog_inc.php';
    document.frmblog.submit();
}

</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Blog</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Blogs Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Escrever Blog</li>
                      <li id="abaCateg" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Categorias</li>
                      <li id="abaColun" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Colunistas</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    
                    <table width="880">
                    	<tr>
                        	<?php 
							$desc = request("desc");
							?>
                            <form action="blog.php?pagina=<?php echo $pagina; ?>" method="post" name="frm">
                            <td height="20" align="right" valign="middle">
                                <strong>Procurar por:</strong>
                                <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" id="desc" value="<?php echo $desc; ?>" />
                                <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                            </td></form>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                    </table>
                    
                	<ul class="noticias">
						<?php
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_BLOG_BLRC, DS_TITULO_BLRC, DT_PUBLICACAO_BLRC, DS_STATUS_BLRC from blog ";
						  if ($desc){
                              $sql .= "WHERE (DS_TITULO_BLRC like '%$desc%' or DS_TITULO_BLRC like '%".utf8_decode($desc)."%' or DS_TITULO_BLRC like '%".utf8_encode($desc)."%') ";
                          }
                          $sql .= " order by DT_PUBLICACAO_BLRC desc LIMIT $primeiro_registro, $num_por_pagina";
                          $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_blog	   = $row[0];
					         $titulo	   = $row[1];
							 $data		   = $row[2];
							 $status	   = $row[3];
							?>
							<li>
                            <span><strong><?php echo date("d/m/Y G:i", strtotime($data));?></strong> | <?php echo $titulo;?></span>
                            <div>
                            <?php echo "<a href=\"#\" title=\"deletar blog\" onclick=\"confirma($id_blog);\">"; ?>
                                <img src="img/cancel.png" width="16" height="16" />
                            <?php echo "</a>"; ?>
                            </div>
							<div>
                              <a href="blog_alt.php?idb=<?php echo $id_blog;?>&pg=<?php echo $pagina; ?>" title="Alterar blog"><img src="img/ico-det.gif" width="16" height="16" /></a>
                            </div>
                            <div>
                              <a href="blog_coments.php?idp=<?php echo $id_blog;?>&pg=<?php echo $pagina;?>" title="Comentarios"><img src="img/ico_coment.gif" width="16" height="16" /></a>
                            </div>
                            <div>
                              <a href="http://reverbcity.com/post/preview/<?php echo $id_blog;?>" target="_blank" title="Blog Preview"><img src="img/compras_ver.gif" width="16" height="16" /></a>
                            </div>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?php
                        $consulta = "SELECT COUNT(*) FROM blog";
                        if ($desc){
                              $consulta .= " WHERE (DS_TITULO_BLRC like '%$desc%' or DS_TITULO_BLRC like '%".utf8_decode($desc)."%' or DS_TITULO_BLRC like '%".utf8_encode($desc)."%') ";
                          }
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&desc=$desc\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&desc=$desc\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&desc=$desc\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form id="frmblog" name="frmblog" action="blog_inc.php" method="post" enctype="multipart/form-data">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="datapub">
                                       Data de Publicação:<br />
                                       <input class="form03" type="text" id="datapub" name="datapub" value="<?php echo date("d/m/Y G:i");?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome_post">
                                       Título da Postagem:<br />
                                       <input class="form02" type="text" id="nome_post" name="nome_post" />
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
                                        Imagem:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                   <li>
                                      <label for="foto">
                                        Video do Youtube:<br />
                                        <textarea name="youtube" class="form02"style="height:100px;"></textarea>
                                      </label>
                                    </li>
                                   <li>
                                     <label for="blogpost">
                                       Conteúdo:<br />
									   <?php
										$oFCKeditor = new FCKeditor('FCKeditor1') ;
										$oFCKeditor->ToolbarSet = 'MyToolbar';
										$oFCKeditor->BasePath = 'fckeditor/' ;
										$oFCKeditor->Height = 500 ;
										$oFCKeditor->ForceSimpleAmpersand = false ;
										$oFCKeditor->Value = '' ;
										$oFCKeditor->Create('blogpost');
										?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="button" id="visu" name="visu" value="Visualizar" style="margin-right: 15px;" onclick="Visualiza();" />
                                     <input type="button" id="postar" name="postar" value="Cadastrar Post" onclick="Envia();" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
					
                    <div id="Colun">
                    
                    	<form action="colunistas_inc.php" method="post" enctype="multipart/form-data">
                
                                 <ul class="formularios">
                                   <li>
                                     <label for="nomecol">
                                       Nome:<br />
                                       <input class="form02" type="text" id="nomecol" name="nomecol" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="emailcol">
                                       E-Mail:<br />
                                       <input class="form02" type="text" id="emailcol" name="emailcol" />
                                     </label>
                                   </li>
                                   <li>
                                      <label for="fotocol">
                                        Foto:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                   </li>
                                   <li>
                                      <label for="linkfoto">
                                        Link para Imagem (n&atilde;o obrigat&oacute;rio):<br />
                                        <input type="text" name="linkfoto" size="40" class="form02" style="height:25px;" />
                                      </label>
                                    </li> 
                                   <li>
                                      <label for="descricaocol">
                                        Descrição:<br />
                                        <textarea name="descricaocol" class="form02"style="height:100px;"></textarea>
                                      </label>
                                    </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Colunista" />
                                   </li>
                                 </ul>
                  
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Colunistas</strong></span>
							   <div>Alt</div>
                               <div>Exc</div>
                               <div>E-Mail</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_COLUNISTA_CORC, DS_COLUNISTA_CORC, DS_EMAIL_CORC from colunistas order by DS_COLUNISTA_CORC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_colu	   = $row[0];
                                 $nm_colu	   = $row[1];
                                 $em_colu	   = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_colu;?></strong></span>
                                <div>
                                <a href="colunista_alt.php?idc=<?php echo $id_colu;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Colunista" /></a>
                                </div>
                                <div>
                                <a href="#" title="deletar colunista" onclick="confirma_col(<?php echo $id_colu; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div>
                                <a href="mailto:<?php echo $em_colu; ?>"><?php echo $em_colu; ?></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /colunista -->
                    
                    <div id="Categ">
                    
                    	<form action="blog_categ_inc.php" method="post">
               
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_cat">
                                       Nome Categoria:<br />
                                       <input class="form02" type="text" id="nome_cat" name="nome_cat" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Categoria" />
                                   </li>
                                 </ul>
       
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Categorias</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_BLOGCAT_BCRC, DS_CATEGORIA_BCRC from blog_categorias order by DS_CATEGORIA_BCRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_cat	   = $row[0];
                                 $nm_cat	   = $row[1];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_cat;?></strong></span>
                                <div>
                                <a href="#" title="deletar categoria" onclick="confirma_cat(<?php echo $id_cat; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /categoria -->
                    
                    <script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  defineAba("abaColun","Colun");
					  defineAba("abaCateg","Categ");
					  <?php
					  if (!$mostrapag && !$aba) $aba = 1;
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaCriar\");";
							  break;
						  case 2:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					      case 3:
						  	  echo "defineAbaAtiva(\"abaColun\");";
							  break;
						  case 4:
						  	  echo "defineAbaAtiva(\"abaCateg\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");"; 
							  break;
					   }
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>