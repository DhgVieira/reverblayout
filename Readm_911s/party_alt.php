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
                      <li id="menuDepo" class="abaativa">Party</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='party.php';">Partys Cadastradas</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Party</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<?
						 $idp = request("idp");
						  $sql = "select NR_SEQ_PARTY_PARC, DT_PARTY_PARC, DS_PARTY_PARC, DS_CIDADE_PARC, DS_UF_PARC, DT_CADASTRO_PARC, ST_PARTY_PARC from partys WHERE NR_SEQ_PARTY_PARC = $idp";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_part	   = $row[0];
					         $dt_party	   = $row[1];
							 $ds_party	   = $row[2];
							 $ds_cidade	   = $row[3];
							 $ds_uf	   	   = $row[4];
							 $dt_cad	   = $row[5];
							 $status	   = $row[6];
							}
						  }
						 ?>
                         <form action="party_alt2.php" method="post" name="myform" enctype="multipart/form-data">
                         <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                            <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="party">
                                       Party:<br />
                                       <input class="form01" type="text" id="party" name="party" value="<?php echo $ds_party; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="data">
                                       Party Data:<br />
                                       <select name="dia" class="input" id="dia" style="width:40px">
									   <?php for ($f=1;$f<=31;$f++){?>
                                            <option value="<?php echo $f; ?>"><?php echo $f; ?></option>
                                       <?php }?>     
                                      </select>
                                      <select name="mes" class="input" id="mes" style="width:100px">
                                            <option value="1">Janeiro</option>
                                            <option value="2">Fevereiro</option>
                                            <option value="3">Março</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Maio</option>
                                            <option value="6">Junho</option>
                                            <option value="7">Julho</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option>
                                      </select>
                                      <select name="ano" class="input" id="ano" style="width:55px">
                                       <?php for ($f=2008;$f<=2010;$f++){?>
                                            <option value="<?php echo $f; ?>"><?php echo $f; ?></option>
                                       <?php }?>
                                      </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="cidade">
                                       Cidade:<br />
                                       <input class="form01" type="text" id="cidade" name="cidade" value="<?php echo $ds_cidade; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="estado">
                                       Estado:<br />
                                       <select name="estado" class="form01" id="estado" style="height:25px;" />
                                        <option value="AC">Acre</option> 
                                        <option value="AL">Alagoas</option> 
                                        <option value="AP">Amapá</option> 
                                        <option value="AM">Amazonas</option> 
                                        <option value="BA">Bahia</option> 
                                        <option value="CE">Ceará</option> 
                                        <option value="DF">Distrito Federal</option> 
                                        <option value="ES">Espírito Santo</option> 
                                        <option value="GO">Goiás</option> 
                                        <option value="MA">Maranhão</option> 
                                        <option value="MT">Mato Grosso</option> 
                                        <option value="MS">Mato Grosso do Sul</option> 
                                        <option value="MG">Minas Gerais</option> 
                                        <option value="PA">Pará</option> 
                                        <option value="PB">Paraíba</option> 
                                        <option value="PR">Paraná</option> 
                                        <option value="PE">Pernambuco</option> 
                                        <option value="PI">Piauí</option> 
                                        <option value="RJ">Rio de Janeiro</option> 
                                        <option value="RN">Rio Grande do Norte</option> 
                                        <option value="RS">Rio Grande do Sul</option> 
                                        <option value="RO">Rondônia</option> 
                                        <option value="RR">Roraima</option> 
                                        <option value="SC">Santa Catarina</option> 
                                        <option value="SP">São Paulo</option> 
                                        <option value="SE">Sergipe</option> 
                                        <option value="TO">Tocantins</option> 
                                    </select>        
                                     </label>
                                   </li>
                                   <li>
                                      <label for="flyer">
                                        Flyer:<br />
                                        <input class="form02" type="file" name="FILE1" size="60" style="height:25px;" />
                                      </label>
                                    </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Party" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    	<script language="JavaScript">
						   document.myform.dia.value = "<?php echo date("j", strtotime($dt_party)); ?>";
						   document.myform.mes.value = "<?php echo date("n", strtotime($dt_party)); ?>";
						   document.myform.ano.value = "<?php echo date("Y", strtotime($dt_party)); ?>";
						   document.myform.estado.value = "<?php echo $ds_uf; ?>";
						</script>
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
<? include 'rodape.php'; ?>
<?php mysql_close($con);?>
