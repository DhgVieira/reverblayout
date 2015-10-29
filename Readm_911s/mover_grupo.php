<?php
include 'auth.php';
include 'lib.php';
$id =  request("nrcli");
$idc = request("idc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2a via Boleto</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.fonte1 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#000000
}
-->
</style>
</head>
<body>    	
<div id="Criar">
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
                        	<input type="hidden" name="id_cadcli" value="<? echo $id;?>" />
                            <input type="hidden" name="idc" value="<? echo $idc;?>" />
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
									 <tr> <td class="fonte1" style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td>
								<?   $i = $i+1;
								 }
                                 
                                 else if ($i == 1){?>
                                 		<td class="fonte1" style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td><?
                                     $i = $i+1;
								 }
								 else  if ($i == 2){?>
                                 		<td class="fonte1" style="max-width:350px" > <input type="checkbox" name="grupo[]" value="<?php echo $id_gp; ?>" />&nbsp;&nbsp;<b><?php echo $nm_gp; ?></b> <td></tr><?
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
</div>
</body>
</html>