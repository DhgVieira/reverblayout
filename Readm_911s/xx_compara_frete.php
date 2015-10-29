<?php
include 'lib.php';
$dia = date("d"); 
$mes = date("m"); 
$ano = date("Y"); 




$sql_vendas = "SELECT 
			    SUM(VL_FRETE_COSO) AS TOTAL_FRETE,
			    SUM(VL_FRETECUSTO_COSO) AS CUSTO,
			    (SELECT 
			            COUNT(NR_SEQ_COMPRA_COSO)
			        FROM
			            compras
			        WHERE
			            VL_FRETE_COSO = 0
			                AND day(DT_STATUS_COSO) = $dia
                      AND month(DT_STATUS_COSO) = $mes
                      AND year(DT_STATUS_COSO) = $ano
                      AND ST_COMPRA_COSO = 'V') AS TOTAL_GRATIS,
          (SELECT 
              COUNT(NR_SEQ_COMPRA_COSO)
            FROM 
               compras
              WHERE
                      day(DT_STATUS_COSO) = $dia
                      AND month(DT_STATUS_COSO) = $mes
                      AND year(DT_STATUS_COSO) = $ano
                      AND ST_COMPRA_COSO = 'V') AS TOTAL_PEDIDOS,
          (SELECT 
            COUNT(NR_SEQ_COMPRA_COSO)
          FROM 
            compras 
          WHERE
              day(DT_STATUS_COSO) = $dia
              AND month(DT_STATUS_COSO) = $mes
              AND year(DT_STATUS_COSO) = $ano
              AND ST_COMPRA_COSO = 'V'
              AND DS_RASTREAMENTO_COSO LIKE 'pg%') AS TOTAL_PAC,

          (SELECT 
            COUNT(NR_SEQ_COMPRA_COSO)
          FROM 
            compras 
          WHERE
              day(DT_STATUS_COSO) = $dia
              AND month(DT_STATUS_COSO) = $mes
              AND year(DT_STATUS_COSO) = $ano
              AND ST_COMPRA_COSO = 'V'
              AND DS_RASTREAMENTO_COSO LIKE 'si%') AS TOTAL_SEDEX,

        (SELECT 
            COUNT(NR_SEQ_COMPRA_COSO)
          FROM 
            compras 
          WHERE
              day(DT_STATUS_COSO) = $dia
              AND month(DT_STATUS_COSO) = $mes
              AND year(DT_STATUS_COSO) = $ano
              AND ST_COMPRA_COSO = 'V'
              AND DS_RASTREAMENTO_COSO LIKE 'sw%') AS TOTAL_ESEDEX,

        (SELECT 
            COUNT(NR_SEQ_COMPRA_COSO)
          FROM 
            compras 
          WHERE
              day(DT_STATUS_COSO) = $dia
              AND month(DT_STATUS_COSO) = $mes
              AND year(DT_STATUS_COSO) = $ano
              AND ST_COMPRA_COSO = 'V'
              AND DS_RASTREAMENTO_COSO LIKE 'jg%') AS TOTAL_REG,

        (SELECT 
            COUNT(NR_SEQ_COMPRA_COSO)
          FROM 
            compras 
          WHERE
              day(DT_STATUS_COSO) = $dia
              AND month(DT_STATUS_COSO) = $mes
              AND year(DT_STATUS_COSO) = $ano
              AND ST_COMPRA_COSO = 'V'
              AND DS_RASTREAMENTO_COSO REGEXP '^[0-9]') AS TOTAL_TAM

			FROM
			    compras
			WHERE
			    day(DT_STATUS_COSO) = $dia
          AND month(DT_STATUS_COSO) = $mes
          AND year(DT_STATUS_COSO) = $ano
          AND VL_FRETECUSTO_COSO IS NOT NULL
          AND ST_COMPRA_COSO = 'V'";



  $st = mysql_query($sql_vendas);
  if (mysql_num_rows($st) > 0) {
            $row = mysql_fetch_row($st);
            
            $total_frete  = $row[0];
            $custo_frete  = $row[1];
            $total_gratis = $row[2];
            $total_pedido = $row[3];
            $total_pac    = $row[4];
            $total_sedex  = $row[5];
            $total_esedex = $row[6];
            $total_regis  = $row[7];
            $total_tam    = $row[8];
          
        }
   $diferenca = $total_frete - $custo_frete;

   if ($total_gratis == "" ) {
    $total_gratis = 0;
   }

   $sql_fretes = "SELECT
   					NR_SEQ_COMPRA_COSO,
   					VL_FRETE_COSO,
   					VL_FRETECUSTO_COSO
   				  FROM 
   				  	compras 
   				  WHERE 
   				   day(DT_STATUS_COSO) = $dia
            AND month(DT_STATUS_COSO) = $mes
            AND year(DT_COMPRA_COSO) = $ano
            AND VL_FRETECUSTO_COSO IS NOT NULL
            AND ST_COMPRA_COSO = 'V'";
   $st_frete = mysql_query($sql_fretes);

   if (mysql_num_rows($st) > 0) {
   		$row_frete = mysql_fetch_row($st);

   		$compra 	 = $row_frete[0];
   		$valor_frete = $row_frete[1];
   		$valor_custo = $row_frete[2];

   		$valor_final = $valor_frete - $valor_custo;
   }


 	if($valor_final < 0){

 		$mensagem .= utf8_encode("<p>A Compra <b>". $compra . "</b> teve custo de frete maior que o valor cobrado, diferença de <b>R$ " .  number_format($valor_final, 2, ",", ".") ." </b> </p>");
 	}

$mensagem .= utf8_encode("<p> Valor Total de Frete R$<b> " .  number_format($total_frete, 2, ",", ".") ." </b> </p>");
$mensagem .= utf8_encode("<p> Valor Total de Custo de Frete (Real) R$ <b> " .  number_format($custo_frete, 2, ",", ".") ." </b> </p>");
if($diferenca < 0){
	$mensagem .= "<p> Valor da Diferença R$ -<b> " .  number_format($diferenca, 2, ",", ".") ." </b> </p>";
}else{
	$mensagem .= "<p> Valor da Diferença R$ <b> " .  number_format($diferenca, 2, ",", ".") ." </b> </p>";
}
$mensagem .= "<p> Total de Pedidos Com Frete Grátis : <b> " .  $total_gratis ." </b> </p>";
$mensagem .= utf8_encode("<p> Total de Pedidos Enviados : <b> " .  $total_pedido ." </b> </p>");
$mensagem .= utf8_encode("<p> Total de Pedidos PAC : <b> " .  $total_pac ." </b> </p>");
$mensagem .= utf8_encode("<p> Total de Pedidos SEDEX : <b> " .  $total_sedex ." </b> </p>");
$mensagem .= utf8_encode("<p> Total de Pedidos E-SEDEX : <b> " .  $total_esedex ." </b> </p>");
$mensagem .= utf8_encode("<p> Total de Pedidos REGISTRADO : <b> " .  $total_regis ." </b> </p>");
$mensagem .= utf8_encode("<p> Total de Pedidos TAM : <b> " .  $total_tam ." </b> </p>");



$contatos = array('gustavo' => "gustavo@reverbcity.com",
                  'tony' => "contato@reverbcity.com",
                  'miri' => "atendimento@reverbcity.com");


$data_formatada = $dia. " / ".$mes. " / ". $ano;

	foreach ($contatos as $key => $contato) {
		$corpo = IncluiPapelCarta("sistema",$mensagem,'Relatório Frete' . " - $data_formatada"); 
		EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",'Relatório Frete' . " - $data_formatada", $corpo);
	}

?>