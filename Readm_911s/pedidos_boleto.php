<?php
include 'auth.php';
include 'lib.php';
$aba = request("aba");
$_SESSION["clitemp"] = "";
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src='scripts/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.ajaxQueue.js'></script>
<!-- <script type='text/javascript' src='scripts/autocomplete/thickbox-compressed.js'></script> -->
<script type='text/javascript' src='scripts/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.functions_boleto.js'></script>
<link rel="stylesheet" type="text/css" href="scripts/autocomplete/jquery.autocomplete.css" />
<script language="JavaScript" src="calendar1.js"></script>
<style>
    #cesta {
        width: 600px;
        float: left;
        font-family: Verdana;
        font-size: 12px;
    }
    #resumo {
        width: 220px;
        float: left;
        font-size: 12px;
        margin: 0 0 0 20px;
        padding: 0;
    }
    ul.carrinho {
	padding:0;
	margin:0 0 0 0;
	}
	
	ul.carrinho li {
	width:98%; height:52px;
	border-bottom:1px dashed #dad7cf;
	padding:0px 0 5px 10px;
	list-style-type:none;
	margin-bottom:5px;
	float:inherit;
	}

	ul.carrinho li span {
	padding-top:3px;
	float:left;
	}
	
	ul.carrinho li div {
	padding:3px 10px 0 0;
	text-align:right;
	float:right;
	}
	
	ul.carrinho li div a img {
	border:none;
	}
    
    .form_pedido {
	width:80px; height:20px;
	border:1px solid #dad7cf;
	font:13px Verdana, Helvetica, sans-serif;
	padding:4px;
	}
</style>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Pagamento Avulso</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Pagamento</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Dados do Cliente</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <form autocomplete="off" style="padding: 10px;" name="form1" id="form1" action="pedidos_boleto2.php" method="post">
                    <input type="hidden" name="cestaitens" id="cestaitens" value="" />
                    <div id="Ver">
                    
                    <div style="width: 950px;">
                    
                    <div id="cesta">
                    
                    Data de Vencimento:
                    <br />
          			<input type="text" id='vencimento' name='vencimento' class="form_pedido" style="width: 130px;" />
                    <br />    
                    <p>
            			Escolha o Produto:<br />
            			<input type="text" id='imageSearch' name='imageSearch' class="form_pedido" style="width: 330px;" />
                        Valor: R$ <input type="text" id='qtde' name='qtde' class="form_pedido" style="width: 60px;" value="" />
            			<input type="button" value="Adicionar" id="Adicionar" class="form_pedido" style="margin: 0; height: 30px; vertical-align: middle;" />
            		</p>
                    <ul class="carrinho">
                    </ul>
                    
                    </div>
                    
                    <div id="resumo">
                        <table width="100%" border="1" cellpadding="2" cellspacing="2">
                            <tr><td colspan="2" align="center" height="25"><strong>Resumo da Compra</strong></td></tr>
                            <tr>
                                <td align="left">&nbsp;<strong>Total</strong></td>
                                <td align="right">R$ <input type="text" id='total' name='total' class="form_pedido" style="width: 65px; border-color: #fff; text-align: right;" readonly="readonly" value="0.00" /></td>
                            </tr>
                        </table>
                    </div>
                   
                    </div>

                    </div> <!-- /ver -->
                    
                    <div id="Criar">
                    
                    <div style="width: 100%;">
                    <p>
            			Digite o Nome ou Documento:
            			<input type="text" id='imageSearch2' name='imageSearch2' class="form_pedido" style="width: 300px;" />
            			<input type="button" value="Adicionar" id="Adicionar2" class="form_pedido" style="margin: 0; height: 30px; vertical-align: middle;" />
            		</p>
                    </div>
                    
                    <div id="formcli" style="width: 900px;">
                        <input type="hidden" id='idcli' name='idcli' />
                        <div style="width: 500px; float: left; margin: 15px 0 0 0;">
                        <strong>Documento:</strong><span style="margin: 0 0 0 98px;"><strong>E-Mail:</strong></span><br />
                        <input type="text" id='docto' name='docto' class="form_pedido" style="width: 150px;" />
                        <input type="text" id='email' name='email' class="form_pedido" style="width: 252px;" />
                        <br />
                        <strong>Nome:</strong><br />
                        <input type="text" id='nome' name='nome' class="form_pedido" style="width: 414px;" />
                        <br />
                        <strong>Endereço:</strong><span style="margin: 0 0 0 310px;"><strong>Nº</strong></span><br />
                        <input type="text" id='endereco' name='endereco' class="form_pedido" style="width: 351px;" /> <input type="text" id='numero' name='numero' class="form_pedido" style="width: 50px;" />
                        <br />
                        <strong>Complemento:</strong><span style="margin: 0 0 0 132px;"><strong>Bairro:</strong></span><br />
                        <input type="text" id='complem' name='complem' class="form_pedido" style="width: 200px;" /> <input type="text" id='bairro' name='bairro' class="form_pedido" style="width: 200px;" />
                        <br />
                        <strong>Cidade:</strong><span style="margin: 0 0 0 172px;"><strong>Estado:</strong></span><br />
                        <input type="text" id='cidade' name='cidade' class="form_pedido" style="width: 200px;" /> 
                        <select name="estado" class="form_pedido" id="estado" style="width:200px; height: 28px; margin: 2px 0 0 0;">
                        	<option value="0">Escolha o Estado</option> 
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
                        <br />
                        <strong>CEP:</strong><span style="margin: 0 0 0 90px;"><strong>Sexo:</strong></span>
                        <span style="margin: 0 0 0 88px;"><strong>DDD:</strong></span> <span style="margin: 0 0 0 16px;"><strong>Fone:</strong></span>
                        <br />
                        <input type="text" id='cep' name='cep' class="form_pedido" style="width: 100px;" />
                        <select name="sexo" id="sexo" style="width:120px; height: 28px; margin: 2px 0 0 0;">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                        <input type="text" id='ddd' name='ddd' class="form_pedido" style="width: 30px;" />
                        <input type="text" id='fone' name='fone' class="form_pedido" style="width: 100px;" />
                        <br />
                        <strong>Twitter:</strong>
                        <input type="text" id='twitter' name='twitter' class="form_pedido" style="width: 100px;" />
                        </div>
                        <div id="enviar" style="float: left; width: 200px;">
                            <strong>Vendedor: </strong>
                            <select name="vendedor" id="vendedor" style="margin: 20px 0 0 0;">
                                <option value="<?php echo $SS_logadm; ?>"><?php echo $SS_login; ?></option>
                                <?php
                                //$sql = "select NR_SEQ_USUARIO_USRC, DS_LOGIN_USRC
//                                      from usuarios WHERE NR_SEQ_USUARIO_USRC NOT IN (8,9,10,".$SS_logadm.")
//                                      and NR_SEQ_LOJA_USRC = $SS_loja and ST_STATUS_USRC = 'A' order by DS_LOGIN_USRC";
//    						    $st = mysql_query($sql);
//    
//    						    if (mysql_num_rows($st) > 0) {
//    						  	  while($row = mysql_fetch_row($st)) {
//    							   $nrsequs	   = $row[0];
//    					           $dslogin	   = $row[1];
    							?>
                                  <!--<option value="<?php echo $nrsequs; ?>"><?php echo $dslogin; ?></option>-->
                                <?php
                                //  }
//                                }
                                ?>
                            </select><br />
                            <input type="submit" id="REGISTRAR" name="REGISTRAR" value="REGISTRAR" class="form_pedido" style="width: 100px; height: 200px; margin: 30px 0 0 0;" />
                        </div>
                    </div>

                    </div> <!-- /criar -->
                    
                    </form>
                  
					<script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  <?php
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaCriar\");";
							  break;
						  case 2:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					   }
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>