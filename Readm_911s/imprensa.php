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
	var confirma = confirm("Confirma a Exclusao dessa Postagem?")
	if ( confirma ){
		document.location.href='imprensa_del.php?pg=<?php echo $pagina; ?>&idp='+idp;
	} else {
		return false
	} 
}


// function Visualiza(){
//     document.frmblog.action = 'blog_visualiza.php';
//     document.frmblog.target = '_blank';
//     document.frmblog.submit();
// }

function Envia(){
    document.frmblog.action = 'imprensa_inc.php';
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
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Topicos cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Escrever Topico</li>
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
                            <form action="imprensa.php?pagina=<?php echo $pagina; ?>" method="post" name="frm">
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
					
						  $sql = "select idimprensa, titulo, data_post, post from imprensa ";
						  if ($desc){
                              $sql .= "WHERE (titulo like '%$desc%' or titulo like '%".utf8_decode($desc)."%' or titulo like '%".utf8_encode($desc)."%') ";
                          }
                          $sql .= " order by data_post desc LIMIT $primeiro_registro, $num_por_pagina";
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
                            <?php echo "<a href=\"#\" title=\"deletar imprensa\" onclick=\"confirma($id_blog);\">"; ?>
                                <img src="img/cancel.png" width="16" height="16" />
                            <?php echo "</a>"; ?>
                            </div>
							<div>
                              <a href="imprensa_alt.php?idb=<?php echo $id_blog;?>&pg=<?php echo $pagina; ?>" title="Alterar imprensa"><img src="img/ico-det.gif" width="16" height="16" /></a>
                            </div>
                            <div>
                              <a href="/blog/blog_preview2.php?idb=<?php echo $id_blog;?>" target="_blank" title="imprensa Preview"><img src="img/compras_ver.gif" width="16" height="16" /></a>
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
                        $consulta = "SELECT COUNT(*) FROM imprensa";
                        if ($desc){
                              $consulta .= " WHERE (titulo like '%$desc%' or titulo like '%".utf8_decode($desc)."%' or titulo like '%".utf8_encode($desc)."%') ";
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

                         <form id="frmimprensa" name="frmimprensa" action="imprensa_inc.php" method="post" enctype="multipart/form-data">
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
                                     <label for="link">
                                       Link:<br />
                                       <input class="form02" type="text" id="link" name="link" />
                                     </label>
                                   </li>
                                   <li>
                                      <label for="foto">
                                        Imagem Destaque:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                    <li>
                                      <label for="foto2">
                                        Imagem Secundaria:<br />
                                        <input class="form02" type="file" name="FILE2" style="height:25px;" />
                                      </label>
                                    </li>
                                    <li>
                                      <label for="foto3">
                                        Imagem Secundaria 2:<br />
                                        <input class="form02" type="file" name="FILE3" style="height:25px;" />
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
                                     <!-- <input type="button" id="visu" name="visu" value="Visualizar" style="margin-right: 15px;" onclick="Visualiza();" /> -->
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Post" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
					
                    
                    
                    
                    
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