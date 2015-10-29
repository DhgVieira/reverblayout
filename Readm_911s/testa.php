<?php 
	include 'lib.php';
	$vlcom = 120;
    $tipo_pacote = null;
    $total_prod = 2;
    $id_itens = array();

    //ganha uma bala de 32 a 65 reais
    if ($vlcom >= 32 and $vlcom < 65 and $total_prod = 1){
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 1, "quantidade" => 1));

    //senao verifico se tem um produto de valor 65 ou 79
    }elseif ($total_prod == 1 and ($vlcom == 65 or $vlcom == 79)) {
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 2, "quantidade" => 2));
    //agora se tem 2 produtos de 79 até 150
    }elseif ($total_prod == 2 and ($vlcom > 79 and $vlcom <= 150)) {
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 3, "quantidade" => 2),
	    				  3 => array("codigo" => 4, "tipo" => 3, "quantidade" => 1));
    //3 pecas e ate 200 reais
    }elseif ($total_prod == 3 and ($vlcom > 79 and $vlcom <= 200)) {
         //defino os brindes
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 4, "quantidade" => 3),
	    				  3 => array("codigo" => 4, "tipo" => 4, "quantidade" => 1));
    // mais de 260 reais ate 350 reais
    }elseif ($vlcom >= 260 and $vlcom < 350) {
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 5, "quantidade" => 3),
	    				  3 => array("codigo" => 4, "tipo" => 5, "quantidade" => 1));
    //mais de 350 reais
    }elseif ($vlcom > 350) {
         //defino os brindes
        $id_itens = array(0 => array("codigo" => 1, "tipo" => 6, "quantidade" => 3),
        				  1 => array("codigo" => 2, "tipo" => 6, "quantidade" => 1),
        				  2 => array("codigo" => 3, "tipo" => 6, "quantidade" => 1),
        				  3 => array("codigo" => 4, "tipo" => 6, "quantidade" => 1));
    }

    foreach ($id_itens as $key => $value) {
    	$inserir_itens = "INSERT INTO 
    						pacotes_has_itens
    					  		(iditem_pacote, idpacote_tipo, quantidade_itens)
    					  	VALUES
    					  		(".$value['codigo'].",".$value['tipo'].",".$value['quantidade'].")";

	    	//insiro o pacote
	    $insere_pacote = mysql_query($inserir_itens);
	    //pego o id do pacote
	    $id_pacote = mysql_insert_id();

    }

?>