<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$idcli = request("idcli");
$nrseq = request("nrseq");

$valor = 0;
$sql = "select VL_LANCAMENTO_CRSA from contacorrente where NR_SEQ_CONTA_CRSA = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $valor = $row[0];
}

$str = "DELETE FROM contacorrente WHERE NR_SEQ_CONTA_CRSA = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou crédito");

$sql = "select DS_NOME_CASO from cadastros where NR_SEQ_CADASTRO_CASO = $idcli";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $nome = $row[0];
}

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
            <p>O funcionário <strong>'.utf8_decode($SS_login).'</strong> realizou a seguinte movimentação:</p> 
          </div>    
          <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                <strong>Cliente:</strong> '.utf8_decode($nome).'<br />
                <strong>Data:</strong> '.date("d/m/Y G:i").'<br />
                <strong>Tipo:</strong> EXCLUSÃO<br />
                <strong>Valor:</strong> R$ '.number_format($valor,2,",","").'<br />
                <strong>Descrição:</strong> Excluiu lançamento do cliente
          </div>
          ';
$corpo = IncluiPapelCarta("sistema",$texto,"MOVIMENTAÇÃO DE CRÉDITO REALIZADA");

EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","","Movimentacao nos Creditos",utf8_encode($corpo));
EnviaMailer("atendimento@reverbcity.com","Reverbcity","compras@reverbcity.com","Compras","janaina@reverbcity.com","Movimentacao nos Creditos",utf8_encode($corpo));


mysql_close($con);

Header("Location: sortecred_det.php?idc=$nrseq");
exit();
?>
