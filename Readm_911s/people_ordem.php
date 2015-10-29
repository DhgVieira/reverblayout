<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "people_ordem.php";
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
    width: 54px;
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
			$.post("people_ordem_up.php", order, function(theResponse){
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
                      <li id="menuDepo" class="abaativa">People</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='people.php';">Fotos Cadastradas</li>
                      <li id="abaPos" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Posição das Fotos</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
        		<div id="Pos" style="width:1050px">                    
                	<div style="clear: both; margin: 20px;">Clique e arraste as fotos para trocar a ordem. Para visualizar a foto no tamanho original clique 2x sobre a mesma.</div>
                    <div id="contentLeft">
			             <ul>
						 <?php
						  $num_por_pagina = 105;
						  
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_FOTO_FORC, DT_CADASTRO_FORC, DS_NOME_FORC, ST_PEOPLE_FORC, DS_NOME_CASO, DS_EXT_FORC, NR_POSICAO_FORC 
						  from me_fotos, cadastros 
						  WHERE NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO 
						  and DS_PEOPLE_FORC = 'S' 
						  and ST_PEOPLE_FORC = 'A'
						  order by NR_POSICAO_FORC asc, DT_CADASTRO_FORC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_foto	   = $row[0];
					         $dt_cad	   = $row[1];
							 $ds_foto	   = $row[2];
							 $status	   = $row[3];
							 $ds_autor	   = $row[4];
							 $ds_ext	   = $row[5];
							 $posicao      = $row[6];
							?>
                            <li id="recordsArray_<?php echo $id_foto; ?>" ondblclick="window.open('../images/me/fotos/<?php echo $id_foto; ?>.<?php echo $ds_ext; ?>')"><img src="../images/me/fotos/<?php echo $id_foto; ?>p.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></li>
                            
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
                        $consulta = "SELECT COUNT(*) FROM me_fotos, cadastros WHERE NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO and DS_PEOPLE_FORC = 'S' and ST_PEOPLE_FORC = 'A'";
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
<!-- //***** POS FIM-->                   

                    <script>
					  defineAba("abaPos","Pos");
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