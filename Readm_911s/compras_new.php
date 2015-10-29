<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$idc   = request("idc");
$pg    = request("pg");

  date_default_timezone_set('America/Sao_Paulo');
  //crio a data de hoje
  $data_hoje = date("Y-m-d H:i:s");

$sqlnome = "SELECT DS_NOME_CASO, DS_EMAIL_CASO, TP_CADASTRO_CACH, VL_TOTAL_COSO, VL_DESCPROMO_COSO from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
        and NR_SEQ_COMPRA_COSO = $idc";
$stnome = mysql_query($sqlnome); 
if (mysql_num_rows($stnome) > 0) {
	$rownome = mysql_fetch_row($stnome);
    $nome = $rownome[0];
    $email = $rownome[1];
    $tipocad = $rownome[2];  
    $vlr_compra_at = $rownome[3]; 
    $vlr_desconto_at = $rownome[4]; 
}

if ($tipocad != 1){
    $str = "INSERT INTO compras (
    NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, DT_COMPRA_COSO, DT_STATUS_COSO,
    DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
    TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
    VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
    DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
    DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, ST_NOVOPGTO_COSO, NR_SEQ_PROMO_COSO) 
       SELECT 
    NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, '$data_hoje', DT_STATUS_COSO,
    DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
    TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
    VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
    DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
    DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, 'S', NR_SEQ_PROMO_COSO FROM compras 
          WHERE NR_SEQ_COMPRA_COSO = $idc;";
}else{
    $vlr_compra_at = $vlr_compra_at + $vlr_desconto_at;
    $str = "INSERT INTO compras (
    NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, DT_COMPRA_COSO, DT_STATUS_COSO,
    DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
    TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
    VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
    DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
    DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, ST_NOVOPGTO_COSO) 
       SELECT 
    NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, '$data_hoje', DT_STATUS_COSO,
    DS_IP_COSO, $vlr_compra_at, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
    TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
    VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
    DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
    DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, null, null, NR_SEQ_VENDEDOR_COSO, 'S' FROM compras 
          WHERE NR_SEQ_COMPRA_COSO = $idc;";
}
$st = mysql_query($str);
$id_compra = mysql_insert_id();

$sql = "select NR_SEQ_ENDERECO_ENRC from enderecos where NR_SEQ_COMPRA_ENRC = $idc";
$st = mysql_query($sql); 
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
    $nrend = $row[0];
    
    $str = "INSERT INTO enderecos (NR_SEQ_COMPRA_ENRC, DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC,
			DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC, DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC, DT_CADASTRO_ENRC)
            SELECT
            $id_compra, DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC,
			DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC, DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC, DT_CADASTRO_ENRC FROM enderecos
            WHERE NR_SEQ_ENDERECO_ENRC = $nrend";
    $st = mysql_query($str);
}

$str = "UPDATE compras set ST_COMPRA_COSO = 'C', DS_OBS_COSO = 'Compra cancelada e recriada para novo pagamento. Compra nova: $id_compra' WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($str);

$str = "UPDATE compras set DS_OBS_COSO = 'Compra recriada a partir da compra $idc' WHERE NR_SEQ_COMPRA_COSO = $id_compra";
$st = mysql_query($str);

$sql = "select NR_SEQ_CESTA_CESO from cestas where NR_SEQ_COMPRA_CESO = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_cesta = $row[0];
        $str = "INSERT INTO cestas (
            NR_SEQ_CADASTRO_CESO, NR_SEQ_COMPRA_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_ESTOQUE_CESO, NR_SEQ_TAMANHO_CESO,
            NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO, DS_OBS_CESO, VL_PRODUTOCHEIO_CESO)
            SELECT
            NR_SEQ_CADASTRO_CESO, $id_compra, NR_SEQ_PRODUTO_CESO, NR_SEQ_ESTOQUE_CESO, NR_SEQ_TAMANHO_CESO,
            NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO, DS_OBS_CESO, VL_PRODUTOCHEIO_CESO FROM cestas
            WHERE NR_SEQ_CESTA_CESO = $id_cesta";
        $stincc = mysql_query($str);
    }
}

$testa = true;
while($testa){
	$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
	$max = strlen($CaracteresAceitos)-1;
	//$password = date('Ymdhis');
	$codigo = "";
	for($i=0; $i < 20; $i++) {
	   $codigo .= $CaracteresAceitos{mt_rand(0, $max)};
	}
	$testa = false;
}

$str = "INSERT INTO controle_novo_pgto (NR_SEQ_COMPRA_NPRC, DT_CRIACAO_NPRC, ST_USO_NPRC, DS_CODIGO_NPRC, DT_VALIDADE_NPRC) VALUES (
        $id_compra, SYSDATE(), 'A', '$codigo', DATE_ADD(SYSDATE(), INTERVAL 2 DAY))";
$st = mysql_query($str);

$link = "https://www.reverbcity.com/reabrir-compra/".$idc;
$link2 = "http://www.reverbcity.com/shop/pgtoc.php?ch=$codigo";

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Reverbcity - Finalização de Compra!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Olá <strong>'.$nome.'</strong>,</p>

                <p>Verificamos em nossos registros e o pagamento referente ao seu pedido <strong>'.$idc.'</strong> ainda <strong>não</strong> foi localizado.</p>	
                
                <p>Você pode <strong><a href="'.$link.'">Clicar Aqui</a></strong> e escolher outra forma de pagamento para finalizar o seu pedido. Vamos reservá-lo por mais dois dias.</p>
                
                <p>Qualquer dúvida basta entrar em contato: <strong>atendimento@reverbcity.com</strong></p>
                
                
                <br />
             </div>';
$corpo = IncluiPapelCarta("compranao",$texto);

EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","","Reverbcity - Compra não aprovada", $corpo);
// <p>Caso você não tenha mais interesse nessa compra, <a href="'.$link2.'">clique aqui</a> e efetue o cancelamento da mesma.</p>
Header("Location: compras.php");
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0" style="font-size: 10px;">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Aniversariante</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);">Enviando Email</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">

                         <form action="compras_new2.php" method="post">
                            <input name="pg" type="hidden" value="<?php echo $pg; ?>" />
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo $subject; ?>" /> <input type="submit" id="postar" name="postar" value="Enviar Email" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo">
                                       Conteudo:<br />
                                       <?php
                                            //$contmala = "<table width=\"600\" align=\"center\" border=\"0\"><tr><td><img src=\"http://www.cheida15.can.br/img/topo_new.jpg\" border=\"0\" /></td></tr><tr><td height=\"150\">&nbsp;</td></tr><tr><td><img src=\"http://www.cheida15.can.br/img/rodape_new.jpg\" border=\"0\" /></td></tr><tr><td align=\"center\">Caso voc&ecirc; n&atilde;o queira mais receber este mailing, <a href=mailto:imprensa@cheida15.can.br?subject=CANCELAR>clique aqui</a></td></tr></table>";
                                            $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                            $oFCKeditor->ToolbarSet = 'MyToolbar';
                                            $oFCKeditor->BasePath = 'fckeditor/' ;
                                            $oFCKeditor->Height = 400 ;
											$oFCKeditor->Width = 600 ;
                                            $oFCKeditor->Value = $corpo ;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    
                    </div> <!-- /criar -->
                    
              

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>