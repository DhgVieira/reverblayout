<?php
include 'lib.php';
include 'auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
$str = "select * from compras where DT_COMPRA_COSO > '2010-07-13 00:00:00' AND ST_COMPRA_COSO IN ('P','V','E')";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
	while($row = mysql_fetch_array($st)) {
		$vltotal   	= $row["VL_TOTAL_COSO"];
		$frete		= $row["VL_FRETE_COSO"];
        $forma		= $row["DS_FORMAPGTO_COSO"];
        $nrcompra	= $row["NR_SEQ_COMPRA_COSO"];
        $parcelas	= $row["NR_PARCELAS_COSO"];
        $custo      = CalculaCusto($vltotal,$forma,$parcelas,$loja=0);
        echo $nrcompra.";".number_format($vltotal,2,",","").";".number_format($frete,2,",","").";".number_format($custo,2,",","").";".$forma.";".number_format(($vltotal-$custo),2,",","").";".$parcelas."<br />";
  }
}

function CalculaCusto($valor,$frmpg,$parc,$loja=0){
    $retvl = 0;
    if ($valor > 0){
        if ($loja > 0){
            switch($frmpg){
                case "debitovisa":
                    $retvl = number_format($valor*2.45/100,2,".","");
                    break;
                case "debitomaster":
                    $retvl = number_format($valor*2.7/100,2,".","");
                    break;
                case "boleto":
                    $retvl = 2.6;
                    break;
                case "visa":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.1/100,2,".","");
                            break;
                    }
                    break;
                case "master":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.7/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.4/100,2,".","");
                            break;
                    }
                    break;
            }
        }else{
            switch($frmpg){
                case "boleto":
                    $retvl = 2.6;
                    break;
                case "visa":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "master":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.7/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.4/100,2,".","");
                            break;
                    }
                    break;
            }
        }
    }
    return $retvl;
}
?>
</body>
</html>