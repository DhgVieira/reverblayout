<?php
include 'auth.php';
include 'lib.php';
$term = $_REQUEST['q'];
$tam = strlen($term);
$sql = "select NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_CPFCNPJ_CASO, DS_CIDADE_CASO, DS_UF_CASO, DS_CEP_CASO,
        DS_EMAIL_CASO, DS_ENDERECO_CASO, DS_NUMERO_CASO, DS_COMPLEMENTO_CASO, DS_BAIRRO_CASO, DS_SEXO_CACH,
        DS_DDDFONE_CASO, DS_FONE_CASO, DS_TWITTER_CACH
        from cadastros WHERE (LEFT(DS_NOME_CASO,$tam) = '$term' OR LEFT(DS_CPFCNPJ_CASO,$tam) = '$term')
        and NR_SEQ_LOJA_CASO = $SS_loja order by DS_NOME_CASO limit 20";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_cad = $row[0];
        $ds_cad = $row[1];
        $ds_doc = $row[2];
        $ds_cid = $row[3];
        $ds_uf = $row[4];
        $ds_cep = $row[5];
        $ds_ema = $row[6];
        $ds_end = $row[7];
        $ds_nro = $row[8];
        $ds_comp = $row[9];
        $ds_bair = $row[10];
        $ds_sexo = $row[11];
        $ds_ddd = $row[12];
        $ds_fone = $row[13];
        $ds_twitter = $row[14];
        
        echo $ds_cad.";". $id_cad.";".$ds_doc.";".$ds_cid.";".$ds_uf.";".$ds_cep.";".$ds_ema.";".$ds_end.";".$ds_nro.";".$ds_comp.";".$ds_bair.";".$ds_sexo.";".$ds_ddd.";".$ds_fone.";".$ds_twitter."\n";
    }
}
mysql_close($con);
?>