<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "paginas.php";
?>
<? include 'topo.php'; ?>
<script language="javascript">
function confirma(idp) {
	var confirma = confirm("Confirma a Exclusao dessa página?")
	if ( confirma ){
		document.location.href='paginas_del.php?pg=<?php echo $pagina; ?>&idp='+idp;
	} else {
		return false
	} 
}
</script> 
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
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Páginas Cadastradas</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Escrever Página</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    
                	<ul class="noticias">
						<?
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PAGINA_PASA, DS_TITULO_PASA, DT_CADASTRO_PASA, DS_STATUS_PASA from paginas order by DS_TITULO_PASA LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_pag	   = $row[0];
					         $titulo	   = $row[1];
							 $data		   = $row[2];
							 $status	   = $row[3];
							?>
							<li>
                            <span><strong><?php echo date("d/m/Y", strtotime($data));?></strong> | <?php echo $titulo;?></span>
                            <div>
                            <?php if ($status == "E") echo "<a href=\"#\" title=\"deletar notícia\" onclick=\"confirma($id_pag);\">"; ?>
                                <img src="img/cancel.png" width="16" height="16" />
                            <?php if ($status == "E") echo "</a>"; ?>
                            </div>
							<div>
                              <a href="paginas_alt.php?idp=<?php echo $id_pag;?>" title="Alterar página">
                                <img src="img/ico-det.gif" width="16" height="16" />
                              </a>
                            </div>
                            </li>
							<?
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?
                        $consulta = "SELECT COUNT(*) FROM paginas";
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
						 mysql_close($con);
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="paginas_inc.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Título da página:<br />
                                       <input class="form02" type="text" id="nome_noticia" name="nome_noticia" />
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
										$oFCKeditor->Value = '' ;
										$oFCKeditor->Create('pagina');
										?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar pagina" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
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
