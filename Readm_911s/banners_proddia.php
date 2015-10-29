<?php
include 'auth.php';
include 'lib.php';
$aba = request("aba");
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src='scripts/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.ajaxQueue.js'></script>
<!-- <script type='text/javascript' src='scripts/autocomplete/thickbox-compressed.js'></script> -->
<script type='text/javascript' src='scripts/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.functions_proddia.js'></script>
<link rel="stylesheet" type="text/css" href="scripts/autocomplete/jquery.autocomplete.css" />
<script language="javascript">
function confirma_cat(idl) {
	var confirma = confirm("Confirma a Exclusao desse Agendamento?")
	if ( confirma ){
		document.location.href='banner_agend_del.php?&idl='+idl;
	} else {
		return false
	} 
}

</script>
<style>
  #cesta {
      width: 800px;
      float: left;
      font-family: Verdana;
      font-size: 12px;
  }

    ul.carrinho {
	padding:0;
	margin:0 0 0 0;
	}
	
	ul.carrinho li {
	width:98%; height:52px;
	border-bottom:1px dashed #dad7cf;
	padding:0px 0 5px 10px;
	list-style-type:none;
	margin-bottom:5px;
	float:inherit;
	}

	ul.carrinho li span {
	padding-top:3px;
	float:left;
	}
	
	ul.carrinho li div {
	padding:3px 10px 0 0;
	text-align:right;
	float:right;
	}
	
	ul.carrinho li div a img {
	border:none;
	}
    
    .form_pedido {
	width:80px; height:20px;
	border:1px solid #dad7cf;
	font:13px Verdana, Helvetica, sans-serif;
	padding:4px;
	}
</style>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Produto do Dia</li>
                      <li id="menuDepo" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='banners.php'">Banners</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
              
                    <form autocomplete="off" style="padding: 10px;" name="form1" id="form1" action="produtodia_fim.php" method="post">
                    <input type="hidden" name="cestaitens" id="cestaitens" value="" />
                    <input type="hidden" name="totalitens" id="totalitens" value="" />
                    <div id="Ver">
                    
                    <div style="width: 950px;">
                    
                    <div id="cesta">
                    
                    <p>
            			Escolha o Produto:<br />
            			<input type="text" id='imageSearch' name='imageSearch' class="form_pedido" style="width: 390px;" /><br />
                        Início da Publicação: <br />
                        <input type="text" id='dataini' name='dataini' class="form_pedido" value="<?php echo date("d/m/Y") ?> 6:00" style="width: 150px;" /><br />
                        Valor em Promo: <br />
                        <input type="text" id='valor' name='valor' class="form_pedido" style="width: 100px;" /><br />
                        Frete Grátis: <br />
                        <select name="fretegratis" id="fretegratis">
                            <option value="N" selected="selected">NÃO</option>
                            <option value="S">SIM</option>                            
                        </select> 
            			<input type="button" value="Inserir" id="Adicionar" class="form_pedido" style="margin: 5px 0 0 20px; height: 30px; vertical-align: middle;" />
            		</p>
                    <ul class="carrinho">
                    </ul>
                    <br /><br />
                    </div>
                    
                    <div id="resumo">
                    
                    <input type="submit" id="REGISTRAR" name="REGISTRAR" value="AGENDAR" class="form_pedido" style="width: 100px; height: 100px; margin: 30px 0 0 0;" />
                
                    </div>
                    
                    <ul class="noticias" style="width: 800px; clear: both;">
                  	   <li>
                       <span><strong>Produtos Agendados</strong> - Em <strong style="color: red;">Vermelho</strong> produto atual</span>
                       <div>Vendas</div>
                       <div style="width: 50px; text-align: center;">Exc</div>
                       <div style="width: 100px; text-align: center;">Frete Gr. novo</div>
                       <div style="width: 100px; text-align: center;">Vlr.Promo novo</div>
                       <div style="width: 100px; text-align: center;">Frete Gr. anter</div>
                       <div style="width: 100px; text-align: center;">Vlr.Promo anter</div>
                       </li>
                    <?php
                      $sql = "select NR_SEQ_AGENDAMENTO_BARC, DS_PRODUTO2_PRRC, DT_PUBLICACAO_BARC, VL_NOVOVALOR_BARC, DS_FRETEGRATIS_BARC,
                              VL_PROMOATUAL_BARC, DS_FRETEGRATUAL_BARC, NR_SEQ_PRODUTO_BARC
                              from banners_agendados, produtos
                              WHERE NR_SEQ_PRODUTO_BARC = NR_SEQ_PRODUTO_PRRC order by DT_PUBLICACAO_BARC desc limit 50";
                      $st = mysql_query($sql);

                      if (mysql_num_rows($st) > 0) {
                        $x = 0;
                        $dataant = "";
                        while($row = mysql_fetch_row($st)) {
                         $id_loca	   = $row[0];
                         $nm_prod	   = $row[1];
                         $dt_agen	   = $row[2];
                         $valorpro	   = $row[3];
                         $fretegra	   = $row[4];
                         $valoratu	   = $row[5];
                         $freteatu	   = $row[6];
                         $idprod	   = $row[7];
                         $cor = "";
                         
                         if (!greaterDate($dt_agen,date("Y-m-d G:i")) && $x==0){
                            $cor = " style=\"color: red;\"";
                            $x = 1;
                         }
                         
                         if (!$dataant){
                            $datefim_my = date("Y-m-d H:i:s");
                         }else{
                            $datefim_my = $dataant;
                         }
                         
                         $sql2 = "SELECT count(*) from compras, cestas
                          where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                          and ST_COMPRA_COSO <> 'C' AND NR_SEQ_PRODUTO_CESO = $idprod AND NR_SEQ_LOJA_COSO = $SS_loja 
                          and (DT_COMPRA_COSO BETWEEN '".date("Y-m-d H:i:s",strtotime($dt_agen))."' and '$datefim_my')";
                         $st2 = mysql_query($sql2);
                         $row2 = mysql_fetch_row($st2);
                         $totalvend = $row2[0];
                        ?>
                        <li>
                        <span><strong><?php echo date("d/m/Y H:i",strtotime($dt_agen));?></strong> - <strong<?php echo $cor; ?>><?php echo $nm_prod;?></strong></span>
                        <div>(<?php echo $totalvend;?>)</div>
                        <div><a href="compradores_proddia.php?idp=<?php echo $idprod; ?>&dti=<?php echo date("Y-m-d H:i:s",strtotime($dt_agen));?>&dtf=<?php echo $dataant;?>"><img src="img/compras_ver.gif" width="16" height="16" /></a></div>
                        <div style="width: 50px; text-align: center;">
                        <a href="#" title="deletar agendamento" onclick="confirma_cat(<?php echo $id_loca; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                        </div>
                        <div style="width: 100px; text-align: center;"><strong><?php echo $fretegra;?></strong></div>
                        <div style="width: 100px; text-align: center;"><strong>R$ <?php echo number_format($valorpro,2,",","");?></strong></div>
                        <div style="width: 100px; text-align: center;"><strong><?php echo $freteatu;?></strong></div>
                        <div style="width: 100px; text-align: center;"><strong>R$ <?php echo number_format($valoratu,2,",","");?></strong></div>
                        </li>
                        <?php
                        $dataant = date("Y-m-d H:i:s",strtotime($dt_agen));
                        }
                      }
                    ?>
                  </ul>
                    
                    </div> <!-- /ver -->
                                     
                    </form>
                    
            	</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);

function greaterDate($start_date,$end_date)
{
  $start = strtotime($start_date);
  $end = strtotime($end_date);
  if ($start-$end > 0)
    return 1;
  else
   return 0;
}
?>