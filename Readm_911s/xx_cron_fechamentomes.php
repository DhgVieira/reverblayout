<?php
include 'lib.php';

$primrodiacomp = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")))." 00:00:00";

$mesant = date("m",strtotime($primrodiacomp));

$subject  = "Reverbcity - Relatórios de fechamento do m�s ".$mesant;

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
<p>Seguem abaixo os links contendo os relatórios de fechamento do mês '.$mesant.':</p>
</div>    
<div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
Compras de Aniversariantes do mes:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_nivers.php">http://www.reverbcity.com/Readm_911s/rel_nivers.php</a><br /><br />
Novos Cadastros x Primeira Compra:<br />
<a href="http://www.reverbcity	.com/Readm_911s/rel_cadastros.php">http://www.reverbcity.com/Readm_911s/rel_cadastros.php</a><br /><br />
Venda de Produtos:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_produtos.php">http://www.reverbcity.com/Readm_911s/rel_produtos.php</a><br /><br />
Vendas para Lojistas:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_atacado.php">http://www.reverbcity.com/Readm_911s/rel_atacado.php</a><br /><br />
Vendas pelo Avise-me:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_aviseme.php">http://www.reverbcity.com/Readm_911s/rel_aviseme.php</a><br /><br />
Vendas do Produto do Dia:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_proddia.php">http://www.reverbcity.com/Readm_911s/rel_proddia.php</a><br /><br />
Resumo de Permutas / Promoções:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_publicidade.php">http://www.reverbcity.com/Readm_911s/rel_publicidade.php</a><br /><br />
Vendas por estados:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_estados.php">http://www.reverbcity.com/Readm_911s/rel_estados.php</a>
</div>
<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
Para acessá-los você precisa estar logado na adm Londrina com um usuário válido.
<br /> 
</p>';

$corpo = IncluiPapelCarta("sistema",$texto,"RELATÓRIOS DE FECHAMENTO DO MÊS $mesant");

$contatos = array('tony' => "contato@reverbcity.com",
                  'marcio' => "marcio@reverbcity.com",
                  'annai' => 'financeiro@reverbcity.com');
	
foreach ($contatos as $key => $contato) {
	EnviaMailer("atendimento@reverbcity.com","Reverbcity",$contato,$key,"",$subject,$corpo);
}
// EnviaMailer("atendimento@reverbcity.com","Reverbcity","marketing@reverbcity.com","Gabriela","",$subject,utf8_encode($corpo));
// EnviaMailer("atendimento@reverbcity.com","Reverbcity","diego@reverbcity.com","Diego","",$subject,utf8_encode($corpo));
?>