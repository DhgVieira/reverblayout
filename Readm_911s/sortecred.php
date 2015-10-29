<?php
include 'auth.php';
include 'lib.php';

$aba = request("aba");
if (!$aba) $aba = "3";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc) {
	var confirma = confirm("Confirma a Exclusao desse Credito?")
	if ( confirma ){
		document.location.href='sortecred_del.php?idc='+idc;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Cr&eacute;ditos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCreditos" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Administrar Cr&eacute;ditos</li>
                      <li id="abaParc" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='parceiros.php';">Parceiros</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                	<div id="Creditos">
                    	<?php 
						$sql = "select sum(VL_LANCAMENTO_CRSA) as total, NR_SEQ_CADASTRO_CRSA, DS_NOME_CASO, DS_DDDFONE_CASO, DS_FONE_CASO,
                                DS_EMAIL_CASO, DS_CIDADE_CASO, DS_UF_CASO, NR_SEQ_CADASTRO_CRSA, DS_CELULAR_CASO,
                                  DS_TWITTER_CACH, DS_FACEBOOK_CACH from contacorrente, cadastros WHERE
                                NR_SEQ_CADASTRO_CRSA = NR_SEQ_CADASTRO_CASO AND TP_CADASTRO_CACH <> 3
                                group by NR_SEQ_CADASTRO_CRSA order by DS_NOME_CASO";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	?>
                            <ul class="noticias">
                            <li>
                            	<table width="1025">
                                	<tr>
                                    	<td width="80" align=center><strong>ME</strong></td>
                                        <td><strong>Nome</strong></td>
                                        <td width="130"><strong>Telefone</strong></td>
                                        <td width="220"><strong>E-Mail</strong></td>
                                        <td width="150"><strong>Cidade/UF</strong></td>
                                        <td width="90" align="center"><strong>Saldo</strong></td>
                                        <td width="25" align="center">&nbsp;</td>
                                        <td width="25" align="center">&nbsp;</td>
                                        <td width="25" align="center">&nbsp;</td>
                                        <td width="25" align="center">&nbsp;</td>
                                        <td width="25" align="center">&nbsp;</td>
                                    </tr>
                                </table>
                             </li>
                            <?php
                            $total = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $saldo		   = $row[0];
					         $nrseqcad	   = $row[1];
							 $nome		   = $row[2];
							 $ddd		   = $row[3];
							 $fone		   = $row[4];
                             $email		   = $row[5];
                             $cidade	   = $row[6];
                             $estado	   = $row[7];
                             $nrseq 	   = $row[8];
                             $celular      = $row[9];
                             $twitter      = $row[10];
                             $facebook     = $row[11];
                             
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
                            <li>
                            	<table width="1025">
                                	<tr>
                                    	<td width=80 align=center><a target="_blank" href="http://www.reverbcity.com/me/me_perfil.php?idme=<?php echo $nrseq ?>"><strong><?php echo $nrseq ?></strong></a></td>
                                        <td><?php echo $nome ?></td>
                                        <td width="130"><?php echo $ddd ?> <?php echo $fone ?></td>
                                        <td width="220"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td>
                                        <td width="150"><?php echo $cidade ?>/<?php echo $estado ?></td>
                                        <td width="90" align="center"><strong>R$ <?php echo number_format($saldo,2,",",".") ?></strong></td>
                                        <td width="25" align="center"><a href="sortecred_det.php?idc=<?php echo $nrseqcad ?>" title="Ver Detalhado"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                        <td align="center" width="25"><a href="envia_email_cred.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar E-mail" border="0" /></a></td>
                                        <?php if (strlen($celular)==8) { ?>
                                        <td align="center" width="25"><a href="envia_sms.php?idcli=<?php echo $nrseqcad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                        <?php }else{ ?>
                                        <td align="center" width="25">&nbsp;</td>
                                        <?php } ?>
                                        <?php if ($twitter) { ?>
                                        <td align="center" width="25"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                        <?php }else{ ?>
                                        <td align="center" width="25">&nbsp;</td>
                                        <?php } ?>
                                        <?php if ($facebook) { ?>
                                            <td align="center" width="25"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                        <?php }else{ ?>
                                            <td align="center" width="25">&nbsp;</td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </li>
                            <?php 
                                $total += $saldo;
                            }?>
                            <li>
                            	<table width="925">
                                	<tr>
                                    	<td width=80 align=center>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="130">&nbsp;</td>
                                        <td width="220">&nbsp;</td>
                                        <td width="150">&nbsp;</td>
                                        <td width="90" align="center"><strong>R$ <?php echo number_format($total,2,",",".") ?></strong></td>
                                        <td width="25" align="center">&nbsp;</td>
                                    </tr>
                                </table>
                            </li>
                           </ul>
                         <?php }?>
                    </div>
                    
                    <script>
					  defineAba("abaCreditos","Creditos");
					  <?php
 					   echo "defineAbaAtiva(\"abaCreditos\");";
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
