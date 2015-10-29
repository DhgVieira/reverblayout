<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");

$PHP_SELF = "grupos_aviso2.php";

$html = "";
?>
<?php include 'topo.php'; ?>
<script type="text/javascript">
    function ExecutaDel(){
        document.frmSel.action = "grupos_aviso_acao.php";
        document.frmSel.submit();
    }
    function ExecutaEmail(){
        document.frmSel.action = "grupos_aviso_mail.php";
        document.frmSel.submit();
    }
    function RemoveSelecionado(){
        document.frmSel.action = "grupos_aviso_deleta.php";
        document.frmSel.submit();
    }
    function ExecutaSMS(){
        document.frmSel.target = "_blank";
        document.frmSel.action = "grupos_aviso_SMS.php";
        document.frmSel.submit();
    }
    function Seleciona(avisemes){
        var n=avisemes.split(";");
        for (i = 0; i < n.length; i++) {
            if (document.getElementById(n[i]).checked == true){
                document.getElementById(n[i]).checked = false;   
            }else{
                document.getElementById(n[i]).checked = true;
            }
        }
    }
</script>
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
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas" style="width: 1000px;">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_aviso.php'">Produtos Avise-me</li>
                      <li id="abaVerJa" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Já Avisados</li>
                      <li><input type="Button" value="Excluir Selecionados" onClick="ExecutaDel();" class="form00" style="width:130px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Enviar Email p/ Selec." onClick="ExecutaEmail();" class="form00" style="width:130px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Enviar SMS p/ Selec." onClick="ExecutaSMS();" class="form00" style="width:130px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Remover Selecionados" onClick="RemoveSelecionado();" class="form00" style="width:130px;height:23px;margin: 0;" /></li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" colspan="2">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                <div id="VerJa">
                
                <table width="880">
                	<tr>
                    	<?php 
						$desc = request("desc");
                        $tipo = request("tipo");
						?>
                    	<form action="grupos_aviso2.php" method="post" name="frm">
                        <td height="20" align="right" valign="middle">
                            <strong>Procurar por:</strong>
                            <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" id="desc" value="<?php echo $desc; ?>" />
                            <strong>Tipo:</strong>
                            <select style="width:160px;height:22px;" class="frm_pesq" name="tipo" id="tipo">
                                <option value="">Qualquer tipo</option>
                                <?php
								$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo WHERE
                                             NR_SEQ_LOJA_PTRC = $SS_loja AND NR_SEQ_CATEGPRO_PTRC <> 9 
                                             order by DS_CATEGORIA_PTRC";
								$st = mysql_query($sql);
	
								if (mysql_num_rows($st) > 0) {
								  while($row = mysql_fetch_row($st)) {
								   $id_tipo	   = $row[0];
								   $ds_tipo	   = $row[1];
								?>
								<option value="<?php echo $id_tipo; ?>"><?php echo $ds_tipo; ?></option>
								<?php
								  }
								}
								?>
                            </select>
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td></form>
                         <script language="JavaScript">
						   document.frm.tipo.value = "<?php echo $tipo;?>";
						</script>
                    </tr>
                </table>
                
                <?php
                    $htmlj = "";
                       
                          $htmlj .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"30\">\n";
                          $htmlj .= " 	<tr>\n";
                          $htmlj .= "     	<td align=\"center\" width=\"10\">&nbsp;</td>\n";
                          $htmlj .= "     	<td align=\"center\" width=\"60\"><strong>Img</strong></td>\n";
                          //$html .= "     	<td align=\"center\" width=\"80\"><strong>Data Cad.</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"100\"><strong>Loja</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"180\"><strong>Tipo</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"68\"><strong>Ref.</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"230\"><strong>Descri&ccedil;&atilde;o</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"95\"><strong>Valor</strong></td>\n";
                          $htmlj .= "         <td align=\"left\" width=\"95\"><strong>Tamanho</strong></td>\n";
                          $htmlj .= "         <td align=\"center\" width=\"45\"><strong>Pessoas</strong></td>\n";
                          $htmlj .= "     </tr>\n";
                          $htmlj .= "</table>\n";
                          
                   		  $htmlj .= "<form action=\"\" method=\"post\" name=\"frmSel\" id=\"frmSel\"><ul class=\"noticias\">\n";
						
						  $num_por_pagina = 60;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, 
                                         DS_TAMANHO_TARC, COUNT(*) as qtde, NR_SEQ_TAMANHO_AVRC, DT_SOLICITACAO_AVRC, NR_QTDE_ESRC
										 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
										 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'S' ";
					      if ($desc) $sql .= " AND (DS_PRODUTO2_PRRC LIKE '%$desc%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_encode($desc)."%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_encode(strtoupper($desc))."%' or DS_PRODUTO2_PRRC LIKE '%".utf8_decode($desc)."%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_decode(strtoupper($desc))."%') ";
                          if ($tipo) $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
                          $sql .= " 	 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC order by DS_PRODUTO2_PRRC, qtde desc
                                         LIMIT $primeiro_registro, $num_por_pagina";
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
                             //$qtdees = 0;
                             //$bgtab = "#FDEBDF";
                             //if (mysql_num_rows($stest) > 0) {
                             if ($estoque > 0) {
                                //$rowest = mysql_fetch_row($stest);
                                //$qtdees = $rowest[0];
                                $qtdees = $estoque;
                                $bgtab = "#CBFEAD";
                             }else{
                                $qtdees = 0;
                                $bgtab = "#FFFFFF";
                             }
                             
							 if ($mostraprod) {
							 $xtot++;
							
							$htmlj .= "<li>\n";
                            $htmlj .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
                            $htmlj .= "	<tr bgcolor=\"$bgtab\">\n";       
                            $htmlj .= "	<td width=\"20\">&nbsp;</td>";                     
                            $htmlj .= "    <td align=\"center\" width=\"60\"><img src=\"../arquivos/uploads/produtos/".$id_prod.".$ext\" width=\"31\" height=\"36\" border=\"0\" /></td>\n";
                            //$html .= "    	<td align=\"center\" width=\"80\">". date("d/m/Y", strtotime($dt_prod))."</td>\n";
                            $htmlj .= "        <td align=\"left\" width=\"100\"><strong>$ds_loja</strong></td>\n";
                            $htmlj .= "        <td align=\"left\" width=\"180\"><strong>$ds_tipo</strong></td>\n";
                            $htmlj .= "        <td align=\"left\" width=\"70\"><strong>$ds_ref</strong></td>\n";
                            if ($qtdees > 0) {
                                $htmlj .= "        <td align=\"left\">$ds_prod ($qtdees no Estoque)</td>\n";
                            }else{
                                $htmlj .= "        <td align=\"left\">$ds_prod</td>\n";
                            }
                            $htmlj .= "        <td align=\"left\" width=\"100\">\n";
                            if ($vlrpromo > 0) {
                            $htmlj .= "           (<font style=\"text-decoration:line-through;\">R$ ".number_format($vl_prod,2,",","")."</font>)<br />R$ ". number_format($vlrpromo,2,",","")."\n";
                            } else {
                            $htmlj .= "            R$ ".number_format($vl_prod,2,",","")."\n";
                            }
                            $htmlj .= "        </td>\n";
                            $htmlj .= "        <td align=\"left\" width=\"100\"><strong>$tamanho</strong></td>\n";
                            $htmlj .= "        <td align=\"center\" width=\"45\"><strong>$qtdepess</strong></td>\n";
                            $htmlj .= "    </tr>\n";
                            
                            $sql3 = "select * from aviseme where NR_SEQ_PRODUTO_AVRC = $id_prod and NR_SEQ_TAMANHO_AVRC = $idtamanho AND ST_AVISO_AVRC = 'S'";
                            $st3 = mysql_query($sql3);
                            if (mysql_num_rows($st3) > 0) {
						  	   $idavisemes = "";
                                 while($row3 = mysql_fetch_array($st3)) {
						  	       $sqlest = "select NR_SEQ_COMPRA_COSO, NR_SEQ_CADASTRO_CASO from cadastros, compras, cestas where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                        AND DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."' AND NR_SEQ_PRODUTO_CESO = $id_prod and NR_SEQ_TAMANHO_CESO = $idtamanho AND DT_COMPRA_COSO > '$datasoli' AND ST_COMPRA_COSO IN ('P','V','E')";
                                     $stest = mysql_query($sqlest);
                                     $qtdees = 0;
                                     $bgtab = "#FDEBDF";
                                     $sqlcad = "select NR_SEQ_CADASTRO_CASO, DS_CELULAR_CASO from cadastros where DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."'";
                                     $stcad = mysql_query($sqlcad);
                                     $comprasver = "";
                                     $ds_nome = $row3["DS_NOME_AVRC"];
                                     
                                     if (mysql_num_rows($stcad) > 0) {
                                        $rowcad = mysql_fetch_array($stcad);
                                        $celular      = $rowcad["DS_CELULAR_CASO"];
                                        
                                        $ds_nome = ChecaClubStyle($rowcad["NR_SEQ_CADASTRO_CASO"],$ds_nome);
                            
                                        $celular = str_replace("-","",$celular);
                                        $celular = str_replace(".","",$celular);
                                        $celular = str_replace("/","",$celular);
                                        $celular = str_replace("=","",$celular);
                                        $celular = str_replace(" ","",$celular);
                                      
                                        $comprasver = "<td align=\"center\" width=\"20\"><a href=\"clientes_ped.php?idc=".$rowcad["NR_SEQ_CADASTRO_CASO"]."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" alt=\"Ver Compras\" width=\"16\" height=\"16\" border=\"0\" /></a></td>";
                                        
                                        if (strlen($celular)==8) {
                                            $sms = "<td align=\"center\" width=\"30\"><a href=\"envia_sms.php?msg=".$msgavise."&idcli=".$rowcad["NR_SEQ_CADASTRO_CASO"]."&KeepThis=true&TB_iframe=true&height=210&width=400\" title=\"Enviando SMS\" class=\"thickbox\"><img src=\"img/ico_celular.png\" width=\"10\" height=\"17\" border=\"0\" alt=\"Enviar SMS\" /></a></td>";
                                          }else{
                                            $sms = "<td align=\"center\" width=\"30\">&nbsp;</td>";
                                          }
                                     }else{
                                      $comprasver = "<td align=\"center\" width=\"20\">&nbsp;</td>";
                                     }
                                     
                                     $checksel = "    <td align=\"center\" width=\"10\"><input id=\"".$row3["NR_SEQ_AVISEME_AVRC"]."\" name=\"selec[]\" type=\"checkbox\" value=\"".$row3["NR_SEQ_AVISEME_AVRC"]."\" /></td>\n";
                                     
                                   $obss = $row3["DS_OBSERVACAO_AVRC"];
                                   if (!$obss) $obss = "&nbsp;";
                                   
                                   $idavisemes .= $row3["NR_SEQ_AVISEME_AVRC"].";";
						  	       
                                     if (mysql_num_rows($stest) > 0) {
                                        $rowest = mysql_fetch_row($stest);
                                        $nrcomp = $rowest[0];
                                        $nrcli = $rowest[1];
                                        $bgtab  = "#BFBFFF";
                                        $htmlj .= "	<tr bgcolor=\"$bgtab\"><td colspan=8><table width=100%><tr>$checksel<td align=left width=60>Solicitante:</td><td align=left width=230><strong>".$ds_nome."</strong></td><td>".$row3["DS_CIDADE_AVRC"]."/".$row3["DS_UF_AVRC"]."</td><td align=\"center\" width=\"100\">Data: ". date("d/m/Y", strtotime($datasoli))."</td><td align=left width=200><strong><a href=\"mailto:".$row3["DS_EMAIL_AVRC"]."\">".$row3["DS_EMAIL_AVRC"]."</a></strong></td><td align=left width=90><strong>".$row3["DS_TELEFONE_AVRC"]."</strong></td><td align=left>".$obss."</td><td width=20><strong><a href=\"compras_ver.php?idcli=$nrcli&idc=$nrcomp&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Detalhamento da Compra Nr $nrcomp\" class=\"thickbox\">$nrcomp</a></strong></td>$comprasver $sms<td align=center width=20><a href=grupos_aviso_exc.php?aba=2&ida=".$row3["NR_SEQ_AVISEME_AVRC"]." title=Excluir><img src=\"img/cancel.png\" border=\"0\" /></a></td></tr></table></td></tr>\n";
                                     }else{
                                        $qtdees = 0;
                                        $bgtab = "#FFFFFF";
                                        $htmlj .= "	<tr bgcolor=\"$bgtab\"><td colspan=8><table width=100%><tr>$checksel<td align=left width=60>Solicitante:</td><td align=left width=230><strong>".$ds_nome."</strong></td><td>".$row3["DS_CIDADE_AVRC"]."/".$row3["DS_UF_AVRC"]."</td><td align=\"center\" width=\"100\">Data: ". date("d/m/Y", strtotime($datasoli))."</td><td align=left width=200><strong><a href=\"mailto:".$row3["DS_EMAIL_AVRC"]."\">".$row3["DS_EMAIL_AVRC"]."</a></strong></td><td align=left width=90><strong>".$row3["DS_TELEFONE_AVRC"]."</strong></td><td align=left>".$obss."</td><td width=20><a href=\"avise_email.php?idav=".$row3["NR_SEQ_AVISEME_AVRC"]."&idp=$id_prod&nome=".$row3["DS_NOME_AVRC"]."&email=".$row3["DS_EMAIL_AVRC"]."\"><img src=\"img/ico_mail.gif\" title=\"Enviar E-mail\" border=\"0\" /></a></td>$comprasver $sms<td align=center width=20><a href=grupos_aviso_exc.php?aba=2&ida=".$row3["NR_SEQ_AVISEME_AVRC"]." title=Excluir><img src=\"img/cancel.png\" border=\"0\" /></a></td></tr></table></td></tr>\n";
                                     }
                               }
                            }
                            
                            $idavisemes = substr($idavisemes,0,strlen($idavisemes)-1);
						  	
                            $htmlj .= "<tr><td width=\"20\"><img src=img/seta_aviseme.gif align=absmiddle></td><td align=left colspan=2><input type=\"checkbox\" onclick=\"Seleciona('$idavisemes');\" /> Selecionar Todos</td><td width=\"20\" colspan=5>&nbsp;</td></tr>";   
                            $htmlj .= "</table>\n";
                            $htmlj .= "</li>\n";
                            
							  }
							}
						  }
						 
                        $htmlj .= "</form></ul>\n";
                        $htmlj .= "</div>\n";
                        echo $htmlj;
                        
                        echo "<ul class=\"paginacao\">\n";
                        	
                        $consulta = "
						select count(*)
										 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
										 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'S' ";
						if ($desc) $consulta .= " AND (DS_PRODUTO2_PRRC LIKE '%$desc%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_encode($desc)."%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_encode(strtoupper($desc))."%' or DS_PRODUTO2_PRRC LIKE '%".utf8_decode($desc)."%' OR DS_PRODUTO2_PRRC LIKE '%".utf8_decode(strtoupper($desc))."%') ";
                        if ($tipo) $consulta .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
                        $consulta .= "	 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC";
                        $st3 = mysql_query($consulta);
                        $total_usuarios = mysql_num_rows($st3);
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&loja=$loja&tipo=$tipo&desc=$desc\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&loja=$loja&tipo=$tipo&desc=$desc\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&loja=$loja&tipo=$tipo&desc=$desc\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    
                </div> <!-- /ver -->
                
					<script>
                      defineAba("abaVerJa","VerJa");
                    </script>
                    
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>

<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>