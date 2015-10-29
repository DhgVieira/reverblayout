<?php
include 'auth.php';
include 'lib.php';
$posicao = request("pos");
if (!$posicao) $posicao = 2;
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Estoque</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Estoque do Produto</li>
                      <li id="abaHistor" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Todo Histórico</li>
                      <li id="abaDefeito" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Pe&ccedil;a com Defeito</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<?php
						  $idp = request("idp");
						  $sql = "select NR_SEQ_LOJAS_PRRC,
							NR_SEQ_TIPO_PRRC,
							NR_SEQ_CATEGORIA_PRRC,
							NR_SEQ_MUSICA_PRRC,
							DS_REFERENCIA_PRRC,
							DS_PRODUTO2_PRRC,
							VL_PRODUTO_PRRC,
							NR_PESOGRAMAS_PRRC,
							DS_GARANTIA_PRRC,
							DS_INFORMACOES_PRRC,
							TP_DESTAQUE_PRRC,
							DS_FRETEGRATIS_PRRC,
							VL_PROMO_PRRC,
							ST_PRODUTOS_PRRC,
							DT_CRIACAO_PRRC,
							DS_IMMEM_PRRC, VL_PRODUTO2_PRRC,
                            DS_EXT_PRRC from produtos WHERE NR_SEQ_PRODUTO_PRRC = $idp";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_loja	   = $row[0];
							 $id_tipo	   = $row[1];
							 $id_cate	   = $row[2];
							 $id_musi	   = $row[3];
							 $ds_refe	   = $row[4];
							 $ds_prod	   = $row[5];
							 $vl_prod	   = number_format($row[6],2,",","");
							 $nr_peso	   = $row[7];
							 $ds_gara	   = $row[8];
							 $ds_info	   = $row[9];
							 $destaque	   = $row[10];
							 $frete		   = $row[11];
							 $vlrpromo	   = $row[12];
							 $status	   = $row[13];
							 $ano_cria	   = $row[14];
							 $mus_prod	   = $row[15];
							 $vl_prod2	   = number_format($row[16],2,",","");
                             $ext_prod	   = $row[17];
							}
						  }
						 ?>
                         <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                         <table width="880">
                        	<tr>
                            	<td valign="top" width="220">
                                <table>
                                    <tr>
                                        <td>
                                               <strong>Produto:</strong><br />
                                               <?php echo $ds_prod; ?>
                                        </td>
                                  </tr>
                                  <tr><td><img src="img/x.gif" border="0" /></td></tr>
                                  <?php if ($ext_prod == "swf") {?>
                                  <tr>
                                      <td>
                                      <object data="../arquivos/uploads/produtos/<?php echo $idp; ?>.<?php echo $ext_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $idp; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $idp; ?>.<?php echo $ext_prod; ?>" />
                                        <param name="wmode" value="opaque" />
                                      </object>
                                      </td>
                                  </tr>
                                  <?php }else{ ?>
                                  <tr>
                                      <td>
                                            <img src="../arquivos/uploads/produtos/<?php echo $idp; ?>.<?php echo $ext_prod; ?>" name="imagem_foto" border="0" width="180" height="210" />
                                      </td>
                                  </tr>
                                  <?php } ?>
                                  <tr>
                                    <td>
										<input type="button" id="postar" name="postar" value="Alterar Produto" onclick="document.location.href='grupos_alt.php?idp=<?php echo $idp ?>'" />
                                    </td>
                                  </tr>
                                </table>
                                </td>
                            
                            <td valign="top">
                                <table width="390">
                                    <tr>
                                        <td>
                                            <strong>Tamanhos/Quantidade Atual:</strong> <!-- <input type="button" id="postar" name="postar" value="Acerto Inicial" onclick="document.location.href='acerto_estoque.php?idp=<?php echo $idp ?>'" /> -->
                                        </td>
                                    </tr>
                                    <?php
                                            $sql = "select NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC from estoque WHERE NR_SEQ_PRODUTO_ESRC = $idp";
											  $st = mysql_query($sql);
											  //$tam1 = 0;
//											  $tam2 = 0;
//											  $tam3 = 0;
//											  $tam4 = 0;
//											  $tam5 = 0;
//											  $tam6 = 0;
//											  $tam7 = 0;
//											  $tam8 = 0;
//											  $tam9 = 0;
//											  $tam10 = 0;
//											  $tam11 = 0;
											  $chec = false;
                                              $mostratam = false;
                                              $mostranum = false;
                                              $mostranumf = false;
                                              $mostrauni = false;
											  if (mysql_num_rows($st) > 0) {
												while($row = mysql_fetch_row($st)) {
												 switch($row[0]){
												 	case 1:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam1 = $row[1];
                                                        $qtdeabert1o = ComprasEmAberto($idp,1);
														break;
													case 2:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam2 = $row[1];
                                                        $qtdeaberto2 = ComprasEmAberto($idp,2);
														break;
													case 3:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam3 = $row[1];
                                                        $qtdeaberto3 = ComprasEmAberto($idp,3);
														break;
													case 4:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam4 = $row[1];
                                                        $qtdeaberto4 = ComprasEmAberto($idp,4);
														break;
													case 5:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam5 = $row[1];
                                                        $qtdeaberto5 = ComprasEmAberto($idp,5);
														break;
													case 6:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam6 = $row[1];
                                                        $qtdeaberto6 = ComprasEmAberto($idp,6);
														break;
													case 7:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam7 = $row[1];
                                                        $qtdeaberto7 = ComprasEmAberto($idp,7);
														break;
													case 8:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam8 = $row[1];
                                                        $qtdeaberto8 = ComprasEmAberto($idp,8);
														break;
													case 9:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam9 = $row[1];
                                                        $qtdeaberto9 = ComprasEmAberto($idp,9);
														break;
													case 10:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam10 = $row[1];
                                                        $qtdeaberto10 = ComprasEmAberto($idp,10);
														break;
                                                    case 33:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam33 = $row[1];
                                                        $qtdeaberto33 = ComprasEmAberto($idp,33);
														break;
                                                        
													case 11:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = true;
                                                        $mostranumf = false;
														$tam11 = $row[1];
                                                        $qtdeaberto11 = ComprasEmAberto($idp,11);
														$chec = true;
														break;
														
													case 13:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam13 = $row[1];
                                                        $qtdeaberto13 = ComprasEmAberto($idp,13);
														break;
													case 14:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam14 = $row[1];
                                                        $qtdeaberto14 = ComprasEmAberto($idp,14);
														break;
													case 15:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam15 = $row[1];
                                                        $qtdeaberto15 = ComprasEmAberto($idp,15);
														break;
													case 16:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam16 = $row[1];
                                                        $qtdeaberto16 = ComprasEmAberto($idp,16);
														break;
													case 17:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam17 = $row[1];
                                                        $qtdeaberto17 = ComprasEmAberto($idp,17);
														break;
													case 18:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam18 = $row[1];
                                                        $qtdeaberto18 = ComprasEmAberto($idp,18);
														break;
													case 19:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam19 = $row[1];
                                                        $qtdeaberto19 = ComprasEmAberto($idp,19);
														break;
													case 20:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam20 = $row[1];
                                                        $qtdeaberto20 = ComprasEmAberto($idp,20);
														break;
													case 21:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam21 = $row[1];
                                                        $qtdeaberto21 = ComprasEmAberto($idp,21);
														break;
													case 22:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam22 = $row[1];
                                                        $qtdeaberto22 = ComprasEmAberto($idp,22);
														break;
													case 23:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam23 = $row[1];
                                                        $qtdeaberto23 = ComprasEmAberto($idp,23);
														break;
													case 24:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam24 = $row[1];
                                                        $qtdeaberto24 = ComprasEmAberto($idp,24);
														break;
													case 25:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam25 = $row[1];
                                                        $qtdeaberto25 = ComprasEmAberto($idp,25);
														break;
													case 26:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam26 = $row[1];
                                                        $qtdeaberto26 = ComprasEmAberto($idp,26);
														break;
                                                        
                                                    case 27:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam27 = $row[1];
                                                        $qtdeaberto27 = ComprasEmAberto($idp,27);
														break;
                                                    case 28:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam28 = $row[1];
                                                        $qtdeaberto28 = ComprasEmAberto($idp,28);
														break;
                                                    case 29:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam29 = $row[1];
                                                        $qtdeaberto29 = ComprasEmAberto($idp,29);
														break;
                                                    case 30:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam30 = $row[1];
                                                        $qtdeaberto30 = ComprasEmAberto($idp,30);
														break;
                                                    case 31:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam31 = $row[1];
                                                        $qtdeaberto31 = ComprasEmAberto($idp,31);
														break;
                                                    case 32:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam32 = $row[1];
                                                        $qtdeaberto32 = ComprasEmAberto($idp,32);
														break;
                                                    case 34:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam34 = $row[1];
                                                        $qtdeaberto34 = ComprasEmAberto($idp,34);
														break;
                                                    case 35:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam35 = $row[1];
                                                        $qtdeaberto35 = ComprasEmAberto($idp,35);
														break;
                                                    case 36:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam36 = $row[1];
                                                        $qtdeaberto36 = ComprasEmAberto($idp,36);
														break;
                                                    case 37:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam37 = $row[1];
                                                        $qtdeaberto37 = ComprasEmAberto($idp,37);
														break;
                                                    case 38:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam38 = $row[1];
                                                        $qtdeaberto38 = ComprasEmAberto($idp,38);
														break;
                                                    case 39:
                                                       $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam39 = $row[1];
                                                        $qtdeaberto39 = ComprasEmAberto($idp,39);
														break;
                                                    case 40:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam40 = $row[1];
                                                        $qtdeaberto40 = ComprasEmAberto($idp,40);
														break;
                                                    case 41:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam41 = $row[1];
                                                        $qtdeaberto41 = ComprasEmAberto($idp,41);
														break;
                                                    case 42:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam42 = $row[1];
                                                        $qtdeaberto42 = ComprasEmAberto($idp,42);
														break;
                                                    case 43:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam43 = $row[1];
                                                        $qtdeaberto43 = ComprasEmAberto($idp,43);
														break;
                                                    case 44:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam44 = $row[1];
                                                        $qtdeaberto44 = ComprasEmAberto($idp,44);
														break;
                                                    case 45:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam45 = $row[1];
                                                        $qtdeaberto45 = ComprasEmAberto($idp,45);
														break;
                                                    case 46:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam46 = $row[1];
                                                        $qtdeaberto46 = ComprasEmAberto($idp,46);
														break;
                                                    case 47:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
                                                        $tam47 = $row[1];
                                                        $qtdeaberto47 = ComprasEmAberto($idp,47);
                                                        break;

													
												 }
												}
											  }
                                    if ($mostratam) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Masculina:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="PP">
                                                           <strong>PP:</strong><?php if ($qtdeaberto1) echo " (".$qtdeaberto1.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamPP" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam1; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=1&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=1&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table>
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="P">
                                                           <strong>P:</strong><?php if ($qtdeaberto2) echo " (".$qtdeaberto2.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamP" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam2; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=2&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=2&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="M">
                                                           <strong>M:</strong><?php if ($qtdeaberto3) echo " (".$qtdeaberto3.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamM" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam3; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=3&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=3&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="G">
                                                           <strong>G:</strong><?php if ($qtdeaberto4) echo " (".$qtdeaberto4.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamG" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam4; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=4&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=4&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="GG">
                                                           <strong>GG:</strong><?php if ($qtdeaberto5) echo " (".$qtdeaberto5.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamGG" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam5; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=5&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=5&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="XGL">
                                                           <strong>XGL:</strong><?php if ($qtdeaberto33) echo " (".$qtdeaberto33.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="m_tamXGL" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam33; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=33&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=33&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>   
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Feminina:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="fPP">
                                                           <strong>PP:</strong><?php if ($qtdeaberto6) echo " (".$qtdeaberto6.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamPP" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam6; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=6&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=6&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fP">
                                                           <strong>P:</strong><?php if ($qtdeaberto7) echo " (".$qtdeaberto7.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamP" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam7; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=7&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=7&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fM">
                                                           <strong>M:</strong><?php if ($qtdeaberto8) echo " (".$qtdeaberto8.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamM" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam8; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=8&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=8&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fG">
                                                           <strong>G:</strong><?php if ($qtdeaberto9) echo " (".$qtdeaberto9.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamG" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam9; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=9&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=9&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fGG">
                                                           <strong>GG:</strong><?php if ($qtdeaberto10) echo " (".$qtdeaberto10.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamGG" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam10; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=10&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=10&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fXGG">
                                                           <strong>XGG:</strong><?php if ($qtdeaberto47) echo " (".$qtdeaberto47.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="f_tamXGG" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam47; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=47&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=47&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostranum) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Numeração:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="15">
                                                           <strong>15:</strong><?php if ($qtdeaberto34) echo " (".$qtdeaberto34.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam15" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam34; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=34&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=34&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="16">
                                                           <strong>16:</strong><?php if ($qtdeaberto35) echo " (".$qtdeaberto35.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam16" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam35; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=35&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=35&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="17">
                                                           <strong>17:</strong><?php if ($qtdeaberto36) echo " (".$qtdeaberto36.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam17" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam36; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=36&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=36&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="18">
                                                           <strong>18:</strong><?php if ($qtdeaberto37) echo " (".$qtdeaberto37.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam18" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam37; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=37&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=37&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="19">
                                                           <strong>19:</strong><?php if ($qtdeaberto38) echo " (".$qtdeaberto38.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam19" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam38; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=38&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=38&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="25">
                                                           <strong>25:</strong><?php if ($qtdeaberto39) echo " (".$qtdeaberto39.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam25" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam39; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=39&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=39&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="26">
                                                           <strong>26:</strong><?php if ($qtdeaberto40) echo " (".$qtdeaberto40.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam26" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam40; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=40&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=40&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="27">
                                                           <strong>27:</strong><?php if ($qtdeaberto41) echo " (".$qtdeaberto41.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam27" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam41; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=41&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=41&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="28">
                                                           <strong>28:</strong><?php if ($qtdeaberto42) echo " (".$qtdeaberto42.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam28" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam42; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=42&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=42&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="29">
                                                           <strong>29:</strong><?php if ($qtdeaberto43) echo " (".$qtdeaberto43.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam29" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam43; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=43&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=43&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="30">
                                                           <strong>30:</strong><?php if ($qtdeaberto44) echo " (".$qtdeaberto44.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam30" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam44; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=44&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=44&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="31">
                                                           <strong>31:</strong><?php if ($qtdeaberto45) echo " (".$qtdeaberto45.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam31" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam45; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=45&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=45&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="32">
                                                           <strong>32:</strong><?php if ($qtdeaberto46) echo " (".$qtdeaberto46.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam32" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam46; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=46&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=46&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                        <label for="33">
                                                           <strong>33:</strong><?php if ($qtdeaberto13) echo " (".$qtdeaberto13.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam33" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam13; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=13&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=13&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                        <label for="34">
                                                           <strong>34:</strong><?php if ($qtdeaberto14) echo " (".$qtdeaberto14.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam34" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam14; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=14&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=14&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="35">
                                                           <strong>35:</strong><?php if ($qtdeaberto15) echo " (".$qtdeaberto15.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam35" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam15; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=15&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=15&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="36">
                                                           <strong>36:</strong><?php if ($qtdeaberto16) echo " (".$qtdeaberto16.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam36" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam16; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=16&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=16&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="37">
                                                           <strong>37:</strong><?php if ($qtdeaberto17) echo " (".$qtdeaberto17.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam37" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam17; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=17&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=17&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="38">
                                                           <strong>38:</strong><?php if ($qtdeaberto18) echo " (".$qtdeaberto18.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam38" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam18; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=18&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=18&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="39">
                                                           <strong>39:</strong><?php if ($qtdeaberto19) echo " (".$qtdeaberto19.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam39" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam19; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=19&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=19&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                          <label for="40">
                                                           <strong>40:</strong><?php if ($qtdeaberto20) echo " (".$qtdeaberto20.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam40" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam20; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=20&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=20&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="41">
                                                           <strong>41:</strong><?php if ($qtdeaberto21) echo " (".$qtdeaberto21.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam41" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam21; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=21&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=21&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                        <label for="42">
                                                           <strong>42:</strong><?php if ($qtdeaberto22) echo " (".$qtdeaberto22.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam42" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam22; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=22&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=22&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="43">
                                                           <strong>43:</strong><?php if ($qtdeaberto23) echo " (".$qtdeaberto23.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam43" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam23; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=23&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=23&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                          <label for="44">
                                                           <strong>44:</strong><?php if ($qtdeaberto24) echo " (".$qtdeaberto24.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam44" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam24; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=24&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=24&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="45">
                                                           <strong>45:</strong><?php if ($qtdeaberto25) echo " (".$qtdeaberto25.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam45" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam25; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=25&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=25&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="46">
                                                           <strong>46:</strong><?php if ($qtdeaberto26) echo " (".$qtdeaberto26.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam46" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam26; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=26&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=26&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostranumf) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Numeração Extendida:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="33-34">
                                                           <strong>33-34:</strong><?php if ($qtdeaberto27) echo " (".$qtdeaberto27.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam27" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam27; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=27&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=27&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="35-36">
                                                           <strong>35-36:</strong><?php if ($qtdeaberto28) echo " (".$qtdeaberto28.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam28" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam28; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=28&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=28&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="37-38">
                                                           <strong>37-38:</strong><?php if ($qtdeaberto29) echo " (".$qtdeaberto29.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam29" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam29; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=29&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=29&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="39-40">
                                                           <strong>39-40:</strong><?php if ($qtdeaberto30) echo " (".$qtdeaberto30.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam30" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam30; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=30&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=30&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="41-42">
                                                           <strong>41-42:</strong><?php if ($qtdeaberto31) echo " (".$qtdeaberto31.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam31" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam31; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=31&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=31&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="43-44">
                                                           <strong>43-44:</strong><?php if ($qtdeaberto32) echo " (".$qtdeaberto32.")"; ?><br />
                                                           <table cellpadding="1" cellspacing="0">
                                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam32" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam32; ?>" /></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=32&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=32&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                                           </table> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostrauni) {
                                    ?>
                                    <tr><td height="25"><strong>Tamanho &Uacute;nico:</strong></td></tr>
                                    <tr>
                                        <td>
										   <table cellpadding="1" cellspacing="0">
                                            <tr><td rowspan="3"><input class="form00" readonly="readonly" type="text" name="tam_unqt" style="width:30px;height:25px;text-align:center;" value="<?php echo $tam11; ?>" /> <?php if ($qtdeaberto11) echo "(".$qtdeaberto11.")"; ?></td></tr>
                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=11&acao=I" title="adicionar"><img src="img/ico_mais.gif" width="15" height="15" border="0" /></a></td></tr>
                                            <tr><td><a href="estoque_acao.php?idp=<?php echo $idp ?>&tam=11&acao=D" title="remover"><img src="img/ico_menos.gif" width="15" height="15" border="0" /></a></td></tr>
                                           </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr bgcolor="#FFDDBB"><td align="left" height="22"><strong>Últimas alterações do estoque:</strong></td></tr>
                                    <?php
                                    $sql = "select * from estoque_controle, tamanhos where NR_SEQ_TAMANHO_ECRC = NR_SEQ_TAMANHO_TARC
                                             and NR_SEQ_PRODUTO_ECRC = $idp AND NR_SEQ_USUARIO_ECRC <> 0 order by DT_ACAO_ECRC desc limit 7";
                                    $st = mysql_query($sql);
                                    if (mysql_num_rows($st) > 0) {
            						    $x = 0;
                                        while($row = mysql_fetch_array($st)) {
                                        if ($x == 0) {
     						 	           $bg = "#FFFFFF";
  								           $x = 1;
                                        }else{
            							   $bg = "#ECECFF";
        							       $x = 0;
            							}
                                        $dsobs = $row["DS_OBS_ECRC"];
                                        $ds_user = PegaUser($row["NR_SEQ_USUARIO_ECRC"]);
                                        
                                        $dsnrcom = preg_replace("[^0-9]", "", $dsobs);
    
                                        $dsobs = str_replace("$dsnrcom","<a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
                                        //$dsobs = str_replace("Compra Nr $dsnrcom","Compra Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
                                        //$dsobs = str_replace("Venda site - Compra Nr $dsnrcom","Venda site - Compra Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
                                        //$dsobs = str_replace("Venda Nr $dsnrcom","Venda Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
       						        ?>
                                    <tr>
                                        <td>
										   <table cellpadding="1" cellspacing="1" width="100%" bgcolor="<?php echo $bg; ?>">
                                            <tr>
                                                <td width="100"><?php echo date("d/m/Y G:i",strtotime($row["DT_ACAO_ECRC"]));?></td>
                                                <td width="100"><strong><?php echo $ds_user;?></strong></td>
                                                <td><?php echo $row["DS_ACAO_ECRC"];?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo $dsobs;?></td>
                                                <td><strong>Tam: </strong><?php echo $row["DS_TAMANHO_TARC"];?></td>
                                            </tr>
                                           </table>
                                        </td>
                                    </tr>
                                          <?php
         						  	   }
                                    }
                                    ?>
                                </table>
								
                            </td>
                            <td valign="top">
                            <form action="estoque_acao.php" method="post">
                                <input type="hidden" name="idp" value="<?php echo $idp; ?>" />
                                <input type="hidden" name="doform" value="S" />
                                <input type="hidden" name="pos" value="<?php echo $posicao; ?>" />
                                <table>
                                    <tr><td align="left" colspan="2"><strong>Adicionando/Removendo Unidades do Estoque:</strong></td></tr>
                                    <tr><td align="left" colspan="2">&nbsp;</td></tr>
                                    <tr>
                                        <td align="left"><strong>Tamanho:</strong></td>
                                        <td>
                                            <select name="tam" style="margin:4px 0 0 0; width:156px;">
                                            <?php
                                                $sql = "select * from tamanhos where NR_SEQ_TAMANHO_TARC <> 12 order by NR_ORDEM_TARC";
                                                $st = mysql_query($sql);
                                                
                                                while($row = mysql_fetch_array($st)) {
                                                    $seleciona = "";
                                                    if ($row["NR_ORDEM_TARC"] == $posicao) $seleciona = " selected";
                                                    
                                                    if ( ($row["NR_SEQ_TAMANHO_TARC"] <= 10 || $row["NR_SEQ_TAMANHO_TARC"] == 47 or $row["NR_SEQ_TAMANHO_TARC"] == 33) && $mostratam) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\"$seleciona>".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ($row["NR_SEQ_TAMANHO_TARC"] == 11 && $mostrauni) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\"$seleciona>".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ( (($row["NR_SEQ_TAMANHO_TARC"] > 12 && $row["NR_SEQ_TAMANHO_TARC"] <= 26) || ($row["NR_SEQ_TAMANHO_TARC"] > 33 && $row["NR_SEQ_TAMANHO_TARC"] <= 46)) && $mostranum) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\"$seleciona>".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ( ($row["NR_SEQ_TAMANHO_TARC"] >= 27 && $row["NR_SEQ_TAMANHO_TARC"] <= 32) && $mostranumf) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\"$seleciona>".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if (!$mostranum && !$mostrauni && !$mostratam && !$mostranumf) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\"$seleciona>".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Ação:</strong></td>
                                        <td align="left"><strong><input type="radio" value="I" checked="checked" name="acao" /> Incluir <input type="radio" value="D" name="acao" /> Excluir</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Quantidade:</strong></td>
                                        <td align="left"><strong><input class="form00" type="text" name="qtde" style="width:40px;height:20px;text-align:center;vertical-align:middle;" /></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Obs:</strong></td>
                                        <td align="left"><strong><textarea class="form01" name="obs" style="width:160px;height:60px;"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>&nbsp;</strong></td>
                                        <td align="left"><strong><input type="submit" id="postar" name="postar" value="Adicionar/Remover" /></td>
                                    </tr>
                                </table>
                            </form>
                            </td>
                            </tr>
                        </table>

                    </div> <!-- /criar -->
                    
                    <div id="Histor">
                            <table width="700">
                            <tr>
                                <td align="right" height="22">
                                <form action="estoque.php" method="post" name="frmest" id="frmest">
                                <input type="hidden" name="idp" value="<?php echo $idp ?>" />
                                    Filtrar por tamanho:
                                    <select name="tamfiltro" style="margin:4px 0 0 0; width:156px;" onchange="document.frmest.submit();">
                                    <option value="-1">Todos Tamanhos</option>
                                    <?php
                                        $tamfil = request("tamfiltro");
                                        if (!$tamfil) $tamfil = 0;
                                        $sql = "select * from tamanhos where NR_SEQ_TAMANHO_TARC <> 12 order by NR_ORDEM_TARC";
                                        $st = mysql_query($sql);
                                        while($row = mysql_fetch_array($st)) {
                                            $select = "";
                                            if ($row["NR_SEQ_TAMANHO_TARC"] == $tamfil) $select = " selected";
                                            if ( ($row["NR_SEQ_TAMANHO_TARC"] <= 10 || $row["NR_SEQ_TAMANHO_TARC"] == 33) && $mostratam) {
                                                echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                            }
                                            if ($row["NR_SEQ_TAMANHO_TARC"] == 11 && $mostrauni) {
                                                echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                            }
                                            if ( (($row["NR_SEQ_TAMANHO_TARC"] > 12 && $row["NR_SEQ_TAMANHO_TARC"] <= 26) || ($row["NR_SEQ_TAMANHO_TARC"] > 33 && $row["NR_SEQ_TAMANHO_TARC"] <= 46)) && $mostranum) {
                                                echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                            }
                                            if ( ($row["NR_SEQ_TAMANHO_TARC"] >= 27 && $row["NR_SEQ_TAMANHO_TARC"] <= 32) && $mostranumf) {
                                                echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                            }
                                            if (!$mostranum && !$mostrauni && !$mostratam && !$mostranumf) {
                                                echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                            }
                                        }
                                    ?>
                                    </select>
                                </form>
                                </td>
                            </tr>
                            <tr bgcolor="#FFDDBB"><td align="left" height="22"><strong>Movimento do estoque do produto <?php echo $ds_prod; ?>:</strong></td></tr>
                                   <?php
                                    $saldo = 0;
                                    $sql = "select * from estoque_controle, tamanhos where NR_SEQ_TAMANHO_ECRC = NR_SEQ_TAMANHO_TARC
                                             and NR_SEQ_PRODUTO_ECRC = $idp";
                                    if ($tamfil > 0) $sql .= " AND NR_SEQ_TAMANHO_TARC = $tamfil";
                                    $sql .= " order by DT_ACAO_ECRC";
                                    $st = mysql_query($sql);
                                    if (mysql_num_rows($st) > 0) {
            						    $x = 0;
                                        while($row = mysql_fetch_array($st)) {
                                        if ($x == 0) {
     						 	           $bg = "#FFFFFF";
  								           $x = 1;
                                        }else{
            							   $bg = "#ECECFF";
        							       $x = 0;
            							}
                                        $dsobs = $row["DS_OBS_ECRC"];
                                        $ds_user = PegaUser($row["NR_SEQ_USUARIO_ECRC"]);
                                        
                                        $dsnrcom = preg_replace("[^0-9]", "", $dsobs);
    
                                        $dsobs = str_replace("$dsnrcom","<a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);

                                        //$dsnrcom = trim(str_replace("Venda site - Compra Nr ","",$dsobs));
                                        //$dsnrcom = trim(str_replace("Compra Nr ","",$dsnrcom));
                                        //$dsnrcom = trim(str_replace("Venda Nr ","",$dsnrcom));
                                        
                                        //$dsobs = str_replace("Compra Nr $dsnrcom","Compra Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
                                        //$dsobs = str_replace("Venda site - Compra Nr $dsnrcom","Venda site - Compra Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);
                                        //$dsobs = str_replace("Venda Nr $dsnrcom","Venda Nr <a href=\"compras_ver.php?idc=$dsnrcom&KeepThis=true&TB_iframe=true&height=470&width=640\" title=\"$dsnrcom\" class=\"thickbox\">$dsnrcom</a>",$dsobs);                                        
       						        ?>
                                    <tr>
                                        <td>
										   <table cellpadding="1" cellspacing="1" width="100%" bgcolor="<?php echo $bg; ?>">
                                            <tr>
                                                <td width="120"><?php echo date("d/m/Y G:i",strtotime($row["DT_ACAO_ECRC"]));?></td>
                                                <td width="120"><strong><?php echo $ds_user;?></strong></td>
                                                <td><?php echo $row["DS_ACAO_ECRC"];?></td>
                                                <td width="150"><strong>Tam: </strong><?php echo $row["DS_TAMANHO_TARC"];?></td>
                                                <td rowspan="2" align="center" width="30"><?php echo $row["NR_QTDE_ECRC"];?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><?php echo $dsobs;?></td>
                                            </tr>
                                           </table>
                                        </td>
                                    </tr>
                                    <?php
                                          $saldo += $row["NR_QTDE_ECRC"];
         						  	   }
                                    }
                                    ?>
                                    <tr><td>
                                        <table cellpadding="1" cellspacing="1" width="100%" bgcolor="<?php echo $bg; ?>">
                                            <tr>
                                                <td width="120">&nbsp;</td>
                                                <td colspan="3" align="right"><strong>Saldo Final:&nbsp;</strong></td></td>
                                                <td align="center" width="30"><?php echo $saldo;?></td>
                                            </tr>
                                        </table>
                                    </tr>
                                </table>
                    </div>
                    
                    <div id="Defeito">
                            <table width="700" cellpadding="8" cellspacing="8">
                            <tr>
                                <td align="left" height="22">
                                <p><strong>Removendo pe&ccedil;a com defeito. &Eacute; obrigat&oacute;rio a impress&atilde;o do recibo de retirada para fixa&ccedil;&atilde;o junto ao produto.</strong></p>
                                <form action="defeito.php" method="post" target="_blank">
                                <input type="hidden" name="idp" value="<?php echo $idp ?>" />
                                <table>
                                    <tr>
                                        <td align="left"><strong>Tamanho:</strong></td>
                                        <td align="left"><strong>
                                        <select name="tam" style="margin:4px 0 0 0; width:170px;">
                                            <?php
                                                $sql = "select * from tamanhos where NR_SEQ_TAMANHO_TARC <> 12 order by NR_ORDEM_TARC";
                                                $st = mysql_query($sql);
                                                while($row = mysql_fetch_array($st)) {
                                                    if ( ($row["NR_SEQ_TAMANHO_TARC"] <= 10 || $row["NR_SEQ_TAMANHO_TARC"] == 33) && $mostratam) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ($row["NR_SEQ_TAMANHO_TARC"] == 11 && $mostrauni) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ( (($row["NR_SEQ_TAMANHO_TARC"] > 12 && $row["NR_SEQ_TAMANHO_TARC"] <= 26) || ($row["NR_SEQ_TAMANHO_TARC"] > 33 && $row["NR_SEQ_TAMANHO_TARC"] <= 46)) && $mostranum) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if ( ($row["NR_SEQ_TAMANHO_TARC"] >= 27 && $row["NR_SEQ_TAMANHO_TARC"] <= 32) && $mostranumf) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                    if (!$mostranum && !$mostrauni && !$mostratam && !$mostranumf) {
                                                        echo "<option value=\"".$row["NR_SEQ_TAMANHO_TARC"]."\" ".$select.">".$row["DS_TAMANHO_TARC"]."</option>\n";
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Defeito:</strong></td>
                                        <td align="left"><strong><textarea class="form01" name="obs" style="width:340px;height:80px;"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>&nbsp;</strong></td>
                                        <td align="left"><strong><input type="submit" id="postar" name="postar" value="Remover" class="form01" style="width:120px;height:25px;" /></td>
                                    </tr>
                                </table>
                                
                                </form>
                                </td>
                            </tr>
                            </table>
                    </div>

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAba("abaHistor","Histor");
                      defineAba("abaDefeito","Defeito");
                      <?php if ($tamfil) { ?>
					  defineAbaAtiva("abaHistor");
                      <?php }else{ ?>
                      defineAbaAtiva("abaCriar");
                      <?php } ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php
function ComprasEmAberto($prod, $taman){
	$sqlmin = "SELECT sum(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
               NR_SEQ_PRODUTO_CESO = $prod and NR_SEQ_TAMANHO_CESO = $taman and ST_COMPRA_COSO = 'A'";
	$stmin = mysql_query($sqlmin);
	$retqtde = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retqtde = $rowmin[0];
	}
	return $retqtde;
}
mysql_close($con);?>