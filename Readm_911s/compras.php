<?php
include 'auth.php';
include 'lib.php';

$status = request("st");
$PHP_SELF = "compras.php";
if (!$status)
    $status = "A";
$pagina = request("pagina");

$statussep = request("stsep");

$dataini = request("dataini");
$datafim = request("datafim");
$pesq_nom = request("nomeps");
$pesq_email = request("emailps");
$cidade = request("cidade");
$estado = request("estado");
$nrpedido = request("nrpedido");

$sqlnf = "select NR_SEQNF_NFRC from notas_fiscais ORDER BY DT_EMISSAO_NFRC desc, NR_SEQ_NFE_NFRC desc limit 1";
$stnf = mysql_query($sqlnf);
$nr_nfe = 0;
if (mysql_num_rows($stnf) > 0) {
    $rownf = mysql_fetch_row($stnf);
    $nr_nfe = $rownf[0];
}

$nr_nfe++;

$num_por_pagina = 80;
if (!$pagina) {
    $pagina = 1;
}
$primeiro_registro = ($pagina * $num_por_pagina) - $num_por_pagina;

$consulta = "SELECT COUNT(*) from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_LOJA_COSO = $SS_loja";
if ($pesq_nom)
    $consulta .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
if ($pesq_email)
    $consulta .= " AND DS_EMAIL_CASO LIKE '%$pesq_email%'";
if ($estado)
    $consulta .= " AND DS_UF_CASO = '$estado'";
if ($cidade)
    $consulta .= " AND DS_CIDADE_CASO like '%$cidade%'";
if ($nrpedido) {
    $consulta .= " AND NR_SEQ_COMPRA_COSO like '%$nrpedido%'";
} else {
    if ($statussep == 'S') {
        $consulta .= " AND ST_COMPRA_COSO = 'P' and ST_SEPARADO_COSO = 'S'";
    } else {
        if ($status == 'P') {
            $consulta .= " AND ST_COMPRA_COSO = '$status' and (ST_SEPARADO_COSO <> 'S' or ST_SEPARADO_COSO is null)";
        } else {
            $consulta .= " AND ST_COMPRA_COSO = '$status'";
        }
    }
}
if ($dataini) {
    if (!$datafim)
        $datafim = date("d/m/Y") . " 23:59:59";
    $consulta .= " and DT_COMPRA_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')";
}
list($total_usuarios) = mysql_fetch_array(mysql_query($consulta, $con));
?>
<?php include 'topo.php'; ?>

<script language="javascript">
    function recriar(idcomp) {
        var confirma = confirm("Tem certeza que voce quer recriar essa compra? Ela sera cancelada e uma nova compra com a mesma data sera criada.")
        if (confirma) {
            document.location.href = 'compras_new.php?pg=<?php echo $pagina; ?>&idc=' + idcomp;
        } else {
            return false
        }
//    window.open('compras_new.php?pg=<?php echo $pagina; ?>&idc='+idcomp);    
    }

    function confirma(idcomp) {
        var confirma = confirm("Confirma a Exclusao dessa compra e seus itens?\nEsta operacao nao podera ser revertida.")
        if (confirma) {
            document.location.href = 'compras_del.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idc=' + idcomp;
        } else {
            return false
        }
    }

    function confirmaC(idcomp) {
        var confirma = confirm("Confirma o Cancelamento dessa compra e seus itens?")
        if (confirma) {
            document.location.href = 'compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&idgrp=' + idcomp;
        } else {
            return false
        }
//     window.open('compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&idgrp='+idcomp);    
    }
    
       function confirmaCSME(idcomp) {
        var confirma = confirm("Confirma o Cancelamento SEM movimentar Estoque?")
        if (confirma) {
            document.location.href = 'compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&stsme=true&idgrp=' + idcomp;
        } else {
            return false
        }
//     window.open('compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&idgrp='+idcomp);    
    }

    function confirmaPg(idcomp) {
        var confirma = confirm("Confirma o Pagamento dessa compra? Um e-mail de confirmacao sera enviado ao cliente.")
        if (confirma) {
            document.location.href = 'compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=P&idgrp=' + idcomp;
        } else {
            return false
        }
    }

    function delfrete(idf) {
        var confirma = confirm("Confirma a Exclusao desse frete?\nEsta operacao nao podera ser revertida.")
        if (confirma) {
            document.location.href = 'fretecruz_del.php?idf=' + idf;
        } else {
            return false
        }
    }

    function GeraCusto() {
        document.frmEtiq.action = "gera_custo.php";
        document.frmEtiq.target = "_blank";
        document.frmEtiq.submit();
    }

    function GeraCorreios() {
        $('input:checkbox:checked.grupo1').each(function ()
        {
            window.open('excel_correio.php?ped=' + $(this).val());
        });
    }

    function GeraNfe() {
        $("#nfe").val($("#nr_nfe").val());
        document.frmEtiq.action = "compras_nfe20.php";
        document.frmEtiq.target = "_blank";
        document.frmEtiq.submit();
    }

    function GeraEtiquetas() {
        $("#ini_et").val($("#ini_eti").val());
        document.frmEtiq.target = "_blank";
        document.frmEtiq.submit();
    }
</script>
<script language="JavaScript" src="calendar1.js"></script>
<table class="textosjogos" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">

                        <ul id="titulos_abas" style="width: 100%;">
                            <?php
                            if ($status == "A") {
                                $tit_page = "Compras em Aberto";
                                echo "<li id='menu1' class='abaativa'>Compras em Aberto</li>";
                            } else {
                                echo "<li id='menu1' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=A'\">Compras em Aberto</li>";
                            }
                            if ($status == "P" && $statussep != "S") {
                                $tit_page = "Compras Pagas";
                                echo "<li id='menu2' class='abaativa'>Compras Pagas</li>";
                            } else {
                                echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=P'\">Compras Pagas</li>";
                            }
                            if ($statussep == "S") {
                                $tit_page = "Expedidas";
                                echo "<li id='menu2' class='abaativa'>Expedidas</li>";
                            } else {
                                echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=P&stsep=S'\">Expedidas</li>";
                            }
                            if ($status == "V") {
                                $tit_page = "Compras Enviadas";
                                echo "<li id='menu2' class='abaativa'>Compras Enviadas</li>";
                            } else {
                                echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=V'\">Compras Enviadas</li>";
                            }
                            if ($status == "E") {
                                $tit_page = "Compras Entregues";
                                echo "<li id='menu2' class='abaativa'>Compras Entregues</li>";
                            } else {
                                echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=E'\">Compras Entregues</li>";
                            }
                            if ($status == "C") {
                                $tit_page = "Compras Canceladas";
                                echo "<li id='menu3' class='abaativa'>Compras Canceladas</li>";
                            } else {
                                echo "<li id='menu3' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=C'\">Compras Canceladas</li>";
                            }
                            echo "<li id='menu10' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='prevenda.php'\">Pr&eacute;-Vendas</li>";
                            ?>
                        </ul>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<?php if ($status != "F") { ?>
    <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#FFFFFF">

                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                                <tr><form action="compras.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>" method="post" name="form1">
                                    <td>
                                        <input type="Button" value="Gerar Etiquetas" onClick="GeraEtiquetas();" class="form00" style="width:100px;height:20px;" />
                                        <input style="width:15px;height:14px;" class="frm_pesq" type="text" name="ini_eti" id="ini_eti" value="1" />
                                        <input type="Button" value="Gerar Custo" onClick="GeraCusto();" class="form00" style="width:80px;height:20px;" />
                                        <input type="Button" value="Gerar NFe" onClick="GeraNfe();" class="form00" style="width:65px;height:20px;" />
                                        <input style="width:40px;height:14px;" class="frm_pesq" type="text" name="nr_nfe" id="nr_nfe" value="<?php echo $nr_nfe; ?>" />
                                        <input type="Button" value="Gerar Correio" onClick="GeraCorreios();" class="form00" style="width:80px;height:20px;" />
                                    </td>
                                    <td height="20" align="right" valign="middle">
                                        <strong>Pedido: </strong><input style="width:50px;height:14px;" class="frm_pesq" type="text" name="nrpedido" value="<?php echo $nrpedido; ?>" />
                                        <strong>Nome: </strong><input style="width:110px;height:14px;" class="frm_pesq" type="text" name="nomeps" value="<?php echo $pesq_nom; ?>" />
                                        <strong>E-mail: </strong><input style="width:110px;height:14px;" class="frm_pesq" type="text" name="emailps" value="<?php echo $pesq_email; ?>" />
                                        <strong>Cidade/UF: </strong>
                                        <input style="width:100px;height:14px;" class="frm_pesq" type="text" name="cidade" value="<?php echo $cidade; ?>" />
                                        <select name="estado" class="input" id="estado" style="width:45px;"/>
                                    <option value="">--</option>
                                    <option value="AC">AC</option> 
                                    <option value="AL">AL</option> 
                                    <option value="AP">AP</option> 
                                    <option value="AM">AM</option> 
                                    <option value="BA">BA</option> 
                                    <option value="CE">CE</option> 
                                    <option value="DF">DF</option> 
                                    <option value="ES">ES</option> 
                                    <option value="GO">GO</option> 
                                    <option value="MA">MA</option> 
                                    <option value="MT">MT</option> 
                                    <option value="MS">MS</option> 
                                    <option value="MG">MG</option> 
                                    <option value="PA">PA</option> 
                                    <option value="PB">PB</option> 
                                    <option value="PR">PR</option> 
                                    <option value="PE">PE</option> 
                                    <option value="PI">PI</option> 
                                    <option value="RJ">RJ</option> 
                                    <option value="RN">RN</option> 
                                    <option value="RS">RS</option> 
                                    <option value="RO">RO</option> 
                                    <option value="RR">RR</option> 
                                    <option value="SC">SC</option> 
                                    <option value="SP">SP</option> 
                                    <option value="SE">SE</option> 
                                    <option value="TO">TO</option> 
                                    </select> 
                                    <!-- 
                                                <strong>Data Inicial: </strong><input style="width:80px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                                                <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a>
                                                <strong>Data Final: </strong><input style="width:80px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                                                <a href="javascript:cal2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a>
                                    -->
                                    &nbsp;&nbsp;<input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />&nbsp;&nbsp;
                                    </td>
                                </form>
                                <script language="JavaScript">

                                </script>
                    </tr>
                </table>
                <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                    <form action="compras_etiquetas.php" method="post" name="frmEtiq" id="frmEtiq">
                        <input type="hidden" name="nfe" id="nfe" />
                        <input type="hidden" name="ini_et" id="ini_et" />
                        <tr>
                            <td align="center" width="15">&nbsp;</td>
                            <td align="center" width="60"><strong>NRO</strong></td>
                            <td align="center" width="145"><strong>Data Compra</strong></td>
                            <td align="left"><strong>Nome</strong></td>
                            <td align="left" width="150"><strong>E-mail</strong></td>
                            <td align="left" width="150"><strong>Rastreamento</strong></td>
                            <td align="center" width="100"><strong>Telefone</strong></td>
                            <td align="center" width="100"><strong>Forma Pgto.</strong></td>
                            <td align="center" width="120"><strong>Valor Total</strong></td>
                            <td align="center" width="30"><strong>Parc</strong></td>
                            <td align="center" width="30"><strong>ST</strong></td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                            <td align="center" width="27">&nbsp;</td>
                        </tr>
                </table>
                <ul class="compras">
                    <?php
                    $sql = "SELECT NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, CONVERT(DS_NOME_CASO USING utf8), DS_EMAIL_CASO, DS_DDDFONE_CASO,
                                         DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO, DT_NASCIMENTO_CASO, ST_COMPRA_COSO, VL_DESCPROMO_COSO,
                                         DS_DESCPROMO_COSO, DS_CELULAR_CASO, DS_TWITTER_CACH, DS_OBS_COSO, TP_CADASTRO_CACH, DS_FACEBOOK_CACH, ST_NOVOPGTO_COSO,
                                         NR_SEQ_PROMO_COSO, DS_RASTREAMENTO_COSO, ST_COMPROU_NIVER
                                         from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND
                                         NR_SEQ_LOJA_COSO = $SS_loja ";
                    if ($dataini) {
                        if (!$datafim)
                            $datafim = date("d/m/Y") . " 23:59:59";
                        $sql .= " and DT_COMPRA_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') ";
                    }
                    if ($pesq_nom)
                        $sql .= " AND DS_NOME_CASO LIKE '%$pesq_nom%'";
                    if ($pesq_email)
                        $sql .= " AND DS_EMAIL_CASO LIKE '%$pesq_email%'";
                    if ($estado)
                        $sql .= " AND DS_UF_CASO = '$estado'";
                    if ($cidade)
                        $sql .= " AND DS_CIDADE_CASO like '%$cidade%'";
                    if ($nrpedido) {
                        $sql .= " AND NR_SEQ_COMPRA_COSO like '%$nrpedido%'";
                    } else {
                        if ($statussep == 'S') {
                            $sql .= " AND ST_COMPRA_COSO = 'P' and ST_SEPARADO_COSO = 'S'";
                        } else {
                            if ($status == 'P') {
                                $sql .= " AND ST_COMPRA_COSO = '$status' and (ST_SEPARADO_COSO <> 'S' or ST_SEPARADO_COSO is null) ";
                            } else {
                                $sql .= " AND ST_COMPRA_COSO = '$status'";
                            }
                        }
                    }
                    $sql .= " ORDER BY NR_SEQ_COMPRA_COSO desc LIMIT $primeiro_registro, $num_por_pagina";


                    $st = mysql_query($sql);
                    $mostrapag = false;
                    if (mysql_num_rows($st) > 0) {
                        $mostrapag = true;
                        $x = 0;
                        $totger = 0;
                        while ($row = mysql_fetch_row($st)) {
                            $id_compra = $row[0];
                            $dt_compra = $row[1];
                            $formapgto = $row[2];
                            $valor = $row[3];
                            $nome = $row[4];
                            $email = $row[5];
                            $dddfone = $row[6];
                            $fone = $row[7];
                            $idcli = $row[8];
                            $parcelas = $row[9];

                            $datanasc = $row[10];
                            $status = $row[11];

                            $dian = date("d", strtotime($datanasc));
                            $mesn = date("m", strtotime($datanasc));

                            $diac = date("d", strtotime($dt_compra));
                            $mesc = date("m", strtotime($dt_compra));

                            $compraniver = false;
                            $textodestaque = "";

                            $totger += $valor;

                            if ($x == 0) {
                                $bg = "#FFFFFF";
                                $x = 1;
                            } else {
                                $bg = "#ECECFF";
                                $x = 0;
                            }

                            $desconto = $row[12];
                            $textopro = $row[13];
                            $celular = $row[14];

                            $celular = str_replace("-", "", $celular);
                            $celular = str_replace(".", "", $celular);
                            $celular = str_replace("/", "", $celular);
                            $celular = str_replace("=", "", $celular);
                            $celular = str_replace(" ", "", $celular);

                            $twitter = $row[15];
                            $dsobs = $row[16];

                            $tipocad = $row[17];

                            $facebook = $row[18];

                            $stnvpgto = $row[19];
                            $codpromo = $row[20];

                            $rastreamento = $row[21];

                            $facebook = trim(str_replace("-", "", $facebook));

                            if ($facebook) {
                                if (strpos($facebook, "http://") <= 0) {
                                    $facebook = str_replace("http//", "", $facebook);
                                    $facebook = str_replace("http/", "", $facebook);
                                    $facebook = str_replace("http://", "", $facebook);
                                    $facebook = str_replace("http://www.reverbcity.com/Readm_911s/", "", $facebook);

                                    if (strpos($facebook, "facebook.com/") > 0) {
                                        $facebook = str_replace("www.facebook.com/", "", $facebook);
                                        $facebook = str_replace("facebook.com/", "", $facebook);
                                        $facebook = str_replace("facebook.com.br/", "", $facebook);
                                        $facebook = str_replace("www.facebook.com.br/", "", $facebook);
                                    }

                                    $facebook = "http://facebook.com/" . $facebook;
                                }
                            }

                            //if (strpos($textopro,"temos um presente para voc") > 0 || strpos($textopro,"No mes do seu aniversario")){
                            if ($row[22] == '1' || strpos($textopro, "s do seu anivers")) {
                                $textodestaque = "Compra de Aniversariante";
                                $bg = "#B3FE97";
                            }

                            if ((strpos($textopro, "primeira compra") || (strpos($textopro, "150,00! Escolha j")) || (strpos($textopro, "130,00! Escolha j"))) > 0 || strpos($textopro, " de desconto para serem usando em uma pr")) {
                                $textodestaque = "Primeira Compra";
                                $bg = "#FBFE98";
                            }

                            if (strpos($textopro, "romo dia da M") > 0) {
                                $textodestaque = "Promo Dia da M&uacute;sica";
                                $bg = "#e8ce52";
                            }

                            if (strpos($textopro, "Dia dos Namorados") > 0) {
                                $textodestaque = "Promo Dia dos Namorados";
                                $bg = "#FBDBFC";
                            }

                            if (strpos($textopro, "Shirt Club") > 0) {
                                $textodestaque = "T-Shirt Club";
                                $bg = "#e8ce52";
                            }

                            if (strpos($textopro, "Tee de Banda com ChocoKisses") > 0) {
                                $textodestaque = "Promo Tee + Choco";
                                $bg = "#F5DD82";
                            }

                            if (strpos($textopro, "Mugshot Jimi Hendrix") > 0) {
                                $textodestaque = "Promo Jeans F + Hendrix";
                                $bg = "#F5DD82";
                            }

                            if (strpos($textopro, "Dia Dos Namorados") > 0) {
                                $textodestaque = "Dia Dos Namorados";
                                $bg = "#e8ce52";
                            }

                            $sqlb = "SELECT NR_SEQ_CUPOM_CURC from cupons where NR_SEQ_COMPRA_USO_CURC = $id_compra";
                            $stb = mysql_query($sqlb);
                            if (mysql_num_rows($stb) > 0) {
                                $textodestaque = "Cupom de Desconto";
                                $bg = "#C8CEFF";
                            }

                            if ($tipocad == 2) {
                                $textodestaque = "Vendedor";
                                $bg = "#e1a463";
                            }

                            if ($tipocad == 3) {
                                $textodestaque = "Parceiro";
                                $bg = "#ffa3b4";
                            }

                            if ($codpromo == 2) {
                                $textodestaque = "Promo leva 2a por 50%";
                                $bg = "#FCD6FE";
                            }

                            if ($codpromo == 3) {
                                $textodestaque = "Promo 65+ Dia do Cliente";
                                $bg = "#FCD6FE";
                            }

                            if ($stnvpgto == 'S') {
                                $textodestaque = "Aguardando novo Pgto.";
                                $bg = "#b8bbe1";
                            }
                            ?>
                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="30" bgcolor="<?php echo $bg; ?>">
                                <tr>
                                    <td align="center" width="10"><input class="grupo1" name="etiq[]" type="checkbox" value="<?php echo $id_compra; ?>" /></td>
                                    <td align="center" width="60"><strong><?php echo $id_compra; ?></strong></td>
                                    <td align="center" width="145" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                                    <td align="left"><strong><?php echo utf8_encode(ChecaClubStyle($idcli, $nome)); ?></strong><?php if ($textodestaque) echo " ($textodestaque)"; ?></td>
                                    <td align="left" width="150" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>?subject=<?php echo htmlspecialchars("Reverbcity - Pedido $id_compra - Cancelamento"); ?>" class="linksmenu"><?php echo $email; ?></a></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $rastreamento ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $dddfone . " " . $fone; ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $formapgto; ?></td>
                                    <td align="center" width="120" nowrap="nowrap"><strong>R$ <?php echo number_format($valor, 2, ",", "."); ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $parcelas; ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="27"><a href="compras_imprimir.php?idcli=<?php echo $idcli; ?>&idc=<?php echo $id_compra; ?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $id_compra ?>" class="thickbox"><img src="img/icone-imprimir.png" width="16" height="16" border="0" alt="Imprimir" /></a></td>
                                    <td align="center" width="27"><a href="compras_ver.php?idcli=<?php echo $idcli; ?>&idc=<?php echo $id_compra; ?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $id_compra ?>" class="thickbox"><img src="img/compras_ver.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
                                    <td align="center" width="27"><a href="clientes_alt.php?idc=<?php echo $idcli; ?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                    <?php if ($status == "A") { ?>
                                        <td align="center" width="27"><a href="#" title="Recriar Compra" onclick="recriar(<?php echo $id_compra; ?>);"><img src="img/money2.gif" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "A") { ?>
                                        <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=A&idgrp=<?php echo $id_compra; ?>" title="Re-Abrir Compra"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status == "P" && $statussep != 'S') { ?>
                                        <td align="center" width="27"><a href="compras_separa.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idgrp=<?php echo $id_compra; ?>" title="Separar Para Envio"><img src="img/ico_separar.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "P") { ?>
                                        <td align="center" width="27"><a onclick="confirmaPg(<?php echo $id_compra; ?>);" href="#" title="Confirmar Pagamento"><img src="img/ico_check.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "V") { ?>
                                        <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=V&idgrp=<?php echo $id_compra; ?>" title="Compra Enviada"><img src="img/ico_entrega.gif" width="18" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "E") { ?>
                                        <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=E&idgrp=<?php echo $id_compra; ?>" title="Compra Entregue"><img src="img/ico_cxopen.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "C") { ?>
                                        <td align="center" width="27"><a href="#" title="Cancelar Compra" onclick="confirmaC(<?php echo $id_compra; ?>);"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if ($status != "C") { ?>
                                        <td align="center" width="27"><a href="#" title="Cancelar Compra Sem Movimentar Estoque" onclick="confirmaCSME(<?php echo $id_compra; ?>);"><img src="img/altera_status.png" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>                                        
                                    <?php if ($SS_nivel > 100) { ?>
                                        <td align="center" width="27"><a href="#" title="Deletar Compra" onclick="confirma(<?php echo $id_compra; ?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <?php if (strlen($celular) == 8) { ?>
                                        <td align="center" width="27"><a href="envia_sms.php?idcli=<?php echo $idcli; ?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                    <?php } else { ?>
                                        <td align="center" width="27">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($twitter) { ?>
                                        <td align="center" width="27"><a href="http://twitter.com/<?php echo $twitter; ?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                    <?php } else { ?>
                                        <td align="center" width="27">&nbsp;</td>
            <?php } ?>
                            <?php if ($facebook) { ?>
                                        <td align="center" width="24"><a href="<?php echo $facebook; ?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                            <?php } else { ?>
                                        <td align="center" width="24">&nbsp;</td>
            <?php } ?>
                                </tr>
                            </table>
            <?php
        }
        ?>
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                            <tr>
                                <td align="center" width="60">&nbsp;</td>
                                <td align="center" width="145">&nbsp;</td>
                                <td align="left">&nbsp;</td>
                                <td align="left" width="150">&nbsp;</td>
                                <td align="center" width="100">&nbsp;</td>
                                <td align="right" width="100"><strong>Total:</strong></td>
                                <td align="center" width="120"><strong>R$ <?php echo number_format($totger, 2, ",", "."); ?></strong></td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                            </tr>
                        </table>
                        </form>
        <?php
    } else {
        ?>
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#FFFFFF">
                            <tr>
                                <td align="center" height="80">Nenhum registro encontrado!</td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>

                </ul>
                    <?php if ($mostrapag) { ?>
                    <ul class="paginacao2" style="width: 1000px;">
                        <?php
                        $total_paginas = $total_usuarios / $num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                            $prev_link = "<li><a href=\"$PHP_SELF?st=$status&pagina=$prev&nomeps=$pesq_nom&emailps=$pesq_email&estado=$estado&cidade=$cidade&dataini=$dataini&datafim=$datafim&stsep=$statussep\">Anterior</a></li>";
                        } else {
                            $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                            $next_link = "<li><a href=\"$PHP_SELF?st=$status&pagina=$next&nomeps=$pesq_nom&emailps=$pesq_email&estado=$estado&cidade=$cidade&dataini=$dataini&datafim=$datafim&stsep=$statussep\">Proxima</a></li>";
                        } else {
                            $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x = 1; $x <= $total_paginas; $x++) {
                            if ($x == $pagina) {
                                $painel .= "<li>[$x]</li> ";
                            } else {
                                $painel .= "<li><a href=\"$PHP_SELF?st=$status&pagina=$x&nomeps=$pesq_nom&emailps=$pesq_email&estado=$estado&cidade=$cidade&dataini=$dataini&datafim=$datafim&stsep=$statussep\">[$x]</a></li>";
                            }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";

                        mysql_close($con);
                        ?>                
                    </ul> <!-- /paginacao -->
    <?php } ?>
            </td>
        </tr>
    </table>
    <br />
    </td>
    </tr>
    </table>

<?php } ?>  
<?php include 'rodape.php'; ?>