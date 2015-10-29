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
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Produtos Avise-me</li>
                      <li id="abaVerJa" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_aviso2.php'">Já Avisados</li>
                    </ul>
                </td>
                <td align="left">
                    <div style="width: 600px; text-align: right;">
                        Gerar lista em PDF: <input type="submit" name="Gerar" value="Gerar" />
                    </div>
                </td>
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
                          $html .= "         <td align=\"left\" width=\"180\"><strong>Tipo</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"68\"><strong>Ref.</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"230\"><strong>Descri&ccedil;&atilde;o</strong></td>\n";
                          $html .= "         <td align=\"left\" width=\"95\"><strong>Tamanho</strong></td>\n";
                          $html .= "         <td align=\"center\" width=\"45\"><strong>Pessoas</strong></td>\n";
                          $html .= "     </tr>\n";
                          $html .= "</table>\n";
                          

                          
                   		  $html .= "<ul class=\"noticias\">\n";
						
						  $num_por_pagina = 2000;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, 
                                         DS_TAMANHO_TARC, COUNT(*) as qtde, NR_SEQ_TAMANHO_AVRC, DT_SOLICITACAO_AVRC
										 from produtos, produtos_tipo, lojas, aviseme, tamanhos
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
										 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND ST_AVISO_AVRC = 'N' and NR_SEQ_TIPO_PRRC = 6
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
                             
                             $sqlest = "SELECT NR_QTDE_ESRC FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = $id_prod AND NR_SEQ_TAMANHO_ESRC = $idtamanho and NR_QTDE_ESRC > 0";
                             $stest = mysql_query($sqlest);
                             $qtdees = 0;
                             $bgtab = "#FDEBDF";
                             if (mysql_num_rows($stest) > 0) {
                                $rowest = mysql_fetch_row($stest);
                                $qtdees = $rowest[0];
                                $bgtab = "#CBFEAD";
                             }else{
                                $qtdees = 0;
                                $bgtab = "#FFFFFF";
                             }
							 
							 if ($mostraprod) {
							 $xtot++;
							
							$html .= "<li>\n";
                            $html .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
                            $html .= "	<tr bgcolor=\"$bgtab\">\n";
                            $html .= "        <td align=\"left\" width=\"180\"><strong>$ds_tipo</strong></td>\n";
                            $html .= "        <td align=\"left\" width=\"70\"><strong>$ds_ref</strong></td>\n";
                            $html .= "        <td align=\"left\">$ds_prod</td>\n";
                            $html .= "        <td align=\"left\" width=\"100\"><strong>$tamanho</strong></td>\n";
                            $html .= "        <td align=\"center\" width=\"45\"><strong>$qtdepess</strong></td>\n";
                            $html .= "    </tr>\n";
                            
                            
						  	   
                            $html .= "</table>\n";
                            $html .= "</li>\n";
                            

						
							  }
							}
						  }
						 
					    $html1 .= "</table>\n";
                        $html .= "</ul>\n";
                        echo $html;
                        $html .= "</div>\n";
						
                        ?>                
                    <!--</ul>  /paginacao -->
                    
                </div> <!-- /ver -->
                
					<script>
					  defineAba("abaVer","Ver");
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