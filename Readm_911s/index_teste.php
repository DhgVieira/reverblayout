<?php
include 'auth.php';
include 'lib.php';
include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Avisos Gerais</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Compras em Aberto</li>
                    </ul>
                </td><form action="clientes.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Buscar por </strong>
                    <select name="tipo" class="frm_pesq">
                    	<option value="1">Nome</option>
                        <option value="2">E-Mail</option>
                        <option value="3">Cidade</option>
                    </select>
                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="palavra" value="" />
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>
            </tr>
            <tr>
            	<td align="left" height="68" bgcolor="#FFFFFF" colspan="2">
                	<table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                            <tr>
                                <td align="center" width="60"><strong>NRO</strong></td>
                                <td align="center" width="145"><strong>Data Compra</strong></td>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="150"><strong>E-mail</strong></td>
                                <td align="center" width="100"><strong>Telefone</strong></td>
                                <td align="center" width="100"><strong>Forma Pgto.</strong></td>
                                <td align="center" width="120"><strong>Valor Total</strong></td>
                                <td align="center" width="30"><strong>Parc</strong></td>
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="20">&nbsp;</td>
                            </tr>
                        </table>
                    <ul class="compras">
						<?php
						  $sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
						   DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
						   AND ST_COMPRA_COSO = 'A' ORDER BY DT_COMPRA_COSO desc";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
							$x = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $id_compra	   = $row[0];
					         $dt_compra	   = $row[1];
							 $formapgto	   = $row[2];
							 $valor		   = $row[3];
							 $nome		   = $row[4];
							 $email		   = $row[5];
							 $dddfone	   = $row[6];
							 $fone		   = $row[7];
							 $idcli		   = $row[8];
							 $parcelas	   = $row[9];

							 if ($x == 0) {
							 	$bg = "#FFFFFF";
								if ( date("d/m/Y", strtotime($dt_compra)) == date("d/m/Y") ) $bg = "#f5f1ea";
								$x = 1;
							 }else{
							 	$bg = "#ECECFF";
								if ( date("d/m/Y", strtotime($dt_compra)) == date("d/m/Y") ) $bg = "#dacfbf";
								$x = 0;
							 }
							?>
							<table border="0" width="100%" cellpadding="0" cellspacing="0" height="30" bgcolor="<?php echo $bg; ?>">
                                <tr>
                                    <td align="center" width="60"><strong><?php echo $id_compra; ?></strong></td>
                                    <td align="center" width="145" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                                    <td align="left"><strong><?php echo $nome; ?></strong></td>
                                    <td align="left" width="150" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" class="linksmenu"><?php echo $email; ?></a></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $dddfone . " " . $fone; ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $formapgto; ?></td>
                                    <td align="center" width="120" nowrap="nowrap"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $parcelas; ?></strong></td>
                                    <td align="center" width="30"><strong>A</strong></td>
                                    <td align="center" width="20"><a href="compras_ver.php?idcli=<?php echo $idcli;?>&idc=<?php echo $id_compra;?>" id="iframe" title="::  :: width: 640, height: 470" class="lightview"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
                                </tr>
                        	</table>
							<?php
							}
							}else{
						?>
                        <table width="100%" align="center" height="60"><tr><td align="center"><strong>Nenhuma Compra em Aberto!</strong></td></tr></table>
                        <?php }?>
                      </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <a name="niver"></a><li id="menuDepo" class="abaativa">Aniversariantes</li>
                    </ul>
                </td>
                <td align="left">
                	<table width="100%">
                    	<tr>
                        	<td width="50%">
                            	<ul id="titulos_abas">
                                  <li id="menuDepo" class="abaativa">Produtos com Estoque Baixo</li>
                                </ul>
                            </td>
                            <td width="50%">
                            	<ul id="titulos_abas">
                                  <li id="menuDepo" class="abaativa">Produtos Sem Estoque</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
           	  <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                	<ul class="noticias">
						<?php
						  $sql = "select DS_NOME_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO, DS_CIDADE_CASO, DS_UF_CASO from cadastros WHERE day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO) order by DS_NOME_CASO";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $nome		   = $row[0];
					         $email		   = $row[1];
							 $dt_nasc	   = $row[2];
							 $cidade	   = $row[3];
							 $estado	   = $row[4];
							?>
							<li style="width:98%;">
                            <span><strong><?php echo date("d/m/Y", strtotime($dt_nasc));?></strong> | <?php echo $nome;?></span>
                            <div>
                              <a href="niver.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mailniver.gif" title="Enviar E-mail de Aniversario" border="0" /></a>
                            </div>
                            <div>
                              	<?php echo $cidade; ?>/<?php echo $estado; ?>
                            </div>
                            <div>
                              <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                            </div>
                            </li>
							<?php
							}
						  }else{

						?>
                        <table width="100%" align="center"><tr><td align="center"><strong>Nenhum aniversariante hoje!</strong></td></tr></table>
                        <?php }?>
                   </ul>
					<br />
				  <ul class="noticias">
                    <li style="width:98%;"><br /><strong>People em Aberto (&Uacute;ltimos 5)</strong></li>
                   <?php
						  $sql = "select NR_SEQ_FOTO_FORC, DT_CADASTRO_FORC, DS_NOME_FORC, ST_PEOPLE_FORC, DS_NOME_CASO, DS_EXT_FORC from me_fotos, cadastros WHERE NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO and DS_PEOPLE_FORC = 'S' and ST_PEOPLE_FORC = 'I' order by DT_CADASTRO_FORC desc LIMIT 5";
						  $st = mysql_query($sql);
						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_foto	   = $row[0];
					         $dt_cad	   = $row[1];
							 $ds_foto	   = $row[2];
							 $status	   = $row[3];
							 $ds_autor	   = $row[4];
							 $ds_ext	   = $row[5];
							?>
                            <li style="width:98%;">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><a href="../images/me/fotos/<?php echo $id_foto; ?>.<?php echo $ds_ext; ?>" class="lightview"><img src="../images/me/fotos/<?php echo $id_foto; ?>p.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></a></td>
                                    <td align="center" width="120"><strong><?php echo date("d/m/Y G:i", strtotime($dt_cad)); ?></strong></td>
                                    <td align="left" width="170"><?php echo $ds_autor; ?></td>
                                    <td align="left"><?php echo $ds_foto; ?></td>
                                    <td align="center" width="25"><strong><?php echo $status; ?></strong></td>
                                </tr>
                            </table>
                    </li>
							<?php
							}
						  }

						?>
                </ul>
              </td>
                <td align="left" height="68" bgcolor="#FFFFFF" valign="top">
                	<table width="100%" cellspacing="4">
                    	<tr>
                        	<td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC
												from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												group by NR_SEQ_PRODUTO_PRRC HAVING total between 1 and 5
												order by total";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $nome		   = $row[1];
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                        ?>
                                        <li style="width:98%;">
                                        <span><?php echo $tipo; ?> | <strong><?php echo $nome;?></strong></span>
                                        <div>
                                            <strong><?php echo $qtde; ?></strong>
                                        </div>
                                        </li>
                                        <?php
                                        }
                                      }else{

                                    ?>
                                    <table width="100%" align="center"><tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                            <td width="50%" valign="top">
                            	<ul class="noticias">
									<?php
                                      $sql = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_ESRC) total, DS_CATEGORIA_PTRC
												from produtos, produtos_tipo, estoque
												WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
												group by NR_SEQ_PRODUTO_PRRC HAVING total < 1
												order by total";
                                      $st = mysql_query($sql);
                                      if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $nome		   = $row[1];
                                         $qtde		   = $row[2];
                                         $tipo		   = $row[3];
                                        ?>
                                        <li style="width:98%;">
                                        <span><?php echo $tipo; ?> | <strong><?php echo $nome;?></strong></span>
                                        <div>
                                            <strong><?php echo $qtde; ?></strong>
                                        </div>
                                        </li>
                                        <?php
                                        }
                                      }else{

                                    ?>
                                    <table width="100%" align="center"><tr><td align="center"><strong>Nenhum Produto!</strong></td></tr></table>
                                    <?php }?>
                               </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
</table>

<!-- //****
    NAO COMPRA HA MAIS DE 3 MESES  -->
<center>
<table class="textostabelas" width="800" bgcolor="#F1EBD3" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <ul id="titulos_abas">
              <a name="aviso"></a><li id="menuDepo" class="abaativa">Ultima Compra</li>
            </ul>
        </td>
    </tr>
    <tr>
       	<td align="left">
           <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                <tr>
                    <td align="center" width="120"><strong>Data da compra</strong></td>
                    <td align="center" width="100"><strong>ID Comprador</strong></td>
                    <td align="left" width="200"><strong>Nome</strong></td>
                    <td align="left" width="200"><strong>E-mail</strong></td>
                    <td align="left" width="50"><strong>Aviso</strong></td>
                </tr>
            </table>
         </td>
	</tr>
    <tr>
    	<td align="left" height="68" bgcolor="#FFFFFF" valign="top">
            <ul class="noticias">
<?php
// SELECIONA TODAS AS COMPRAS ENVIADAS OU EFETUADAS.
				$compra = "select DT_COMPRA_COSO, NR_SEQ_CADASTRO_COSO, DS_NOME_CASO, DS_EMAIL_CASO, ST_COMPRA_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and (ST_COMPRA_COSO = 'E' or ST_COMPRA_COSO = 'V') order by NR_SEQ_CADASTRO_COSO , DT_COMPRA_COSO DESC ";
				$compraST = mysql_query($compra);
				$x = 0;
				$entra = '0';
				$pessoa = "";
				$imprime = '0';
				$dia = date("d");
				$mes = date("m")*30;
				$ano = date("Y")*365;
				$datahoje = $dia + $mes + $ano;
				$contador = 0;
				if (mysql_num_rows($compraST) > 0) {
				 	while($row = mysql_fetch_row($compraST)) {
					  $datCompra = $row[0];
					  $nrCompra = $row[1];
					  $nome = $row[2];
					  $email = $row[3];
					  $status = $row[4];

// PEGA O NOME DA PESSOA PARA VER A ULTIMA COMPRA
					  if ($entra == '0' ){
						  if ( $pessoa == "") {
							$pessoa = $nome;
							$entra = '1';
						  }
						  elseif ( $pessoa == $nome) {
							  $entra = '0';
							   }
							   else if( $pessoa <> $nome) {
								  $entra = '1';
								  $pessoa = $nome;
							   }
					  } // FIM IF
// VERIFICA A DATA
					  $diaComp = date("d",strtotime($datCompra));
					  $mesComp = date("m",strtotime($datCompra))*30;
					  $anoComp = date("Y",strtotime($datCompra))*365;
					  $dataComp = $diaComp + $mesComp + $anoComp;

					  if ($datahoje - $dataComp > 90 && $entra == '1'){
						  $imprime = '1';
					  }
					  else {
						  $entra = '0';
						  $imprime = '0';
					  }
// IMPRIME A ULTIMA COMPRA, QUE A DATA MENOR QUE HOJE
					  if ( $entra == '1' && $imprime == '1'){
						$entra = '0';
						$imprime = '0';
						$contador++;

			?>
                        <li style="width:98%; ">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" >
                                <tr>
                                    <td align="center" width="120"><strong><?php echo date("d-m-Y", strtotime($datCompra)); ?></strong></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $nrCompra; ?></td>
                                    <td align="left" width="200"><?php echo $nome; ?></td>
                                    <td align="left" width="200" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" ><?php echo $email; ?></a></td>
                                    <td align="left" width="50"><a href="aviso.php?nome=<?php echo $nome; ?>&email=<?php echo $email; ?>"><img src="img/ico_mail.gif" title="Enviar aviso" border="0" /></a></td>
                                </tr>
                    </table>
                        </li>
  			        <?php
						} // FIM IF
					} // FIM WHILE
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
				echo "<strong> Encontrado </strong>: ".$contador;
			?>
           </ul>
		</td>
    </tr>
</table>
</center>
<!-- //**** -->

<?php include 'rodape.php'; ?>