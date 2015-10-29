<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "grupos_ordem_todos.php";
if (!$pagina) {
 $pagina = 1;
}
?>
<?php include 'topo.php'; ?>
<style>

#contentLeft {
	width: 100%;
    margin: 10px;
}

#contentLeft li {
    width: 134px;
    text-align: center;
	list-style-type:none;
	margin: 4px;
	padding: 2px;
	background-color:#E1E9E9;
	border: #CCCCCC solid 1px;
	color:#fff;
    float: left;
    display:inline;
}

</style>


<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings&pg=<?php echo $pagina ?>'; 
			$.post("grupos_ordem_todos_up.php", order, function(theResponse){
				//$("#contentRight").html(theResponse);
			}); 															 
		}								  
		});
	});

});	
</script>
<script type="text/javascript" src="scripts/jquery-ui-1.7.1.custom.min.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Ordem dos Produtos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos.php';">Produtos</li>
                      <li id="abaPos7" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem.php';">Ordem Camisetas</li>
                      <li id="abaPos2" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem_lcto.php';">Ordem Lan&ccedil;amentos</li>
                      <li id="abaPos3" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem_clas.php';">Ordem Cl&aacute;ssicos</li>
                      <li id="abaPos4" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem_repr.php';">Ordem Reprint</li>
                      <li id="abaPos5" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem_sale.php';">Ordem Sale</li>
                      <li id="abaPos6" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='grupos_ordem_home.php';">Ordem Home</li>
                      <li id="abaPos" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Ordem Todos</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
        		<div id="Pos" style="width:1050px">                    
                	<div style="clear: both; margin: 20px;">Clique e arraste as fotos para trocar a ordem.</div>
                    <div id="contentLeft">
			             <ul>
						 <?php
						  $num_por_pagina = 500;
						  
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;

                $sql = "SELECT 
    `produtos`.`NR_SEQ_PRODUTO_PRRC`,
    `produtos`.`DS_EXT_PRRC`,
    `produtos`.`VL_PRODUTO_PRRC`,
    `produtos`.`DS_PRODUTO2_PRRC`,
    `produtos`.`TP_DESTAQUE_PRRC`,
    `produtos`.`DS_FRETEGRATIS_PRRC`,
    `produtos`.`NR_SEQ_CATEGORIA_PRRC`,
    `produtos`.`NR_SEQ_TIPO_PRRC`,
    `produtos`.`VL_PROMO_PRRC`,
    `produtos`.`DS_GENERO_PRRC`,
    `produtos`.`DS_CORES_PRRC`,
    `produtos`.`DS_FRETEGRATIS_PRRC`,
    `estoque`.`NR_QTDE_ESRC`,
    `tamanhos`.`NR_SEQ_TAMANHO_TARC`
FROM
    `produtos`
        INNER JOIN
    `estoque` ON produtos.NR_SEQ_PRODUTO_PRRC = estoque.NR_SEQ_PRODUTO_ESRC
        LEFT JOIN
    `tamanhos` ON tamanhos.NR_SEQ_TAMANHO_TARC = estoque.NR_SEQ_TAMANHO_ESRC
        INNER JOIN
    `produtos_categoria` ON produtos.NR_SEQ_CATEGORIA_PRRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC
        INNER JOIN
    `menu_site_has_produtos_categoria` ON menu_site_has_produtos_categoria.produtos_categoria_NR_SEQ_CATEGPRO_PCRC = produtos_categoria.NR_SEQ_CATEGPRO_PCRC
        INNER JOIN
    `menu_site` ON menu_site_has_produtos_categoria.menu_site_idmenu = menu_site.idmenu
WHERE
    (NR_SEQ_LOJAS_PRRC = 1)
        AND (DS_CLASSIC_PRRC = 'N')
        AND (ST_PRODUTOS_PRRC = 'A')
        AND (NR_QTDE_ESRC > 0)
        AND (NR_SEQ_TIPO_PRRC NOT IN (4 , 24, 139, 140, 65, 59))
GROUP BY `NR_SEQ_PRODUTO_PRRC`
ORDER BY -- `DS_CATEGORIA_PCRC` ASC , 
`NR_ORDEM_TODOS_PRRC` ASC";
                      
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_foto	   = $row[0];
							 $ds_ext	   = $row[1];

               $select_fotos = "SELECT
                  NR_SEQ_FOTO_FORC,
                  NR_SEQ_PRODUTO_FORC,
                  DS_EXT_FORC
                FROM
                   fotos
                WHERE
                   NR_SEQ_PRODUTO_FORC = ". $id_foto ."
                ORDER BY
                        NR_ORDEM_FORC ASC
                LIMIT 2";
                $stFoto = mysql_query($select_fotos);
                $fotoRow = mysql_fetch_row($stFoto);

							?>
                            <li id="recordsArray_<?php echo $id_foto; ?>">
                              <img src="/thumb/fotosprodutos/1/129/150/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" border="0" width="129" height="150" />
                            </li>
							<?php
							}
						  }
						?>
                      </ul>
		              </div>
                      <div style="clear: both; margin: 20px;">&nbsp;</div>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao" style="width: 900px;">
						<?php
                        $consulta = "select count(*)
                                 from produtos, estoque, produtos_tipo WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1
                                 AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC ";
                        $consulta .= "AND (NR_SEQ_TIPO_PRRC = 6 or NR_SEQ_TIPO_PRRC = 4) ";
                        $consulta .= "group by NR_SEQ_PRODUTO_PRRC ";
                          
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&aba=2\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&aba=2\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&aba=2\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> 

                    <script>
					  defineAba("abaPos","Pos");
					  defineAbaAtiva("abaPos");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>