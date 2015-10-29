<?php

include 'auth.php';
include 'lib.php';

include 'pagarme/Pagarme.php';

Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

$transaction = PagarMe_Transaction::all(3, 3);

if(isset($transaction)){
    foreach($transaction as $index => $value){
        foreach($value['postback_url'] as $dadoPedido){
            echo $dadoPedido['id_pedido'] . '<br />';
        }
    }
}
exit;
?>
