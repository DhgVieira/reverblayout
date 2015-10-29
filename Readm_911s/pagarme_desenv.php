<?php

include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';



$sql = "SELECT * FROM reverb_amazon.cadastros";

$st = mysql_query($sql);
$conteudotxt = '';

while ($array = mysql_fetch_assoc($st)) {
    if ($array['DS_FONE_CASO'] != null) {
        if ($array['DS_FONE_CASO'] == '-') {
            $telefonenumber = '00000000';
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $array['DS_FONE_CASO'])) {
            $arrayStrreplace = array(0 => ' ', 1 => '-');
            $telefonenumber = str_replace($arrayStrreplace, '', $array['DS_FONE_CASO']);
        } else {
            $telefonenumber = $array['DS_FONE_CASO'];
        }
    }
    echo $telefonenumber . '<br>';
}

