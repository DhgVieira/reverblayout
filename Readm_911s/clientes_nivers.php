<?php
include 'auth.php';
include 'lib.php';

$mes = request("mes");

$consulta = "select count(*) from cadastros WHERE month(DT_NASCIMENTO_CASO) = '$mes' AND NR_SEQ_LOJA_CASO = $SS_loja";
$st = mysql_query($consulta);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $total = $row[0];
}else{
    $total = 0;
}
?>
<?php include 'topo.php'; ?>
<script language="javascript">

function confirmaGP(idc) {
	var confirma = confirm("Confirma a Exclusão desse grupo e de todas as suas informações relacionadas? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='gruposcliente_del.php?idg='+idc;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Aniversariantes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Clientes</li>
                    </ul>
                </td>
                <td align="left">
                    <div style="width: 600px; text-align: right;">
                        <input type="Button" value="Enviar E-Mails" onClick="document.location.href=('envia_mail_nivers.php?mes=<?php echo $mes ?>');" class="form00" style="width:100px;height:23px;margin: 0 10px 0 0;" />
                        <strong><?php echo $total ?></strong> aniversariantes do Mês <strong><?php echo $mes ?></strong>
                    </div>
                </td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="Ver">
                   
                	<ul class="compras">
                    <li>
                    <table border="0" width="100%" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="170"><strong>E-mail</strong></td>
                                <td align="center" width="115"><strong>Telefone</strong></td>
                                <td align="center" width="150"><strong>Cidade/UF</strong></td>
                                <td align="center" width="100"><strong>CEP</strong></td>
                                <td align="center" width="80"><strong>Data Nasc.</strong></td>
                                <td align="center" width="50"><strong>Pontos</strong></td>
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                            </tr>
                        </table>
                    </li>
						<?php
                          $sql = "select NR_SEQ_CADASTRO_CASO, DS_LOGIN_CASO, DS_NOME_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO,
                                 DS_EMAIL_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, ST_CADASTRO_CASO, DT_NASCIMENTO_CASO from 
                          cadastros WHERE month(DT_NASCIMENTO_CASO) = '$mes' and NR_SEQ_LOJA_CASO = $SS_loja
                          order by DS_NOME_CASO";
						  
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_cad	   = $row[0];
					         $ds_login	   = $row[1];
							 $ds_nome	   = $row[2];
							 $ds_cidade	   = $row[3];
							 $ds_uf		   = $row[4];
							 $ds_cep	   = $row[5];
							 $ds_email	   = $row[6];
							 $ds_ddd	   = $row[7];
							 $ds_fone	   = $row[8];
							 $ds_status	   = $row[9];
                             $nasc  	   = $row[10];
							 
							$sqlp = "select sum(NR_QTDE_PORC) from pontos where NR_SEQ_CADASTRO_PORC = $id_cad and ST_PONTOS_PORC = 'E'";
							$stp = mysql_query($sqlp);
							$pontos = 0;
							if (mysql_num_rows($stp) > 0) {
								$rowp = mysql_fetch_row($stp);
								$pontos	= $rowp[0];
							}else{
								$pontos = 0;
							}
							if (!$pontos) $pontos = 0;
							
							$mostra = true;
							
							if ($pesq_sta == "0") {
								if ($pontos > 0) {
									$mostra = true;
								}else{
									$mostra = false;
								}
							}
							
							if ($mostra) {
							?>
							<li>
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td align="left"><strong><?php echo $ds_nome; ?></strong></td>
                                    <td align="left" width="170"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td align="center" width="115"><?php echo $ds_ddd; ?> <?php echo $ds_fone; ?></td>
                                    <td align="center" width="150"><?php echo $ds_cidade; ?>/<?php echo $ds_uf; ?></td>
                                    <td align="center" width="100"><?php echo $ds_cep; ?></td>
                                    <td align="center" width="80"><?php echo date("d/m/Y", strtotime($nasc)); ?></td>
                                    <td align="center" width="50"><?php echo $pontos; ?></td>
                                    <td align="center" width="30"><?php echo $ds_status; ?></td>
                                    <td align="center" width="20"><a href="clientes_pontos.php?pg=<?php echo $pagina; ?>&idc=<?php echo $id_cad;?>" title="Pontos"><img src="img/pontos.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="clientes_ped.php?pg=<?php echo $pagina; ?>&idc=<?php echo $id_cad;?>" id="iframe" title="::  :: width: 640, height: 300" class="lightview"><img src="img/compras_ver.gif" alt="Ver Compras" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="gruposcliente_add.php?id_cadcli=<?php echo $id_cad ?>" title="Adicionar ao Grupo "><img src="img/ico_usuarios.gif" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
	     	<?php
							}
							}
						  }
						 
						?>
                      </ul>
                     
                  	</div>	<!-- Ver -->
<!-- Grupos -->                    
 		             
                    <script>
                      defineAba("abaVer","Ver");
					  <?php
					  $aba = request("aba");
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					   }
					  ?>
                    </script>
                    
                    
              <?php  mysql_close($con);    ?>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>