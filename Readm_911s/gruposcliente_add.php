<?php
include 'auth.php';
include 'lib.php';

$id =  request("id_cadcli");
?>

<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Clientes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <!-- <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes.php?aba=2';">Clientes Grupos</li> -->
                      <li id="abaAssin" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Adicionar Ao Grupo</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                <table><tr>
<?php                    
                    $sql = "select NR_SEQ_GRUPO_CADGP from cadastros_grupocad where NR_SEQ_CADASTRO_CADGP = '$id'";
					$st = mysql_query($sql);
					if (mysql_num_rows($st) >0 ){
						echo '<td>&nbsp;&nbsp;&nbsp;Cliente '.$id.'. Faz parte dos grupos.</td></tr><tr><td>';
						while ($row = mysql_fetch_row($st)){
							$idgg = $row[0];
							
							$sql2 = "select DS_GRUPO_GPCAD from grupocad where NR_SEQ_GRUPO_GPCAD = '$idgg'";
							$st2 = mysql_query($sql2);
							if (mysql_num_rows($st2) >0 ){
									$row = mysql_fetch_row($st2);
									$dsgg = $row[0];
									echo $dsgg.'<br />';
							}
						
						}
					echo '</td></tr><td>----------------------------------------</td>';	
					}
					
?>                    
                    <div id="Add">
                    	
                         <ul class="noticias">
                         <table style="min-width:500px">
                         <form action="gruposcliente_add2.php" method="post" name="frmmail" id="frmmail">
                        	<input type="hidden" name="id_cadcli" value="<? echo $id;?>">
                            
                            <?
							  
                              $sql = "select NR_SEQ_GRUPO_GPCAD, DS_GRUPO_GPCAD
							  			from grupocad";
                              $st = mysql_query($sql);
    							$i = 0;
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_gp	   = $row[0];
                                 $nm_gp	   = $row[1];
								 if ($i == 0 ){?>
									 <tr> <td style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td>
								<?   $i = $i+1;
								 }
                                 
                                 else if ($i == 1){?>
                                 		<td style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td><?
                                     $i = $i+1;
								 }
								 else  if ($i == 2){?>
                                 		<td style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td></tr><?
                                     $i = 0;
								 }
                                ?>
                                	
                                <?
                                }
								?><tr> <td colspan="3" align="center">
                                 
                                	<input type="submit" value="Adicionar" class="form01" style="height:25px;"> </td></tr>
                               
								</form>
                                </table>
								<?
								
                              }
							  
							  else{
								  echo 'Nenhum grupo registrado';
							  }
                            ?>
                          </ul>
                          
                          
                    </div>

                    
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
