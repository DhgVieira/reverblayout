<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Marketing</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Maiores Compradores</li>
                      <li id="menuDepo" class="abainativa" style="cursor: pointer;" onclick="document.location.href='relatorios.php?aba=M'">Relatórios</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF">
                    <table class="textostabelas" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                
								<?php
								$pagina = request("pagina");
                                $strBuscabyUfCidade = "";
                                if(!empty(request("endereco_estado")) && !empty(request("endereco_cidade"))) {
                                    $strBuscabyUfCidade = " AND DS_UF_CASO = '" . request("endereco_estado") ."' AND DS_CIDADE_CASO = '" . request("endereco_cidade") ."' ";
                                    $strBuscabyUfCidadeGet = "aba=" . request("aba") ."&endereco_estado=" . request("endereco_estado") ."&endereco_cidade=" . request("endereco_cidade") ."&";
                                }

								$num_por_pagina = 50;
								if (!$pagina) {
									$pagina = 1;
								}
								$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;

                                $sqlTotalDeRegistros =

                                $compra = "select NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO,
                                DS_DDDFONE_CASO, DS_FONE_CASO, count(*) as total, DS_CELULAR_CASO, SUM(VL_TOTAL_COSO) as vlrtotal, DS_TWITTER_CACH,
                                DS_FACEBOOK_CACH, DS_DDDCEL_CASO
                                from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                AND ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_COSO not in (8074, 6605, 4160, 2, 3, 9701)
                                $strBuscabyUfCidade
                                GROUP BY NR_SEQ_CADASTRO_COSO ORDER BY vlrtotal desc";

                                $limit = $compra . " LIMIT $primeiro_registro, $num_por_pagina";

                                $compraST = mysql_query($limit);
                                $compraTotal = mysql_query($compra);

                                $total_usuarios = mysql_num_rows($compraTotal);

                                if (mysql_num_rows($compraST) > 0) {
                                    $mos = true;
                                    while($row = mysql_fetch_row($compraST)) {
                                        $datCompra = $row[1];
                                        $nrCompra = $row[0];
                                        $nome = $row[2];
                                        $email = $row[3];
                                        $status = $row[4];
										$ddd = $row[5];
										$fone = $row[6];
										$total = $row[7];
                                        $dddCelular = $row[12];
                                        $celular    = $row[8];
                                        $vlcompras  = $row[9];
                                        $twitter    = $row[10];
                                        $facebook   = $row[11];

                                        $facebook = trim(str_replace("-","",$facebook));
                             
                                         if ($facebook){
                                            if (strpos($facebook,"http://") <= 0){
                                                $facebook = str_replace("http//","",$facebook);
                                                $facebook = str_replace("http/","",$facebook);
                                                $facebook = str_replace("http://","",$facebook);
                                                $facebook = str_replace("http://www.reverbcity.com/Readm_911s/","",$facebook);
            
                                                if (strpos($facebook,"facebook.com/") > 0){
                                                    $facebook = str_replace("www.facebook.com/","",$facebook);
                                                    $facebook = str_replace("facebook.com/","",$facebook);
                                                    $facebook = str_replace("facebook.com.br/","",$facebook);
                                                    $facebook = str_replace("www.facebook.com.br/","",$facebook);
                                                }
                                                
                                                $facebook = "http://facebook.com/".$facebook;
                                             }  
                                         }
                                        
                                        $celular = str_replace("-","",$celular);
                                        $celular = str_replace(".","",$celular);
                                        $celular = str_replace("/","",$celular);
                                        $celular = str_replace("=","",$celular);
                                        $celular = str_replace(" ","",$celular);

                                        $dddCelular = str_replace("(", "", $dddCelular);
                                        $dddCelular = str_replace(")", "", $dddCelular);
                                        $dddCelular = str_replace(" ", "", $dddCelular);

                                        if($celular) {
                                            $strCelular = $dddCelular . " - " . $celular;
                                        } else {
                                            $strCelular = "-";
                                        }

                                ?>
                                            
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                                    <?php if ($mos) { ?>
                                                        <?php  if($strBuscabyUfCidade) : ?>
                                                            <tr bgcolor=#CCCCBB><td colspan=13 align=center><strong><?php echo request("endereco_cidade") . " - " . request("endereco_estado"); ?></strong></td></tr>
                                                        <? endif; ?>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td align="center"><strong>ID</strong></td>
                                                        <td align="left"><strong>Nome</strong></td>
                                                        <td align="left"><strong>E-mail</strong></td>
                                                        <td align="left"><strong>Telefone</strong></td>
                                                        <td align="left"><strong>Celular</strong></td>
                                                        <td align="left"><strong>Compras</strong></td>
                                                        <td align="left"><strong>Total</strong></td>
                                                        <td align="center"><strong>Ver</strong></td>
                                                        <td align="center"><strong>Ver Cadastro</strong></td>
                                                        <td align="center"><strong>Email</strong></td>
                                                        <td align="center"><strong>SMS</strong></td>
                                                        <td align="center"><strong>TW</strong></td>
                                                        <td align="center"><strong>FB</strong></td>
                                                    </tr>  
                                                    <?php 
                                                          $mos = false;
                                                          } 
                                                    ?>
                                                    <tr>
                                                        <td align="center" width="50" nowrap="nowrap"><?php echo $nrCompra; ?></td>
                                                        <td align="left"><?php echo ChecaClubStyle($nrCompra,$nome); ?></td>
                                                        <td align="left" width="200" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="left" width="100"><?php echo $ddd.' - '.$fone; ?></td>
                                                        <td align="left" width="100"><?php echo $strCelular; ?></td>
                                                        <td align="center" width="60"><?php echo $total ?></td>
                                                        <td align="center" width="150">R$ <?php echo number_format($vlcompras,2,",",".") ?></td>
                                                        <td align="center" width="60"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Compras" class="thickbox"><img src="img/compras_ver.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                                        <td align="center" width="60"><a href="clientes_alt.php?rvbview=true&pg=<?php echo $pagina; ?>&idc=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Ver Cadastro" class="thickbox"><img src="img/ico-det.gif" alt="Ver Cadastro" width="16" height="16" border="0" /></a></td>
                                                        <td align="center" width="45"><a href="aviso.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar aviso" border="0" /></a></td>
                                                        <?php if (strlen($celular)==8) { ?>
                                                        <td align="center" width="30"><a href="envia_sms.php?idcli=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                                        <?php }else{ ?>
                                                        <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                        <?php if ($twitter) { ?>
                                                        <td align="center" width="30"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                                        <?php }else{ ?>
                                                        <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                        <?php if ($facebook) { ?>
                                                            <td align="center" width="30"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                                        <?php }else{ ?>
                                                            <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                    </tr>
                                        		</table>  
                                           
                                        <?php	
                                     } // FIM WHILE
									 ?> 
									 <ul class="paginacao2" style="clear: both; margin: 20px 0 0 0;">
										<?php
                                        error_reporting(1);
                                        if(!empty($total_usuarios)) {

                                            if ($strBuscabyUfCidadeGet) {
                                                $urlGet = $strBuscabyUfCidadeGet;
                                            } else {
                                                $urlGet = "";
                                            }

                                            $total_paginas = $total_usuarios / $num_por_pagina;
                                            $prev = $pagina - 1;
                                            $next = $pagina + 1;
                                            if ($pagina > 1) {
                                                $prev_link = "<li><a href=\"$PHP_SELF?{$urlGet}pagina=$prev\">Anterior</a></li>";
                                            } else {
                                                $prev_link = "<li>Anterior</li>";
                                            }

                                            if ($total_paginas > $pagina) {
                                                $next_link = "<li><a href=\"$PHP_SELF?{$urlGet}pagina=$next\">Proxima</a></li>";
                                            } else {
                                                $next_link = "<li>Proxima</li>";
                                            }
                                            $total_paginas = ceil($total_paginas);
                                            $painel = "";
                                            //if ($total_paginas <= 40) {
                                                for ($x = 1; $x <= $total_paginas; $x++) {
                                                    if ($x == $pagina) {
                                                        $painel .= "<li>[$x]</li>";
                                                    } else {
                                                        $painel .= "<li><a href=\"$PHP_SELF?{$urlGet}pagina=$x\">[$x]</a></li>";
                                                    }
                                                }
                                            //}
                                            echo "$prev_link";
                                            echo "$painel";
                                            echo "$next_link";

                                            mysql_close($con);
                                        }
										?>                
									</ul>
									 
								<?php	 
                               } // FIM IF
                               else{                
                               ?>
                                <table width="44%" align="left">
                                    <tr>
                                        <td align="center">
                                            <strong>Nenhum cliente!</strong>
                                        </td>
                                    </tr>
                                </table>
                                <?php 
                               } // FIM ELSE
                               ?>
                              
                            </td>
                        </tr>
                    </table> 
                    <p>&nbsp;</p> 
                    <p>&nbsp;</p> 
                    <p>&nbsp;</p>  
				 </td>
            </tr>
        </table>   
   
<?php include 'rodape.php'; ?>