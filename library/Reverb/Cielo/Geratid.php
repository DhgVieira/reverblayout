<?
function GerarTid ($shopid,$pagbla) {

 //    if(strlen($shopid) != 10) {
 //        echo "Tamanho do shopid deve ser 10 dígitos";
 //        exit;
	// }
	
	// if(is_numeric($shopid) != 1) {
 //        echo "Shopid deve ser numérico";
 //        exit;
	// }

 //    if(strlen($pagbla) != 4) {
 //        echo "Tamanho do código de pagamento deve ser 4 dígitos.";
 //        exit;
	// }

    //Número da Maquineta
    $shopid_formatado = substr($shopid, 4, 5);

    //Hora Minuto Segundo e Décimo de Segundo
    $hhmmssd = date("His").substr(sprintf("%0.1f",microtime()),-1);

    //Obter Data Juliana
    $datajuliana = sprintf("%03d",(date("z")+1));

	//Último dígito do ano
    $dig_ano = substr(date("y"), 1, 1);


    return $shopid_formatado.$dig_ano.$datajuliana.$hhmmssd.$pagbla;
  }
?>