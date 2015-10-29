<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; ?>


<?php 

$total = "SELECT COUNT(NR_SEQ_CADASTRO_COSO) from cadastros, compras 
            where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
            and ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_CASO in
            (select NR_SEQ_CADASTRO_COSO from compras where ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_COSO not in 
            (select NR_SEQ_CADASTRO_COSO from compras where ST_COMPRA_COSO <> 'C' AND (DT_COMPRA_COSO > date_add(sysdate(),INTERVAL -180 DAY)))) 
           ";

                                $totalST = mysql_query($total);
                                if (mysql_num_rows($totalST) > 0) { 
                                    while($row = mysql_fetch_row($totalST)) {
                                        $total_result = $row[0];
                                    }
                                }


?>

        <table class="textosjogos" cellpadding="0" cellspacing="0">
            <tr>
                <td height="20" align="center" class="textostabelas">
                    <ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Avisos Gerais</li>
                    </ul>
                </td>
            </tr>
        </table>
       <form method="post" action="clientes_mailing.php" id="formclientes">
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
            <tr>
                <td align="left" height="18">
                    <ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa" style="width:300px">Clientes que Compraram a mais de 6 meses (<?php echo $total_result?>)</li>
                      <li id="menuDepo" class="abaativa" style="width:300px"><input type="submit" value="Mailing Selecionados" /></li>
                      <li id="menuDepo" class="abaativa" style="width:300px"><a href="#" onclick="self:print()"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir"></a></li>
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
                                        <td align="center" width="123"><strong>Selecione</strong></td>
                                        <td align="center" width="123"><strong>Última compra</strong></td>
                                        <td align="center" width="128"><strong>ReverbMe</strong></td>
                                        <td align="left" width="112"><strong>Nome</strong></td>
                                        <td align="left" width="162"><strong>E-mail</strong></td>
                                        <td align="left" width="75"><strong>Telefone</strong></td>
                                        <td align="left" width="60"><strong>Compras</strong></td>
                                        <td align="center" width="47"><strong>Aviso</strong></td>
                                        <td align="center" width="30"><strong>SMS</strong></td>
                                        <td align="center" width="30"><strong>TW</strong></td>
                                        <td align="center" width="30"><strong>FB</strong></td>
                                        <td align="center" width="30"><strong>obs</strong></td>
                                        <td align="center" width="30"><strong>Remover</strong></td>
                                    </tr>  
                                </table> 
                             </td>
                        </tr>    
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                
                                <?php
                                $pagina = request("pagina");
                                $num_por_pagina = 70;
                                if (!$pagina) {
                                    $pagina = 1;
                                }
                                $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                
                                $compra = "select NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO, 
                                DS_DDDFONE_CASO, DS_FONE_CASO, count(*) as total, DS_CELULAR_CASO, DS_TWITTER_CACH, DS_FACEBOOK_CACH,
                                DS_LOGIN_CASO from cadastros, compras where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO
                                and ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_CASO in
                                (select NR_SEQ_CADASTRO_COSO from compras where ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_COSO not in 
                                (select NR_SEQ_CADASTRO_COSO from compras where ST_COMPRA_COSO <> 'C' AND (DT_COMPRA_COSO > date_add(sysdate(),INTERVAL -180 DAY)))) 
                                GROUP BY NR_SEQ_CADASTRO_COSO ORDER by DT_COMPRA_COSO desc, total desc LIMIT $primeiro_registro, $num_por_pagina";
                                $compraST = mysql_query($compra);
                                if (mysql_num_rows($compraST) > 0) { 
                                    while($row = mysql_fetch_row($compraST)) {
                                        $datCompra = $row[1];
                                        $nrCompra = $row[0];
                                        $nome = $row[2];
                                        $email = $row[3];
                                        $status = $row[4];
                                        $ddd = $row[5];
                                        $fone = $row[6];
                                        $total = $row[7];
                                        $celular      = $row[8];
                                        $twitter      = $row[9];
                                        $facebook     = $row[10];
                                        $nick     = $row[11];
                                        
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
                                ?>
                                            
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                                    <tr>
                                                        <td align="center" width="120"><input type="checkbox" name="idcliente[]" value="<?php echo $nrCompra ?>"/></td>
                                                        <td align="center" width="120"><strong><?php echo date("d-m-Y", strtotime($datCompra)); ?></strong></td>
                                                        <td align="center" width="130" nowrap="nowrap"><a href="http://www.reverbcity.com/me/me_perfil.php?idme=<?php echo $nrCompra;?>" target="_blank"><?php echo $nick; ?></a></td>
                                                        <td align="left" width="115"><?php echo $nome; ?></td>
                                                        <td align="left" width="159" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="left" width="77"><?php echo $ddd.' - '.$fone; ?></td>
                                                        <td align="center"><?php echo $total ?></td>
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
                                                        <?php if ($facebook) { ?>
                                                            <td align="center" width="30"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                                        <?php }else{ ?>
                                                            <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                        <td align="center" width="30"><a href="clientes_obs.php?idcli=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Observação no Cadastro" class="thickbox"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Observacao" /></a></td>
                                                        <td align="center" width="30"><a href="clientes_remover.php?idcliente=<?php echo $nrCompra;?>" title="Deletar cliente" class="thickbox"><img src="img/cancel.png" width="16" height="16" border="0" alt="Deletar"></a></td>
                                                    </tr>
                                                </table>  
                                           
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
                    </form> 
                 </td>
            </tr>
        </table>  
   
<?php include 'rodape.php'; ?>