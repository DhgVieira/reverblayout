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
                      <li id="menuDepo" class="abaativa" style="width: 300px;">Maiores Compradores de Tshirts de Bandas</li>
                      <li id="menuDepo" class="abainativa" style="cursor: pointer;" onclick="document.location.href='relatorios.php?aba=M'">Relatórios</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF">
                    <table class="textostabelas" width="800" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">   
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                
								<?php
								$pagina = request("pagina");
								$num_por_pagina = 50;
								if (!$pagina) {
									$pagina = 1;
								}
								$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
								
                                $compra = "select NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO,
                                DS_DDDFONE_CASO, DS_FONE_CASO, SUM(NR_QTDE_CESO) as total, DS_CELULAR_CASO, 
                                format(SUM(NR_QTDE_CESO*VL_PRODUTO_CESO),2) as vlrtotal, DS_TWITTER_CACH 
                                from compras, cestas, produtos, cadastros
                                where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                NR_SEQ_TIPO_PRRC = 6 AND NR_SEQ_CATEGORIA_PRRC = 7 AND NR_SEQ_CADASTRO_COSO not in (8074, 6605, 4160, 2, 3, 9701)
                                AND ST_COMPRA_COSO <> 'C' GROUP BY NR_SEQ_CADASTRO_COSO ORDER BY total desc, vlrtotal desc limit $primeiro_registro, $num_por_pagina";
                                $compraST = mysql_query($compra);
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
                                        $celular    = $row[8];
                                        $vlcompras  = $row[9];
                                        $twitter    = $row[10];
                                        
                                        $celular = str_replace("-","",$celular);
                                        $celular = str_replace(".","",$celular);
                                        $celular = str_replace("/","",$celular);
                                        $celular = str_replace("=","",$celular);
                                        $celular = str_replace(" ","",$celular);
                                ?>
                                            
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                                    <?php if ($mos) { ?>
                                                    <tr bgcolor="#CCCCCC">
                                                        <td align="center"><strong>ID</strong></td>
                                                        <td align="left"><strong>Nome</strong></td>
                                                        <td align="left"><strong>E-mail</strong></td>
                                                        <td align="left"><strong>Telefone</strong></td>
                                                        <td align="left"><strong>Total</strong></td>
                                                        <td align="center"><strong>Ver</strong></td>
                                                        <td align="center"><strong>Email</strong></td>
                                                        <td align="center"><strong>SMS</strong></td>
                                                        <td align="center"><strong>TW</strong></td>
                                                    </tr>  
                                                    <?php 
                                                          $mos = false;
                                                          } 
                                                    ?>
                                                    <tr>
                                                        <td align="center" width="50" nowrap="nowrap"><?php echo $nrCompra; ?></td>
                                                        <td align="left"><?php echo ChecaClubStyle($nrCompra,$nome); ?></td>
                                                        <td align="left" width="159" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="left" width="77"><?php echo $ddd.' - '.$fone; ?></td>
                                                        <td align="center" width="60"><?php echo $total ?></td>
                                                        <td align="center" width="60"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Compras" class="thickbox"><img src="img/ico_check.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
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
                                                    </tr>
                                        		</table>  
                                           
                                        <?php	
                                     } // FIM WHILE
									 ?> 
									 <ul class="paginacao2" style="clear: both; margin: 20px 0 0 0;">
										<?php
										$total_usuarios = 1400;
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