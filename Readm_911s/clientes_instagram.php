<?php
include 'auth.php';
include 'lib.php';

$stremail = "";

$pagina = request("pagina");

$tipo = request("tipo");
$palavra = request("palavra");

$pesq_nom = request("nome");
$pesq_email = request("email");
$pesq_sta = request("status");
$pesq_cpf = request("cpf");
$cidade = request("cidade");
$pesq_nick = request("nick");

if ($tipo == "1") {
	$pesq_nom = $palavra;
}else if ($tipo == "2") {
	$stremail = $palavra;
}else if ($tipo == "3") {
	$cidade = $palavra;
}

$estado = request("estado");
$PHP_SELF = "clientes_instagram.php";

if ($pesq_sta == "0") {
	$num_por_pagina = 5000;
}else{
	$num_por_pagina = 50;
}
if (!$pagina) {
	$pagina = 1;
}
$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;

$consulta = "SELECT COUNT(*) FROM cadastros WHERE NR_SEQ_CADASTRO_CASO <> 3 ";

if ($SS_loja != 2){
 $consulta .= "AND NR_SEQ_LOJA_CASO = $SS_loja";                        
}else{
 $consulta .= "AND (NR_SEQ_LOJA_CASO = $SS_loja or DS_CIDADE_CASO like '%SAO PAULO%' or DS_CIDADE_CASO like '%são paulo%' or DS_CIDADE_CASO like '%sÃ£o paulo%' or DS_CIDADE_CASO like '%sao paulo%' or DS_CIDADE_CASO like '%saopaulo%')";
}
						
if ($pesq_nom) {
  if (strpos($pesq_nom," ") > 0){
     $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
     $nome2 = str_replace($nome1." ","",$pesq_nom);
     $consulta .= " AND (DS_NOME_CASO like '%$nome1%' and DS_NOME_CASO like '%$nome2%')";
  }else{
     $consulta .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
  }
}
if ($pesq_email) $consulta .= " AND DS_EMAIL_CASO LIKE '%$pesq_email%'";
if ($pesq_sta) $consulta .= " AND ST_CADASTRO_CASO = '$pesq_sta'";
if ($estado) $consulta .= " AND DS_UF_CASO = '$estado'";
if ($cidade) $consulta .= " AND DS_CIDADE_CASO like '%$cidade%'";
if ($stremail) $consulta .= " AND DS_EMAIL_CASO like '%$stremail%'";
if ($pesq_cpf) $consulta .= " AND DS_CPFCNPJ_CASO like '%$pesq_cpf%'";
if ($pesq_nick) $consulta .= " AND DS_LOGIN_CASO like '%$pesq_nick%'";


list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc) {
	var confirma = confirm("Confirma a Exclusão desse cliente e de todas as suas informações relacionadas? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='clientes_del.php?pg=<?php echo $pagina; ?>&idc='+idc+'&nom=<?php echo $pesq_nom ?>&cpf=<?php echo $pesq_cpf ?>'
	} else {
		return false
	} 
}

function confirmaGP(idc) {
	var confirma = confirm("Confirma a Exclusão desse grupo e de todas as suas informações relacionadas? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='gruposcliente_del.php?idg='+idc;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Cliente com Instagram</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes.php';">Clientes Cadastrados (<?php echo $total_usuarios; ?>)</li>
                      <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes_sp.php';">Clientes S&atilde;o Paulo</li>
                      <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes_semdata.php';">Clientes sem dt/nasc</li>
                      <li id="abaInstagram" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes_instagram.php';">Cliente com Instagram</li>
                      <li id="abaNivers" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Aniversariantes</li>
                      <li id="abaExport" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Exportar Lista</li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="Ver">
                   <table><tr>
                   <td width="300">&nbsp;</td>
                   <form action="clientes.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Classificar por Nome: </strong><input style="width:120px;height:14px;" class="frm_pesq" type="text" name="nome" value="<?php echo utf8_encode($pesq_nom); ?>" />
                    <strong>Nick: </strong><input style="width:80px;height:14px;" class="frm_pesq" type="text" name="nick" value="<?php echo $pesq_nick; ?>" />
                    <strong>E-mail: </strong><input style="width:120px;height:14px;" class="frm_pesq" type="text" name="email" value="<?php echo $pesq_email; ?>" />
                    <strong>CPF: </strong>
                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="cpf" value="<?php echo $pesq_cpf; ?>" />
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
                    
                    </tr></table>
                	<ul class="compras">
                    <li>
                    <table border="0" width="1200" cellpadding="0" cellspacing="2">
                            <tr>
                                <td align="left" width="100"><strong>Nick</strong></td>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="170"><strong>E-mail</strong></td>
                                <td align="center" width="115"><strong>Telefone</strong></td>
                                <td align="center" width="150"><strong>Cidade/UF</strong></td>
                                <td align="center" width="100"><strong>CEP</strong></td>
                                <!--<td align="center" width="80"><strong>Pontos</strong></td>-->
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="30">&nbsp;</td>
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
						  
					
						  $sql = "select NR_SEQ_CADASTRO_CASO, DS_LOGIN_CASO, DS_NOME_CASO, DS_CIDADE_CASO, DS_UF_CASO,
                                  DS_CEP_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, ST_CADASTRO_CASO, DS_CELULAR_CASO,
                                  DS_TWITTER_CACH, DS_FACEBOOK_CACH, DS_LOGIN_CASO, ST_BLOQUEIOMAIL_CACH, DS_INSTAGRAM_CASO from cadastros WHERE NR_SEQ_CADASTRO_CASO <> 3 and DS_INSTAGRAM_CASO <> ''                                    ";
                          if ($SS_loja != 2){
                             $sql .= "AND NR_SEQ_LOJA_CASO = $SS_loja";                        
                          }else{
                             $sql .= "AND (NR_SEQ_LOJA_CASO = $SS_loja or DS_CIDADE_CASO like '%SAO PAULO%' or DS_CIDADE_CASO like '%são paulo%' or DS_CIDADE_CASO like '%sÃ£o paulo%' or DS_CIDADE_CASO like '%sao paulo%' or DS_CIDADE_CASO like '%saopaulo%')";
                          }
						  if ($pesq_nom) {
                              if (strpos($pesq_nom," ") > 0){
							     $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
                                 $nome2 = str_replace($nome1." ","",$pesq_nom);
                                 $sql .= " AND (DS_NOME_CASO like '%$nome1%' and DS_NOME_CASO like '%$nome2%')";
                              }else{
                                 $sql .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
                              }
						  }
						  if ($pesq_email) $sql .= " AND DS_EMAIL_CASO LIKE '%$pesq_email%'";
						  if ($pesq_sta) {
						  	if ($pesq_sta != "0") {
								$sql .= " AND ST_CADASTRO_CASO = '$pesq_sta'";
							}
						  }
						  if ($estado) $sql .= " AND DS_UF_CASO = '$estado'";
						  if ($cidade) $sql .= " AND DS_CIDADE_CASO like '%$cidade%'";
						  if ($stremail) $sql .= " AND DS_EMAIL_CASO like '%$stremail%'";
                          if ($pesq_cpf) $sql .= " AND DS_CPFCNPJ_CASO like '%$pesq_cpf%'";
                          if ($pesq_nick) $sql .= " AND DS_LOGIN_CASO like '%$pesq_nick%'";

						  $sql .= " order by DS_NOME_CASO LIMIT $primeiro_registro, $num_por_pagina";

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
                             $celular      = $row[10];
                             $twitter      = $row[11];
                             
                             $facebook     = $row[12];
                             $dsnick       = $row[13];
                             $st_bloqmail  = $row[14];
                             $instagram = $row[15];

                             $instagram = str_replace('http://', '', $instagram);
                             $instagram = str_replace('https://', '', $instagram);
                             $instagram = str_replace('instagram.com/', '', $instagram);
                             $instagram = str_replace('www.', '', $instagram);
                             $instagram = str_replace('@', '', $instagram);

                             
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
							 
							//$sqlp = "select sum(NR_QTDE_PORC) from pontos where NR_SEQ_CADASTRO_PORC = $id_cad and ST_PONTOS_PORC = 'E'";
//							$stp = mysql_query($sqlp);
//							$pontos = 0;
//							if (mysql_num_rows($stp) > 0) {
//								$rowp = mysql_fetch_row($stp);
//								$pontos	= $rowp[0];
//							}else{
//								$pontos = 0;
//							}
//							if (!$pontos) $pontos = 0;
							
							$mostra = true;
							
							//if ($pesq_sta == "0") {
//								if ($pontos > 0) {
//									$mostra = true;
//								}else{
//									$mostra = false;
//								}
//							}
							
							if ($mostra) {
							?>
							<li style="width: 1200px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td align="left" width="100"><strong><?php echo utf8_encode($dsnick); ?></strong></td>
                                    <td align="left"><strong><?php echo utf8_encode($ds_nome); ?></strong></td>
                                    <td align="left" width="170"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td align="center" width="115"><?php echo $ds_ddd; ?> <?php echo $ds_fone; ?></td>
                                    <td align="center" width="150"><?php echo $ds_cidade; ?>/<?php echo $ds_uf; ?></td>
                                    <td align="center" width="100"><?php echo $ds_cep; ?></td>
                                    <!--<td align="center" width="80"><?php echo $pontos; ?></td>-->
                                    <td align="center" width="30"><?php echo $ds_status; ?></td>
                                    <?php if ($SS_nivel>=80) { ?>
                                    <td align="center" width="20"><a href="sortecred_det.php?idc=<?php echo $id_cad;?>" title="Créditos"><img src="img/money.png" width="16" height="16" border="0" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                    <td align="center" width="20"><a href="clientes_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $ds_status; ?>&idc=<?php echo $id_cad;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="clientes_alt.php?idc=<?php echo $id_cad;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                    <td align="center" width="20"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $id_cad;?>" id="iframe" title="::  :: width: 640, height: 300" class="lightview"><img src="img/compras_ver.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar Cliente" onclick="confirma(<?php echo $id_cad;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <?php if ($st_bloqmail == "N") { ?>
                                        <td align="center" width="30"><a href="clientes_email.php?idc=<?php echo $id_cad;?>&ac=B&pg=<?php echo $pagina; ?>" title="Bloquear Envio"><img src="img/ico_bloqmail_n.gif" width="28" height="16"></a></td>
                                    <?php }else{ ?>
                                        <td align="center" width="30"><a href="clientes_email.php?idc=<?php echo $id_cad;?>&ac=D&pg=<?php echo $pagina; ?>" title="Liberar Envio"><img src="img/ico_bloqmail_s.gif" width="28" height="16"></a></td>
                                    <?php } ?>
                                    <!--<td align="center" width="20"><a href="gruposcliente_add.php?id_cadcli=<?php echo $id_cad ?>" title="Adicionar ao Grupo "><img src="img/ico_usuarios.gif" width="16" height="16" border="0" /></a></td>-->
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
                                    <?php if ($instagram) { ?>
                                        <td align="center" width="20"><a href="https://instagram.com/<?php echo $instagram?>" title="Instagram" target="_blank"><img src="img/instagram_ico.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                    <?php }else{ ?>
                                        <td align="center" width="20">&nbsp;</td>
                                    <?php } ?>
                                </tr>
                            </table>
                            </li>
							<?php
							}
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
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&nome=$pesq_nom&email=$pesq_email&status=$pesq_sta&estado=$estado&cidade=$cidade\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&nome=$pesq_nom&email=$pesq_email&status=$pesq_sta&estado=$estado&cidade=$cidade\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&nome=$pesq_nom&email=$pesq_email&status=$pesq_sta&estado=$estado&cidade=$cidade\">[$x]</a></li>";
                          }
                        }
                        
                        $mostrapainel = false;
                        
                        if ($pesq_nom) $mostrapainel = true;
				        if ($pesq_email) $mostrapainel = true;
						if ($estado) $mostrapainel = true;
						if ($cidade)  $mostrapainel = true;
						if ($stremail) $mostrapainel = true;
                        if ($pesq_cpf) $mostrapainel = true;
                        
                        echo "$prev_link";
                        if ($mostrapainel) echo "$painel";
                        echo "$next_link";
						
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                  	</div>	<!-- Ver -->
                                     
                    <script>
                      defineAba("abaVer","Ver");
					             defineAba("abaGrupo","Grupos");
                      defineAba("abaNivers","Nivers");
                      defineAba("abaExport","Export");
                      defineAba("abaInstagram","Instagram");
                      //defineAbaAtiva("abaInstagram");
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