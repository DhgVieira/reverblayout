<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$dateini = request("dti");
$datefim = request("dtf");

if (!$datefim) $datefim = date("Y-m-d")." ".time();

$consulta = "SELECT DS_PRODUTO2_PRRC, DS_CATEGORIA_PTRC from produtos, produtos_tipo WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($consulta);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $ds_produto = $row[0];
    $ds_categoria = $row[1];
}else{
    exit();
}

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li style="width: 460px;" id="menuDepo" class="abaativa">Compradores <?php echo $ds_categoria . " - ". $ds_produto ?></li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li style="width: 460px;" id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);"><?php echo date("d/m/Y G:i",strtotime($dateini)) ?> - <?php echo date("d/m/Y G:i",strtotime($datefim)) ?></li>
                    </ul>
                </td>
                <td align="left">
                    <!--
                    <div style="width: 600px; text-align: right;">
                        <input type="Button" value="Enviar E-Mail" onClick="document.location.href=('envia_mail_comp.php?idp=<?php echo $idp ?>');" class="form00" style="width:100px;height:23px;" />
                        Compradores do Produto: <strong><?php echo $ds_categoria . " - ". $ds_produto ?></strong>
                    </div>
                    -->
                </td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="Ver">

                	<ul class="compras">
                    <li>
                    <table border="0" width="100%" cellpadding="0" cellspacing="2">
                            <tr>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="170"><strong>E-mail</strong></td>
                                <td align="center" width="115"><strong>Telefone</strong></td>
                                <td align="center" width="150"><strong>Cidade/UF</strong></td>
                                <td align="center" width="100"><strong>CEP</strong></td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                            </tr>
                        </table>
                    </li>
						<?php
                          $qtde_tt = 0;
                          $valot_tt = 0;
                          
                          $sql = "SELECT NR_SEQ_CADASTRO_CASO, DS_LOGIN_CASO, DS_NOME_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO,
                          DS_EMAIL_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, ST_CADASTRO_CASO, sum(NR_QTDE_CESO), VL_PRODUTO_CESO,
                          DS_CELULAR_CASO, DS_TWITTER_CACH, NR_SEQ_COMPRA_COSO from cadastros, compras, cestas
                          where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                          and ST_COMPRA_COSO <> 'C' AND NR_SEQ_PRODUTO_CESO = $idp AND NR_SEQ_LOJA_COSO = $SS_loja 
                          and (DT_COMPRA_COSO BETWEEN '$dateini' and '$datefim') GROUP BY NR_SEQ_CADASTRO_CASO order by DS_NOME_CASO";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_cad	   = $row[0];
					         $ds_login	   = $row[1];
							 $ds_nome	   = $row[2];
							 $ds_cidade	   = $row[3];
							 $ds_uf		   = $row[4];
							 $ds_cep	   = $row[5];
							 $ds_email	   = $row[6];
							 $ds_ddd	   = $row[7];
							 $ds_fone	   = $row[8];
							 $ds_status	   = $row[9];
                             $qtde  	   = $row[10];
                             $valor 	   = $row[11];
                             
                             $celular      = $row[12];
                             $twitter      = $row[13];
                             
                             $celular = str_replace("-","",$celular);
                             $celular = str_replace(".","",$celular);
                             $celular = str_replace("/","",$celular);
                             $celular = str_replace("=","",$celular);
                             $celular = str_replace(" ","",$celular);
							 
                             $qtde_tt += $qtde;
                             $valot_tt += ($qtde*$valor);
                             
                            
							 ?>
							<li>
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td align="left"><strong><?php echo $ds_nome; ?></strong></td>
                                    <td align="left" width="170"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td align="center" width="115"><?php echo $ds_ddd; ?> <?php echo $ds_fone; ?></td>
                                    <td align="center" width="150"><?php echo $ds_cidade; ?>/<?php echo $ds_uf; ?></td>
                                    <td align="center" width="100"><?php echo $ds_cep; ?></td>
                                    <td align="center" width="20"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $id_cad;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $id_compra ?>" class="thickbox"><img src="img/compras_ver.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                    <?php if (strlen($celular)==8 || strlen($celular)==9) { ?>
                                    <td align="center" width="20"><a href="envia_sms.php?idcli=<?php echo $id_cad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($twitter) { ?>
                                    <td align="center" width="20"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                            <li>
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td align="left">&nbsp;</td>
                                    <td align="left" width="170">&nbsp;</td>
                                    <td align="center" width="115">&nbsp;</td>
                                    <td align="center" width="150">&nbsp;</td>
                                    <td align="center" width="100">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
                      </ul>
                     
                  	</div>	<!-- Ver -->
<!-- Grupos -->                    
 		             
                    <script>
                      defineAba("abaVer","Ver");
					  <?php
					  $aba = request("aba");
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					   }
					  ?>
                    </script>
                    
                    
              <?php  mysql_close($con);    ?>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>