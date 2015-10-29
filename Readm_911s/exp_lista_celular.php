<?php
include "../Readm_911s/lib.php";
include "../Readm_911s/auth.php";
?>
<?php

function getOptionsAllEstados() {
    $sql = "SELECT ds_estado_efrc as Nome, ds_sigla_efrc as Sigla FROM estados_frete;";
    $st = mysql_query($sql);

    $retorno = null;
    while ($resultSet = mysql_fetch_assoc($st)) {
        $retorno .= "<option value=$resultSet[Sigla]>$resultSet[Nome]</option>";
    }

    return $retorno;
}

if ($SS_logadm) {
    $sqll = "select ST_STATUS_USRC, NR_SEQ_FUNC_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC  = $SS_logadm";
    $stl = mysql_query($sqll);
    $nrfunc = 0;
    if (mysql_num_rows($stl) > 0) {
        $rowl = mysql_fetch_row($stl);
        $stlog = $rowl[0];
        $nrfunc = $rowl[1];
        if ($stlog != A) {
            $_SESSION["SS_sessao"] = "";
            $_SESSION["SS_logadm"] = "";
            $_SESSION["SS_login"] = "";
            $_SESSION["SS_acesso"] = "";
            $_SESSION["SS_nivel"] = "";
            $_SESSION["SS_loja"] = "";

            setcookie("ck_sessao", "", time() - 3600, "/");
            setcookie("ck_logadm", "", time() - 3600, "/");
            setcookie("ck_login", "", time() - 3600, "/");
            setcookie("ck_nivel", "", time() - 3600, "/");
            setcookie("ck_acesso", "", time() - 3600, "/");
            setcookie("ck_loja", "", time() - 3600, "/");

            Header("Location: login.php");
            exit();
        }
    }
}

$sqlsms = "select sum(NR_QTDE_CSRC) from sms_controle";
$stsms = mysql_query($sqlsms);
if (mysql_num_rows($stsms) > 0) {
    $rowsms = mysql_fetch_row($stsms);
    $saldosms = $rowsms[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Reverb City Adm</title>
        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="scripts/abas.js"></script>
        <link href="css/aba.css" media="all" rel="stylesheet" type="text/css" />

        <?php
        mb_internal_encoding("UTF-8");
        mb_http_output("iso-8859-1");
        ob_start("mb_output_handler");
        header("Content-Type: text/html; charset=ISO-8859-1", true);
        ?>
        <script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="scripts/thickbox-compressed.js"></script>
        <script src="scripts/jquery.periodicalupdater.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" /> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"/>
        <style type="text/css">

            .row{
                clear: both;
                padding: 5px 10px;
            }
            .span12{
                width: 100%;
            }
            h1,h2{
                margin: 10px 0;
                border-bottom: 1px solid #E0E0E0;
                color: #5F5F5F;
                font-family: sans-serif;
            }
            .span6{
                width: 50%;
            }
            div[class^="span"]{
                float: left;
            }
            .titled{
                font-size: 18px;
                font-family: sans-serif;
                margin: 5px 0;
            }

            .field-group label{
                border-top-left-radius: 3px;
                background-color: #6EC6A4;
                display: block;
                float: left;
                width: 30px;
                height: 32px;
                color: #FFFFFF;
                text-align: center;
                font-family: arial;
                font-size: 14px;
                border-bottom-left-radius: 3px;
            }

            .label-block{
                width: 100% !important;
            }

            .field-group i{                
                line-height: 33px;
            }
            .field-group input,select, textarea{
                font-family: sans-serif;
                padding: 0 5px;
                border-top-right-radius: 3px;
                border-bottom-right-radius: 3px;
                border: 1px solid #6EC6A4;
            }
            .field-group input{
                width: 200px;
                height: 30px;
            }

            .field-group textarea{
                padding: 5px 5px;
                width: calc(100%/1.049);
                height: 100px;
            }

            .field-group select{
                width: 212px;
                height: 32px;              
            }

            .field-group{
                float: left;
                width: 245px;
                margin: 5px 5px;
                font-family: arial;
                font-size: 14px;
            }
            .actions-group{
                float: left;
                width: 100%;
                margin: 10px 0;
            }

            .actions-group button{
                font-size: 15px;
                border-radius: 3px;
                border: 0;
                background-color: #6EC6A4;
                width: 200px;
                height: 32px;
                color: #fff;
                cursor: pointer;
            }

            .actions-group button:hover{
                background-color: #57A084;  
            }
            .top-field{
                float: none !important;
            }
            .full-line{
                width: 100%;
            }
            .feedback-alert{
                background-color: #e74c3c;
                height: 30px;
                line-height: 30px;
                text-align: center;
                font-size: 18px;
                color: #983025;
                font-weight: bold;
                font-family: sans-serif;
            }
            .feedback-success{
                background-color: #A2EBAD;
                height: 30px;
                line-height: 30px;
                text-align: center;
                font-size: 18px;
                color: #439825;
                font-weight: bold;
                font-family: sans-serif;
            }
        </style>
    </head>
    <body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#361a0f">
                <td width="820"><img src="img/logo.gif" /></td>
                <td width="40">&nbsp;</td>
                <td style="font-family: Verdana; font-size: 11px; color: #b59589;">
                    Usuário: <strong><?php echo $_SESSION["SS_login"]; ?> <span id="userlogado"><?php echo @$HTTP_COOKIE_VARS["ujr73jfw93"] ?></span></strong><br />
                    Último Acesso: <strong><?php echo $_SESSION["SS_acesso"]; ?></strong><br />
                    Saldo SMS: <strong><?php echo $saldosms ?></strong>
                </td>
            </tr>
            <tr>
                <td height="70" colspan="3">
                    <?php include 'menu_princ.php'; ?>
                </td>
            </tr>
        </table>
        <table class="textosjogos" cellpadding="0" cellspacing="0">
            <tr>
                <td height="20" width="130" align="center" class="textostabelas">
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
                        <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'clientes.php';">Clientes Cadastrados (<?php echo $total_usuarios; ?>)</li>
                        <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'clientes_sp.php';">Clientes S&atilde;o Paulo</li>
                        <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'clientes_semdata.php';">Clientes sem dt/nasc</li>
                        <li id="abaInstagram" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'clientes_instagram.php';">Cliente com Instagram</li>
                        <li id="abaNivers" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'clientes_nivers.php';">Aniversariantes</li>
                        <li id="abaExport" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href = 'exp_lista_mail.php';">Exportar Lista Mail</li>
                        <li id="abaExport" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Exportar Lista Cels</li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <?php
        $f_datacadastroinicial = request("f_datacadastroinicial") != "" ? request("f_datacadastroinicial") : date("d/m/Y");
        $f_datacadastrofinal = request("f_datacadastrofinal") != "" ? request("f_datacadastrofinal") : date("d/m/Y");
        $f_genero = request("f_genero");
        $f_uf = request("f_uf");
        $f_regiao = request("f_regiao");
        $f_orderby = request("f_orderby");
        $f_colaboradores = request('f_colaboradores');

        if (isset($_GET["gerar"])) {


            // Obrigo o usuário a inserir um range de datas
            if (($f_datacadastroinicial != "") && ($f_datacadastrofinal != "")) {

                // converto para formato do banco
                $datainicialformatada = explode("/", $f_datacadastroinicial);
                $f_datacadastroinicialbanco = "$datainicialformatada[2]-$datainicialformatada[1]-$datainicialformatada[0]";

                // converto para formato do banco
                $datafinalformatada = explode("/", $f_datacadastrofinal);
                $f_datacadastrofinalbanco = "$datafinalformatada[2]-$datafinalformatada[1]-$datafinalformatada[0]";

                // coloco aspas simples nas regioes
                if ($f_regiao != "") {
                    $arrRegiao = explode(', ', $f_regiao);
                    $f_regiao = '';
                    foreach ($arrRegiao as $regiao) {
                        $f_regiao .= ", '$regiao'";
                    }
                    $f_regiao = substr($f_regiao, 2);
                }

                //inicio a variavel de feedback
                $feedback = "";

                //caminho e nome do arquivo que sera gerado
                $filepath = "lista_celular_" . time() . ".csv";

                //variavel dos filtros opcionais
                $andsql = "";

                //ordenação 
                $orderby = "";

                //join
                $join = '';

                //monto os filtros opcionais
                if ($f_avisemeprodutos != '') {
                    $join .= " LEFT JOIN";
                } else {

                    if ($f_uf != "")
                        $andsql .= " and DS_UF_CASO = '$f_uf'";
                    if ($f_regiao != "" and $f_uf == "")
                        $andsql .= " and DS_UF_CASO in ($f_regiao)";
                    if ($f_genero != "")
                        $andsql .= " and DS_SEXO_CACH = '$f_genero'";
                    if ($f_orderby != "")
                        $orderby = " ORDER BY DS_NOME_CASO $f_orderby";

                    if ($f_colaboradores != "") {
                        $orsql = " NR_SEQ_CADASTRO_CASO IN (4162, 2, 22652, 362602, 356432, 30791)";
                    } else {
                        $orsql = " DT_CADASTRO_CASO >= '$f_datacadastroinicialbanco'"
                                . "AND DT_CADASTRO_CASO <= '$f_datacadastrofinalbanco'  AND ST_ENVIOSMS_CACH = 'S' ";
                    }
                }
                //monto a variavel com a query
                $sql = "SELECT cad.NR_SEQ_CADASTRO_CASO, cad.DS_NOME_CASO, DS_DDDCEL_CASO, cad.DS_CELULAR_CASO, cad.ST_ENVIOSMS_CACH"
                        . " FROM cadastros cad "
                        . " WHERE $orsql"
                        . "$andsql $orderby LIMIT 10000000";

                // executo
                $st = mysql_query($sql);
                $conteudoCsv = "";

                //enquanto houver resultado
                while ($rsSet = mysql_fetch_assoc($st)) {

                    if (!empty($rsSet['DS_CELULAR_CASO']) && !empty($rsSet['DS_DDDCEL_CASO'])) {

                        $celddd = $rsSet['DS_DDDCEL_CASO'];
                        $celular = $rsSet['DS_CELULAR_CASO'];

                        $celddd = str_replace("(", "", $celddd);
                        $celddd = str_replace(")", "", $celddd);
                        $celddd = str_replace(" ", "", $celddd);

                        $celular = str_replace("-", "", $celular);
                        $celular = str_replace(".", "", $celular);
                        $celular = str_replace("/", "", $celular);
                        $celular = str_replace("=", "", $celular);
                        $celular = str_replace(" ", "", $celular);

                        $celular = $celddd . $celular;

                        if (substr($celular, 0, 1) == "0") {
                            $celular = substr($celular, 1, strlen($celular));
                        }
                    }

                    // caso nao seja vazio
                    if (!empty($rsSet) && $celular != '-') {
                        //monta conteudo do csv
                        $conteudoCsv .= $rsSet['NR_SEQ_CADASTRO_CASO'] . "," . $rsSet['DS_NOME_CASO'] . "," . $celular . "\n";
                    }
                }

                //se o conteudo nao for vazio, grava o arquivo
                if ($conteudoCsv != "") {
                    if (fwrite($file = fopen($filepath, "w+"), $conteudoCsv)) {
                        fclose($file);
                        header("location: $filepath");
                    }
                }
                // se nao alimenta a variavel de feedback
                else {
                    $feedback = '<p class="feedback-alert"><i class="fa fa-warning"></i> Nenhum registro encontrado</p>';
                }
            }
        } elseif (isset($_GET["enviar"])) {

            $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : null;
            $texto = isset($_POST['smstext']) ? $_POST['smstext'] : null;

            if ($arquivo != null && $texto != null) {

                $arquivoCsv = fopen($arquivo['tmp_name'], 'r');
                if ($arquivoCsv) {
                    while (!feof($arquivoCsv)) {
                        $linha = fgetcsv($arquivoCsv);

                        $idCliente = $linha[0];
                        $nome = $linha[0];
                        $celular = $linha[2];
                        $celular = trim($celular);

                        if ($celular != '') {
                            EnviaSMS($SS_logadm, $idCliente, $celular, $texto);
                        }
                    }
                    $feedback_sms = '<p class="feedback-success"><i class="fa fa-check-circle"></i>  SMS enviada com sucesso! :D</p>';
                }
            } else {
                $feedback_sms = '<p class="feedback-alert"><i class="fa fa-warning"></i> Insira a planilha no formato CSV e digite uma mensagem. </p>';
            }
        }
        ?>
        <!-- Inicio do bloco-->
        <div class="container">
            <div class="row">
                <div class="span12">
                    <h1><i class="fa fa-file-text-o"></i> Exportar lista de celulares</h1>
                    <!-- Mostra feedback -->
                    <?= $feedback; ?>
                    <div class="row">
                        <h3 class="titled"><i class="fa fa-filter"></i> Filtros</h3>
                        <form method="post" action="exp_lista_celular.php?gerar">
                            <div class="row">
                                <div class="span6">
                                    <div class="field-group">     
                                        <label for="f_datacadastroinicial" title="Data Cadastro Inicial"><i class="fa fa-calendar"></i></label><input type="text" placeholder="Data Cadastro Inicial ex: 01/01/2012" id="f_datacadastroinicial" name="f_datacadastroinicial" value="<?= $f_datacadastroinicial ?>"/>           
                                    </div>
                                    <div class="field-group">
                                        <label for="f_datacadastrofinal" title="Data Cadastro Final"><i class="fa fa-calendar"></i></label><input type="text" placeholder="Data Cadastro Final ex: 28/02/2012" id="f_datacadastrofinal" name="f_datacadastrofinal" value="<?= $f_datacadastrofinal ?>"/> 
                                    </div>
                                    <div class="field-group">
                                        <label for="f_genero" title="Genero"><i class="fa fa-venus-mars"></i></label>
                                        <select id="f_genero" name="f_genero">
                                            <option value="">Todos os Generos</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                        </select>
                                    </div>
                                    <div class="field-group">
                                        <label for="f_colaboradores" title="Equipe Reverbcity"><i class="fa fa-users"></i> Equipe Reverbcity</label>
                                        <input type="checkbox" id="f_colaboradores" name="f_colaboradores" value="0"></input>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="field-group">
                                        <label for="f_uf"><i class="fa fa-map-marker"></i></label>
                                        <select id="f_uf" name="f_uf">
                                            <option value="">Todas as UFs</option>
                                            <?= getOptionsAllEstados(); ?>
                                        </select>
                                    </div>
                                    <div class="field-group">
                                        <label for="f_regiao"><i class="fa fa-map"></i></label>
                                        <select id="f_regiao" name="f_regiao">
                                            <option value="">Todas as Regiões</option>
                                            <option value="PR, SC, RS">Sul</option>
                                            <option value="MG, SP, RJ, ES">Sudeste</option>
                                            <option value="MT, DF, GO, MS">Centro-Oeste</option>
                                            <option value="MA, PI, CE, RN, PB, PE, AL, SE, BA">Nordeste</option>
                                            <option value="RR, AP, AM, PA, TO, AC, RO">Norte</option>
                                        </select>                                
                                    </div>
                                    <div class="field-group">
                                        <label for="f_orderby"><i class="fa fa-reorder"></i></label>
                                        <select id="f_orderby" name="f_orderby">
                                            <option value="asc">Ordernar por Nome - Ascendente</option>
                                            <option value="desc">Ordernar por Nome - Descendente</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="field-group">
                                    <label for="avisemeprodutos" class="label-block"><i class="top-field">Avise-me Produtos</i></label>
                                    <textarea rows="5" id="avisemeprodutos" name="avisemeprodutos" placeholder="Produtos Avise-me. Ex: Muse,Game of Thrones, The Killers"><?= $textoAviseme ?></textarea>
                                </div>  
                            </div>
                            <div class="actions-group">
                                <button type="submit" name="gerar"><i class="fa fa-download"></i> Gerar Lista</button>
                            </div>
                        </form>
                    </div>                    
                    <div class="row">
                        <h1><i class="fa fa-mobile"></i> Enviar SMS a partir de uma lista (csv)</h1>
                        <?= $feedback_sms ?>
                        <form method="post" action="exp_lista_celular.php?enviar" enctype="multipart/form-data">
                            <div class="field-group full-line">     
                                <label for="arquivo" title="Arquivo CSV"><i class="fa fa-file-archive-o "></i></label><input type="file" id="arquivo" name="arquivo" value="<?= $arquivo ?>"/>           
                            </div>
                            <div class="field-group">
                                <label for="smstext"><i class="top-field" id="contador">140</i></label>
                                <textarea rows="5" id="smstext" name="smstext" placeholder="Corpo da mensagem" onKeyUp="javascript:cont();"><?= $texto ?></textarea>
                            </div>
                            <div class="actions-group">
                                <button type="submit" name="gerar"><i class="fa fa-send-o"></i> Enviar Sms</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Teste -->
        <script type="text/javascript" language="javascript">
            function cont() {
                var msg = document.getElementById('smstext');
                var cont = document.getElementById('contador');
                $("#contador").html(140 - msg.value.length);
                var limite = 0;
                if ((140 - msg.value.length) <= limite) {
                    msg.value = msg.value.substring(0, 140);
                }
            }
        </script>
    </body>
</html>