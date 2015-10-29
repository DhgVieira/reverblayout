<?php
include 'auth.php';
include 'lib.php';

$tipo = request("tip");
$cat = request("cat");

$totalgeral = 0;
$rodaind = false;

if ($tipo && $cat){
    $sql = "select NR_SEQ_CADASTRO_CASO
            from cadastros, compras, cestas, produtos
            where
            	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
            	NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
            	NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
            and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' 
            AND NR_SEQ_TIPO_PRRC = $tipo 
            and NR_SEQ_CATEGORIA_PRRC = $cat and
            DS_DDDCEL_CASO is not null and DS_CELULAR_CASO is not null ";
    $sql .= "group by NR_SEQ_CADASTRO_CASO";
    
    $st2 = mysql_query($sql);
    if (mysql_num_rows($st2) > 0) {
        $totparc  = mysql_num_rows($st2);
    }
    $totalgeral += $totparc;
}else{
    $rodaind = true;
}

if ($tipo){
    $sql = "select DS_CATEGORIA_PTRC from produtos_tipo WHERE NR_SEQ_CATEGPRO_PTRC = $tipo";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) { 
        $row = mysql_fetch_row($st);
        $dstipo = $row[0];
        
        $sql = "select NR_SEQ_CADASTRO_CASO
                from cadastros, compras, cestas, produtos
                where
                	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
                	NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
                	NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' AND NR_SEQ_TIPO_PRRC = $tipo 
                and DS_DDDCEL_CASO is not null and DS_CELULAR_CASO is not null ";
        $sql .= "group by NR_SEQ_CADASTRO_CASO";
        
        if ($rodaind){
            $st2 = mysql_query($sql);
            if (mysql_num_rows($st2) > 0) {
                $totparc  = mysql_num_rows($st2);
            }
            $totalgeral += $totparc;
        }
    }
}

if ($cat){
    $sql = "select DS_CATEGORIA_PCRC from produtos_categoria WHERE NR_SEQ_CATEGPRO_PCRC = $cat";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) { 
        $row = mysql_fetch_row($st);
        $dscat = $row[0];
        
        $sql = "select NR_SEQ_CADASTRO_CASO
                from cadastros, compras, cestas, produtos
                where
                	NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
                	NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
                	NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' and NR_SEQ_CATEGORIA_PRRC = $cat 
                and DS_DDDCEL_CASO is not null and DS_CELULAR_CASO is not null ";
        $sql .= "group by NR_SEQ_CADASTRO_CASO";
        
        if ($rodaind){
            $st2 = mysql_query($sql);
            if (mysql_num_rows($st2) > 0) {
                $totparc  = mysql_num_rows($st2);
            }
            $totalgeral += $totparc;
        }

    }
}

$subject = "Sale Reverbcity! Queima de Buttons! Garanta ja o seu! www.reverbcity.com";

//switch($cat){
//    case "57":
//        $subject  = "Black Friday Reverbcity! Todas as canecas estao com 20% OFF, aproveite os descontos em todo o site! http://rvb.la/CanecasRock  ";
//        break;
//    case "107":
//        $subject  = "Caminhe pelas trilhas do rock com o desconto de 20% em todos os chinelos, apenas hj durante a Black Friday! http://rvb.la/Chinelos";
//        break;
//    case "46":
//        $subject  = "Black Friday na Reverbcity com 40% de desconto em todas as almofadas, aproveite! http://rvb.la/Almofadas";
//        break;
//    case "8":
//        $subject  = "Ja viu nossa nova colecao de verao? Somente hj com 10% de desconto, aproveite! http://rvb.la/Summer2013";
//        break;
//}
//
//switch($tipo){
//    case "11":
//        $subject  = "Durante a Black Friday todas as Revistas Zupi estao com 10% de desconto aqui na Reverbcity! http://rvb.la/Revistas";
//        break;
//}


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
                      <li id="menuDepo" class="abaativa">Envio de SMS</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);">Enviando SMS</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                       
                    <div id="Criar">
                         <p style="margin: 0 0 0 20px;"><strong>Enviando SMS para Compradores de <?php echo $dstipo; ?> - <?php echo $dscat; ?></strong></p>
                         <p style="margin: 0 0 0 20px;"><strong>Total de compradores: <?php echo $totalgeral; ?></strong></p>
                         <form action="envia_mail_compradores2.php" method="post">
                             <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" />
                             <input type="hidden" name="cat" value="<?php echo $cat; ?>" />
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