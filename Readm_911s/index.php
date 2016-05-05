<?php
include 'lib.php';
include 'auth.php';
include 'topo.php';

$msgal = request("ms");

//CHECA SE TEM CREDITO EXPIPRADO
// $str = "select NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, NR_SEQ_CONTA_CRSA, DT_LANCAMENTO_CRSA, DT_VENCIMENTO_CRSA from contacorrente
//          where SYSDATE() > DT_VENCIMENTO_CRSA AND ST_EXPIRADO_CRSA = 'N'
//          AND TP_LANCAMENTO_CRSA = 'C'";
// $st = mysql_query($str);
// if (mysql_num_rows($st) > 0) {
//     $strbaixas = "";
//     while($row = mysql_fetch_row($st)) {
//         $NRSEQ = $row[0];
//         $vlcred = $row[1];
//         $nrconta = $row[2];
//         $dtcredito = $row[3];
//         $dtexpirado = $row[4];
//         $saldo = 0;
//         $str2 = "select sum(VL_LANCAMENTO_CRSA) from contacorrente WHERE NR_SEQ_CADASTRO_CRSA = $NRSEQ";
//         $st2 = mysql_query($str2);
//         if (mysql_num_rows($st2) > 0) {
//              $row2 = mysql_fetch_row($st2);
//              $saldo = $row2[0];
//              if (!$saldo) $saldo = 0;
//         }
        
//         $str2 = "select sum(VL_LANCAMENTO_CRSA) from contacorrente WHERE NR_SEQ_CADASTRO_CRSA = $NRSEQ and
//                  NR_SEQ_CONTA_CRSA <> $nrconta and TP_LANCAMENTO_CRSA = 'C' and ST_EXPIRADO_CRSA = 'N' AND
//                  (DT_VENCIMENTO_CRSA > SYSDATE() OR DT_VENCIMENTO_CRSA IS NULL)";
//         $st2 = mysql_query($str2);
//         if (mysql_num_rows($st2) > 0) {
//              $row2 = mysql_fetch_row($st2);
//              $maiscredito = $row2[0];
//              if (!$maiscredito) $maiscredito = 0;
//              $saldo = $saldo - $maiscredito;
//         }
        
//         $vlradebitar = 0;
        
//         if ($saldo > 0){
//             $vlradebitar = $vlcred;
//             if (($saldo - $vlradebitar) < 0){
//                 $vlradebitar = $saldo;
//             }
            
//             $str3 = "INSERT INTO contacorrente (NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DT_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA)
// 			         VALUES ($NRSEQ, -$vlradebitar, 'D', sysdate(), '".utf8_encode("Cr�dito")." do dia ".date("d/m/Y G:i",strtotime($dtcredito))." Expirado em ".date("d/m/Y G:i",strtotime($dtexpirado))."')";
//             $st3 = mysql_query($str3);
            
//             $strbaixas .= $str3."<br />";
//         }
        
//         $str3 = "UPDATE contacorrente SET ST_EXPIRADO_CRSA = 'S' WHERE NR_SEQ_CONTA_CRSA = $nrconta";
//         $st3 = mysql_query($str3);
//         $strbaixas .= $str3."<br />";
//     }
// }
?>

<script type="text/javascript">
function recriar(idcomp) {
	var confirma = confirm("Tem certeza que voce quer recriar essa compra? Ela sera cancelada e uma nova compra com a mesma data sera criada.")
	if ( confirma ){
		document.location.href='compras_new.php?idc='+idcomp;
	} else {
		return false
	} 
}

function confirma_cla(idp) {
	var confirma = confirm("Tem certeza que voce deseja mover este produto para o Clssics?")
	if ( confirma ){
		document.location.href='grupos_cla.php?&idp='+idp+'&back=I';
	} else {
		return false
	} 
}
</script>
    	<?php
        if ($SS_logadm == 1){
        ?>
        <form action="ponto_batida.php" method="post">
            <input type="submit" value="REGISTRAR PONTO" style="width: 150px; height: 60px; margin-bottom: 20px;" />
        </form>
        <?php } ?>
        <?php
        if ($SS_logadm == 30){
        ?>
        <ul id="titulos_abas">
          <li id="menuDepo" class="abainativa" onclick="document.location.href='clientes3meses.php'" style="cursor:pointer">Sem compras h&aacute; 3 meses</li>
        </ul>
        <?php } ?>
        <?php
        if ($msgal){
        ?>
        <div style="margin: 0 0 20px 20px; color: red; font-size: 14px; font-family: tahoma;"><p><strong><?php echo $msgal; ?></strong></p></div>
        <?php } ?>
        <br />
        <?php if ($SS_nivel >= 20) { ?>
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
            	<td align="left" height="18" width="50%">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Compras em Aberto</li>
                      <?php if ($SS_nivel >= 50) { ?>
                      <li id="menuDepo" class="abainativa" onclick="document.location.href='clientes3meses.php'" style="cursor:pointer">Sem compras h&aacute; 3 meses</li>
                      <?php } ?>
                    </ul>
                </td><form action="clientes.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Buscar por </strong>
                    <select name="tipo" class="frm_pesq">
                    	<option value="1">Nome</option>
                        <option value="2">E-Mail</option>
                        <option value="3">Cidade</option>
                    </select>
                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="palavra" value="<?php echo $pesq_nom; ?>" />
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF" colspan="2">
                	<table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                            <tr>
                                <td align="center" width="60"><strong>NRO</strong></td>
                                <td align="center" width="145"><strong>Data Compra</strong></td>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="310"><strong>E-mail</strong></td>
                                <td align="center" width="100"><strong>Telefone</strong></td>
                                <td align="center" width="100"><strong>Forma Pgto.</strong></td>
                                <td align="center" width="120"><strong>Valor Total</strong></td>
                                <td align="center" width="30"><strong>Parc</strong></td>
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="90">&nbsp;</td>
                            </tr>
                        </table>
                    <ul class="compras">
						<?php
						  $sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
						   DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO, DT_NASCIMENTO_CASO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, DS_CELULAR_CASO,
                           DS_TWITTER_CACH, DS_OBS_COSO, TP_CADASTRO_CACH, DS_FACEBOOK_CACH, NR_SEQ_PROMO_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
						   AND ST_COMPRA_COSO = 'A' AND NR_SEQ_LOJA_COSO = $SS_loja ORDER BY DT_COMPRA_COSO desc";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
							$x = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $id_compra	   = $row[0];
					         $dt_compra	   = $row[1];
							 $formapgto	   = $row[2];
							 $valor		   = $row[3];
							 $nome		   = utf8_encode($row[4]);
							 $email		   = $row[5];
							 $dddfone	   = $row[6];
							 $fone		   = $row[7];
							 $idcli		   = $row[8];
							 $parcelas	   = $row[9];
                             
                             $datanasc     = $row[10];
                             $dian         = date("d",strtotime($datanasc));
                             $mesn         = date("m",strtotime($datanasc));
                             
                             $diac         = date("d",strtotime($dt_compra));
                             $mesc         = date("m",strtotime($dt_compra));
                             
                             $textodestaque = "";                             

							 if ($x == 0) {
							 	$bg = "#FFFFFF";
								if ( date("d/m/Y", strtotime($dt_compra)) == date("d/m/Y") ) $bg = "#f5f1ea";
								$x = 1;
							 }else{
							 	$bg = "#ECECFF";
								if ( date("d/m/Y", strtotime($dt_compra)) == date("d/m/Y") ) $bg = "#dacfbf";
								$x = 0;
							 }
                          
                             
                             $desconto     = $row[11];
                             $textopro     = $row[12];
                             $celular      = $row[13];
                             
                             $twitter      = $row[14];
                             
                             $dsobs        = $row[15];
                             
                             $tipocad      = $row[16];
                             $facebook     = $row[17];
                             $codpromo     = $row[18];
                             
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

                             if (strpos($textopro,"temos um presente para voc") > 0 || strpos($textopro,"No mes do seu aniversario") || strpos($textopro,"s do seu anivers")){
                                $textodestaque = "Compra de Aniversariante";   
                                $bg = "#B3FE97";                             
                             }                                                          
                             
                            if ((strpos($textopro,"primeira compra") || (strpos($textopro,"150,00! Escolha j")) || (strpos($textopro,"130,00! Escolha j"))) > 0 || strpos($textopro, " de desconto para serem usando em uma pr")){
                                $textodestaque = "Primeira Compra";   
                                $bg = "#FBFE98";                             
                             }
                             
                             if (strpos($textopro,"romo dia da M") > 0){
                                $textodestaque = "Promo Dia da M&uacute;sica";   
                                $bg = "#e8ce52";                             
                             }
                             
                             if (strpos($textopro,"Dia dos Namorados") > 0){
                                $textodestaque = "Promo Dia dos Namorados";   
                                $bg = "#FBDBFC";                             
                             }
                             
                             if (strpos($textopro,"Shirt Club") > 0){
                                $textodestaque = "T-Shirt Club";   
                                $bg = "#e8ce52";                       
                             }
                             
                             if (strpos($textopro,"Tee de Banda com ChocoKisses") > 0){
                                $textodestaque = "Promo Tee + Choco";   
                                $bg = "#F5DD82";                       
                             }
                             
                             if (strpos($textopro,"Mugshot Jimi Hendrix") > 0){
                                $textodestaque = "Promo Jeans F + Hendrix";   
                                $bg = "#F5DD82";                       
                             }
                             
                             if (strpos($textopro,"Dia Dos Namorados") > 0){
                                $textodestaque = "Dia Dos Namorados";   
                                $bg = "#e8ce52";                       
                             }
                             
                             if ($codpromo == 2){
                                $textodestaque = "Promo leva 2a por 50%";   
                                $bg = "#FCD6FE";                             
                             }
                             
                             if ($codpromo == 3){
                                $textodestaque = "Promo 65+ Dia do Cliente";   
                                $bg = "#FCD6FE";                             
                             }
                             
                             if (strpos($dsobs,"recriada a partir") > 0){
                                $textodestaque = "Aguardando novo Pgto.";   
                                $bg = "#b8bbe1";                             
                             }
                             
                             if ($tipocad == 2){
                                $textodestaque = "Vendedor";   
                                $bg = "#e1a463";   
                             }
                             
                             if ($tipocad == 3){
                                $textodestaque = "Parceiro";   
                                $bg = "#ffa3b4";   
                             }
                             
                             $sqlb = "SELECT NR_SEQ_CUPOM_CURC from cupons where NR_SEQ_COMPRA_USO_CURC = $id_compra";
                    		 $stb = mysql_query($sqlb);
                    		 if (mysql_num_rows($stb) > 0) {
               		            $textodestaque = "Cupom de Desconto";   
                                $bg = "#C8CEFF";    
                             }
                             
                             //if (strpos($textopro,"cheio) e a 2a. camiseta") > 0){
//                                $textodestaque = "Promo leva 2a por 50%";   
//                                $bg = "#FFD31F";                             
//                             }
                             
                             $msgini = "";

							?>                            
							<table border="0" width="100%" cellpadding="0" cellspacing="0" height="30" bgcolor="<?php echo $bg; ?>">
                                <tr>
                                    <td align="center" width="60"><strong><?php echo $id_compra; ?></strong></td>
                                    <td align="center" width="145" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                                    <td align="left"><strong><?php echo ChecaClubStyle($idcli,$nome); ?></strong><?php if ($textodestaque) echo " ($textodestaque)"; ?></td>
                                    <td align="left" width="310" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" class="linksmenu"><?php echo $email; ?></a></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $dddfone . " " . $fone; ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $formapgto; ?></td>
                                    <td align="center" width="120" nowrap="nowrap"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $parcelas; ?></strong></td>
                                    <td align="center" width="30"><strong>A</strong></td>
                                    <td align="center" width="30">&nbsp;</td>
                                    <td align="center" width="30"><a href="compras_ver.php?idcli=<?php echo $idcli;?>&idc=<?php echo $id_compra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $id_compra ?>" class="thickbox"><img src="img/compras_ver.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
                                    <td align="center" width="27"><a href="#" title="Recriar Compra" onclick="recriar(<?php echo $id_compra;?>);"><img src="img/money2.gif" border="0" /></a></td>
                                    <td align="center" width="30"><a href="clientes_alt.php?idc=<?php echo $idcli;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                    <?php if (strlen($celular)>=8) { ?>
                                    <td align="center" width="30"><a href="envia_sms.php?msg=<?php echo $msgini;?>&idcli=<?php echo $idcli;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
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
							}
							}else{
						?>
                        <table width="100%" align="center" height="60"><tr><td align="center"><strong>Nenhuma Compra em Aberto!</strong></td></tr></table>
                        <?php }?>
                      </ul>
                </td>
            </tr>
        </table>
        <?php } ?>
        <table class="textostabelas" width="100%" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
        	<tr>
            	<?php if ($SS_nivel >= 50) { 
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
                <td align="left" colspan="2">
                	<ul id="titulos_abas">
                      <a name="niver"></a><li id="menuDepo" class="abaativa">Aniversariantes (<?php echo $totniver ?>)</li>
                      <li><input type="Button" value="Enviar p/ Todos" onClick="document.location.href=('envia_mail_nivers_dia.php');" class="form00" style="width:100px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Enviar p/ Todos (Per&iacute;odo)" onClick="document.location.href=('envia_mail_nivers_per.php');" class="form00" style="width:150px;height:23px;margin: 0;" /></li>
                      <li><input type="Button" value="Enviar p/ Todos (SMS)" onClick="document.location.href=('envia_sms_nivers_dia.php');" class="form00" style="width:120px;height:23px;margin: 0;" /></li>
                    </ul>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <?php if ($SS_nivel >= 50) { ?>
            	<td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                	<ul class="noticias">
						<?php
						  $sql = "SELECT 
                                        DS_NOME_CASO,
                                        DS_EMAIL_CASO,
                                        DT_NASCIMENTO_CASO,
                                        DS_CIDADE_CASO,
                                        DS_UF_CASO,
                                        DS_DDDFONE_CASO,
                                        DS_FONE_CASO,
                                        NR_SEQ_CADASTRO_CASO,
                                        DS_CELULAR_CASO,
                                        DS_TWITTER_CACH,
                                        DS_FACEBOOK_CACH,
                                        (SELECT 
                                                DATE_FORMAT(MAX(dt_compra_coso), '%Y-%m-%d')
                                            FROM
                                                compras c
                                            WHERE
                                                c.NR_SEQ_CADASTRO_COSO = cadastros.NR_SEQ_CADASTRO_CASO
                                                    AND c.ST_COMPRA_COSO <> 'C') as ultima_compra
                                    FROM
                                        cadastros
                                        left join compras on nr_seq_cadastro_coso = nr_seq_cadastro_caso
                                    WHERE
                                        NR_SEQ_LOJA_CASO = 1
                                            AND TP_CADASTRO_CACH <> 1
                                            AND DAY(SYSDATE()) = DAY(DT_NASCIMENTO_CASO)
                                            AND MONTH(SYSDATE()) = MONTH(DT_NASCIMENTO_CASO)
                                    group by nr_seq_cadastro_caso
                                    having date_format(ultima_compra, '%Y-%m') < date_format(now(), '%Y-%m')
                                    ORDER BY DS_NOME_CASO
                                    LIMIT 0 , 60";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $nome		   = utf8_encode($row[0]);
					         $email		   = $row[1];
							 $dt_nasc	   = $row[2];
							 $cidade	   = $row[3];
							 $estado	   = $row[4];
                             $dddfone	   = $row[5];
                             $fone         = $row[6];
                             $nrcad        = $row[7];
                             $celular      = $row[8];
                             $twitter      = $row[9];
                             $facebook     = $row[10];
                             
                             $mesatual = date("m");
                             $anoatual = date("Y");
                             
                             $sqlniv = "SELECT DT_COMPRA_COSO from compras WHERE ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_COSO = $nrcad
                                        and MONTH(DT_COMPRA_COSO) = $mesatual and YEAR(DT_COMPRA_COSO) = $anoatual";
                             
                             $stniv = mysql_query($sqlniv);
						     if (mysql_num_rows($stniv) > 0) {
                                $rowniv = mysql_fetch_row($stniv);
                                $datacomp = date('d/m/Y G:i', strtotime($rowniv[0]));
                                $textodestaque = "($datacomp)";   
                                $bgniver = " bgcolor=\"#B3FE97\"";    
                             }else{
                                $bgniver = "";
                                $textodestaque = "";
                             }
                                                         
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
                             
                             $sqlniv = "select count(*) from compras WHERE NR_SEQ_CADASTRO_COSO = $nrcad AND (ST_COMPRA_COSO = 'P' or ST_COMPRA_COSO = 'V' or ST_COMPRA_COSO = 'E')";
        					 $stniv = mysql_query($sqlniv);
                             $totniver = 0;
        					 if (mysql_num_rows($stniv) > 0) {
        					 	 $rowniv = mysql_fetch_row($stniv);
                                 $totcomp = $rowniv[0];
                             }else{
                                 $totcomp = 0;
                             }
                               
                                $msgniver = "Ganhe 20% de desconto em suas compras durante o mes do seu aniversario na Reverbcity http://rvb.la/Bday";
                             //$msgniver = "Presente Reverb! No mes do seu aniversario vc compra 1 camiseta fora de promo e ganha outra de igual ou menor valor. http://rvb.la/FelizBday";
                             //$msgniver = "Happy bday! Aproveite o seu dia com uma promo exclusiva: LEVE 3 PAGUE 2! www.reverbcity.com";
                             //$msgniver = "Parabens, aproveite que hj e seu dia e bora se jogar nas compras! Estamos com ate 50% OFF em quase todos os produtos www.reverbcity.com";
							?>
							<li style="width:98%;">
                            <table width="100%" align="center">
                               <tr<?php echo $bgniver;?>>
                                 <td align="center" width="70" style="font-size: 11px;"><?php echo date("d/m/Y", strtotime($dt_nasc));?></td>
                                 <td align="left"><strong><a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo $nome;?></a><?php if ($totcomp > 0) echo "<br />(compras: ".$totcomp." <a href=\"clientes_ped.php?idc=".$nrcad."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"Ver Detalhamento\" /></a>)" ?></strong> <?php echo $textodestaque; ?></td>
                                 <td align="left" width="130"><?php echo $cidade; ?>/<?php echo $estado; ?></td>
                                 <td align="left" width="80">(<?php echo $dddfone; ?>) <?php echo $fone; ?></a></td>
                                 <td align="center" width="22"><a href="niver.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar E-mail" border="0" /></a></td>
                                 <td align="center" width="22"><a href="clientes_alt.php?idc=<?php echo $nrcad;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                 <?php if (strlen($celular)>=8) { ?>
                                 <td align="center" width="22"><a href="envia_sms.php?msg=<?php echo $msgniver;?>&idcli=<?php echo $nrcad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                 <?php }else{ ?>
                                 <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                                 <?php if ($twitter) { ?>
                                 <td align="center" width="22"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                 <?php }else{ ?>
                                 <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                                 <?php if ($facebook) { ?>
                                    <td align="center" width="22"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                 <?php }else{ ?>
                                    <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                              </tr>
                            </table>
                            </li>
							<?php
							}
						  }else{
						 
						?>
                        <table width="100%" align="center"><tr><td align="center"><strong>Nenhum aniversariante hoje!</strong></td></tr></table>
                        <?php }?>
                   </ul>
                   <?php }?>
                   <?php if ($SS_nivel >= 50) { ?>
            	<td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                	<ul class="noticias">
						<?php
						  $sql = "select DS_NOME_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO, DS_CIDADE_CASO, DS_UF_CASO,
                                 DS_DDDFONE_CASO, DS_FONE_CASO, NR_SEQ_CADASTRO_CASO, DS_CELULAR_CASO, DS_TWITTER_CACH, DS_FACEBOOK_CACH
                                 from cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND TP_CADASTRO_CACH <> 1 and 
                                 day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO)
                                 order by DS_NOME_CASO limit 31, 140";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $nome		   = utf8_encode($row[0]);
					         $email		   = $row[1];
							 $dt_nasc	   = $row[2];
							 $cidade	   = $row[3];
							 $estado	   = $row[4];
                             $dddfone	   = $row[5];
                             $fone         = $row[6];
                             $nrcad        = $row[7];
                             $celular      = $row[8];
                             $twitter      = $row[9];
                             $facebook     = $row[10];
                             
                             $mesatual = date("m");
                             $anoatual = date("Y");
                             
                             $sqlniv = "SELECT DT_COMPRA_COSO from compras WHERE ST_COMPRA_COSO <> 'C' AND NR_SEQ_CADASTRO_COSO = $nrcad
                                        and MONTH(DT_COMPRA_COSO) = $mesatual and YEAR(DT_COMPRA_COSO) = $anoatual";
                            
                             $stniv = mysql_query($sqlniv);
						     if (mysql_num_rows($stniv) > 0) {
                                $rowniv = mysql_fetch_row($stniv);
                                $datacomp = date('d/m/Y G:i', strtotime($rowniv[0]));
                                $textodestaque = "($datacomp)";   
                                $bgniver = " bgcolor=\"#B3FE97\"";    
                             }else{
                                $bgniver = "";
                                $textodestaque = "";
                             }
                             
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
                             
                             $sqlniv = "select count(*) from compras WHERE NR_SEQ_CADASTRO_COSO = $nrcad AND (ST_COMPRA_COSO = 'P' or ST_COMPRA_COSO = 'V' or ST_COMPRA_COSO = 'E')";
        					 $stniv = mysql_query($sqlniv);
                             $totniver = 0;
        					 if (mysql_num_rows($stniv) > 0) {
        					 	 $rowniv = mysql_fetch_row($stniv);
                                 $totcomp = $rowniv[0];
                             }else{
                                 $totcomp = 0;
                             }
                                $msgniver = "Ganhe 20% de desconto em suas compras durante o mes do seu aniversario na Reverbcity http://rvb.la/Bday";
//                             $msgniver = "Presente Reverb! No mes do seu aniversario vc compra 1 camiseta fora de promo e ganha outra de igual ou menor valor. http://rvb.la/FelizBday";
                             //$msgniver = "Happy bday! Aproveite o seu dia com uma promo exclusiva: LEVE 3 PAGUE 2! www.reverbcity.com";
                             //$msgniver = "Parabens, aproveite que hj e seu dia e bora se jogar nas compras! Estamos com ate 50% OFF em quase todos os produtos www.reverbcity.com";
							?>
							<li style="width:98%;">
                            <table width="100%" align="center">
                              <tr<?php echo $bgniver;?>>
                                 <td align="center" width="70" style="font-size: 11px;"><?php echo date("d/m/Y", strtotime($dt_nasc));?></td>
                                 <td align="left"><strong><a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo $nome;?></a><?php if ($totcomp > 0) echo "<br />(compras: ".$totcomp." <a href=\"clientes_ped.php?idc=".$nrcad."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"Ver Detalhamento\" /></a>)" ?></strong> <?php echo $textodestaque; ?></td>
                                 <td align="left" width="130"><?php echo $cidade; ?>/<?php echo $estado; ?></td>
                                 <td align="left" width="80">(<?php echo $dddfone; ?>) <?php echo $fone; ?></a></td>
                                 <td align="center" width="22"><a href="niver.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar E-mail" border="0" /></a></td>
                                 <td align="center" width="22"><a href="clientes_alt.php?idc=<?php echo $nrcad;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                 <?php if (strlen($celular)>=8) { ?>
                                 <td align="center" width="22"><a href="envia_sms.php?msg=<?php echo $msgniver;?>&idcli=<?php echo $nrcad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                 <?php }else{ ?>
                                 <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                                 <?php if ($twitter) { ?>
                                 <td align="center" width="22"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                 <?php }else{ ?>
                                 <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                                 <?php if ($facebook) { ?>
                                    <td align="center" width="22"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                 <?php }else{ ?>
                                    <td align="center" width="22">&nbsp;</td>
                                 <?php } ?>
                              </tr>
                            </table>
                            </li>
							<?php
							}
						  }else{
						 
						?>
                        <table width="100%" align="center"><tr><td align="center"><strong>Nenhum aniversariante hoje!</strong></td></tr></table>
                        <?php }?>
                   </ul>
                   </td>
                   <?php }?>
                   </tr>
              <?php if ($SS_nivel >= 20) { ?>      
                   <tr>
            
                <td align="left" colspan="2">
                	<table width="100%">
                    	<tr>
                        	<td>
                            	<ul id="titulos_abas">
                                  <li id="menuDepo" class="abaativa" style="width: 400px;">Produtos com Estoque Baixo (5 unidades)&nbsp; &nbsp;&nbsp;&nbsp;<a href="#" onclick="window.open('estoque_baixo.php','estbaix','width=500,height=400,menubar=no,scrollbars=no,toolbar=no');"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" align="absmiddle" /></a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                   
                   
                   <tr>
                   
                   <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                <a name="estoquebaixo"></a>
                	<table width="100%" cellspacing="4">
                    	<tr>
                        	<td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC,
												DS_EXT_PRRC, ST_MARCA_PRRC, NR_SEQ_TIPO_PRRC from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												and DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja and ST_PRODUTOS_PRRC = 'A' AND
                                                (ST_MARCA_PRRC <> 'B' or ST_MARCA_PRRC is null)
												group by NR_SEQ_PRODUTO_PRRC HAVING total between 1 and 5
												order by NR_SEQ_TIPO_PRRC, total desc, DS_PRODUTO2_PRRC limit 0,60 ";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $idprod	   = $row[0];
                                         $nome		   = utf8_encode($row[1]);
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                         $extprod      = $row[4];
                                         $stmarca      = $row[5];
                                         $nrtipo	   = $row[6];
                                        ?>
                                        <li style="width:98%;">
                                        <table width="100%" align="center"><td align="center" width="39">
                                        <?php if ($extprod == "swf") {?>
                                          <object data="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $idprod; ?>" />
                                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                    	<a href="estoque.php?idp=<?php echo $idprod; ?>"><img src="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" width="31" height="36" border="0" /></a>
                                    	<?php } ?>
                                         </td><td align="left" width="<?php if ($nrtipo == 4) {echo "55";}else{echo "105";}?>"><?php echo $tipo; ?></td><td align="left"><strong><?php echo $nome;?></strong></td>
                                         </td>
                                         <?php if ($nrtipo == 4) {?>
                                         <?php if ($stmarca == "S") {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/ico_check.gif" border="0" /></a></td>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else if ($stmarca == "K") {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/printer_lock.png" border="0" /></a></td>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else if ($stmarca == "B") {?>
                                            <?php if ($SS_nivel >= 100) {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Producao Bloqueada"><img src="img/icon_secure.gif" border="0" /></a></td>
                                            <?php }else{ ?>
                                            <td align="center" width="20"><img src="img/icon_secure.gif" border="0" /></td>
                                            <td align="center" width="20">&nbsp;</td>
                                            <?php } ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else{ ?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=S&pos=estoquebaixo" title="Marca Produto para Producao"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=B&pos=estoquebaixo" title="Bloqueia Produto para Producao"><img src="img/cancel.png" border="0" /></a></td>
                                         <?php } ?>
                                         <?php }else{ ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php } ?>
                                         <td align="center" width="18"><a href="clientes_produto.php?idp=<?php echo $idprod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                         <td align="center" width="15"><strong><?php echo $qtde; ?></strong></td>
                                         </table>
                                        </li>
                                        <?php
                                        }
                                      }else{
                                     
                                    ?>
                                    <table width="100%" align="center">
                                        <tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                            <td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC,
												DS_EXT_PRRC, ST_MARCA_PRRC, NR_SEQ_TIPO_PRRC from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												and DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja and ST_PRODUTOS_PRRC = 'A'
                                                AND (ST_MARCA_PRRC <> 'B' or ST_MARCA_PRRC is null)
												group by NR_SEQ_PRODUTO_PRRC HAVING total between 1 and 5
												order by NR_SEQ_TIPO_PRRC, total desc, DS_PRODUTO2_PRRC limit 61,60 ";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $idprod	   = $row[0];
                                         $nome		   = utf8_encode($row[1]);
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                         $extprod      = $row[4];
                                         $stmarca      = $row[5];
                                         $nrtipo	   = $row[6];
                                        ?>
                                        <li style="width:98%;">
                                        <table width="100%" align="center"><td align="center" width="39">
                                        <?php if ($extprod == "swf") {?>
                                          <object data="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $idprod; ?>" />
                                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                    	<a href="estoque.php?idp=<?php echo $idprod; ?>"><img src="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" width="31" height="36" border="0" /></a>
                                    	<?php } ?>
                                         </td><td align="left" width="<?php if ($nrtipo == 4) {echo "55";}else{echo "105";}?>"><?php echo $tipo; ?></td><td align="left"><strong><?php echo $nome;?></strong></td>
                                         </td>
                                         <?php if ($nrtipo == 4) {?>
                                             <?php if ($stmarca == "S") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/ico_check.gif" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "K") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/printer_lock.png" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "B") {?>
                                                 <?php if ($SS_nivel >= 100) {?>
                                                    <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Producao Bloqueada"><img src="img/icon_secure.gif" border="0" /></a></td>
                                                 <?php }else{ ?>
                                                     <td align="center" width="20"><img src="img/icon_secure.gif" border="0" /></td>
                                                     <td align="center" width="20">&nbsp;</td>
                                                 <?php } ?>
                                                 <td align="center" width="20">&nbsp;</td>
                                             <?php }else{ ?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=S&pos=estoquebaixo" title="Marca Produto para Producao"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=B&pos=estoquebaixo" title="Bloqueia Produto para Producao"><img src="img/cancel.png" border="0" /></a></td>
                                             <?php } ?>
                                         <?php }else{ ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php } ?>
                                         <td align="center" width="18"><a href="clientes_produto.php?idp=<?php echo $idprod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                         <td align="center" width="15"><strong><?php echo $qtde; ?></strong></td>
                                         </table>
                                        </li>
                                        <?php
                                        }
                                      }else{
                                     
                                    ?>
                                    <table width="100%" align="center">
                                        <tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                        </tr>
                    </table>
                </td>
                   
                    
                    <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                <a name="estoquebaixo"></a>
                	<table width="100%" cellspacing="4">
                    	<tr>
                        	<td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC,
												DS_EXT_PRRC, ST_MARCA_PRRC, NR_SEQ_TIPO_PRRC from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												and DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja and ST_PRODUTOS_PRRC = 'A'
                                                AND (ST_MARCA_PRRC <> 'B' or ST_MARCA_PRRC is null)
												group by NR_SEQ_PRODUTO_PRRC HAVING total between 1 and 5
												order by NR_SEQ_TIPO_PRRC, total desc, DS_PRODUTO2_PRRC limit 122,60 ";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $idprod	   = $row[0];
                                         $nome		   = utf8_encode($row[1]);
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                         $extprod      = $row[4];
                                         $stmarca      = $row[5];
                                         $nrtipo	   = $row[6];
                                        ?>
                                        <li style="width:98%;">
                                        <table width="100%" align="center"><td align="center" width="39">
                                        <?php if ($extprod == "swf") {?>
                                          <object data="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $idprod; ?>" />
                                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                    	<a href="estoque.php?idp=<?php echo $idprod; ?>"><img src="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" width="31" height="36" border="0" /></a>
                                    	<?php } ?>
                                         </td><td align="left" width="<?php if ($nrtipo == 4) {echo "55";}else{echo "105";}?>"><?php echo $tipo; ?></td><td align="left"><strong><?php echo $nome;?></strong></td>
                                         </td>
                                         <?php if ($nrtipo == 4) {?>
                                         <?php if ($stmarca == "S") {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/ico_check.gif" border="0" /></a></td>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else if ($stmarca == "K") {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/printer_lock.png" border="0" /></a></td>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else if ($stmarca == "B") {?>
                                            <?php if ($SS_nivel >= 100) {?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Producao Bloqueada"><img src="img/icon_secure.gif" border="0" /></a></td>
                                            <?php }else{ ?>
                                            <td align="center" width="20"><img src="img/icon_secure.gif" border="0" /></td>
                                            <td align="center" width="20">&nbsp;</td>
                                            <?php } ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php }else{ ?>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=S&pos=estoquebaixo" title="Marca Produto para Producao"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                            <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=B&pos=estoquebaixo" title="Bloqueia Produto para Producao"><img src="img/cancel.png" border="0" /></a></td>
                                         <?php } ?>
                                         <?php }else{ ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php } ?>
                                         <td align="center" width="18"><a href="clientes_produto.php?idp=<?php echo $idprod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                         <td align="center" width="15"><strong><?php echo $qtde; ?></strong></td>
                                         </table>
                                        </li>
                                        <?php
                                        }
                                      }else{
                                     
                                    ?>
                                    <table width="100%" align="center">
                                        <tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                            <td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC,
												DS_EXT_PRRC, ST_MARCA_PRRC, NR_SEQ_TIPO_PRRC from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												and DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja and ST_PRODUTOS_PRRC = 'A'
                                                AND (ST_MARCA_PRRC <> 'B' or ST_MARCA_PRRC is null)
												group by NR_SEQ_PRODUTO_PRRC HAVING total between 1 and 5
												order by NR_SEQ_TIPO_PRRC, total desc, DS_PRODUTO2_PRRC limit 183,60 ";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $idprod	   = $row[0];
                                         $nome		   = utf8_encode($row[1]);
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                         $extprod      = $row[4];
                                         $stmarca      = $row[5];
                                         $nrtipo	   = $row[6];
                                        ?>
                                        <li style="width:98%;">
                                        <table width="100%" align="center"><td align="center" width="39">
                                        <?php if ($extprod == "swf") {?>
                                          <object data="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $idprod; ?>" />
                                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                    	<a href="estoque.php?idp=<?php echo $idprod; ?>"><img src="../arquivos/uploads/produtos/<?php echo $idprod; ?>.<?php echo $extprod; ?>" width="31" height="36" border="0" /></a>
                                    	<?php } ?>
                                         </td><td align="left" width="<?php if ($nrtipo == 4) {echo "55";}else{echo "105";}?>"><?php echo $tipo; ?></td><td align="left"><strong><?php echo $nome;?></strong></td>
                                         </td>
                                         <?php if ($nrtipo == 4) {?>
                                             <?php if ($stmarca == "S") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/ico_check.gif" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "K") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Desmarca Produto"><img src="img/printer_lock.png" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "B") {?>
                                                 <?php if ($SS_nivel >= 100) {?>
                                                    <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=N&pos=estoquebaixo" title="Producao Bloqueada"><img src="img/icon_secure.gif" border="0" /></a></td>
                                                 <?php }else{ ?>
                                                     <td align="center" width="20"><img src="img/icon_secure.gif" border="0" /></td>
                                                     <td align="center" width="20">&nbsp;</td>
                                                 <?php } ?>
                                                 <td align="center" width="20">&nbsp;</td>
                                             <?php }else{ ?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=S&pos=estoquebaixo" title="Marca Produto para Producao"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idprod;?>&m=B&pos=estoquebaixo" title="Bloqueia Produto para Producao"><img src="img/cancel.png" border="0" /></a></td>
                                             <?php } ?>
                                         <?php }else{ ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php } ?>
                                         <td align="center" width="18"><a href="clientes_produto.php?idp=<?php echo $idprod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                         <td align="center" width="15"><strong><?php echo $qtde; ?></strong></td>
                                         </table>
                                        </li>
                                        <?php
                                        }
                                      }else{
                                     
                                    ?>
                                    <table width="100%" align="center">
                                        <tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php
            $sqlc = "select count(*) from cadastros where 
                     DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
                     MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
                     YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) and TP_CADASTRO_CACH <> 1 ";
            $stc = mysql_query($sqlc);
            $totnew = 0;
            if (mysql_num_rows($stc) > 0) {
                $rowc = mysql_fetch_row($stc);
                $totnew = $rowc[0];
            }
            ?>
            <tr>
                <td align="left">
                	<ul id="titulos_abas">
                      <a name="cadontem"></a><li id="menuDepo" class="abaativa">Cadastros de Ontem (<?php echo $totnew;?>)</li>
                      <li><input type="Button" value="Enviar p/ Todos (SMS)" onClick="document.location.href=('envia_sms_primeira.php');" class="form00" style="width:120px;height:23px;margin: 0;" /></li>
                    </ul>
                </td>
                <td align="left">
                	<table width="100%">
                    	<tr>
                            <td>
                            	<ul id="titulos_abas">
                                  <li id="menuDepo" class="abaativa" style="width: 300px;">Produtos Sem Estoque&nbsp; &nbsp;&nbsp;&nbsp;<a href="#" onclick="window.open('estoque_zero.php','estbaix','width=500,height=400,menubar=no,scrollbars=no,toolbar=no');"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" align="absmiddle" /></a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                    <table width="100%" cellspacing="4">
                    	<tr>
                        	<td valign="top">
                            <ul class="noticias">
                				<?php
                                  $sql = "select DS_NOME_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO, DS_CIDADE_CASO, DS_UF_CASO,
                                            DS_DDDFONE_CASO, DS_FONE_CASO, NR_SEQ_CADASTRO_CASO, DS_CELULAR_CASO, DS_TWITTER_CACH, DS_FACEBOOK_CACH
                                            from cadastros where 
                                         DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
                                         MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
                                         YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) and TP_CADASTRO_CACH <> 1 ";
                                  $st = mysql_query($sql);
                                  if (mysql_num_rows($st) > 0) {
                                    $totcompgeral = 0;
                                    $totcompras = 0;
                                    while($row = mysql_fetch_row($st)) {
                                     $nome		   = utf8_encode($row[0]);
        					         $email		   = $row[1];
        							 $dt_nasc	   = $row[2];
        							 $cidade	   = $row[3];
        							 $estado	   = $row[4];
                                     $dddfone	   = $row[5];
                                     $fone         = $row[6];
                                     $nrcad        = $row[7];
                                     $celular      = $row[8];
                                     $twitter      = $row[9];
                                     
                                     $facebook     = $row[10];
                             
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
                                     
                                     $sqlniv = "select VL_TOTAL_COSO from compras WHERE NR_SEQ_CADASTRO_COSO = $nrcad AND ST_COMPRA_COSO <> 'C' order by DT_COMPRA_COSO limit 1";
                					 $stniv = mysql_query($sqlniv);
                                     $totniver = 0;
                					 if (mysql_num_rows($stniv) > 0) {
                					 	 $rowniv = mysql_fetch_row($stniv);
                                         $totcomp = $rowniv[0];
                                         $totcompras++;
                                     }else{
                                         $totcomp = 0;
                                     }
                                     
                                     $totcompgeral += $totcomp;
                                        $msgcel = "Como presente de boas vindas na Reverbcity você ganha 15% de desconto! Saiba mais aqui www.reverbcity.com/ajuda";
//                                     $msgcel = "Pedidos a partir de R$59 em itens fora de promo&ccedil;&atilde;o ganham 15% de desconto para serem usados em uma pr&oacute;xima compra! http://rvb.la/Compra";
                                     //$msgcel = "Ola! Como presente de boas-vindas, na sua 1a compra em 30d a partir de 150, em produtos fora de promo, voce ganha outra tee reverbcity.com";
                                     //$msgcel = "Welcome to Reverbcity! Vamos te presentear na sua primeira compra de camisetas a partir de $150 voce ganha outra! www.reverbcity.com";
                             
                                    ?>
                                    <li style="width:98%;">
                                    <table width="100%" align="center">
                                         <td align="center" width="5">&nbsp;</td>
                                         <td align="left"><strong><a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo $nome;?></a><?php if ($totcomp > 0) echo "<br />(compras: <a href=\"clientes_ped.php?idc=".$nrcad."&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"Compras do Cliente\" class=\"thickbox\"><img src=\"img/compras_ver.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" alt=\"Ver Detalhamento\" /></a>)" ?></strong></td>
                                         <td align="left" width="65">
                                            <?php if ($totcomp > 0) { ?>
                                            R$ <?php echo number_format($totcomp,2,",",""); ?>
                                            <?php }else{ ?>
                                            &nbsp;
                                            <?php } ?>
                                         </td>
                                         <td align="left" width="130"><?php echo $cidade; ?>/<?php echo $estado; ?></td>
                                         <td align="left" width="100">(<?php echo $dddfone; ?>) <?php echo $fone; ?></a></td>
                                         <td align="center" width="22"><a href="envia_email.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar E-mail" border="0" /></a></td>
                                         <td align="center" width="22"><a href="clientes_alt.php?idc=<?php echo $nrcad;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                         <?php if (strlen($celular)>=8) { ?>
                                         <td align="center" width="22"><a href="envia_sms.php?msg=<?php echo $msgcel;?>&idcli=<?php echo $nrcad;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                         <?php }else{ ?>
                                         <td align="center" width="22">&nbsp;</td>
                                         <?php } ?>
                                         <?php if ($twitter) { ?>
                                         <td align="center" width="22"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                         <?php }else{ ?>
                                         <td align="center" width="22">&nbsp;</td>
                                         <?php } ?>
                                         <?php if ($facebook) { ?>
                                            <td align="center" width="22"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                         <?php }else{ ?>
                                            <td align="center" width="22">&nbsp;</td>
                                         <?php } ?>
                                    </table>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                    <li style="width:98%;">
                                    <table width="100%" align="center">
                                         <td align="center" width="5">&nbsp;</td>
                                         <td align="right"><strong><?php echo $totcompras ?></strong> Compras - <strong>Total:</strong></td>
                                         <td align="left" width="85" nowrap="nowrap">
                                            <?php if ($totcompgeral > 0) { ?>
                                            <strong>R$ <?php echo number_format($totcompgeral,2,",","."); ?></strong>
                                            <?php }else{ ?>
                                            &nbsp;
                                            <?php } ?>
                                         </td>
                                         <td align="left" width="110">&nbsp;</td>
                                         <td align="left" width="100">&nbsp;</td>
                                         <td align="center" width="22">&nbsp;</td>
                                         <td align="center" width="22">&nbsp;</td>
                                         <td align="center" width="22">&nbsp;</td>
                                         <td align="center" width="22">&nbsp;</td>
                                    </table>
                                    </li>
                                    <?php
                                  }else{
                                ?>
                                <table width="100%" align="center"><tr><td align="center"><strong>Nenhum Cadastro!</strong></td></tr></table>
                                <?php }?>
                           </ul>
                           <br />
                           
                           <a name="me_fotos"></a>
					<ul class="noticias">
                    <li style="width:98%;"><br /><strong>People em Aberto (&Uacute;ltimos 10)</strong></li>
                   <?php
						  $sql = "select NR_SEQ_FOTO_FORC, DT_CADASTRO_FORC, DS_NOME_FORC, ST_PEOPLE_FORC, DS_NOME_CASO, DS_EXT_FORC from me_fotos, cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO and DS_PEOPLE_FORC = 'S' and ST_PEOPLE_FORC = 'I' order by DT_CADASTRO_FORC desc LIMIT 10";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_foto	   = $row[0];
					         $dt_cad	   = $row[1];
							 $ds_foto	   = $row[2];
							 $status	   = $row[3];
							 $ds_autor	   = $row[4];
							 $ds_ext	   = $row[5];
							?>
                            <li style="width:98%;">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><a href="../images/me/fotos/<?php echo $id_foto; ?>.<?php echo $ds_ext; ?>" class="lightview"><img src="../images/me/fotos/<?php echo $id_foto; ?>p.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></a></td>
                                    <td align="center" width="120"><strong><?php echo date("d/m/Y G:i", strtotime($dt_cad)); ?></strong></td>
                                    <td align="left" width="170"><?php echo $ds_autor; ?></td>
                                    <td align="left"><?php echo $ds_foto; ?></td>
                                    <td align="center" width="25"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="25"><a href="people_can.php?idp=<?php echo $id_foto; ?>"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                           
                        </td>
                    </tr>
                </table>
            </td>
            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                <a name="semestoque"></a>
                <table width="100%" cellspacing="4">
                    	<tr>
                        	<td valign="top">
                            <ul class="noticias">
                				<?php
                                  $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC,
                							DS_EXT_PRRC, ST_MARCA_PRRC, NR_SEQ_TIPO_PRRC from produtos, produtos_tipo, estoque
                							WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
                							and DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja
                							group by NR_SEQ_PRODUTO_PRRC HAVING total < 1
                							order by NR_SEQ_TIPO_PRRC desc, NR_SEQ_PRODUTO_PRRC";
                                  $st = mysql_query($sql);
                                  if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)) {
                                     $idpr         = $row[0];
                                     $nome		   = utf8_encode($row[1]);
                                     $qtde		   = $row[2];
                                     $tipo		   = $row[3];
                                     $extprod      = $row[4];
                                     $stmarca      = $row[5];
                                     $nrtipo	   = $row[6];
                                    ?>
                                    <li style="width:98%;">
                                    <table width="100%" align="center"><td align="center" width="39">
                                        <?php if ($extprod == "swf") {?>
                                          <object data="../arquivos/uploads/produtos/<?php echo $idpr; ?>.<?php echo $extprod; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $idpr; ?>" />
                                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idpr; ?>.<?php echo $extprod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                    	<img src="../arquivos/uploads/produtos/<?php echo $idpr; ?>.<?php echo $extprod; ?>" width="31" height="36" border="0" />
                                    	<?php } ?>
                                         </td><td align="left" width="180"><?php echo $tipo; ?></td><td align="left"><strong><?php echo $nome;?></strong>
                                         </td>
                                         <?php if ($nrtipo == 4) {?>
                                             <?php if ($stmarca == "S") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idpr;?>&m=N&pos=semestoque" title="Desmarca Produto"><img src="img/ico_check.gif" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "K") {?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idpr;?>&m=N&pos=semestoque" title="Desmarca Produto"><img src="img/printer_lock.png" border="0" /></a></td>
                                                <td align="center" width="20">&nbsp;</td>
                                             <?php }else if ($stmarca == "B") {?>
                                                 <?php if ($SS_nivel >= 100) {?>
                                                    <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idpr;?>&m=N&pos=semestoque" title="Producao Bloqueada"><img src="img/icon_secure.gif" border="0" /></a></td>
                                                 <?php }else{ ?>
                                                     <td align="center" width="20"><img src="img/icon_secure.gif" border="0" /></td>
                                                     <td align="center" width="20">&nbsp;</td>
                                                 <?php } ?>
                                                 <td align="center" width="20">&nbsp;</td>
                                             <?php }else{ ?>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idpr;?>&m=S&pos=semestoque" title="Marca Produto para Producao"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                                <td align="center" width="20"><a href="grupos_marca.php?idp=<?php echo $idpr;?>&m=B&pos=semestoque" title="Bloqueia Produto para Producao"><img src="img/cancel.png" border="0" /></a></td>
                                             <?php } ?>
                                         <?php }else{ ?>
                                            <td align="center" width="20">&nbsp;</td>
                                         <?php } ?>
                                         <td align="center" width="25"><a href="clientes_produto.php?idp=<?php echo $idpr;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                         <?php if ($SS_nivel >= 20) { ?>
                                         <td align="center" width="35"><a href="#" onclick="confirma_cla(<?php echo $idpr; ?>);" title="Mover para Classics"><img src="img/ico_classicsp.gif" border="0" /></a>
                                         </td>
                                         <?php } ?>
                                         <td align="center" width="15"><strong><?php echo $qtde; ?></strong></td>
                                    </table>
                                    </li>
                                    <?php
                                    }
                                  }else{
                                 
                                ?>
                                <table width="100%" align="center"><tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                <?php }?>
                           </ul>
                        </td>
                    </tr>
                    
                </table>
            </td>
            </tr>
            <?php } ?>    
        </table>
       
<?php include 'rodape.php'; ?>