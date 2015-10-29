<?php
ini_set("max_execution_time","360");
ini_set("memory_limit","16M");
set_time_limit(360);
error_reporting(1);

include 'auth.php';
include 'lib.php';

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

$totg = 0;
$comprasnao = "";

if($arquivo["name"])
{	
	$arq_dir = "temp/" . $arquivo["name"];
	move_uploaded_file($arquivo["tmp_name"], $arq_dir);
    

	$ponteiro = fopen($arq_dir, "r");

	while (!feof (utf8_decode($ponteiro))) {
	  $linha = str_replace("'","",$linha);
	  $linha = trim(fgets($ponteiro, 4096));
	  
	  if ($linha) {
		  if (strpos($linha,";") > 0) {
			$dados = explode(";", $linha);
			$nrprinc = $dados[4];
            
            $idgrp = (int)substr($nrprinc,10,10);
            
            $sql = "select NR_SEQ_COMPRA_COSO from compras where ST_COMPRA_COSO = 'A' AND DS_FORMAPGTO_COSO = 'boleto' 
                    and NR_SEQ_COMPRA_COSO = $idgrp";
            $st = mysql_query($sql);
            if (mysql_num_rows($st) > 0) {

                date_default_timezone_set('America/Sao_Paulo');
                //crio a data de hoje
                $data_hoje = date("Y-m-d H:i:s");

                $str2 = "UPDATE compras SET DT_PAGAMENTO_COSO = '$data_hoje' WHERE NR_SEQ_COMPRA_COSO = $idgrp";
                $st2 = mysql_query($str2);
            
            	$sql3 = "SELECT NR_SEQ_CADASTRO_CASO, VL_TOTAL_COSO, VL_FRETE_COSO, TP_CADASTRO_CACH, DS_TWITTER_CACH, DS_NOME_CASO, DS_EMAIL_CASO,
                         DS_DDDCEL_CASO, DS_CELULAR_CASO, ST_ENVIOSMS_CACH
                         FROM cadastros, compras WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND NR_SEQ_COMPRA_COSO = $idgrp";
            	$st3 = mysql_query($sql3);
            	if (mysql_num_rows($st3) > 0) {
            		$row3 = mysql_fetch_row($st3);
            		$nrcad = $row3[0];
            		$vlcom = $row3[1];
            		$frete = $row3[2];
                    $tipocli = $row3[3];
                    $dstwitter = trim($row3[4]);
                    $nomet  = utf8_decode($row3[5]);
                    $email = $row3[6];
                    
                    $celddd  = $row3[7];
                    $celular = $row3[8];
                    $enviar  = $row3[9];
                    
                    $loginspl = explode(" ", $nomet);
                    $nome = $loginspl[0];
            	}
                
                if ($dstwitter){
                    if (strlen($dstwitter) > 1){
                        EnviaEmail("atendimento@reverbcity.com", "marcio@reverbcity.com", "Compra realizada por usuário do Twitter: $dstwitter", "Seguir: http://twitter.com/$dstwitter");
                    }
                }
                    
            	$sql4 = "SELECT DS_BILHETE_BIRC, DS_NOME_CASO, DS_EMAIL_CASO, NR_SEQ_BILHETES_BIRC from bilhetes, cadastros where NR_SEQ_CADCRIADOR_BIRC = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_BIRC = $idgrp AND ST_STATUS_BIRC = 'A'";
            	$st4 = mysql_query($sql4);
            	if (mysql_num_rows($st4) > 0) {
            		$row4 = mysql_fetch_row($st4);
            		$bilhete = $row4[0];
            		$nomebi  = utf8_decode($row4[1]);
            		$emailbi = $row4[2];
            		$nrbilhe = $row4[3];
            		$subject  = "ReverbCity - Vale Presente";
                    
                    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                                    <p>Olá <strong>'.$nomebi.'</strong>!</p>
                    
                                    <p>O vale-presente só poderá ser usado integralmente em uma única compra. Caso sua compra exceda o valor do vale, você poderá pagar a diferença.</p>
                                                                        
                                    <p>O código do Vale Presente que você deverá usar no nosso site:  <strong>'.$bilhete.'</strong></p>
                                    
                                    <p><strong><a href="http://www.reverbcity.com/valepresente/valepresente_1.php">Clique aqui</a></strong> para enviar o vale-presente para alguém.</p>
                              </div>';
                            
                    $corpo = IncluiPapelCarta("valepres",$texto);

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
            	
            		// @mail($emailbi, $subject, $corpo, $headers);
            		
            		$str5 = "UPDATE bilhetes SET ST_STATUS_BIRC = 'L' WHERE NR_SEQ_BILHETES_BIRC = $nrbilhe";
            		$st5 = mysql_query($str5);
            	}
                
                $texto = utf8_encode('<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
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
                              </div>');
                              
                $corpo = IncluiPapelCarta("confpgto",$texto);
                 
                EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","","ReverbCity - Confirmação de Pagamento!", $corpo);
                
                if ($enviar == "S"){
                    $celddd = str_replace("(","",$celddd);
                    $celddd = str_replace(")","",$celddd);
                    $celddd = str_replace(" ","",$celddd);
                    
                    $celular = str_replace("-","",$celular);
                    $celular = str_replace(".","",$celular);
                    $celular = str_replace("/","",$celular);
                    $celular = str_replace("=","",$celular);
                    $celular = str_replace(" ","",$celular);
                    
                    $celularcomp = $celddd.$celular;
            
                    if (substr($celularcomp,0,1) == "0"){
                        $celularcomp = substr($celularcomp,1,strlen($celularcomp));
                    }
                    
                    if (strlen($celularcomp)==10 || strlen($celularcomp)==11){
                        $textosms = "Pagamento Confirmado! Sua compra de numero $idgrp foi paga com sucesso, obrigado! Logo estaremos enviando o seu pedido Reverbcity";
                        EnviaSMS(0,$nrcad,$celularcomp,$textosms);
                    }
                }          
                
                $str6 = "UPDATE compras SET ST_COMPRA_COSO = 'P', DT_STATUS_COSO = sysdate(), ST_NOVOPGTO_COSO = null WHERE NR_SEQ_COMPRA_COSO = $idgrp";
                $st6 = mysql_query($str6);
                
                GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Compra Capturada e Status alterado pelo sistema de boletos - $idgrp ST P");
                
                $totg++;
             }else{
                $comprasnao .= $idgrp."\\n";
             }
		  }
		}
	}
	
	fclose ($ponteiro);
	
	if (file_exists($arq_dir)) unlink($arq_dir);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Importou arquivo para baixa de boletos");

if (!$comprasnao) $comprasnao = "Nenhuma";

mysql_close($con);
?>
<script language="JavaScript">
   alert('Baixa Finalizada!\n\nTotal de Compras processadas: <?php echo $totg ?>\n\nCompras NAO processadas:\n\n<?php echo $comprasnao; ?>');
   top.window.location.href=('index.php');
</script>