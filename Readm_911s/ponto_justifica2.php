<?php
include 'auth.php';
include 'lib.php';

$acao = request("tipo");
$SS_func = (isset($_SESSION["SS_nrfunc"])) ? $_SESSION["SS_nrfunc"] : 0;
$data = request("data");
$just = request("just");

$sql2 = "select DS_FUNCIONARIO_FURC from funcionarios, funcionarios_ponto_just where
		NR_SEQ_FUNCIONARIO_FURC = NR_SEQ_FUNCIONARIO_JUPO and NR_SEQ_FUNCIONARIO_FURC = $SS_func limit 1";
$st = mysql_query($sql2);
if (mysql_num_rows($st) > 0) {
    $row2 = mysql_fetch_row($st);
    $funcionario = $row2[0];
}

if ($acao == "S"){
    $str = "update funcionarios_ponto_just set ST_JUSTIFICADO_JUPO = 'S', DT_JUSTIFICATIVA_JUPO = sysdate() where DT_PONTO_JUPO = '$data' and 
            NR_SEQ_FUNCIONARIO_JUPO = $SS_func";
    $stf = mysql_query($str);
}else{
    $str = "update funcionarios_ponto_just set ST_JUSTIFICADO_JUPO = 'S', DS_JUSTIFICATIVA_JUPO = '$just', DT_JUSTIFICATIVA_JUPO = sysdate() where
            DT_PONTO_JUPO = '$data' and NR_SEQ_FUNCIONARIO_JUPO = $SS_func";
    $stf = mysql_query($str);
    
    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>O funcionário <strong>'.utf8_decode($funcionario).'</strong> efetuou uma justificativa referente para dia: <strong>'.date("d/m/Y",strtotime($data)).'</strong></p> 
                
                <p>Descrição:</p>
              </div>    
              <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                   '.utf8_decode($just).'
              </div>
                <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                Para acessar o ponto do funcionário, clique no link abaixo:
                <br /><br />
                http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$SS_func.'&mes='.date("m",strtotime($data)).'&ano='.date("Y",strtotime($data)).' ou <a href=http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$SS_func.'&mes='.date("m",strtotime($data)).'&ano='.date("Y",strtotime($data)).'>clique aqui</a>
                <br /><br /></p>
              ';
    $corpo = IncluiPapelCarta("sistema",$texto,"JUSTIFICA&Ccedil;&Atilde;O DE HORA EXTRA");
    
    EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","","Ponto Jusitificado: $funcionario",$corpo);
}

Header("Location: index.php");
exit();

mysql_close($con);
?>