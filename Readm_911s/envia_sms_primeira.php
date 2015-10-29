<?php
include 'auth.php';
include 'lib.php';

$subject  = "Ola! Pedidos a partir de R$59 em itens fora de promoção ganham 15% de desconto para serem usando em uma próxima compra! http://rvb.la/Compra";
?>
<?php include 'topo.php'; ?>
<script type="text/javascript" language="javascript">
    function cont(){
    var msg = document.getElementById('msg');
    var cont = document.getElementById('contador');
    cont.value = 140-msg.value.length;
    var limite = 0;
    if ((140-msg.value.length) <= limite) {
     		msg.value = msg.value.substring(0, 140);
     	}
    }
</script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Envio Aniversariantes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);">Enviando Email</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                       
                    <div id="Criar">
                         <p style="margin: 0 0 0 20px;"><strong>Enviando SMS para os cadastros de ontem!!</strong></p>
                         <form action="envia_sms_primeira2.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo" class="fonte1">
                                       Texto do SMS:
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo" class="fonte1">
                                       <textarea name="msg" id="msg" cols="50" rows="5" class="frm_pesq" style="width:350px;" onKeyUp="javascript:cont();"><?php echo $subject ?></textarea>
                                     </label>
                                   </li>
                                   <li>
                                    <label for="carac" class="fonte1">
                                        Caracteres restantes: <input name="contador" id="contador" type="text" value="140" size="6" class="input-cycle" style="width:30px;" />
                                    </label>
                                   </li>
                                   <li>
                                     <label for="todos" class="fonte1">
                                       <input type="checkbox" name="todos" value="S" /> <strong>Enviar para todos</strong> (deixar sem marcar para enviar somente para quem n&atilde;o fez compra)
                                     </label>
                                   </li>
                                   <li>
                                        <input type="submit" id="postar" name="postar" value="Enviar SMSs" />
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    </div>

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
    <script type="text/javascript">cont();</script>
<?php include 'rodape.php'; ?>