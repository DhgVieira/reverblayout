<?php
include 'auth.php';
include 'lib.php';
$pTipo = request("tipo");

//QUERY  
$sql = "SELECT NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC   
        FROM  produtos, estoque
		WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TIPO_PRRC = ".$pTipo."  
        AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A'
		ORDER BY DS_PRODUTO2_PRRC";            

//EXECUTA A QUERY               
$sql = mysql_query($sql);       

$row = mysql_num_rows($sql);    

//VERIFICA SE VOLTOU ALGO 
if($row) {                
   //XML
   $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
   $xml .= "<produtos>\n";               
   
   //PERCORRE ARRAY            
   for($i=0; $i<$row; $i++) {  
      $codigo    = mysql_result($sql, $i, "NR_SEQ_PRODUTO_PRRC"); 
	  $descricao = mysql_result($sql, $i, "DS_PRODUTO2_PRRC");
      $xml .= "<produto>\n";     
      $xml .= "<codigo>".$codigo."</codigo>\n";                  
      $xml .= "<descricao>".str_replace("&","e",$descricao)."</descricao>\n";         
      $xml .= "</produto>\n";    
   }//FECHA FOR                 
   
   $xml.= "</produtos>\n";
   
   //CABEÇALHO
   Header("Content-type: application/xml; charset=utf-8"); 
}//FECHA IF (row)                                               

//PRINTA O RESULTADO  
echo $xml;            
?>