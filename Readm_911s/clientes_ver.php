<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
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
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='clientes.php';">Clientes Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Cliente</li>
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
						 $idc = request("idc");

						$sql = "SELECT DS_LOGIN_CASO, DS_NOME_CASO, DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_CIDADE_CASO,
								DS_UF_CASO, DS_CEP_CASO, DS_EMAIL_CASO, DT_NASCIMENTO_CASO,	DS_CPFCNPJ_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, DS_DDDCEL_CASO,
								DS_CELULAR_CASO, DT_CADASTRO_CASO, DS_SENHA_CASO, ST_CADASTRO_CASO, NR_NIVELSEG_CASO, DS_CONHECEU_CASO, DS_TIPO_CASO, TP_CADASTRO_CACH,
                                DS_TWITTER_CACH, DS_FACEBOOK_CACH, DS_INSCRICAO_CACH
								FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $idc";
						$st = mysql_query($sql);
						
						if (mysql_num_rows($st) > 0) {
							$row = mysql_fetch_row($st);
							
							$login		   = utf8_encode($row[0]);
							$nome		   = utf8_encode($row[1]);
							$endereco	   = $row[2];
							$numero		   = $row[3];
							$complem	   = $row[4];
							$bairro		   = $row[5];
							$cidade		   = $row[6];
							$estado		   = $row[7];
							$cep		   = $row[8];
							$email		   = $row[9];
							$dt_nasc	   = $row[10];
							$documento	   = $row[11];
							$dddfone	   = $row[12];
							$fone		   = $row[13];
							$dddcel		   = $row[14];
							$celular	   = $row[15];
							$dt_cadastro   = $row[16];
							$senha		   = $row[17];
							$status		   = $row[18];
							$nivelseg	   = $row[19];
							$conheceu	   = $row[20];
							$tipo		   = $row[21];
							$tipocli	   = $row[22];
                            $dstwitter	   = $row[23];
                            $facebook      = $row[24];
                            $ie            = $row[25];
						}
						
						?>
                         <form action="clientes_alt2.php" method="post" name="myform">
                         <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome">
                                      <table cellpadding="0" cellspacing="0" width="450">
                                     	<tr>
                                        	<td>Nick:</td>
                                            <td>&nbsp;</td>
                                        	<td>Data de Cadastro:</td>
                                            <td>&nbsp;</td>
                                            <td align="center">Status:</td>
                                            <td>&nbsp;</td>
                                            <td>Nivel:</td>
                                            <td>&nbsp;</td>
                                            <td><strong>Tipo Cliente:</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><strong><input maxlength="40" class="form02" style="width:110px;" type="text" name="nick" value="<?php echo $login; ?>" /></strong></td>
                                            <td>&nbsp;</td>
                                        	<td><strong><?php echo date("d/m/Y G:i", strtotime($dt_cadastro)); ?></strong></td>
                                            <td>&nbsp;</td>
                                            <td align="center"><strong><?php echo $status; ?></strong></td>
                                            <td>&nbsp;</td>
                                            <td><strong><?php echo $nivelseg; ?></strong></td>
                                            <td>&nbsp;</td>
                                            <td> <?php echo $tipocli; ?> </td>
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                       Nome:<br />
                                        <input maxlength="80" class="form02" style="width:304px;" type="text" name="nome" value="<?php echo $nome; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                     <table cellpadding="0" cellspacing="0">
                                     	<tr>
                                        	<td>Endereco:</td>
                                            <td>&nbsp;</td>
                                            <td>Numero:</td>
                                            <td>&nbsp;</td>
                                            <td>Complemento:</td>
                                        </tr>
                                        <tr>
                                        	<td><input maxlength="80" class="form02" style="width:304px;" type="text" name="endereco" value="<?php echo $endereco; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="8" class="form00" style="width:40px;" type="text" name="numero" value="<?php echo $numero; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="30" class="form00" style="width:120px;" type="text" name="complem" value="<?php echo $complem; ?>" /></td>
                                            
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                      <table cellpadding="0" cellspacing="0">
                                     	<tr>
                                        	<td>Bairro:</td>
                                            <td>&nbsp;</td>
                                            <td>Cidade:</td>
                                            <td>&nbsp;</td>
                                            <td>UF:</td>
                                            <td>&nbsp;</td>
                                            <td>CEP:</td>
                                        </tr>
                                        <tr>
                                        	<td><input maxlength="50" class="form00" style="width:177px;" type="text" name="bairro" value="<?php echo $bairro; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="70" class="form00" style="width:177px;" type="text" name="cidade" value="<?php echo $cidade; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="2" class="form00" style="width:25px;" type="text" name="estado" value="<?php echo $estado; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="8" class="form00" style="width:70px;" type="text" name="cep" value="<?php echo $cep; ?>" /></td>
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                        <table cellpadding="0" cellspacing="0">
                                     	<tr>
                                        	<td>Data de Nasc.:</td>
                                            <td>&nbsp;</td>
                                            <td>CPF/CNPJ:</td>
                                            <td>&nbsp;</td>
                                            <td>Tipo:</td>
                                            <td>&nbsp;</td>
                                            <td>E-Mail:</td>
                                        </tr>
                                        <?php
                                        if ($dt_nasc){
                                            $datanasc = date("d/m/Y", strtotime($dt_nasc));
                                        }else{
                                            $datanasc = "";
                                        }
                                        
                                        ?>
                                        <tr>
                                        	<td><input class="form00" style="width:70px;" type="text" name="dt_nasc" value="<?php echo $datanasc; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="15" class="form00" style="width:120px;" type="text" name="documento" value="<?php echo $documento; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="2" class="form00" style="width:25px;" type="text" name="tipo" value="<?php echo $tipo; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="80" class="form00" style="width:234px;" type="text" name="email" value="<?php echo $email; ?>" /></td>
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                       <table cellpadding="0" cellspacing="0">
                                     	<tr>
                                        	<?php if ($tipocli==1) { ?>
                                            <td>Inscr. Est</td>
                                            <?php } ?>
                                            <td>DDD</td>
                                            <td>&nbsp;</td>
                                            <td>Telefone:</td>
                                            <td>&nbsp;</td>
                                            <td>DDD:</td>
                                            <td>&nbsp;</td>
                                            <td>Celular:</td>
                                            <td>&nbsp;</td>
                                            <td>Senha:</td>
                                        </tr>
                                        <tr>
                                        	<?php if ($tipocli==1) { ?>
                                            <td><input maxlength="20" class="form00" style="width:95px;" type="text" name="ie" value="<?php echo $ie; ?>" /></td>
                                            <?php } ?>
                                            <td><input maxlength="3" class="form00" style="width:25px;" type="text" name="dddfone" value="<?php echo $dddfone; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="8" class="form00" style="width:75px;" type="text" name="fone" value="<?php echo $fone; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="3" class="form00" style="width:25px;" type="text" name="dddcel" value="<?php echo $dddcel; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="8" class="form00" style="width:75px;" type="text" name="celular" value="<?php echo $celular; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="15" class="form00" style="width:110px;" type="text" name="senha" value="<?php echo $senha; ?>" /></td>
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                       <table cellpadding="0" cellspacing="0">
                                     	<tr>
                                        	<td>Twitter</td>
                                            <td>&nbsp;</td>
                                            <td>Facebook</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                        	<td><input maxlength="30" class="form01" style="width:125px;" type="text" name="twitter" value="<?php echo $dstwitter; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td><input maxlength="50" class="form01" style="width:125px;" type="text" name="facebook" value="<?php echo $facebook; ?>" /></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                     </table>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome">
                                       Receber Emails promocionais:<br />
                                       <input maxlength="3" class="form00" style="width:25px;" type="text" name="conheceu" value="<?php echo $conheceu; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Dados" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php mysql_close($con);?>