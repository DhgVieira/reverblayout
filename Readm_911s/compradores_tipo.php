<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; 

$tipo = request("tip");
$cat = request("cat");

if ($tipo){
    $sql = "select DS_CATEGORIA_PTRC from produtos_tipo WHERE NR_SEQ_CATEGPRO_PTRC = $tipo";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) { 
        $row = mysql_fetch_row($st);
        $dstipo = $row[0];
    }
}

if ($cat){
    $sql = "select DS_CATEGORIA_PCRC from produtos_categoria WHERE NR_SEQ_CATEGPRO_PCRC = $cat";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) { 
        $row = mysql_fetch_row($st);
        $dscat = $row[0];
    }
}
?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Compradores</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa" style="width:300px"><?php echo $dstipo; ?> - <?php echo $dscat; ?></li>
                      <li><input type="Button" value="Enviar p/ Todos (SMS)" onClick="document.location.href=('envia_sms_compradores.php?tip=<?php echo $tipo; ?>&cat=<?php echo $cat; ?>');" class="form00" style="width:120px;height:23px;margin: 0;" /></li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF">
                    <table class="textostabelas" width="800" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left"> 
                               <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                                    <tr>
                                        <td align="center" width="128"><strong>Me</strong></td>
                                        <td align="left" width="112"><strong>Nome</strong></td>
                                        <td align="left" width="162"><strong>E-mail</strong></td>
                                        <td align="left" width="75"><strong>Telefone</strong></td>
                                        <td align="center" width="47"><strong>Aviso</strong></td>
                                        <td align="center" width="30"><strong>SMS</strong></td>
                                    </tr>  
                                </table> 
                             </td>
                        </tr>    
                        <tr>
                            <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                                
								<?php
                                $compra = "select 
                                NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO, DS_DDDFONE_CASO, DS_FONE_CASO, DS_CELULAR_CASO
                                from cadastros, compras, cestas, produtos
                                where
                                	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
                                	NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
                                	NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' ";
                                if ($tipo) $compra .= "AND NR_SEQ_TIPO_PRRC = $tipo ";
                                if ($cat) $compra .= "and NR_SEQ_CATEGORIA_PRRC = $cat ";
                                $compra .= "group by NR_SEQ_CADASTRO_CASO";

                                $compraST = mysql_query($compra);
                                if (mysql_num_rows($compraST) > 0) { 
                                    while($row = mysql_fetch_row($compraST)) {
                                        $datCompra = $row[1];
                                        $nrCompra = $row[0];
                                        $nome = $row[2];
                                        $email = $row[3];
                                        $status = $row[4];
										$ddd = $row[5];
										$fone = $row[6];
                                        $celular      = $row[7];
                                        
                                        $celular = str_replace("-","",$celular);
                                        $celular = str_replace(".","",$celular);
                                        $celular = str_replace("/","",$celular);
                                        $celular = str_replace("=","",$celular);
                                        $celular = str_replace(" ","",$celular);
                                ?>
                                            
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                                    <tr>
                                                        <td align="center" width="130" nowrap="nowrap"><a target="_blank" href="http://www.reverbcity.com/me/me_perfil.php?idme=<?php echo $nrCompra; ?>"><?php echo $nrCompra; ?></a></td>
                                                        <td align="left" width="115"><?php echo $nome; ?></td>
                                                        <td align="left" width="159" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                                        <td align="left" width="77"><?php echo $ddd.' - '.$fone; ?></td>
                                                        <td align="center" width="60"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Compras" class="thickbox"><img src="img/ico_check.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                                        <td align="center" width="45"><a href="aviso.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar aviso" border="0" /></a></td>
                                                        <?php if (strlen($celular)==8) { ?>
                                                        <td align="center" width="30"><a href="envia_sms.php?idcli=<?php echo $nrCompra;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                                        <?php }else{ ?>
                                                        <td align="center" width="30">&nbsp;</td>
                                                        <?php } ?>
                                                    </tr>
                                        		</table>  
                                           
                                        <?php	
                                     } // FIM WHILE
									 ?> 
									
									 
								<?php	 
                               } // FIM IF
                               else{                
                               ?>
                                <table width="44%" align="left">
                                    <tr>
                                        <td align="center">
                                            <strong>Nenhum cliente!</strong>
                                        </td>
                                    </tr>
                                </table>
                                <?php 
                               } // FIM ELSE
                               ?>
                              
                            </td>
                        </tr>
                    </table>    
				 </td>
            </tr>
        </table>   
   
<?php include 'rodape.php'; ?>