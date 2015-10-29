<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Avisos Gerais</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa" style="width:300px">Clientes que Compraram a mais de 3 meses</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF">
                    <table class="textostabelas" width="800" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left"> 
                               <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                                    <tr>
                                        <td align="center" width="120"><strong>Data da compra</strong></td>
                                        <td align="center" width="100"><strong>ID Comprador</strong></td>
                                        <td align="left" width="200"><strong>Nome</strong></td>
                                        <td align="left" width="200"><strong>E-mail</strong></td>
                                        <td align="left" width="20"><strong>Compras</strong></td>
                                        <td align="center" width="50"><strong>Aviso</strong></td>
                                    </tr>  
                                </table> 
                             </td>
                        </tr>    
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                <ul class="noticias">
								<?
								$pagina = request("pagina");
								$num_por_pagina = 100;
								if (!$pagina) {
									$pagina = 1;
								}
								$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
								
                                $compra = "select NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO from cadastros, compras where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
                                and (ST_COMPRA_COSO = 'E' or ST_COMPRA_COSO = 'V')  AND NR_SEQ_CADASTRO_CASO in
                                (select NR_SEQ_CADASTRO_COSO from compras where NR_SEQ_CADASTRO_COSO not in 
                                (select NR_SEQ_CADASTRO_COSO from compras where (DT_COMPRA_COSO > date_add(sysdate(),INTERVAL -90 DAY)))) 
                                GROUP BY NR_SEQ_CADASTRO_COSO ORDER BY DT_COMPRA_COSO DESC LIMIT $primeiro_registro, $num_por_pagina";
                                $compraST = mysql_query($compra);
                                if (mysql_num_rows($compraST) > 0) { 
                                    while($row = mysql_fetch_row($compraST)) {
                                        $datCompra = $row[1];
                                        $nrCompra = $row[0];
                                        $nome = $row[2];
                                        $email = $row[3];
                                        $status = $row[4];
                                ?>
                                            <li style="width:98%; ">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                                    <tr>
                                                        <td align="center" width="120"><strong><?php echo date("d-m-Y", strtotime($datCompra)); ?></strong></td>
                                                        <td align="center" width="100" nowrap="nowrap"><?php echo $nrCompra; ?></td>
                                                        <td align="left" width="200"><?php echo $nome; ?></td>
                                                        <td align="left" width="200" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="center" width="20"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<? echo $nrCompra;?>" id="iframe" title="::  :: width: 640, height: 300" class="lightview"><img src="img/ico_check.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                                        <td align="center" width="50"><a href="aviso.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar aviso" border="0" /></a></td>
                                                    </tr>
                                        		</table>  
                                            </li>
                                        <?php	
                                     } // FIM WHILE
									 ?> 
									 <ul class="paginacao2">
										<?php
										$total_usuarios = 1400;
										$total_paginas = $total_usuarios/$num_por_pagina;
										$prev = $pagina - 1;
										$next = $pagina + 1;
										if ($pagina > 1) {
										$prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&nome=$pesq_nom&status=$pesq_sta&estado=$estado&cidade=$cidade\">Anterior</a></li>";
										} else { 
										$prev_link = "<li>Anterior</li>";
										}
										if ($total_paginas > $pagina) {
										$next_link = "<li><a href=\"$PHP_SELF?pagina=$next&nome=$pesq_nom&status=$pesq_sta&estado=$estado&cidade=$cidade\">Proxima</a></li>";
										} else {
										$next_link = "<li>Proxima</li>";
										}
										$total_paginas = ceil($total_paginas);
										$painel = "";
										for ($x=1; $x<=$total_paginas; $x++) {
										  if ($x==$pagina) { 
											$painel .= "<li>[$x]</li>";
										  } else {
											$painel .= "<li><a href=\"$PHP_SELF?pagina=$x&nome=$pesq_nom&status=$pesq_sta&estado=$estado&cidade=$cidade\">[$x]</a></li>";
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
                               </ul>
                            </td>
                        </tr>
                    </table>    
				 </td>
            </tr>
        </table>   
   
<? include 'rodape.php'; ?>
