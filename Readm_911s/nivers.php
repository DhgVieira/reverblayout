<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; 
?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Aniversariantes</li>
                    </ul>
                </td>
            </tr>
        </table>
       
        <table class="textostabelas" width="100%" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
        	<tr>
            	<?php 
					  $sql = "select count(*) from cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO) ";
					  $st = mysql_query($sql);
                      $totniver = 0;
					  if (mysql_num_rows($st) > 0) {
					  	 $row = mysql_fetch_row($st);
                         $totniver = $row[0];
                      }else{
                         $totniver = 0;
                      }
                ?>
                <td align="left">
                	<ul id="titulos_abas">
                      <a name="niver"></a><li id="menuDepo" class="abaativa">Aniversariantes (<?php echo $totniver ?>)</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                	<ul class="noticias" style="width: 600px;">
						<?php
						  $sql = "select DS_NOME_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO, DS_CIDADE_CASO, DS_UF_CASO,
                                 DS_DDDFONE_CASO, DS_FONE_CASO, NR_SEQ_CADASTRO_CASO, DS_CELULAR_CASO, DS_TWITTER_CACH
                                 from cadastros WHERE DS_UF_CASO = 'SP' AND (DS_CIDADE_CASO LIKE '%saopaulo%' OR DS_CIDADE_CASO LIKE '%sao paulo%' OR DS_CIDADE_CASO LIKE '%sp%' OR DS_CIDADE_CASO LIKE '%são paulo%') and
                                 day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO)
                                 order by DS_NOME_CASO";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $nome		   = $row[0];
					         $email		   = $row[1];
							 $dt_nasc	   = $row[2];
							 $cidade	   = $row[3];
							 $estado	   = $row[4];
                             $dddfone	   = $row[5];
                             $fone         = $row[6];
                             $nrcad        = $row[7];
                             $celular      = $row[8];
                             $twitter      = $row[9];
                             
                             $celular = str_replace("-","",$celular);
                             $celular = str_replace(".","",$celular);
                             $celular = str_replace("/","",$celular);
                             $celular = str_replace("=","",$celular);
                             $celular = str_replace(" ","",$celular);
                             
                             $sqlniv = "select count(*) from compras WHERE NR_SEQ_CADASTRO_COSO = $nrcad AND (ST_COMPRA_COSO = 'P' or ST_COMPRA_COSO = 'V' or ST_COMPRA_COSO = 'E')";
        					 $stniv = mysql_query($sqlniv);
                             $totniver = 0;
        					 if (mysql_num_rows($stniv) > 0) {
        					 	 $rowniv = mysql_fetch_row($stniv);
                                 $totcomp = $rowniv[0];
                             }else{
                                 $totcomp = 0;
                             }
                             $msgniver = "Parabens! Aproveite que hoje e seu dia e bora se jogar nas compras a partir de R$150 com 30% OFF em produtos fora de promo reverbcity.com";
                             //$msgniver = "Parabens, aproveite que hj e seu dia e bora se jogar nas compras! Estamos com ate 50% OFF em quase todos os produtos www.reverbcity.com";
							?>
							<li style="width:99%;">
                            <span><strong><?php echo date("d/m/Y", strtotime($dt_nasc));?></strong> | <a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo ChecaClubStyle($nrcad,$nome);?></a> <?php if ($totcomp > 0) echo "(compras: ".$totcomp." <a href=\"clientes_ped.php?idc=".$nrcad."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"Ver Detalhamento\" /></a>)" ?></span>
                            <div>
                            <?php if ($twitter) { ?>
                                <a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a>
                            <?php }else{ ?>
                            &nbsp;
                            <?php } ?>
                            </div>
                            <div>
                              	(<?php echo $dddfone; ?>)<?php echo $fone; ?>
                            </div>
                            <div>
                              	<?php echo $cidade; ?>/<?php echo $estado; ?>
                            </div>
                            </li>
							<?php
							}
						  }else{
						 
						?>
                        <table width="100%" align="center"><tr><td align="center"><strong>Nenhum aniversariante hoje!</strong></td></tr></table>
                        <?php }?>
                   </ul>
                </td>
            </tr>
        </table>
       
<?php include 'rodape.php'; ?>