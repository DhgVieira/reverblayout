<?php
include 'auth.php';
include 'lib.php';

$stremail = "";

$pagina = request("pagina");

$tipo = request("tipo");
$palavra = request("palavra");

$pesq_nom = request("nome");
$pesq_sta = request("status");
$cidade = request("cidade");

if ($tipo == "1") {
	$pesq_nom = $palavra;
}else if ($tipo == "2") {
	$stremail = $palavra;
}else if ($tipo == "3") {
	$cidade = $palavra;
}

$estado = request("estado");
$PHP_SELF = "clientes_lj.php";

if ($pesq_sta == "0") {
	$num_por_pagina = 5000;
}else{
	$num_por_pagina = 100;
}
if (!$pagina) {
	$pagina = 1;
}

if (!$pesq_sta) $pesq_sta = 'A';

$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;


$consulta = "select count(*) from cadastros where TP_CADASTRO_CACH = 1 and NR_SEQ_CADASTRO_CASO not in
(select NR_SEQ_CADASTRO_COSO from compras, cadastros where NR_SEQ_CADASTRO_CASO =
 NR_SEQ_CADASTRO_COSO and TP_CADASTRO_CACH = 1 and ST_COMPRA_COSO <> 'C') ";
						
if ($pesq_nom) $consulta .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
if ($pesq_sta) $consulta .= " AND ST_CADASTRO_CASO = '$pesq_sta'";
if ($estado) $consulta .= " AND DS_UF_CASO = '$estado'";
if ($cidade) $consulta .= " AND DS_CIDADE_CASO like '%$cidade%'";
if ($stremail) $consulta .= " AND DS_EMAIL_CASO like '%$stremail%'";

list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc) {
	var confirma = confirm("Confirma a Exclusão desse cliente e de todas as suas informações relacionadas? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='clientes_del.php?pg=<?php echo $pagina; ?>&idc='+idc;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Atacado</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Lojistas Sem Compras</li>
                      <li id="abatipos" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='atacado_tipos.php';">Tipos Liberados</li>
                      <li id="abatipos1" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='atacado_semcomp3m.php';">Sem Compras 3 meses</li>
                      <li id="abatipos2" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes_lj.php';">Lojistas Cadastrados</li>
                    </ul>
                </td><form action="atacado_semcomp3m.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Classificar por Nome: </strong><input style="width:120px;height:14px;" class="frm_pesq" type="text" name="nome" value="<?php echo $pesq_nom; ?>" />
                    <strong>Cidade/UF: </strong>
                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="cidade" value="<?php echo $cidade; ?>" />
                    <select name="estado" class="input" id="estado" style="width:45px;"/>
                    		<option value="">--</option>
                        	<option value="AC">AC</option> 
                            <option value="AL">AL</option> 
                            <option value="AP">AP</option> 
                            <option value="AM">AM</option> 
                            <option value="BA">BA</option> 
                            <option value="CE">CE</option> 
                            <option value="DF">DF</option> 
                            <option value="ES">ES</option> 
                            <option value="GO">GO</option> 
                            <option value="MA">MA</option> 
                            <option value="MT">MT</option> 
                            <option value="MS">MS</option> 
                            <option value="MG">MG</option> 
                            <option value="PA">PA</option> 
                            <option value="PB">PB</option> 
                            <option value="PR">PR</option> 
                            <option value="PE">PE</option> 
                            <option value="PI">PI</option> 
                            <option value="RJ">RJ</option> 
                            <option value="RN">RN</option> 
                            <option value="RS">RS</option> 
                            <option value="RO">RO</option> 
                            <option value="RR">RR</option> 
                            <option value="SC">SC</option> 
                            <option value="SP">SP</option> 
                            <option value="SE">SE</option> 
                            <option value="TO">TO</option> 
                        </select>  
                    <select name="status" class="frm_pesq" style="width:90px;height:20px;">
                    	<option value="A">Ativos</option>
                        <option value="I">Inativos</option>
                        <option value="0">Com Pontos</option>
                    </select>
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>
                	<script language="JavaScript">
					   document.formnews.estado.value = "<?php echo $estado; ?>";
					</script>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   
                	<ul class="compras">
                    <li>
                    <table border="0" width="100%" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td align="left" width="100"><strong>Nick</strong></td>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="170"><strong>E-mail</strong></td>
                                <td align="center" width="115"><strong>Telefone</strong></td>
                                <td align="center" width="150"><strong>Cidade/UF</strong></td>
                                <!--<td align="center" width="100"><strong>CEP</strong></td>-->
                                <td align="center" width="80"><strong>Desconto</strong></td>
                                <td align="center" width="80"><strong>Vlr.Mínimo</strong></td>
                                <td align="center" width="80"><strong>Mín.Repos.</strong></td>
                                <td align="center" width="80"><strong>%Desc Boleto</strong></td>
                                <td align="center" width="80"><strong>Frete Gr&aacute;tis</strong></td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                            </tr>
                        </table>
                    </li>
						<?php
						  
					
						  $sql = "select NR_SEQ_CADASTRO_CASO, DS_LOGIN_CASO, DS_NOME_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
						  				DS_FONE_CASO, ST_CADASTRO_CASO, VL_DESCONTO_CACH, NR_QTDEMINIMA_CACH, NR_QTDEMINBUTTONS_CACH, DS_LOGIN_CASO,
                                        DS_CELULAR_CASO, DS_TWITTER_CACH, DS_FACEBOOK_CACH, NR_ATAC_VLRMIN_CACH, VL_ATAC_DESCBOLETO_CACH,
                                        ST_ATAC_FRETEGRATIS_CACH, VL_ATAC_MINREPOS_CACH
										from cadastros where TP_CADASTRO_CACH = 1 and NR_SEQ_CADASTRO_CASO not in
                                        (select NR_SEQ_CADASTRO_COSO from compras, cadastros where NR_SEQ_CADASTRO_CASO =
                                         NR_SEQ_CADASTRO_COSO and TP_CADASTRO_CACH = 1 and ST_COMPRA_COSO <> 'C') ";

						  if ($pesq_nom) $sql .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
						  if ($pesq_sta) {
						  	if ($pesq_sta != "0") {
								$sql .= " AND ST_CADASTRO_CASO = '$pesq_sta'";
							}
						  }
						  if ($estado) $sql .= " AND DS_UF_CASO = '$estado'";
						  if ($cidade) $sql .= " AND DS_CIDADE_CASO like '%$cidade%'";
						  if ($stremail) $sql .= " AND DS_EMAIL_CASO like '%$stremail%'";

						  $sql .= " order by DS_LOGIN_CASO LIMIT $primeiro_registro, $num_por_pagina";

						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
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
							 $desconto	   = $row[10];
							 $qtdemin	   = $row[11];
                             $qtdemin_butt = $row[12];
                             $dsnick       = $row[13];
                             $celular      = $row[14];
                             $twitter      = $row[15];
                             
                             $facebook     = $row[16];
                             
                             $valormin     = $row[17];
                             $desconto_boleto = $row[18];
                             $fretegratis  = $row[19];
                             
                             $minrepos     = $row[20];
                             
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
							 
							$mostra = true;
							?>
							<li>
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr><form action="clientes_lj2.php" method="post">
                                	<input name="idcli" type="hidden" value="<?php echo $id_cad ?>" />
                                    <td align="left" width="100"><strong><?php echo $dsnick; ?></strong></td>
                                    <td align="left"><strong><?php echo $ds_nome; ?></strong></td>
                                    <td align="left" width="170"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td align="center" width="115"><?php echo $ds_ddd; ?> <?php echo $ds_fone; ?></td>
                                    <td align="center" width="150"><?php echo $ds_cidade; ?>/<?php echo $ds_uf; ?></td>
                                    <!--<td align="center" width="100"><?php echo $ds_cep; ?></td>-->
                                    <td align="center" width="80"><input style="width:30px;height:14px;" class="frm_pesq" type="text" name="desconto" value="<?php echo $desconto; ?>" />%</td>
                                    <td align="center" width="80">R$<input style="width:40px;height:14px;" class="frm_pesq" type="text" name="valormin" value="<?php echo number_format($valormin,2,",",""); ?>" /></td>
                                    <td align="center" width="80">R$<input style="width:40px;height:14px;" class="frm_pesq" type="text" name="minrepos" value="<?php echo number_format($minrepos,2,",",""); ?>" /></td>
                                    <td align="center" width="80"><input style="width:30px;height:14px;" class="frm_pesq" type="text" name="desconto_boleto" value="<?php echo $desconto_boleto; ?>" />%</td>
                                    <td align="center" width="80"><input type="checkbox" value="S" name="fretegratis"<?php if ($fretegratis == "S") echo " checked=\"checked\"";?> /></td>
                                    <!--
                                    <td align="center" width="80"><input style="width:30px;height:14px;" class="frm_pesq" type="text" name="qtdemin" value="<?php echo $qtdemin; ?>" /></td>
                                    <td align="center" width="80"><input style="width:30px;height:14px;" class="frm_pesq" type="text" name="qtdemin2" value="<?php echo $qtdemin_butt; ?>" /></td>
                                    -->
                                    <td align="left" width="30"><input name="Pesquisar" type="submit" class="frm_pesq" alt="Alterar" value=" >> " align="absmiddle" style="border:solid;border-width:1px; cursor:pointer" /></td>
                                    <td align="center" width="30"><?php echo $ds_status; ?></td>
                                    <td align="center" width="20"><a href="clientes_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $ds_status; ?>&idc=<?php echo $id_cad;?>&tp=1" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="clientes_alt.php?idc=<?php echo $id_cad;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                    <td align="center" width="27"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $id_cad;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Compras do Lojista" class="thickbox"><img src="img/compras_ver.gif" width="16" height="16" border="0" alt="Ver Compras" /></a></td>
                                    <!--<td align="center" width="20"><a href="#" title="Deletar Cliente" onclick="confirma(<?php echo $id_cad;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>-->
                                    <td align="center" width="20"><a href="envia_email_lj.php?nome=<?php echo $ds_nome; ?>&email=<?php echo $ds_email; ?>"><img src="img/ico_mail.gif" title="Enviar E-mail" border="0" /></a></td>
                                    <?php if (strlen($celular)==8) { ?>
                                    <td align="center" width="20"><a href="envia_sms.php?idcli=<?php echo $id_cad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($twitter) { ?>
                                    <td align="center" width="20"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($facebook) { ?>
                                        <td align="center" width="20"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                    <?php }else{ ?>
                                        <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                    <td align="center" width="30"><a href="clientes_obs.php?idcli=<?php echo $id_cad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Observação no Cadastro" class="thickbox"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Observacao" /></a></td>
                                </tr></form>
                            </table>
                            </li>
							<?php
					
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao2">
						<?php
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
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                  
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>