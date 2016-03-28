<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");
$PHP_SELF = "banners.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idb,ext) {
	var confirma = confirm("Confirma a Exclusao desse Banner?")
	if ( confirma ){
		document.location.href='banners_del.php?pg=<?php echo $pagina; ?>&idb='+idb+'&ext='+ext;
	} else {
		return false
	} 
}

function confirma_cat(idl) {
	var confirma = confirm("Confirma a Exclusao desse Local?")
	if ( confirma ){
		document.location.href='banner_loc_del.php?&idl='+idl;
	} else {
		return false
	} 
}

</script>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Banners</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Banners Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Banner</li>
                      <li id="abaCateg" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Locais</li>
                      <li id="abaBanner" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Banners Blog</li>
                      <li id="abaBannerEsp" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Banner Especial</li>
                      <li id="abaBannerEsp2" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='banners_proddia.php';">Produto do Dia</li>
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
						<?php
						  $num_por_pagina = 180;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_BANNER_BARC, DS_EXT_BARC, DT_CADASTRO_BARC, ST_BANNER_BARC, DS_LOCAL_BLRC, DS_DESCRICAO_BARC, NR_SEQ_LOCAL_BARC
						  		  from banners, banners_locais WHERE NR_SEQ_LOCAL_BARC = NR_SEQ_BANLOCAL_BLRC and NR_SEQ_LOCAL_BARC not in (14,15,16,17,18,19,22,23,24,25,26,32,33,34,35,36,37)
								  order by NR_SEQ_LOCAL_BARC, DT_CADASTRO_BARC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
							$localant = "";
						  	while($row = mysql_fetch_row($st)) {
							 $id_bann	   = $row[0];
					         $ds_ext	   = $row[1];
							 $data		   = $row[2];
							 $status	   = $row[3];
							 $local		   = $row[4];
							 $ds_bann	   = $row[5];
							 $idlocal	   = $row[6];
							 if ($idlocal != $localant) {
							 	echo "<li style=\"background:#F5EFE7\"><span><strong>$local</strong>($idlocal)</span></li>";
							 	$localant = $idlocal;
							 }
							?>
							<li>
                            <span><strong><?php echo date("d/m/Y G:i", strtotime($data));?></strong> | <strong><?php echo $status; ?></strong> | <?php echo $local;?> | <?php echo $ds_bann; ?></span>
                            <div>
                            <?php echo "<a href=\"#\" title=\"deletar banner\" onclick=\"confirma($id_bann,'$ds_ext');\">"; ?>
                                <img src="img/cancel.png" width="16" height="16" />
                            <?php echo "</a>"; ?>
                            </div>
                            <div>
                              <a href="banners_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idb=<?php echo $id_bann;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a>
                            </div>
                            <div>
                              <a href="banners_alt.php?idb=<?php echo $id_bann;?>" title="Alterar Banner"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a>
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
                        $consulta = "SELECT COUNT(*) FROM banners, banners_locais WHERE NR_SEQ_BANNER_BARC = NR_SEQ_BANLOCAL_BLRC";
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
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="banners_inc.php" method="post" enctype="multipart/form-data">
            
                                 <ul class="formularios">
                                   <li>
                                     <label for="descricao">
                                       Descrição do Banner:<br />
                                       <input class="form02" type="text" id="descricao" name="descricao" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="link">
                                       Link:<br />
                                       <input class="form02" type="text" id="link" name="link" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="embed">
                                       Embed:<br />
                                       <?php
										$oFCKeditor = new FCKeditor('FCKeditor1') ;
										$oFCKeditor->ToolbarSet = 'MyToolbar';
										$oFCKeditor->BasePath = 'fckeditor/' ;
										$oFCKeditor->Height = 210 ;
										$oFCKeditor->Width = 400 ;
										$oFCKeditor->ForceSimpleAmpersand = false ;
										$oFCKeditor->Value = '' ;
										$oFCKeditor->Create('embed');
										?>
                                     </label>
                                   </li>
                                   <li>
                                      <label for="foto">
                                        Imagem/swf:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                    <li>
                                      <label for="banner_agendado"> Banner Agendado?</br>
                                        <input type="radio" name="banner_agendado" id="banner_agendado" value="0"
                                         <?php if ($agendado == 0 or $agendado == ""){?>
                                           checked 
                                          <?php } ?> 
                                        > Não
                                         <input type="radio" name="banner_agendado" id="banner_agendado" value="1"
                                         <?php if ($agendado == 1){?>
                                          checked
                                          <?php } ?>
                                         > Sim
                                      </label>
                                    </li>
                                    <li>
                                     <label for="data_inicio">
                                       Data de Inicio :<br />
                                       <input  type="date" id="data_inicio" name="data_inicio" />
                                     </label>
                                   </li>
                                     <li>
                                     <label for="hora_inicio">
                                        Horário de Inicio :<br />
                                       <input  type="time" id="hora_inicio" name="hora_inicio" />
                                     </label>
                                   </li>
                                    <li>
                                     <label for="data_fim">
                                       Data de Fim :<br />
                                       <input  type="date" id="data_fim" name="data_fim" />
                                     </label>
                                   </li>
                                     <li>
                                     <label for="hora_fim">
                                        Horário de Fim :<br />
                                       <input  type="time" id="hora_fim" name="hora_fim" />
                                     </label>
                                   </li>
                                    <li>
                                       <label for="localBan">
                                       Local:<br />
                                       <select name="localBan">
                                       <?php
                                       $sql = "select NR_SEQ_BANLOCAL_BLRC, DS_LOCAL_BLRC from banners_locais order by DS_LOCAL_BLRC";
                                       $st = mysql_query($sql);
            
                                       if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $id_loc	   = $row[0];
                                         $nome_l	   = $row[1];
                                        ?>
                                       <option value="<?php echo $id_loc;?>"><?php echo $nome_l;?></option>
                                       <?php
                                         }
                                       }
                                       ?>
                                       </select>
                                       </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Banner" />
                                   </li>
                                 </ul>
   
                         </form>
                    
                    </div> <!-- /criar -->
					
                    <div id="Categ">
                    
                    	<form action="banners_locais_inc.php" method="post">
               
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_cat">
                                       Local:<br />
                                       <input class="form02" type="text" id="local" name="local" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Local" />
                                   </li>
                                 </ul>
        
                         </form>
                        
                           <ul class="noticias">
                          	   <li>
                               <span><strong>Locais</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_BANLOCAL_BLRC, DS_LOCAL_BLRC from banners_locais order by DS_LOCAL_BLRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_loca	   = $row[0];
                                 $nm_loca	   = $row[1];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_loca;?></strong></span>
                                <div>
                                <a href="#" title="deletar local" onclick="confirma_cat(<?php echo $id_loca; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /categoria -->
                    
                    <div id="Banners">
                    
                	<ul class="noticias">
						<?php
						  $num_por_pagina = 100;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_BANNER_BARC, DS_EXT_BARC, DT_CADASTRO_BARC, ST_BANNER_BARC, DS_LOCAL_BLRC, DS_DESCRICAO_BARC, NR_SEQ_LOCAL_BARC, NR_POSICAO_BARC
						  		  from banners, banners_locais WHERE NR_SEQ_LOCAL_BARC = NR_SEQ_BANLOCAL_BLRC and NR_SEQ_LOCAL_BARC in (14,15,16,17,18,19,22,23,24,25,26,32,33,34,35,36,37)
								  order by NR_SEQ_LOCAL_BARC, DT_CADASTRO_BARC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
							$localant = "";
						  	while($row = mysql_fetch_row($st)) {
							 $id_bann	   = $row[0];
					         $ds_ext	   = $row[1];
							 $data		   = $row[2];
							 $status	   = $row[3];
							 $local		   = $row[4];
							 $ds_bann	   = $row[5];
							 $idlocal	   = $row[6];
							 $posicao	   = $row[7];
							 if ($idlocal != $localant) {
							 	echo "<li style=\"background:#F5EFE7\"><span><strong>$local</strong></span></li>";
							 	$localant = $idlocal;
							 }
							?>
							<li>
                            <form action="alterapos.php" method="post">
                            <input name="idb" type="hidden" value="<?php echo $id_bann;?>" />
                            <span><strong><?php echo date("d/m/Y G:i", strtotime($data));?></strong> | <strong><?php echo $status; ?></strong> | <?php echo $local;?> | <?php echo $ds_bann; ?></span>
                            <div><input type="submit" value="Altera Ordem" class="frm_pesq" style="width:80px;" /></div>
                            <div><input style="width:30px;" type="text" name="posicao" value="<?php echo $posicao; ?>" class="frm_pesq" /></div>
                            <div>
                            <?php echo "<a href=\"#\" title=\"deletar banner\" onclick=\"confirma($id_bann,'$ds_ext');\">"; ?>
                                <img src="img/cancel.png" width="16" height="16" />
                            <?php echo "</a>"; ?>
                            </div>
                            <div>
                              <a href="banners_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idb=<?php echo $id_bann;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a>
                            </div>
                            <div>
                              <a href="banners_alt.php?idb=<?php echo $id_bann;?>" title="Alterar Banner"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a>
                            </div>
                            </form>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?php
                        $consulta = "SELECT COUNT(*) FROM banners, banners_locais WHERE NR_SEQ_BANNER_BARC = NR_SEQ_BANLOCAL_BLRC";
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
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="BannerEspe">
                    	<form action="config_ban.php" method="post">
                         <fieldset>
                             <table width="250">
                                <tr>
                                    <td colspan="2"><strong>Banner Grande Especial</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php
                                $sql = "select DS_FRASE1_GESA, DS_FRASE2_GESA, DS_FRASE3_GESA, DS_FRASE4_GESA from config_gerais WHERE NR_SEQ_CONFIG_GESA = 1";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $frase   = $row[0];
                                    $dsvlr   = $row[1];
                                    $frase2  = $row[2];
									$frase3  = $row[3];
                                }
                                ?>
                                <tr>
                                    <td><strong>Texto:</strong></td>
                                    <td><input class="form01" type="text" name="frase" value="<?php echo $frase ?>" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Texto2:</strong></td>
                                    <td><input class="form01" type="text" name="frase2" value="<?php echo $dsvlr ?>" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Texto3:</strong></td>
                                    <td><input class="form01" type="text" name="frase3" value="<?php echo $frase2 ?>" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Texto4:</strong></td>
                                    <td><input class="form01" type="text" name="frase4" value="<?php echo $frase3 ?>" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" id="postar" name="postar" value="Alterar" /></td>
                                </tr>
                             </table>
                         </fieldset>
                     </form>
                    </div>
                    
                    <script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  defineAba("abaCateg","Categ");
					  defineAba("abaBanner","Banners");
					  defineAba("abaBannerEsp","BannerEspe");
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
						  	  echo "defineAbaAtiva(\"abaCateg\");";
							  break;
						  case 4:
						  	  echo "defineAbaAtiva(\"abaBanner\");";
							  break;
						  case 5:
						  	  echo "defineAbaAtiva(\"abaBannerEsp\");";
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