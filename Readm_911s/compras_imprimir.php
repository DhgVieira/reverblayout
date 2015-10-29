<?php
include 'auth.php';
include 'lib.php';
$idc = request("idc");

//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Visualizou detalhes da compra $idc");

$sql = "SELECT DT_COMPRA_COSO, DT_STATUS_COSO, DS_IP_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO, DS_FORMAPGTO_COSO, DS_OBS_COSO, DS_LOGIN_CASO, DS_NOME_CASO,
		DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO,
		DS_CPFCNPJ_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, DS_DDDCEL_CASO, DS_CELULAR_CASO, DT_CADASTRO_CASO, VL_FRETE_COSO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO,
		TP_CADASTRO_CACH, DS_OBS_CACH, DS_OPERADORA_CACH, DS_RASTREAMENTO_COSO, VL_FRETECUSTO_COSO,
        DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO, DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO,
        VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO, DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO,
        VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, DS_TID_COSO, DS_TWITTER_CACH, DS_FORMAENVIO_COSO
        FROM compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $idc ";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	
	$dt_compra	   = $row[0];
	$dt_status	   = $row[1];
	$ip_compra	   = $row[2];
	$valor		   = $row[3];
	$st_compra	   = $row[4];
	$forma_pgto	   = $row[5];
	$obs_compra	   = $row[6];
	
	$login		   = $row[7];
	$nome		   = $row[8];
	$endereco	   = $row[9];
	$numero		   = $row[10];
	$complem	   = $row[11];
	$bairro		   = $row[12];
	$cidade		   = $row[13];
	$estado		   = $row[14];
	$cep		   = $row[15];
	$email		   = $row[16];
	$dt_nasc	   = $row[17];
	$documento	   = $row[18];
	$dddfone	   = $row[19];
	$fone		   = $row[20];
	$dddcel		   = $row[21];
	$celular	   = $row[22];
	$dt_cadastro   = $row[23];
	
	$frete		   = $row[24];
	
	$nrseqcad	   = $row[25];
	$parcelas	   = $row[26];
	$tipocli	   = $row[27];
    $obscad 	   = $row[28];
    $operadora	   = $row[29];
    
    $rastreamento  = $row[30];
    $fretereal     = $row[31];
    
    $nrbanco       = $row[32];
    $agencia       = $row[33];
    $contaco       = $row[34];
    $cheque1       = $row[35];
    $cheque2       = $row[36];
    $cheque3       = $row[37];
    $chvalrl       = $row[38];
    $chvalr2       = $row[39];
    $chvalr3       = $row[40];
    $chdatal       = $row[41];
    $chdata2       = $row[42];
    $chdata3       = $row[43];
    $desconto      = $row[44];
    
    $valorpago     = $row[45];
    $valortroco    = $row[46];
    
    $valorpromoc   = $row[47];
    $descpromoc    = $row[48];
    
    $dstid         = $row[49];
    
    $dstwitter     = $row[50];
    $formaenvio = $row[51];
	
    $fretereal = number_format($fretereal,2,",","");
    
	switch ($st_compra) {
		case "A":
			$st_compra = "Em Aberto";
			break;
		case "F":
			$st_compra = "Finalizada";
			break;
		case "C":
			$st_compra = "Cancelada";
			break;
	}
    
     $celular = str_replace("-","",$celular);
     $celular = str_replace(".","",$celular);
     $celular = str_replace("/","",$celular);
     $celular = str_replace("=","",$celular);
     $celular = str_replace(" ","",$celular);
}else{
    exit();
}

$dadosetiq = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalhamento Pedido</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body onload="window.print();window.close();">
<table width="615" border="0" align="center" cellpadding="2" cellspacing="1" class="textosver">
  <tr>
    <td bgcolor="#CACCE8">Detalhamento da Compra <span class="style1">NR <?php echo $idc; ?></span> feita em <strong><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></strong></td>
  </tr>
  <tr>
    <td>
    	<table height="30" cellspacing="0" cellpadding="0" width="615" border="0">
        <tr bgcolor="#EEEEEE">
          <td bgcolor="#CACCE8" class="style1" >IMG</td>
          <td bgcolor="#CACCE8" class="style1" >Poduto</td>
          <td bgcolor="#CACCE8" class="style1" >Ref.</td>
          <td bgcolor="#CACCE8" class="style1" ><div align="center">Size</div></td>
          <td bgcolor="#CACCE8" class="style1" nowrap="nowrap"><div align="center">Valor Unit.</div></td>
          <td bgcolor="#CACCE8" class="style1" nowrap="nowrap"><div align="center">Valor Total</div></td>
          <td bgcolor="#CACCE8" class="style1" ><div align="center">Qtd.</div></td>
        </tr>
        <?php
        $sql = "SELECT DS_PRODUTO2_PRRC, DS_REFERENCIA_PRRC, DS_TAMANHO_TARC, VL_PRODUTO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO,
                DS_EXT_PRRC, VL_PRODUTOCHEIO_CESO FROM cestas, produtos, tamanhos
				 WHERE NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC AND NR_SEQ_COMPRA_CESO = $idc";
		$st = mysql_query($sql);
		
		$vl_geral = 0;
		$ct_total = 0;
			
		if (mysql_num_rows($st) > 0) {
			$x = 0;
			$bg = "#FFFFFF";
			while($row = mysql_fetch_row($st)) {
				$vl_total = 0;
				
				$ds_prod	   = $row[0];
				$ds_refe	   = $row[1];
				$ds_tama	   = $row[2];
				$vl_prod	   = $row[3];
				$qt_prod	   = $row[4];
				$id_prod	   = $row[5];
				$ex_prod	   = $row[6];

				$vl_total += ($vl_prod*$qt_prod);
				$vl_geral += $vl_total;
				$ct_total += $qt_prod;
                
                $vl_cheio      = $row[7];
				
				if ($x == 0) {
					$bg = "#FFFFFF";
					$x = 1;
				}else{
					$bg = "#EEEEEE";
					$x = 0;
				}				

        $select_fotos = "SELECT
                  NR_SEQ_FOTO_FORC,
                  NR_SEQ_PRODUTO_FORC,
                  DS_EXT_FORC
          FROM
             fotos
          WHERE
             NR_SEQ_PRODUTO_FORC = ". $id_prod ."
          ORDER BY
                  NR_ORDEM_FORC ASC
          LIMIT 2";
          $stFoto = mysql_query($select_fotos);
          $fotoRow = mysql_fetch_row($stFoto);
				?>
                <tr bgcolor="<?php echo $bg; ?>">
                  <td height="80" align="center">
                  		<?php if ($ex_prod == "swf") {?>
                          <object data="../arquivos/uploads/produtos/<?php echo $id_prod ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="65" height="75">
                            <param name="quality" value="high" />
                            <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod ?>.<?php echo $ex_prod; ?>" />
                            <param name="wmode" value="opaque" />
                          </object>
                        <?php }else{ ?>
                        <img src="/thumb/fotosprodutos/1/65/76/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" width="65" height="75" />
                        <?php } ?>
                  </td>
                  <td align="left"><?php echo utf8_encode($ds_prod); ?></td>
                  <td align="left"><?php echo $ds_refe; ?></td>
                  <td align="center"><?php echo $ds_tama; ?></td>
                  <td align="center">
                  <?php if ($vl_cheio > 0) echo "De <span style=\"text-decoration:line-through;\">R$ ".number_format($vl_cheio,2,",","")."</span><br />Por "; ?>
                  R$ <?php echo number_format($vl_prod,2,",","."); ?></td>
                  <td align="center" nowrap="nowrap">R$ <?php echo number_format($vl_total,2,",","."); ?></td>
                  <td align="center"><?php echo $qt_prod; ?></td>
                </tr>
			<?php
            }
		 }
         ?>
         <tr bgcolor="#CACCE8">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left"><strong>SubTotal:</strong></td>
          <td align="center" nowrap="nowrap"><strong>R$ <?php echo number_format($vl_geral,2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
        </tr>
         <?php
         if (!$valorpromoc) $valorpromoc = 0;
         if ($valorpromoc > 0) {
         ?>
            <tr bgcolor="#E1E3F4">
              <td align="left" colspan="4"><strong><?php echo utf8_encode($descpromoc) ?></strong></td>
              <td align="left"><strong>Desconto Promo</strong></td>
              <td align="center" nowrap="nowrap"><strong>- R$ <?php echo number_format($valorpromoc,2,",","."); ?></strong></td>
              <td align="center">&nbsp;</td>
            </tr>
         <?php
            $vl_geral -= $valorpromoc;
         }else{
            if ($descpromoc){?>
                <tr bgcolor="#E1E3F4">
                  <td align="left" colspan="5"><strong><?php echo utf8_encode($descpromoc) ?></strong></td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
            <?php
            }
         }
         
         $sqlb = "SELECT VL_VALOR_CURC, DS_CUPOM_CURC from cupons where NR_SEQ_COMPRA_USO_CURC = $idc";
		 $stb = mysql_query($sqlb);
		 if (mysql_num_rows($stb) > 0) {
			$rowb = mysql_fetch_row($stb);
			$vlbil = $rowb[0];
			$dsbil = $rowb[1];
         ?>
         <tr bgcolor="#E1E3F4">
          <td align="left" colspan="6">Cupom de Desconto: <strong><?php echo $dsbil; ?></strong> - Desc. nos Produtos de R$ <?php echo number_format($vlbil,2,",","."); ?></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php 
		} 
         
		 $sqlb = "SELECT VL_BILHETE_BIRC, DS_BILHETE_BIRC from bilhetes where NR_SEQ_COMPRAUTIL_BIRC = $idc";
		 $stb = mysql_query($sqlb);
		 if (mysql_num_rows($stb) > 0) {
			$rowb = mysql_fetch_row($stb);
			$vlbil = $rowb[0];
			$dsbil = $rowb[1];
         ?>
         <tr bgcolor="#E1E3F4">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="left"><strong>Vale Presente:</strong></td>
          <td align="left"><strong><?php echo $dsbil; ?></strong></td>
          <td align="center"><strong>- R$ <?php echo number_format($vlbil,2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php 
		$vl_geral -= $vlbil;
		} 
        
        $sqlp = "SELECT SUM(NR_QTDE_PORC) from pontos where NR_SEQ_COMPRAUTIL_PORC = $idc";
		$stp = mysql_query($sqlp);
		if (mysql_num_rows($stp) > 0) {
			$rowp = mysql_fetch_row($stp);
			$vlpontos = $rowp[0];
			
			if ($vlpontos > 0) {
         ?>
         <tr bgcolor="#E1E3F4">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left"><strong>Pontos (desconto):</strong></td>
          <td align="center"><strong>- R$ <?php echo number_format($vlpontos,2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php 
			$vl_geral -= $vlpontos;
			}
		} ?>
        <?php if ($desconto > 0){ ?>
        <tr bgcolor="#E1E3F4">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left"><strong>Desconto:</strong></td>
          <td align="center"><strong>- R$ <?php echo number_format($desconto,2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php } ?>
         <tr bgcolor="#EEEEEE">
          <form action="frete_real.php" method="post">
          <input type="hidden" name="idc" value="<?php echo $idc ?>" />
          <td align="right" colspan="3">Frete real: 
          R$ <input name="frete" type="text" size="6" value="<?php echo $fretereal ?>" /> <input type="submit" value="Lançar" class="frm_pesq" style="width:45px;" />
          </td>
          <td align="center">&nbsp;</td>
          <td align="left"><strong>Frete:</strong></td>
          <td align="center"><strong>R$ <?php echo number_format($frete,2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
           <tr bgcolor="#EEEEEE">
             <td align="right" colspan="3">
              <b>Forma de envio:</b> <?php echo utf8_encode($formaenvio); ?>
          </td>
          </tr>
          </form>
        </tr>
        <?php 
		$vl_geral += $frete;
		if ($vl_geral < 0) $vl_geral = 0;
		?>
        
        <?php
        $sqlcre = "SELECT VL_LANCAMENTO_CRSA from contacorrente where NR_SEQ_COMPRA_CRSA = $idc";
		$stcr = mysql_query($sqlcre);
		if (mysql_num_rows($stcr) > 0) {
			$rowcre = mysql_fetch_row($stcr);
			$vlcred = $rowcre[0];
         ?>
         <tr bgcolor="#E1E3F4">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left"><strong><a href="compras_ver_cred.php?idcli=<?php echo $nrseqcad;?>&idc=<?php echo $idc;?>">Créditos</a></strong></td>
          <td align="center" style="color: red;"><strong>- R$ <?php echo number_format(($vlcred*-1),2,",","."); ?></strong></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php 
		$vl_geral += $vlcred;
		} 
        ?>
        
        <tr bgcolor="#CACCE8">
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="middle">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="left"><strong>Total:</strong></td>
          <td align="center"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
          <td align="center"><strong><?php echo $ct_total; ?></strong></td>
        </tr>
    </table>    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>IP:</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo $ip_compra; ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Status:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo $st_compra; ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Forma de Pagamento:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $forma_pgto; ?></td>
        <td bgcolor="#EBEBEB"><strong>Mudança de Status:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo date("d/m/Y", strtotime($dt_status)); ?></td>
      </tr>
      <?php if ($dstid) {?>
      <tr>
        <td bgcolor="#EBEBEB"><strong>TID:</strong></td>
        <td bgcolor="#EBEBEB" colspan="3"><strong><?php echo $dstid; ?></strong></td>
      </tr>
      <?php } ?>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Parcelas:</strong></td>
        <td bgcolor="#EBEBEB" colspan="3">
            <table width="100%">
                <tr>
                    <td align="left"><?php echo $parcelas; ?></td>
                    <form action="envia_mail_rast.php" method="post">
                    <input type="hidden" name="nome" value="<?php echo $nome ?>" />
                    <input type="hidden" name="email" value="<?php echo $email ?>" />
                    <input type="hidden" name="idc" value="<?php echo $idc ?>" />
                    <td width="225" align="right"><strong>Rastreamento:</strong></td>
                    <td><input name="rastre" type="text" size="17" value="<?php echo $rastreamento ?>" /> <input type="submit" value="Enviar" class="frm_pesq" style="width:45px;" /></td>
                    </form>
                </tr>
            </table>
        </td>
      </tr>
      <?php if ($forma_pgto == "dinheiro") { ?>
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>Valor Pago:</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo number_format($valorpago,2,",","."); ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Troco:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo number_format($valortroco,2,",","."); ?></td>
      </tr>
      <?php } ?>
      <?php if ($forma_pgto == "cheque") { ?>
      <tr bgcolor="#CACCE8">
          <td align="left" colspan="4">Dados do(s) Cheque(s)</td>
      </tr>
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>Nr. Banco</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo $nrbanco; ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Agência:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo $agencia; ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Conta Corr.:</strong></td>
        <td bgcolor="#EBEBEB" colspan="3"><?php echo $contaco; ?></td>
      </tr>
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>Nr Cheque</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo $cheque1; ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Valor:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo number_format($chvalrl,2,",","."); ?></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB"><strong>Vencimento:</strong></td>
        <td bgcolor="#EBEBEB"><strong><?php if ($chdatal) echo date("d/m/Y", strtotime($chdatal)); ?></strong></td>
      </tr>
      <?php if ($chdata2) { ?>
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>Nr Cheque</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo $cheque2; ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Valor:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo number_format($chvalr2,2,",","."); ?></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB"><strong>Vencimento:</strong></td>
        <td bgcolor="#EBEBEB"><strong><?php if ($chdata2) echo date("d/m/Y", strtotime($chdata2)); ?></strong></td>
      </tr>
      <?php } ?>
      <?php if ($chdata3) { ?>
      <tr>
        <td width="26%" bgcolor="#EBEBEB"><strong>Nr Cheque</strong></td>
        <td width="24%" bgcolor="#EBEBEB"><?php echo $cheque3; ?></td>
        <td width="24%" bgcolor="#EBEBEB"><strong>Valor:</strong></td>
        <td width="26%" bgcolor="#EBEBEB"><?php echo number_format($chvalr3,2,",","."); ?></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td align="center" bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB"><strong>Vencimento:</strong></td>
        <td bgcolor="#EBEBEB" colspan="3"><strong><?php if ($chdata3) echo date("d/m/Y", strtotime($chdata3)); ?></strong></td>
      </tr>
      <?php } ?>
      <?php } ?>
      <?php if ($obs_compra) { ?>
      <tr>
        <td colspan="4" bgcolor="#CACCE8"><strong>Observações:</strong></td>
      </tr>
      <tr>
        <td height="40" colspan="4" bgcolor="#EBEBEB"><?php echo utf8_encode($obs_compra); ?></td>
      </tr>
	  <?php } ?>
    </table></td>
  </tr>
  <?php
  $sql2 = "SELECT DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC, DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC,
  			 DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC FROM enderecos WHERE NR_SEQ_COMPRA_ENRC = $idc";
  $st2 = mysql_query($sql2);
  if (mysql_num_rows($st2) > 0) {
  $row2 = mysql_fetch_assoc($st2);
  ?>
  <tr>
    <td bgcolor="#CACCE8"><strong>Endereço para Entrega:</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="20%" height="20" bgcolor="#EBEBEB"><strong>Nome:</strong></td>
        <td colspan="3" bgcolor="#EBEBEB"><span class="style1"><?php echo utf8_encode($row2["DS_DESTINATARIO_ENRC"]); ?></span></td>
        </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Endereço:</strong></td>
        <td width="34%" bgcolor="#EBEBEB"><?php echo utf8_encode($row2["DS_ENDERECO_ENRC"]); ?> N&deg; <?php echo $row2["DS_NUMERO_ENRC"]; ?></td>
        <td width="25%" bgcolor="#EBEBEB"><strong>Bairro:</strong></td>
        <td width="21%" bgcolor="#EBEBEB"><?php echo utf8_encode($row2["DS_BAIRRO_ENRC"]); ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Cidade/UF:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo utf8_encode($row2["DS_CIDADE_ENRC"]); ?>/<?php echo $row2["DS_UF_ENRC"]; ?></td>
        <td bgcolor="#EBEBEB"><strong>CEP:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $row2["DS_CEP_ENRC"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Complemento:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo utf8_encode($row2["DS_COMPLEMENTO_ENRC"]); ?></td>
        <td bgcolor="#EBEBEB"><strong>País:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $row2["DS_PAIS_ENRC"]; ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Fone:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $row2["DS_FONE_ENRC"]; ?></td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <?php 
  $dadosetiq .= $row2["DS_DESTINATARIO_ENRC"]."<br />";
  $dadosetiq .= $row2["DS_ENDERECO_ENRC"].", N&deg; ".$row2["DS_NUMERO_ENRC"]."<br />";
  $dadosetiq .= "Bairro ".$row2["DS_BAIRRO_ENRC"]."<br />";
  $dadosetiq .= $row2["DS_CIDADE_ENRC"]."/".$row2["DS_UF_ENRC"]."<br />";
  $dadosetiq .= $row2["DS_COMPLEMENTO_ENRC"]." - CEP ".$row2["DS_CEP_ENRC"]."<br />";
  }?>
  <tr>
    <td bgcolor="#CACCE8">
    	<table width="100%">
        	<tr>
            	<td><strong>Dados do Comprador:</strong></td>
                <form action="etiquetas_pos.php" method="post" target="_blank">
                <input name="idc" type="hidden" value="<?php echo $nrseqcad; ?>" />
                <input name="idcompra" type="hidden" value="<?php echo $idc; ?>" />
                <td align="right">
                	Imprimir Etiqueta: Posição <input name="pos" type="text" size="1" value="1" /> <input type="submit" value="Gerar" class="frm_pesq" style="width:45px;" />
                </td>
            </tr></form>
        </table>
    </td>
  </tr>
  <?php 
  if (!$dadosetiq) {
  	$dadosetiq .= $nome."<br />";
    $dadosetiq .= $endereco.", N&deg; ".$numero."<br />";
    $dadosetiq .= $complem."<br />";
    $dadosetiq .= "Bairro ".$bairro."<br />";
    $dadosetiq .= $cidade."/".$estado."<br />";
    $dadosetiq .= "CEP ".$cep."<br />";
  }
  ?>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td width="20%" height="20" bgcolor="#EBEBEB"><strong>Nome:</strong></td>
        <td colspan="3" bgcolor="#EBEBEB"><span class="style1"><?php echo utf8_encode($nome); ?> <?php if ($tipocli == 1) echo " (LOJISTA)"; ?></span></td>
        </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Endereço:</strong></td>
        <td width="34%" bgcolor="#EBEBEB"><?php echo utf8_encode($endereco); ?> N&deg; <?php echo $numero; ?></td>
        <td width="25%" bgcolor="#EBEBEB"><strong>Bairro:</strong></td>
        <td width="21%" bgcolor="#EBEBEB"><?php echo utf8_encode($bairro); ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Cidade/UF:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo utf8_encode($cidade); ?>/<?php echo $estado; ?></td>
        <td bgcolor="#EBEBEB"><strong>CEP:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $cep; ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Complemento:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo utf8_encode($complem); ?></td>
        <td bgcolor="#EBEBEB"><strong>Data de Nasc.:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo date("d/m/Y", strtotime($dt_nasc)); ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Documento:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo $documento; ?></td>
        <td bgcolor="#EBEBEB"><strong>Twitter:</strong></td>
        <td bgcolor="#EBEBEB"><a href="http://www.twitter.com/<?php echo $dstwitter; ?>" target="_blank"><?php echo $dstwitter; ?></a></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>E-mail:</strong></td>
        <td bgcolor="#EBEBEB"><a href="mailto:<?php echo $email; ?>" class="linksmenu"><?php echo $email; ?></a></td>
        <td bgcolor="#EBEBEB"><strong>Data de Cad.:</strong></td>
        <td bgcolor="#EBEBEB"><?php echo date("d/m/Y", strtotime($dt_cadastro)); ?></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Telefone:</strong></td>
        <td bgcolor="#EBEBEB">(<?php echo $dddfone; ?>) <?php echo $fone; ?></td>
        <td bgcolor="#EBEBEB"><strong>Celular:</strong></td>
        <td bgcolor="#EBEBEB">(<?php echo $dddcel; ?>) <?php echo $celular; ?> <?php if($operadora && $operadora != "nenhuma") echo " (".$operadora.")" ?></td>
      </tr>
      <?php if ($obscad) { ?>
      <tr>
        <td colspan="4" bgcolor="#CACCE8"><strong>Observação do Cadastro:</strong></td>
      </tr>
      <tr>
        <td height="40" colspan="4" bgcolor="#EBEBEB"><?php echo utf8_encode($obscad); ?></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CACCE8"><strong>Últimos 5 Pedidos do Cliente:</strong></td>
  </tr>
  <tr>
    <td><table height="30" cellspacing="0" cellpadding="0" width="100%" border="0">
      <tr bgcolor="#CACCE8">
        <td width="6%" align="center"><strong>NR</strong></td>
        <td width="22%" height="20" align="middle"><strong>Data</strong></td>
        <td width="14%" align="center"><strong>Qtde</strong></td>
        <td width="14%" align="center"><strong>Forma de Pgto</strong></td>
        <td width="14%" align="center"><strong>Vlr.Total</strong></td>
        <td width="14%" align="center"><strong>Status</strong></td>
      </tr>
      <?php
	    $idcli = $nrseqcad;

		$sql = "SELECT NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DT_STATUS_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO, DS_FORMAPGTO_COSO
				FROM compras WHERE NR_SEQ_CADASTRO_COSO = $idcli AND NR_SEQ_COMPRA_COSO <> $idc order by DT_COMPRA_COSO desc limit 5";
		$st = mysql_query($sql);
		
		if (mysql_num_rows($st) > 0) {
			$x = 0;
			while($row = mysql_fetch_row($st)) {
				$nr_compra	   = $row[0];
				$dt_compra	   = $row[1];
				$dt_status	   = $row[2];
				$valor		   = $row[3];
				$st_compra	   = $row[4];
				$forma_pgto	   = $row[5];
				
				switch ($st_compra) {
					case "A":
						$st_compra = "Em Aberto";
						break;
					case "F":
						$st_compra = "Finalizada";
						break;
					case "C":
						$st_compra = "Cancelada";
						break;
				}

				if ($x == 0) {
					$bg = "#FFFFFF";
					$x = 1;
				}else{
					$bg = "#EEEEEE";
					$x = 0;
				}
				
				$cotas = 0;
				$sql2 = "SELECT sum(NR_QTDE_CESO) from cestas where NR_SEQ_COMPRA_CESO = $nr_compra";
				$st2 = mysql_query($sql2);
				if (mysql_num_rows($st2) > 0) {
					$row2 = mysql_fetch_row($st2);
					$cotas = $row2[0];
				}
				if (!$cotas) $cotas = 0;
				?>
                <tr bgcolor="<?php echo $bg; ?>">
                    <td align="center"><a href="compras_ver.php?idc=<?php echo $nr_compra; ?>"><strong><?php echo $nr_compra; ?></strong></a></td>
                    <td height="20" align="middle"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                    <td align="center"><?php echo $cotas; ?></td>
                    <td align="center"><?php echo $forma_pgto; ?></td>
                    <td align="center">R$ <?php echo number_format($valor,2,",","."); ?></td>
                    <td align="center"><?php echo $st_compra; ?></td>
                  </tr>
                <?php
			}
		}
		
		mysql_close($con);
      ?>
    </table></td>
  </tr>
  <!--
  <tr>
  	<td>
    	<br />
		<br />
		<strong><?php echo $dadosetiq ?></strong>
    </td>
  </tr>-->
</table>
</body>
</html>