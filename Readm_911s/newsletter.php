<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");
$PHP_SELF = "newsletter.php";

$opt = request("opt");
if (!$opt) $opt = 1;

if ($opt==1) {
	$corpo = "<table width=\"557\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
	$corpo .= "<tr><td width=\"557\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"557\" height=\"87\"></td>";
	$corpo .= "</tr><tr>";
	$corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "    <td><table width=\"100%\" cellpadding=\"3\" cellspacing=\"3\">";
	$corpo .= "        	<tr><td style=\"font-family:Arial, Helvetica, sans-serif;\" width=\"555\">&nbsp;</td></tr>";
	$corpo .= "        </table></td>";
	$corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "</tr><tr>";
	$corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "    <td height=\"1\"><center style=\"font-size:10px\">Se você desejar não receber mais news da Reverbcity <a href=\"../me/me_assinante.php\" target=\"_blank\" > Clique aqui</a></center></td>";
	$corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "</tr><tr><td width=\"557\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" width=\"557\" height=\"26\" border=0></td>";
	$corpo .= "</tr></table>";
	$corpo .= "<map name=\"Map\"><area shape=\"rect\" coords=\"435,4,541,22\" href=\"http://www.reverbcity.com\" target=\"_blank\">";
	$corpo .= "</map>";
}else if ($opt==2) {
$corpo = "<table width=\"750\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
	$corpo .= "<tr><td width=\"750\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing2.gif\" width=\"750\" height=\"87\"></td>";
	$corpo .= "</tr><tr>";
	$corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "    <td>&nbsp;</td>";
	$corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "</tr><tr>";
	$corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "    <td height=\"1\"><center style=\"font-size:10px\" >Se você desejar não receber mais news da Reverbcity <a href=\"../me/me_assinante.php\" target=\"_blank\" > Clique aqui</a></center></td>";
	$corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
	$corpo .= "</tr><tr><td width=\"750\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing2.gif\" usemap=\"#Map\" width=\"750\" height=\"26\" border=0></td>";
	$corpo .= "</tr></table>";
	$corpo .= "<map name=\"Map\"><area shape=\"rect\" coords=\"628,5,736,21\" href=\"http://www.reverbcity.com\" target=\"_blank\">";
	$corpo .= "</map>";
}

?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idg) {
	var confirma = confirm("Confirma a Exclusao desse Grupo?")
	if ( confirma ){
		document.location.href='adminGrupos_del.php?&idg='+idg;
	} else {
		return false
	} 
}

function confirma_ass(ida) {
	var confirma = confirm("Confirma a Exclusao desse E-Mail?")
	if ( confirma ){
		document.location.href='adminAssina_del.php?&ida='+ida;
	} else {
		return false
	} 
}

</script> 

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Newsletter</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Newsletter Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Escrever Newsletter</li>
                      <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Newsletter Grupos</li>
                      <li id="abaAssin" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Assinantes</li>
                      <li id="abaImport" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Importa&ccedil;&atilde;o / Exportação </li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">

						<ul class="compras">
						<?php
                        $sql = "select ds_descricao, dt_inicio, dt_fim, total_enviado, st_status, id_spam from spam order by dt_inclusao desc";
                        $st = mysql_query($sql);
                        ?>
                        <li>
                        <table class="textostabelas" width="850" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0" align="center">
                            <tr bgcolor='#FFFFFF'>
                                <td><b>News</b></td>
                                <td align="center" width="130"><b>Inicio</b></td>
                                <td align="center" width="130"><b>Fim</b></td>
                                <td align="center" width="50"><b>Tot.</b></td>
                                <td align="center" width="100"><b>Status</b></td>
                                <td align="center" width="270"><b>Opcoes</b></td>
                            </tr>
                         </table>
                         </li>
                            <?php
                            if (mysql_num_rows($st) > 0) {
                            while($row = mysql_fetch_row($st)) {
                             $dsdec		   = $row[0];
                             $dtini		   = $row[1];
                             $dtfim		   = $row[2];
                             $tot_env	   = $row[3];
                             $status	   = $row[4];
                             $idspam	   = $row[5];
                            ?>
                            <li>
                            <table class="textostabelas" width="850" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td><?php echo $dsdec;?></td>
                                <td align="center" nowrap="nowrap" width="130"><?php if ($dtini) echo date("d/m/Y G:i", strtotime($dtini)); ?></td>
                                <td align="center" nowrap="nowrap" width="130"><?php if ($dtini) echo date("d/m/Y G:i", strtotime($dtfim)); ?></td>
                                <td align="center" nowrap="nowrap" width="50"><? echo $tot_env;?></td>
                                <?php
                                if ($status == "A"){
                                    $status = "Nao Enviado";
                                }elseif ($status == "I"){
                                    $status = "Em Andamento";
                                }else{
                                    $status = "Ja Enviado";
                                }
                                ?>
                                <td align="center" width="100"><b><?php echo $status;?></b></td>
                                <td align="center" nowrap="nowrap" width="270">
                                    <input type="Button" value="Enviar" onClick="document.location.href=('adminSpam_env.php?id=<? echo $idspam;?>&nome=<? echo $dsdec;?>');" class="form00" style="width:45px;height:25px;">
                                    <input type="Button" value="Continuar" onClick="document.location.href=('adminSpam_env2.php?id_spam=<? echo $idspam;?>&nome=<? echo $dsdec;?>');" class="form00" style="width:55px;height:25px;">
                                    <input type="Button" value="ALT" onClick="document.location.href=('adminSpam_alt.php?id=<? echo $idspam;?>');" class="form00" style="width:45px;height:25px;">
                                    <input type="Button" value="EXC" onClick="document.location.href=('adminSpam_exc.php?id=<? echo $idspam;?>');" class="form00" style="width:45px;height:25px;">
                                </td>
                            </tr>
                            </table>
                            </li>
                            <?php
                                }
                            }
                            ?>

                    	</ul>
                    
                    </div> <!-- /ver -->
                    
                    <div id="Criar">
                    	  <table>
                          	<tr>
                            	<td>&nbsp;</td>
                            	<td><p><strong><a href="newsletter.php?opt=1&aba=1">Op&ccedil;&atilde;o 1 (550px)</a></strong></p></td>
                                <td>&nbsp;</td>
                                <td><p><strong><a href="newsletter.php?opt=2&aba=1">Op&ccedil;&atilde;o 2 (750px)</a></strong></p></td>
                            </tr>
                          </table>

                         <form action="adminSpam_inc2.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Descricao:<br />
                                       <input class="form02" type="text" name="titulo" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo">
                                       Conteudo:<br />
                                       <?php
                                            //$contmala = "<table width=\"600\" align=\"center\" border=\"0\"><tr><td><img src=\"http://www.cheida15.can.br/img/topo_new.jpg\" border=\"0\" /></td></tr><tr><td height=\"150\">&nbsp;</td></tr><tr><td><img src=\"http://www.cheida15.can.br/img/rodape_new.jpg\" border=\"0\" /></td></tr><tr><td align=\"center\">Caso voc&ecirc; n&atilde;o queira mais receber este mailing, <a href=mailto:imprensa@cheida15.can.br?subject=CANCELAR>clique aqui</a></td></tr></table>";
                                            $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                            $oFCKeditor->ToolbarSet = 'MyToolbar';
                                            $oFCKeditor->BasePath = 'fckeditor/' ;
                                            $oFCKeditor->Height = 400 ;
											$oFCKeditor->Width = 800 ;
                                            $oFCKeditor->Value = $corpo ;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Newsletter" />
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    
                    </div> <!-- /criar -->
                    
                    <div id="Grupos">
                    	<form action="adminGrupos_inc.php" method="post">
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_grp">
                                       Descricao:<br />
                                       <input class="form02" type="text" id="nome_grp" name="nome_grp" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Grupo" />
                                   </li>
                                 </ul>
                         </form>
                         
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Grupos</strong></span>
                               <div>Exc</div>
                               <div>Ver</div>
                               </li>
                            <?php
                              $sql = "select IdGrupo, Nome from Grupo order by Nome";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_grp	   = $row[0];
                                 $nm_grp	   = $row[1];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_grp;?></strong></span>
                                <div>
                                <a href="#" title="deletar grupo" onclick="confirma(<?php echo $id_grp; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                 <div>
                                <a href="newsletter_grpemail.php?idg=<?php echo $id_grp; ?>" title="Ver E-Mails Cadastrados"><img src="img/ico-det.gif" width="16" height="16" /></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                    </div>
                    
                    <div id="Assin">
                    <!-- //***** BUSCA DE EMAIL -->
     <form action="newsletter.php?aba=4" method="post" name="formbusca" id="formbusca">
                       	<strong>Buscar por E-mail</strong>
                   		<input style="width:180px;height:14px;" class="frm_pesq" type="text" name="buscaEmail" value=""  />
                           		<input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" onclick="trataCliqueAba("Assin");" />
                   <?php                            
					 	$busca = request ("buscaEmail");//'taiscanizo@hotmail.com'; // email de teste cadastrado
						if ( $busca ==  ""){
							//echo '<strong> Informe o e-mail </strong>';
						}
						else{
							$buscaemail = "select IdAssinante, Nome, Email from Assinante WHERE Email like '%$busca%' ";
                        	$aux = mysql_query($buscaemail);
                        	if (mysql_num_rows($aux) > 0) {
                            	while($row = mysql_fetch_row($aux)) {
                                	$id_ass	   = $row[0];
                                 	$nm_ass	   = $row[1];
								 	$email	   = $row[2];	
                   ?>
                   <center>
                    <ul class="noticias">
                       	<li style="width:285px; float:left;">
                            <div>
                                <a href="#" title="Remover Assinante" onclick="confirma_ass(<?php echo $id_ass; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>              			
                            </div>
                            <div>
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                            </div>                            
						</li>	
                   </ul>
  <?php
                            	} // FIM WHILE
                       		}// FIM IF ROWS	
						   	else{
								echo '<div><font color=red><strong> E-mail não cadastrado. </strong></font><br />'.$busca.'</div>';
					   		} // FIM ELSE
						} // FIM ELSE
					?>
                   </center>

<!-- FIM BUSCA /***** -->    
</form>
<br />
<br />
                   	  <form action="adminAssin_inc.php" method="post">
                        <ul class="formularios">
                                   <li>
                                     <label for="nome_ass">
                                       Nome:<br />
                                       <input class="form02" type="text" id="nome_ass" name="nome_ass" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email_ass">
                                       E-Mail:<br />
                                       <input class="form02" type="text" id="email_ass" name="email_ass" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="idgrupo">
                                       Grupo:<br />
                                       <select name="idgrupo">
                                       <?php
									  $sql = "select IdGrupo, Nome from Grupo order by Nome";
									  $st = mysql_query($sql);
									  $strgrupo = "";
									  if (mysql_num_rows($st) > 0) {
										while($row = mysql_fetch_row($st)) {
										 $id_grp	   = $row[0];
										 $nm_grp	   = $row[1];
										 
										 $strgrupo .= "<option value=\"$id_grp\">$nm_grp</option>";
										}
										echo $strgrupo;
									  }
									?>
                                    </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Assinante" />
                                   </li>
                        </ul>
                          
                          <ul class="noticias">
                            <?php
							  $pagina_a = request("pagina_a");
							  $num_por_pagina_a = 20;
							  if (!$pagina_a) {
								 $pagina_a = 1;
							  }
							  $primeiro_registro_a = ($pagina_a*$num_por_pagina_a) - $num_por_pagina_a;
							  
                              $sql = "select IdAssinante, Nome, Email from Assinante order by IdAssinante desc LIMIT $primeiro_registro_a, $num_por_pagina_a";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_ass	   = $row[0];
                                 $nm_ass	   = $row[1];
								 $email		   = $row[2];
                                ?>
                                <li style="width:285px; float:left;">
                                <div>
                                <a href="#" title="deletar Assinante" onclick="confirma_ass(<?php echo $id_ass; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div>
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                          
                          <ul class="paginacao" style="margin:30px 0 0 0; padding:5px; clear:both">
						<?php
                        $consulta_a = "select count(*) from Assinante";
                        list($total_usuarios_a) = mysql_fetch_array(mysql_query($consulta_a,$con));
                        
                        $total_paginas_a = $total_usuarios_a/$num_por_pagina_a;
                        $prev = $pagina_a - 1;
                        $next = $pagina_a + 1;
                        if ($pagina_a > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina_a=$prev&aba=4\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas_a > $pagina_a) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina_a=$next&aba=4\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas_a = ceil($total_paginas_a);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas_a; $x++) {
                          if ($x==$pagina_a) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina_a=$x&aba=4\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        //echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul>
                    </form> 

                    </div>
                    
                    <div id="Import">
                    <table>
                    	<tr>
                        	<td>
                            	<strong>Importação de e-mails de um arquivo.</strong>
                            </td>
                            <?php /*?><td>
                            	<strong>Exportar e-mails para um arquivo.</strong>
                            </td><?php */?>
                        </tr>
                      <tr>
                        	<td >
                    	 <form action="newsletter_importa.php" method="post" enctype="multipart/form-data"  style="width:420px">
                         		<ul class="formularios">
                                   <li>
                                     <label for="descricao">
                                       Para o Grupo:<br />
                                       <select name="grupo" class="form01" style="height:25px;">
                                       		<?php echo $strgrupo; ?>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="link">
                                       Arquivo txt:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                     </label>
                                   </li>
                                    <li>
                                     <input type="submit" id="postar" name="postar" value="Importar" />
                                   </li>
                                 </ul>
                         </form>
                         </td>
<!-- //***** EXPORTAR LISTA DE EMAIL -->                         
						<td>
                         <form action="newsletter_exporta.php" method="" target="_blank" enctype="text/plain" style="width:420px">
                         		<ul class="formularios">
                                   <li>
                                     <label for="descricao">
                                       Do Grupo:<br />
										<?php $strgrupo .= "<option value=\"0\">Todos</option>"; ?>
                                       <select name="grupo2" class="form01" style="height:25px;">
                                       		<?php echo $strgrupo;?>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                   		<input  type="submit" id="postar2" name="postar2" value="Exportar"/>
<!--                                     <input type="button" id="postar2" onclick="window.location.href='/temp/email.doc'" name="postar2" value="Exportar" /> -->
                                   </li>
                                 </ul>
                         </form>
                         </td>
                          <td>
                              <form action="newsletter_exporta_aniversariantes.php" method="" target="_blank" enctype="text/plain" style="width:420px">
                                  <ul class="formularios">
                                      <li>
                                          <label for="descricao">
                                              Aniversariantes do Mes:<br />
                                          </label>
                                      </li>
                                      <li>
                                          <input  type="submit" id="postar2" name="postar2" value="Exportar"/>
                                      </li>
                                  </ul>
                              </form>
                          </td>
                     </tr>
                 </table>
<!-- FIM DE EXPORTAR //***** -->
                    </div>

                    <script>
                      defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  defineAba("abaGrupo","Grupos");
					  defineAba("abaAssin","Assin");
					  defineAba("abaImport","Import");
					  <?php
					  $aba = request("aba");
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaCriar\");";
							  break;
						  case 2:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  case 3:
						  	  echo "defineAbaAtiva(\"abaGrupo\");";
							  break;
						  case 4:
						  	  echo "defineAbaAtiva(\"abaAssin\");";
							  break;
						  case 5:
						  	  echo "defineAbaAtiva(\"abaImport\");";
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
<?php include 'rodape.php'; ?>
