<?php
include 'auth.php';
include 'lib.php';

$assunto = request("titulo");
$corpo = request("FCKeditor1");

$sql = "select NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC
    	 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque 
    	 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
    	 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
    	 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
         NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC and NR_QTDE_ESRC > 0
    	 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_prod	   = $row[0];
        $idtamanho	   = $row[1];
        
        $sql3 = "select DS_EMAIL_AVRC, NR_SEQ_AVISEME_AVRC from aviseme where NR_SEQ_PRODUTO_AVRC = $id_prod and NR_SEQ_TAMANHO_AVRC = $idtamanho AND ST_AVISO_AVRC = 'N'";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
	  	   while($row3 = mysql_fetch_array($st3)) {
               $idav = $row3["NR_SEQ_AVISEME_AVRC"];
               $sqlcad = "select DS_NOME_CASO, DS_EMAIL_CASO from cadastros where DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."'";
               $stcad = mysql_query($sqlcad);
               
               $sql2 = "SELECT DS_PRODUTO2_PRRC, DS_CATEGORIA_PTRC from produtos, produtos_tipo 
                       WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = $id_prod";
               $st2 = mysql_query($sql2); 
               if (mysql_num_rows($st2) > 0) {
                    $row2 = mysql_fetch_row($st2);
                    $ds_prod	   = $row2[0];
                    $ds_categoria  = $row2[1];    
                    $ds_categoria = str_replace("&","e;",$ds_categoria);
                    $ds_prod_url = str_replace("&","e;",$ds_prod);
               }
                
               $linkproduto = 'produto/'.urlencode($ds_prod_url).'/'.$id_prod;
               
               $sql2 = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $id_prod order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC LIMIT 1";
               $st2 = mysql_query($sql2);
               if (mysql_num_rows($st2) > 0) {
                    $row2 = mysql_fetch_row($st2);
                    $idfoto = $row2[0];
                    $extens = $row2[1];
               }
               
               if (mysql_num_rows($stcad) > 0) {
                   $rowcad = mysql_fetch_row($stcad);
                   $ds_nome = $rowcad[0];
                   $ds_mail = $rowcad[1];
                   
                   if (strpos($ds_nome," ") > 0){
                        $ds_nome = substr($ds_nome,0,strpos($ds_nome," "));
                   }
                   
                   $corpo_msg = str_replace("##NOME##","$ds_nome",$corpo);
                   $corpo_msg = str_replace("##IMGPRODUTO##","<a href=\"http://www.reverbcity.com/$linkproduto\"><img src=\"http://www.reverbcity.com/arquivos/uploads/fotosprodutos/$idfoto.$extens\" width=\"265\" border=\"0\"></a>",$corpo_msg);

                   EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$ds_mail,"","",$assunto,$corpo_msg);
                   
                   $str = "update aviseme set ST_AVISO_AVRC = 'S' where NR_SEQ_AVISEME_AVRC = $idav";
                   $st4 = mysql_query($str);
               }else{
                   $corpo_msg = str_replace("##NOME##","",$corpo);
                   $corpo_msg = str_replace("##IMGPRODUTO##","<a href=\"http://www.reverbcity.com/$linkproduto\"><img src=\"http://www.reverbcity.com/arquivos/uploads/produtos/$idfoto.$extens\" width=\"265\" border=\"0\"></a>",$corpo_msg);
                   
                   $ds_mail = $row3["DS_EMAIL_AVRC"];
                   
                   EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$ds_mail,"","",$assunto,$corpo_msg);
                   
                   $str = "update aviseme set ST_AVISO_AVRC = 'S' where NR_SEQ_AVISEME_AVRC = $idav";
                   $st4 = mysql_query($str);
               }
          }
       }
    }
}
GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou e-mail avise-me para todos");

mysql_close($con);
?>
<script language="JavaScript">
   alert('Email de aviso enviado para TODOS com Sucesso!');
   window.location.href=('grupos_aviso.php');
</script>
