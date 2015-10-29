<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; 
?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Compradores</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa" style="width:300px">Promo Frete Gr&aacute;tis</li>
                      <!--<li><input type="Button" value="Enviar p/ Todos (SMS)" onClick="document.location.href=('envia_sms_compradores.php?tip=<?php echo $tipo; ?>&cat=<?php echo $cat; ?>');" class="form00" style="width:120px;height:23px;margin: 0;" /></li>-->
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF">
                    <br />
                    <table class="textostabelas" width="1000" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                <tr bgcolor="#CCCCCC">
                                        <td align="center"><strong>Data</strong></td>
                                        <td align="center"><strong>Me</strong></td>
                                        <td align="center"><strong>Compra</strong></td>
                                        <td align="center"><strong>ST</strong></td>
                                        <td align="center"><strong>Valor</strong></td>
                                        <td align="left"><strong>Nome</strong></td>
                                        <td align="left"><strong>E-mail</strong></td>
                                        <td align="left"><strong>Telefone</strong></td>
                                        <td align="center"><strong>Compras</strong></td>
                                        <td align="center"><strong>E-mail</strong></td>
                                        <td align="center"><strong>SMS</strong></td>
                                </tr>  
								<?php
                                
                                $compra = "select NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO,
                                ST_COMPRA_COSO, DS_DDDFONE_CASO, DS_FONE_CASO, DS_CELULAR_CASO, NR_SEQ_COMPRA_COSO,
                                VL_TOTAL_COSO, ST_COMPRA_COSO
                                from compras, cadastros where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
                                ST_COMPRA_COSO <> 'C' and DT_COMPRA_COSO > '2013-04-19 13:00:00' and VL_FRETE_COSO = 0
                                and NR_SEQ_CADASTRO_COSO not in (8074, 22364) and NR_SEQ_LOJA_COSO = 1 order by DT_COMPRA_COSO";

                                $compraST = mysql_query($compra);
                                if (mysql_num_rows($compraST) > 0) {
                                    $qtde = 0;
                                    $total = 0;
                                    while($row = mysql_fetch_row($compraST)) {
                                        $datCompra = $row[1];
                                        $nrCadastro = $row[0];
                                        $nome = $row[2];
                                        $email = $row[3];
                                        $status = $row[4];
										$ddd = $row[5];
										$fone = $row[6];
                                        $celular      = $row[7];
                                        $nrCompra     = $row[8];
                                        $vlCompra     = $row[9];
                                        $STCompra     = $row[10];
                                        
                                        $total += $vlCompra;
                                        
                                        $celular = str_replace("-","",$celular);
                                        $celular = str_replace(".","",$celular);
                                        $celular = str_replace("/","",$celular);
                                        $celular = str_replace("=","",$celular);
                                        $celular = str_replace(" ","",$celular);
                                ?>
                                            
                                            
                                                    <tr>
                                                        <td align="center" width="80"><?php echo date("d/m/Y G:i", strtotime($datCompra)); ?></td>
                                                        <td align="center" width="50" nowrap="nowrap"><a target="_blank" href="http://www.reverbcity.com/me/me_perfil.php?idme=<?php echo $nrCadastro; ?>"><?php echo $nrCadastro; ?></a></td>
                                                        <td align="center" width="50"><a href="compras_ver.php?idcli=<?php echo $nrCadastro;?>&idc=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $nrCompra ?>" class="thickbox"><strong><?php echo $nrCompra;?></strong></a></td>
                                                        <td align="center" width="20"><?php echo $STCompra; ?></td>
                                                        <td align="center" width="80">R$ <?php echo number_format($vlCompra,2,",","."); ?></td>
                                                        <td align="left" width="175"><?php echo $nome; ?></td>
                                                        <td align="left" width="159" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="left" width="77"><?php echo $ddd.' - '.$fone; ?></td>
                                                        <td align="center" width="60"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $nrCadastro;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Compras" class="thickbox"><img src="img/ico_check.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                                        <td align="center" width="45"><a href="aviso.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar aviso" border="0" /></a></td>
                                                        <?php if (strlen($celular)==8) { ?>
                                                        <td align="center" width="30"><a href="envia_sms.php?idcli=<?php echo $nrCadastro;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                                        <?php }else{ ?>
                                                        <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                    </tr>
                                        		
                                           
                                        <?php
                                        $qtde++;
                                     } // FIM WHILE
									 ?> 
									<tr bgcolor="#CCCCCC">
                                        <td align="center" width="80"><strong>Total: <?php echo $qtde; ?></strong></td>
                                        <td align="center" width="50" nowrap="nowrap">&nbsp;</td>
                                        <td align="center" width="50">&nbsp;</td>
                                        <td align="center" width="20">&nbsp;</td>
                                        <td align="center" width="80"><strong>R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                        <td align="left" width="175">&nbsp;</td>
                                        <td align="left" width="159" nowrap="nowrap">&nbsp;</td>
                                        <td align="left" width="77">&nbsp;</td>
                                        <td align="center" width="60">&nbsp;</td>
                                        <td align="center" width="45">&nbsp;</td>
                                        <td align="center" width="30">&nbsp;</td>
                                    </tr>
									</table>   
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
				 </td>
            </tr>
        </table>   
   
<?php include 'rodape.php'; ?>