<?php
include 'auth.php';
include 'lib.php';
$status = request("st");
$statusn = request("stn");
$page = request("pg");
$statussme = request("stsme");
$idgrp = request("idgrp");

date_default_timezone_set('America/Sao_Paulo');
//crio a data de hoje
$data_hoje = date("Y-m-d H:s:i");

if (!$status) $status = 'A';

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou status Compra $idgrp ST $status - STN $statusn");

if ($statusn == "C" && $statussme != true) {
    $sqlche = "select ST_COMPRA_COSO from compras WHERE NR_SEQ_COMPRA_COSO = $idgrp";
    $stche = mysql_query($sqlche);
    if (mysql_num_rows($stche) > 0) {
        $rowche = mysql_fetch_row($stche);
        if ($rowche[0] == 'C'){
            $msg = "Essa compra ja esta cacelada!";
            $msg = str_replace(" ","%20", $msg);
            Header("Location: erro.php?msg=$msg");
            exit();
        }
    }

    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $id_tamanho = $row[0];
            $nr_qtde	= $row[1];
            $nr_produto	= $row[2];

            $sqlche = "select NR_SEQ_ESTCONTROLE_ECRC from estoque_controle WHERE DS_OBS_ECRC = 'Cancelamento compra $idgrp' AND NR_SEQ_PRODUTO_ECRC = $nr_produto AND NR_SEQ_TAMANHO_ECRC = $id_tamanho";
            $stche = mysql_query($sqlche);
            if (mysql_num_rows($stche) > 0) {
                EnviaEmail("atendimento@reverbcity.com", "gustavo@reverbcity.com", "REVERBCITY ERRO", "<b>Tentativa de volta duplicada de produto.<br />$sqlche<br /></b>");
            }

            $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$nr_qtde." WHERE NR_SEQ_TAMANHO_ESRC = $id_tamanho AND NR_SEQ_PRODUTO_ESRC = $nr_produto";
            $st4 = mysql_query($str4);

            GravaLogEstoque($SS_logadm,$nr_produto,$id_tamanho,"Adicionou $nr_qtde","Cancelamento compra $idgrp",$nr_qtde);


            $str5 = "UPDATE produtos SET DS_CLASSIC_PRRC = 'N' WHERE NR_SEQ_PRODUTO_PRRC = $nr_produto";
            $st5 = mysql_query($str5);
        }
    }

    //$strpt = "UPDATE pontos SET ST_PONTOS_PORC = 'E' WHERE NR_SEQ_COMPRAUTIL_PORC = $idgrp AND ST_PONTOS_PORC = 'U'";
    //$st = mysql_query($strpt);
    //$strpt = "UPDATE pontos SET ST_PONTOS_PORC = 'C' WHERE NR_SEQ_COMPRA_PORC = $idgrp";
    //$st = mysql_query($strpt);
}

if ($statusn == "P") {
    $str = "UPDATE compras SET DT_PAGAMENTO_COSO = '" . $data_hoje . "' WHERE NR_SEQ_COMPRA_COSO = " . $idgrp;
    $st = mysql_query($str);

    $sql = "SELECT NR_SEQ_CADASTRO_CASO, VL_TOTAL_COSO, VL_FRETE_COSO, TP_CADASTRO_CACH, DS_TWITTER_CACH, DS_NOME_CASO, DS_EMAIL_CASO
             FROM cadastros, compras WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND NR_SEQ_COMPRA_COSO = $idgrp";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $nrcad = $row[0];
        $vlcom = $row[1];
        $frete = $row[2];
        $tipocli = $row[3];
        $dstwitter = trim($row[4]);
        $nome  = utf8_decode($row[5]);
        $email = $row[6];
    }

    $tem5169 = false;
    //VERIFICA COMPRA COM VALE CAMISETA de 75 por 50
    $sqlV = "select sum(VL_PRODUTO_CESO), sum(NR_QTDE_CESO) FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp AND NR_SEQ_PRODUTO_CESO = 5169";
    $stV = mysql_query($sqlV);
    if (mysql_num_rows($stV) > 0) {
        $rowV = mysql_fetch_row($stV);
        $totpago = $rowV[0];
        $qtdetotal = $rowV[1];
        $tem5169 = true;

        $strpt = "INSERT INTO vale_camisetas (NR_SEQ_COMPRA_VLRC, NR_SEQ_CADASTRO_VLRC, NR_SEQ_PROMO_VLRC, VL_TOTALPAGO_VLRC, NR_QTDEVALE_VLRC, DT_PGTO_VLRC, ST_UTILIZADO_VLRC, ST_FRETEGRATIS_VLRC)
 				  VALUES ($idgrp, $nrcad, 1, $totpago, $qtdetotal, 'data_hoje', 'A', 'S')";
        $stv = mysql_query($strpt);

        $valorcred = $qtdetotal*75;
        $strinsertc = "Vale Reverbcity - Compra: <a href=compras_ver.php?idc=$idgrp>$idgrp</a>";

        $str = "INSERT INTO contacorrente (NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DT_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, DT_VENCIMENTO_CRSA)
     			VALUES ($nrcad, $valorcred, 'C', 'data_hoje', '$strinsertc', '2013-12-31 23:59:59')";
        $st = mysql_query($str);

        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Confirmou pgto compra $idgrp e creditou para $nrcad R$ $valorcred");
    }

    //  if ($dstwitter){
//        if (strlen($dstwitter) > 1){
//            EnviaEmail("atendimento@reverbcity.com", "marcio@reverbcity.com", "Compra realizada por usuário do Twitter: $dstwitter", "Seguir: http://twitter.com/$dstwitter");
//        }
//    }

    //COMPRA DO TSHIRT CLUB CONFIRMADA - VERIFICAR SE POSSUI ESSE ITEM NA COMPRA
    //  $sql = "select NR_SEQ_PRODUTO_CESO, NR_SEQ_TAMANHO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp";
//	$st = mysql_query($sql);
//	if (mysql_num_rows($st) > 0) {
//	    $temclub = false;
//		while($row = mysql_fetch_row($st)) {
//            $nr_produto	= $row[0];
//            $nr_tamanho	= $row[1];
//            if ($nr_produto == 2001) $temclub = true;
//		}
//        if ($temclub){
//            $strpt = "INSERT INTO tshirtclub (NR_SEQ_CADASTRO_TCRC, DT_ADESAO_TCRC, ST_CADASTRO_TCRC, NR_SEQ_COMPRA_TCRC, NR_SEQ_TAMANHO_TCRC)
//    				VALUES ($nrcad, 'data_hoje', 'A', $idgrp, $nr_tamanho)";
//    		$st = mysql_query($strpt);
//        }
//	}

    // if ($tipocli != 1){
//    	$sqlpt = "SELECT NR_SEQ_PONTOS_PORC FROM pontos where NR_SEQ_COMPRA_PORC = $idgrp";
//    	$st = mysql_query($sqlpt);
//    	if (mysql_num_rows($st) <= 0) {
//    		$pontos = number_format(($vlcom-$frete)*4/100,0,".","");
//    		$strpt = "INSERT INTO pontos (NR_SEQ_CADASTRO_PORC, NR_SEQ_REFERENCIA_PORC, NR_SEQ_COMPRA_PORC, NR_QTDE_PORC, DT_INCLUSAO_PORC, ST_PONTOS_PORC)
//    				VALUES ($nrcad, 1, $idgrp, $pontos, 'data_hoje', 'E')";
//    		$st = mysql_query($strpt);
//    	}
//    }

    //VERIFICA PROMO INDICAÇÃO (30% DE CREDITO PRA QUEM COMPRAR)
    //$sqlpt = "SELECT count(*) FROM compras where NR_SEQ_CADASTRO_COSO = $nrcad and
//                 (ST_COMPRA_COSO <> 'A' and ST_COMPRA_COSO <> 'C') and NR_SEQ_COMPRA_COSO <> $idgrp";
//    	$st = mysql_query($sqlpt);
//        $totalcp = 0;
//    	if (mysql_num_rows($st) > 0) {
//    		$row = mysql_fetch_row($st);
//            $totalcp = $row[0];
//    	}
//        if (!$totalcp) $totalcp = 0;
//        
//        //É PRIMEIRA ENTAO ENTRA
//        if ($totalcp <= 0){
//            $sqlpt = "SELECT DS_EMAILINDICA_CACH FROM cadastros where NR_SEQ_CADASTRO_CASO = $nrcad AND DT_CADASTRO_CASO < '2012-04-30 23:59:59'";
//    	    $st = mysql_query($sqlpt);
//            if (mysql_num_rows($st) > 0) {
//        		$row = mysql_fetch_row($st);
//                $emailpai = $row[0];
//                
//                $sqlpai = "SELECT NR_SEQ_CADASTRO_CASO FROM cadastros where DS_EMAIL_CASO = '".$emailpai."' and NR_SEQ_CADASTRO_CASO <> $nrcad AND ST_CADASTRO_CASO = 'A' AND TP_CADASTRO_CACH = 0";
//        	    $stp = mysql_query($sqlpai);
//                if (mysql_num_rows($stp) > 0) {
//            		$rowp = mysql_fetch_row($stp);
//                    $nrseqpai = $rowp[0];
//                    
//                    $valorcred = number_format(($vlcom-$frete)*30/100,2,".","");
//                    
//                    $strinsertc = "Reverbducao - Primeira compra de cadastro indicado - Compra: <a href=compras_ver.php?idc=$idgrp>$idgrp</a>";
//                    
//                    $str = "INSERT INTO contacorrente (NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DT_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, DT_VENCIMENTO_CRSA)
//                    			VALUES ($nrseqpai, $valorcred, 'C', 'data_hoje', '$strinsertc', DATE_ADD('data_hoje', INTERVAL 30 DAY))";
//                    $st = mysql_query($str);
//
//                    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Confirmou pgto compra $idgrp e creditou para $nrseqpai R$ $valorcred");
//                    
//                    $nomecomprador = $nome;
//    	
//                    $corpo = "<table height=\"300\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"557\">\n";
//                    $corpo .= "<tbody>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td height=\"87\" width=\"557\" valign=\"bottom\" colspan=\"3\"><img height=\"87\" width=\"557\" src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" alt=\"\" /></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td bgcolor=\"#7a6c61\" width=\"1\"><img height=\"1\" width=\"1\" src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" alt=\"\" /></td>\n";
//                    $corpo .= "<td>\n";
//                    $corpo .= "<table cellspacing=\"3\" cellpadding=\"3\" width=\"100%\">\n";
//                    $corpo .= "<tbody>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td width=\"555\" bgcolor=\"#D1A72E\" style=\"font-family: Verdana,Helvetica,sans-serif; font-size:12px; color: #FFF;\">&nbsp;<strong>Promoção Reverbdução!</strong></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td height=\"166\" style=\"font-family: Verdana,Helvetica,sans-serif; font-size:12px; color: #000;\"><p>Olá,</p>\n";
//                    $corpo .= "<p>Parabéns!!, você acaba de ganhar R$ ".number_format($valorcred,2,",","")." referente a compra do <strong>$nomecomprador</strong>, que você indicou para se cadastrar em nosso site!</p>
//                                <p><strong>O seu bônus já está disponível</strong>, você pode usar agora ou espere acumular de compras de outros amigos que vc indicou!</p></td>\n";
//                    $corpo .= "<td width=\"275\" align=\"center\"><a href=\"http://www.reverbcity.com/blog/blog.php?com=2657&idb=2657#2657\"><img src=\"http://www.reverbcity.com/images/reverbducao.gif\" width=\"250\" border=\"0\"></a></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td colspan=\"2\" bgcolor=\"#D1A72E\" style=\"font-family: Verdana,Helvetica,sans-serif; font-size:12px; color: #FFF;\">&nbsp;<strong>IMPORTANTE</strong></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td height=\"45\" colspan=\"2\" style=\"font-family: Verdana,Helvetica,sans-serif; font-size:12px; color: #000;\">Lembre-se que o bônus tem validade de 30 dias.<br />O seu crédito aparece automaticamente no seu carrinho de compras, bastando estar logado.</td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "</table></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "</tbody>\n";
//                    $corpo .= "</table>\n";
//                    $corpo .= "</td>\n";
//                    $corpo .= "<td bgcolor=\"#7a6c61\" width=\"1\"><img height=\"1\" width=\"1\" src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" alt=\"\" /></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "<tr>\n";
//                    $corpo .= "<td height=\"26\" width=\"557\" valign=\"top\" colspan=\"3\"><img height=\"26\" border=\"0\" width=\"557\" usemap=\"#Map\" src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" alt=\"\" /></td>\n";
//                    $corpo .= "</tr>\n";
//                    $corpo .= "</tbody>\n";
//                    $corpo .= "</table>\n";
//                    $corpo .= "<p><map name=\"Map\">\n";
//                    $corpo .= "<area target=\"_blank\" href=\"http://www.reverbcity.com\" coords=\"435,4,541,22\" shape=\"rect\" /></map></p>\n";
//                    
//                    EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$emailpai,"","","Reverbdução Confirmada!", $corpo);
//            	}
//        	}
//        }


    $sql = "SELECT DS_BILHETE_BIRC, DS_NOME_CASO, DS_EMAIL_CASO, NR_SEQ_BILHETES_BIRC from bilhetes, cadastros where NR_SEQ_CADCRIADOR_BIRC = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_BIRC = $idgrp AND ST_STATUS_BIRC = 'A'";

    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $bilhete = $row[0];
        $nomebi  = utf8_decode($row[1]);
        $emailbi = $row[2];
        $nrbilhe = $row[3];


        if ($nrbilhe != "") {
            # code...
            $subject  = "ReverbCity - Vale Presente";

            // $corpo = "<table width=\"500\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#e5d6c5\">";
            // $corpo .= "<tr><td><img src=\"http://www.reverbcity.com/images/mail_presente_01.jpg\" alt=\"Vale Presente Reverbcity\" width=\"500\" height=\"151\" /></td></tr>";
            // $corpo .= "<tr><td><p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #6b4922;\"><strong>Olá $nomebi</strong>,</p>";
            // $corpo .= "<p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #6b4922;\">O vale-presente deverá ser usado integralmente de uma só vez. Caso sua compra exceda o valor do vale, você poderá usá-lo normalmente e pagar pela diferença.</p>";
            // $corpo .= "<p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #6b4922;\">The gift-certificate must be used up all in one purchase. In case your order excedes its value, you may use your gift-certificate as credit and pay the diference.</p>";
            // $corpo .= "<p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #6b4922;\">Um Abra&ccedil;o,</p>";
            // $corpo .= "<p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #6b4922;\"><strong>REVERBCITY música que veste.</strong></p>    </td>";
            // $corpo .= "</tr><tr><td bgcolor=\"#6a4922\"><p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #FFFFFF;\">O código do Vale Presente é <span style=\"font-size:30px;	font-weight:bold;\">$bilhete</span><br />";
            // $corpo .= "Utilize este código para fazer compras <br />no site <a href=\"http://www.reverbcity.com\" target=\"_blank\">www.reverbcity.com</a>.</p>";
            // $corpo .= "<p style=\"margin: 30px 30px 30px 70px;font-size:16px;color: #FFFFFF;\">Como usar o cupom? <a href=\"https://www.reverbcity.com/vale-presente/page\">aqui</a></p></td>";
            // $corpo .= "</tr><tr><td align=\"right\"><p style=\"float:right;font-size:11px;	margin: 10px 30px 10px 0px;	color: #6b4922;\"><a style=\"color: #62c29c;text-decoration:none;font-weight:bold;text-decoration:underline;\" href=\"http://www.reverbcity.com\">www.reverbcity.com</a></p></td>";
            // $corpo .= "</tr></table><h3>&nbsp;</h3>";

            $corpo = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                                <p>Olá; <strong>'.$nomebi.'</strong>,</p>

                                <p>O vale-presente deverá ser usado integralmente de uma só vez. Caso sua compra exceda o valor do vale, você poderá usá-lo normalmente e pagar pela diferen&ccedil;a.</p> 
                                <p>O código do Vale Presente é <span style=\"font-size:30px;  font-weight:bold;\">'.$bilhete.'</span></p>
                            
                                <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
                            </div> ';

            $corpo = IncluiPapelCarta("padrao",$corpo);

            $emailsender='atendimento@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

            // if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
            // elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
            // else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
            $quebra_linha = "\n";

            $nomeremetente     = "Reverbcity";
            $emailremetente    = "atendimento@reverbcity.com";

            $headers = "MIME-Version: 1.1".$quebra_linha;
            $headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
            $headers .= "From: ".$emailsender.$quebra_linha;
            $headers .= "Return-Path: " . $emailsender . $quebra_linha;
            $headers .= "Reply-To: ".$emailremetente.$quebra_linha;

            // mail($emailbi, $subject, $corpo, $headers);
            EnviaMailer("atendimento@reverbcity.com","Reverbcity",$emailbi,$nome,"",$subject,$corpo);

            $str = "UPDATE bilhetes SET ST_STATUS_BIRC = 'L' WHERE NR_SEQ_BILHETES_BIRC = $nrbilhe";
            $st = mysql_query($str);
        }
    }

    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
    <p>Olá <strong>'.$nome.'</strong>,</p>

    <p>O seu pagamento referente ao pedido <a href="http://reverbcity.com/reverbme/minhascompras"><strong>'.$idgrp.'</strong></a> foi confirmado com sucesso e já estamos separando sua compra aqui na Reverbcity!</p> 
    <p>Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.</p>
    
        <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
    </div>    
    <div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
         <b>Prazo para a postagem:</b>
                                Pedidos com o pagamento confirmado até as 13:00 de um dia útil serão postados no mesmo dia, após este horário a postagem se dará no próximo dia útil.

                                Prazo para a entrega:
                                Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                Os envios por E-sedex, Sedex e TAM levam em média três dias úteis após a postagem.

                                Os envios por PAC podem levar até 23 dias úteis, dependendo da região do país. Veja abaixo o prazo médio para sua região:
                                1 a 2 dias úteis para as capitais PR, SC, SP, RJ e MG
                                3 a 7 dias úteis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                7 a 12 dias úteis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                até 23 dias úteis para AM
    </div>';

    $corpo = IncluiPapelCarta("confpgto",$texto);

    EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","",utf8_encode("ReverbCity - Confirmação de Pagamento!"), $corpo);

}

if ($status == "C"){
    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp";


    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $id_tamanho = $row[0];
            $nr_qtde	= $row[1];
            $nr_produto	= $row[2];
            if ($nr_produto != 4679){
                $sql2 = "select NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = $nr_produto and NR_SEQ_TAMANHO_ESRC = $id_tamanho and NR_SEQ_LOJA_ESRC = $SS_loja";

                $st2 = mysql_query($sql2);
                if (mysql_num_rows($st2) > 0) {
                    $row2 = mysql_fetch_row($st2);
                    $qtdeat = $row2[0];
                    if ($qtdeat < $nr_qtde){
                        $msg = "Voce não pode re-abrir essa compra pois um ou mais produtos não possuem mais estoque! $nr_produto";
                        $msg = str_replace(" ","%20",$msg);
                        Header("Location: erro.php?msg=$msg");
                        exit();
                    }
                }else{
                    $msg = "Voce não pode re-abrir essa compra pois um ou mais produtos não possuem mais estoque! $nr_produto";
                    $msg = str_replace(" ","%20",$msg);
                    Header("Location: erro.php?msg=$msg");
                    exit();
                }
            }
        }
    }

    $sql = "select NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $id_tamanho = $row[0];
            $nr_qtde	= $row[1];
            $nr_produto	= $row[2];

            $sql_nome = "SELECT NR_SEQ_CADASTRO_CASO, VL_TOTAL_COSO, VL_FRETE_COSO, TP_CADASTRO_CACH, DS_TWITTER_CACH, DS_NOME_CASO, DS_EMAIL_CASO
             FROM cadastros, compras WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND NR_SEQ_COMPRA_COSO = $idgrp";



            $st_nome = mysql_query($sql_nome);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st_nome);
                $nrcad = $row[0];
                $vlcom = $row[1];
                $frete = $row[2];
                $tipocli = $row[3];
                $dstwitter = trim($row[4]);
                $nome  = utf8_decode($row[5]);
                $email = $row[6];
                $link = "https://www.reverbcity.com/reabrir-compra/".$idgrp;
            }

            $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC - ".$nr_qtde." WHERE NR_SEQ_TAMANHO_ESRC = $id_tamanho AND NR_SEQ_PRODUTO_ESRC = $nr_produto";

            $st4 = mysql_query($str4);

            $texto = utf8_encode('<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                    <p>Olá <strong>'.$nome.'</strong>,</p>

                    <p>Sua compra <strong>não</strong> foi aprovada e seu pedido <strong>'.$idgrp.'</strong> ainda não foi finalizado.</p>   

                    <p>Você pode <strong><a href="'.$link.'">Clicar Aqui</a></strong> e escolher outra forma de pagamento. Vamos reservar o seu pedido por mais dois dias.</p>

                    <p>Qualquer dúvida basta entrar em contato: <strong>atendimento@reverbcity.com</strong></p>


                    <br />
                    </div>');

            $corpo = IncluiPapelCarta("compranao",$texto);

            EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","",utf8_encode("Reverbcity - Compra não aprovada"), $corpo);

            GravaLogEstoque($SS_logadm,$nr_produto,$id_tamanho,"Removeu $nr_qtde","Re-abertura da compra $idgrp",$nr_qtde*-1);
        }
    }
}

//$str4 = "UPDATE pontos SET ST_PONTOS_PORC = '$statusn' WHERE NR_SEQ_COMPRA_PORC = $idgrp";
//$st4 = mysql_query($str4); 

$str = "UPDATE compras SET ST_COMPRA_COSO = '$statusn', DT_STATUS_COSO = '$data_hoje', ST_NOVOPGTO_COSO = null WHERE NR_SEQ_COMPRA_COSO = $idgrp";
$st = mysql_query($str);

mysql_close($con);

Header("Location: " . $_SERVER['HTTP_REFERER']);

?>