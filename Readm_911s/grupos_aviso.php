<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");

$PHP_SELF = "grupos_aviso.php";

$html = "";
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" onMouseOver="trataMouseAba(this);" class="abaativa">Produtos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr><form action="avisemepdf.php" method="post" target="_blank">
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Produtos Avise-me</li>
                      <li id="abaVerTo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_aviso3.php'">Todas Solicitações</li>
                      <li id="abaVerJa" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_aviso2.php'">Já Avisados</li>
                      <li><input type="Button" value="Enviar p/ Todos" onClick="document.location.href=('envia_mail_avtodos.php');" class="form00" style="width:100px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Enviar p/ Todos (SMS)" onClick="document.location.href=('envia_sms_avtodos.php');" class="form00" style="width:120px;height:23px;margin: 0;" /></li>
                    </ul>
                </td>
                <!--
                <td align="left">
                    <div style="width: 600px; text-align: right;">
                        Gerar lista em PDF: <input type="submit" name="Gerar" value="Gerar" />
                    </div>
                </td>
                -->
            </tr>
            <tr>
            	<td align="left" colspan="2">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                <div id="Ver">
                <?php
                    $html = "";
                    $html1 = "";
                       
                          $html .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"30\">\n";
                          $html .= " 	<tr>\n";
                          $html .= "     	<td align=\"center\" width=\"10\">&nbsp;</td>\n";
                          $html .= "     	<td align=\"center\" width=\"60\"><strong>Img</strong></td>\n";
                          //$html .= "     	<td align=\"center\" width=\"80\"><strong>Data Cad.</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"100\"><strong>Loja</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"180\"><strong>Tipo</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"68\"><strong>Ref.</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"230\"><strong>Descri&ccedil;&atilde;o</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"95\"><strong>Valor</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"95\"><strong>Tamanho</strong></td>\n";
                          $html .= "         <td align=\"center\" width=\"45\"><strong>Pessoas</strong></td>\n";
                          $html .= "     </tr>\n";
                          $html .= "</table>\n";
                          
                          $html1 .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\" style=\"font:normal 10pt/160% sans-serif;\">\n";
                          $html1 .= " 	<tr>\n";
                          $html1 .= "     	<td width=\"60\">&nbsp;</td>\n";
                          $html1 .= "         <td width=\"100\"><strong>Tipo</strong></td>\n";
                          $html1 .= "         <td width=\"68\"><strong>Ref.</strong></td>\n";
                          $html1 .= "         <td><strong>Descri&ccedil;&atilde;o</strong></td>\n";
                          $html1 .= "         <td width=\"95\"><strong>Tamanho</strong></td>\n";
                          $html1 .= "         <td width=\"50\"><strong>Qtde</strong></td>\n";
                          $html1 .= "     </tr>\n";
                          
                   		  $html .= "<ul class=\"noticias\">\n";
						
						  $num_por_pagina = 2000;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                          
					
						  $sql = "SELECT NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, 
                                         DS_TAMANHO_TARC, COUNT(*) as qtde, NR_SEQ_TAMANHO_AVRC, DT_SOLICITACAO_AVRC, NR_QTDE_ESRC
										 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque 
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
										 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
                                         NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC and NR_QTDE_ESRC > 0
										 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC order by DS_PRODUTO2_PRRC, qtde desc";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$xtot = 0;
                            $tr = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $mostraprod = true;
							 
							 $id_prod	   = $row[0];
					         $dt_prod	   = $row[1];
							 $ds_tipo	   = $row[2];
							 $ds_ref	   = $row[3];
							 $vl_prod	   = $row[4];
							 $ds_prod	   = $row[5];
							 $ds_loja	   = $row[6];
							 $ext		   = $row[7];
							 $ext2		   = $row[8];
							 $status	   = $row[9];
							 $vlrpromo	   = $row[10];
							 $tamanho	   = $row[11];
							 $qtdepess	   = $row[12];
                             $idtamanho	   = $row[13];
                             
                             $datasoli	   = $row[14];
                             $estoque	   = $row[15];
                             
                             $msgavise = "Hey, sabe aquela tee do $ds_prod que vc tanto queria? Ela voltou! Corre pro site e garanta a sua. www.reverbcity.com";
                             
                             //$sqlest = "SELECT NR_QTDE_ESRC FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $id_prod AND NR_SEQ_TAMANHO_ESRC = $idtamanho and NR_QTDE_ESRC > 0";
                             //$stest = mysql_query($sqlest);
                             $qtdees = $estoque;
                             //$bgtab = "#FDEBDF";
                             //if ($estoque > 0) {
                             //if (mysql_num_rows($stest) > 0) {
                             //   $rowest = mysql_fetch_row($stest);
                             //   $qtdees = $rowest[0];
                                //$qtdees = $estoque;
                                $bgtab = "#CBFEAD";
                             //}else{
                             //   $qtdees = 0;
                             //   $bgtab = "#FFFFFF";
                            // }
							 
							 if ($mostraprod) {
							 $xtot++;
               $select_fotos = "SELECT
                  NR_SEQ_FOTO_FORC,
                  NR_SEQ_PRODUTO_FORC,
                  DS_EXT_FORC
                FROM
                   fotos
                WHERE
                   NR_SEQ_PRODUTO_FORC = ". $id_prod ."
                ORDER BY
                        NR_ORDEM_FORC ASC
                LIMIT 2";
                $stFoto = mysql_query($select_fotos);
                $fotoRow = mysql_fetch_row($stFoto);
							
							$html .= "<li>\n";
                            $html .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
                            $html .= "	<tr bgcolor=\"$bgtab\">\n";
                            $html .= "    	<td align=\"center\" width=\"60\"><img src=\"/thumb/fotosprodutos/1/31/36/".$fotoRow[0].".".$fotoRow[2]."\" width=\"31\" height=\"36\" border=\"0\" /></td>\n";
                            //$html .= "    	<td align=\"center\" width=\"80\">". date("d/m/Y", strtotime($dt_prod))."</td>\n";
                            $html .= "        <td align=\"left\" width=\"100\"><strong>$ds_loja</strong></td>\n";
                            $html .= "        <td align=\"left\" width=\"180\"><strong>$ds_tipo</strong></td>\n";
                            $html .= "        <td align=\"left\" width=\"70\"><strong>$ds_ref</strong></td>\n";
                            if ($qtdees > 0) {
                                $html .= "        <td align=\"left\">$ds_prod ($qtdees no Estoque)</td>\n";
                            }else{
                                $html .= "        <td align=\"left\">$ds_prod</td>\n";
                            }
                            $html .= "        <td align=\"left\" width=\"100\">\n";
                            if ($vlrpromo > 0) {
                            $html .= "           (<font style=\"text-decoration:line-through;\">R$ ".number_format($vl_prod,2,",","")."</font>)<br />R$ ". number_format($vlrpromo,2,",","")."\n";
                            } else {
                            $html .= "            R$ ".number_format($vl_prod,2,",","")."\n";
                            }
                            $html .= "        </td>\n";
                            $html .= "        <td align=\"left\" width=\"100\"><strong>$tamanho</strong></td>\n";
                            $html .= "        <td align=\"center\" width=\"45\"><strong>$qtdepess</strong></td>\n";
                            $html .= "    </tr>\n";
                            
                            $sql3 = "select * from aviseme where NR_SEQ_PRODUTO_AVRC = $id_prod and NR_SEQ_TAMANHO_AVRC = $idtamanho AND ST_AVISO_AVRC = 'N'";
                            $st3 = mysql_query($sql3);
                            if (mysql_num_rows($st3) > 0) {
						  	   $ds_nome = "";
                               while($row3 = mysql_fetch_array($st3)) {
                                   $idav = $row3["NR_SEQ_AVISEME_AVRC"];
                                   $sqlcad = "select NR_SEQ_CADASTRO_CASO, DS_CELULAR_CASO from cadastros where DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."'";
                                   $stcad = mysql_query($sqlcad);
                                   $comprasver = "";
                                   $sms = "";
                                   $ds_nome = $row3["DS_NOME_AVRC"];
                                   
                                   if (mysql_num_rows($stcad) > 0) {
                                      $rowcad = mysql_fetch_array($stcad);
                                      $celular      = $rowcad["DS_CELULAR_CASO"];
                            
                                      $celular = str_replace("-","",$celular);
                                      $celular = str_replace(".","",$celular);
                                      $celular = str_replace("/","",$celular);
                                      $celular = str_replace("=","",$celular);
                                      $celular = str_replace(" ","",$celular);
                                      
                                      $comprasver = "<td align=\"center\" width=\"25\"><a href=\"clientes_ped.php?idc=".$rowcad["NR_SEQ_CADASTRO_CASO"]."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" alt=\"Ver Compras\" width=\"16\" height=\"16\" border=\"0\" /></a></td>";
                                      
                                      if (strlen($celular)==8) {
                                        $sms = "<td align=\"center\" width=\"30\"><a href=\"envia_sms.php?msg=".$msgavise."&idcli=".$rowcad["NR_SEQ_CADASTRO_CASO"]."&KeepThis=true&TB_iframe=true&height=210&width=400\" title=\"Enviando SMS\" class=\"thickbox\"><img src=\"img/ico_celular.png\" width=\"10\" height=\"17\" border=\"0\" alt=\"Enviar SMS\" /></a></td>";
                                      }else{
                                        $sms = "<td align=\"center\" width=\"30\">&nbsp;</td>";
                                      }
                                   }else{
                                      $celular      = $row3["DS_TELEFONE_AVRC"];
                                      
                                      $celular = str_replace("(","",$celular);
                                      $celular = str_replace(")","",$celular);
                                      $celular = str_replace("-","",$celular);
                                      $celular = str_replace(".","",$celular);
                                      $celular = str_replace("/","",$celular);
                                      $celular = str_replace("=","",$celular);
                                      $celular = str_replace(" ","",$celular);
                                      
                                      if (substr($celular,0,1) == "0"){
                                        $celular = substr($celular,1,strlen($celular));
                                      }
                                      
                                      $ehcelular = false;
                                      
                                      if (substr($celular,2,1) == "9" || substr($celular,2,1) == "8" || substr($celular,2,1) == "7"){
                                        $ehcelular = true;
                                      }
                                      
                                      $smsmostra = "";
                                      
                                      if (strpos($row3["DS_EMAIL_AVRC"],"@") > 0){
                                        $tiralista = 0; 
                                      }else{
                                        $tiralista = $idav;
                                      }
                                      
                                      if (strlen($celular)==10 && $ehcelular) {
                                        $smsmostra = "<td align=\"center\" width=\"30\"><a href=\"envia_sms_esp.php?msg=".$msgavise."&celular=".$celular."&tiralista=$tiralista&KeepThis=true&TB_iframe=true&height=210&width=400\" title=\"Enviando SMS\" class=\"thickbox\"><img src=\"img/ico_celular.png\" width=\"10\" height=\"17\" border=\"0\" alt=\"Enviar SMS\" /></a></td>";
                                      }else{
                                        $smsmostra = "<td align=\"center\" width=\"30\">&nbsp;</td>";
                                      }
                                      
                                      $comprasver = "<td align=\"center\" width=\"25\">&nbsp;</td>$smsmostra";
                                   }
                                   $obss = $row3["DS_OBSERVACAO_AVRC"];
                                   if (!$obss) $obss = "&nbsp;";
                                   
                                   if (strpos($row3["DS_EMAIL_AVRC"],"@") > 0){
                                        $mostraemail = "<td align=left width=200><strong><a href=\"mailto:".$row3["DS_EMAIL_AVRC"]."\">".$row3["DS_EMAIL_AVRC"]."</a></strong></td>";
                                        $icomail = "<td width=20><a href=\"avise_email.php?idav=".$row3["NR_SEQ_AVISEME_AVRC"]."&idp=$id_prod&nome=".$row3["DS_NOME_AVRC"]."&email=".$row3["DS_EMAIL_AVRC"]."\"><img src=\"img/ico_mail.gif\" title=\"Enviar E-mail\" border=\"0\" /></a></td>";
                                   }else{
                                        $mostraemail = "<td align=\"center\" width=\"200\">&nbsp;</td>";
                                        $icomail = "<td align=\"center\" width=\"20\">&nbsp;</td>";
                                   }
                                   
						  	       $html .= "	<tr bgcolor=\"$bgtab\"><td colspan=9><table width=100% cellpadding=1 cellspacing=1><tr><td align=left width=60>Solicitante:</td><td align=left width=230><strong>".$ds_nome."</strong></td><td>".$row3["DS_CIDADE_AVRC"]."/".$row3["DS_UF_AVRC"]."</td><td align=\"center\" width=\"100\">Data: ". date("d/m/Y", strtotime($datasoli))."</td>$mostraemail<td align=left width=90><strong>".$row3["DS_TELEFONE_AVRC"]."</strong></td><td align=left>".$obss."</td>$comprasver".$icomail."$sms<td align=center width=25><a href=grupos_aviso_exc.php?aba=1&ida=".$row3["NR_SEQ_AVISEME_AVRC"]." title=Excluir><img src=\"img/cancel.png\" border=\"0\" /></a></td></tr></table></td></tr>\n";
                               }
                            }
						  	   
                            $html .= "</table>\n";
                            $html .= "</li>\n";
                            
                            if ($qtdees <= 0) {
                            
                            if ($tr == 0) {
                                $html1 .= "	<tr>\n";
                                $tr = 1;
                            }else{
                                $html1 .= "	<tr>\n";
                                $tr = 0;
                            }
                            $html1 .= "    	<td height=33><img src=../arquivos/uploads/produtos/".$id_prod.".$ext width=45 height=52 /></td>";
                            $html1 .= "     <td>$ds_tipo</td>";
                            $html1 .= "     <td>$ds_ref</td>";
                            $html1 .= "     <td>". utf8_decode($ds_prod)."</td>";
                            $html1 .= "     <td>$tamanho</td>";
                            $html1 .= "     <td>$qtdepess</td>";
                            $html1 .= " </tr>";
                            
                            }
						
							  }
							}
						  }
						 
					    $html1 .= "</table>\n";
                        $html .= "</ul>\n";
                        echo $html;
                        $html .= "</div>\n";
//                        echo "<ul class=\"paginacao\">\n";
                        	
                        //$consulta = "
//						select COUNT(*) from produtos, produtos_tipo, lojas, aviseme, tamanhos
//										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
//										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
//										 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND DS_CLASSIC_PRRC = 'N' AND ST_AVISO_AVRC = 'N'
//										 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC";
//                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
//                        
//                        $total_paginas = $total_usuarios/$num_por_pagina;
//                        $prev = $pagina - 1;
//                        $next = $pagina + 1;
//                        if ($pagina > 1) {
//                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&loja=$loja&tipo=$tipo&desc=$desc\">Anterior</a></li>";
//                        } else { 
//                        $prev_link = "<li>Anterior</li>";
//                        }
//                        if ($total_paginas > $pagina) {
//                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&loja=$loja&tipo=$tipo&desc=$desc\">Proxima</a></li>";
//                        } else {
//                        $next_link = "<li>Proxima</li>";
//                        }
//                        $total_paginas = ceil($total_paginas);
//                        $painel = "";
//                        for ($x=1; $x<=$total_paginas; $x++) {
//                          if ($x==$pagina) { 
//                            $painel .= "<li>[$x]</li>";
//                          } else {
//                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&loja=$loja&tipo=$tipo&desc=$desc\">[$x]</a></li>";
//                          }
//                        }
//                        echo "$prev_link";
//                        echo "$painel";
//                        echo "$next_link";
						
                        ?>                
                    <!--</ul>  /paginacao -->
                    
                </div> <!-- /ver -->
                
					<script>
					  defineAba("abaVer","Ver");
                    </script>
                    
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <input type="hidden" name="html" value="<?php echo str_replace("\n","",htmlentities($html1));?>" />
                </form>
                <br />
                </td>
            </tr>
        </table>

<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>