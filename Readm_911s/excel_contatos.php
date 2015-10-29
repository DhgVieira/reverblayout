<?php
include 'auth.php';
include 'lib.php';

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('America/Sao_Paulo');

$compras = $_POST['etiq'];

$idscomp = "";
foreach ($compras as $idc) {
    $idscomp .= $idc.",";
}

$idscomp = substr($idscomp,0,strlen($idscomp)-1);
         
$sql2 = "SELECT 
    
    DS_NOME_CASO,
    DS_EMAIL_CASO,
    DS_CEP_CASO,
    DS_ENDERECO_CASO,
    DS_NUMERO_CASO,
    DS_COMPLEMENTO_CASO,
    DS_BAIRRO_CASO,
    DS_UF_CASO,
    DS_CIDADE_CASO,
    NR_SEQ_CADASTRO_CESO,
    DS_FONE_CASO,
    DS_DDDFONE_CASO,
    DS_CPFCNPJ_CASO


from
    cestas,
    cadastros
where
    NR_SEQ_CADASTRO_CESO = NR_SEQ_CADASTRO_CASO
        and NR_SEQ_COMPRA_CESO in ($idscomp)
GROUP BY NR_SEQ_CADASTRO_CASO";

$st2 = mysql_query($sql2);

$conteudo = "";



if (mysql_num_rows($st2) > 0) {
  
    // $x = 1;
    // $total = 0;
    $conteudo .= "1SIGEP DESTINATARIO NACIONAL \r\n";
    $total = 0;
    while($row2 = mysql_fetch_row($st2)){
        $nome = $row2[0];
        $email  = $row2[1];
        $cep  = $row2[2];
        $endereco = $row2[3];
        $numero = $row2[4];
        $complemento = $row2[5];
        $bairro = $row2[6];
        $uf = $row2[7];
        $cidade = $row2[8];
        $codigo = $row2[9];
        $fone = $row2[10];
        $ddd = $row2[11];
        $cpf = $row2[12];
       

        $fone_formatado = "(".$ddd.") " . $fone;


        $caracteres_nome = 50 - strlen($nome);
        $caracteres_mail = 50 - strlen($email);
        $caracteres_cep  = 8  - strlen($cep);
        $caracteres_ende = 50 - strlen($endereco);
        $caracteres_nume = 6  - strlen($numero);
        $caracteres_comp = 30 - strlen($complemento);
        $caracteres_bair = 51 - strlen($bairro);
        $caracteres_uf   = 50 - strlen($uf);
        $caracteres_cida = 51 - strlen($cidade);
        $caracteres_codi = 50 - strlen($codigo);
        $caracteres_fone = 18 - strlen($fone_formatado);
        $caracteres_cpf  = 14 - strlen($cpf);
        $caracteres_fone = 18;
        $caracteres_cel = 12;
        $caracteres_fax = 12;
        
        
        $conteudo .= "2";
        
        $conteudo .= $cpf . str_repeat(" ", $caracteres_cpf);
        
        $conteudo .= $nome . str_repeat(" ", $caracteres_nome);
        $conteudo .= $email . str_repeat(" ", $caracteres_mail);
        $conteudo .= $nome . str_repeat(" ", $caracteres_nome);
        $conteudo .= $nome . str_repeat(" ", $caracteres_nome);
        $conteudo .= $cep . str_repeat(" ", $caracteres_cep);
        $conteudo .= $endereco . str_repeat(" ", $caracteres_ende);
        $conteudo .= $numero . str_repeat(" ", $caracteres_nume);
        $conteudo .= $complemento . str_repeat(" ", $caracteres_comp);
        $conteudo .= $bairro . str_repeat(" ", $caracteres_bair);
        $conteudo .= $cidade . str_repeat(" ", $caracteres_cida);
        $conteudo .= str_repeat(" ", $caracteres_fone);
        $conteudo .= str_repeat(" ", $caracteres_cel);
        $conteudo .= str_repeat(" ", $caracteres_fax)."\r\n";
        $total ++;
    }

   $caracteres_cpf  = 6 - strlen($total);
   $conteudo .= "9";
   $conteudo .= str_repeat("0", $caracteres_cpf) . $total;
    
}






$nome = date("d-m-Y H:i:s");

$arquivo= $nome.".txt"; // defina o nome do arquivo
$arq=fopen("arquivos_correio/".$arquivo,"a+"); // defina a pasta do arquivo
$base= "pasta/".$arquivo; // para o download
fputs($arq,$conteudo);
fclose($arq);
// echo "criou arquivo com sucesso<br />Aguarde o download...<br /><br />
// <meta http-equiv=\"refresh\" content=\"0;url=download.php\" />";

$filename = "arquivos_correio/".$nome.".txt";;
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);  
header("Content-Type: text/html");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");
exit();





mysql_close($con);

// /** Include path **/
// set_include_path(get_include_path() . PATH_SEPARATOR . 'Excel/');

// /** PHPExcel_IOFactory */
// include 'PHPExcel/IOFactory.php';

// $inputFileName = 'Excel/PHPExcel/CONTATOCORREIO.xls';

// $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

// $objWorksheet = $objPHPExcel->getActiveSheet();

// $objWorksheet->getCell('A1')->setValue('PEDIDO');

//   $cell = 1;

//   $objWorksheet->getCell('A'.$cell)->setValue("1SIGEP DESTINATARIO NACIONAL");



      
        
      
        
//         $cell += 1;
    
//         $objWorksheet->getCell('A'.$cell)->setValue($codigo);
//         $objWorksheet->getCell('C'.$cell)->setValue($nome);
//         $objWorksheet->getCell('D'.$cell)->setValue($email);
//         $objWorksheet->getCell('G'.$cell)->setValue($cep_formato);
//         $objWorksheet->getCell('H'.$cell)->setValue($endereco);
       
//         $cell += 1;
        

//         $objWorksheet->getCell('A'.$cell)->setValue($numero);
//         $objWorksheet->getCell('C'.$cell)->setValue($bairro);
//         $objWorksheet->getCell('D'.$cell)->setValue($cidade);
//         $objWorksheet->getCell('D'.$cell)->setValue($fone_formatado);   
        
//         $x++;
// 	}
// }

//$sql = "select VL_TOTAL_COSO from compras where NR_SEQ_COMPRA_COSO = $pedido";
//$st = mysql_query($sql);
//if (mysql_num_rows($st) > 0) {
//    $row = mysql_fetch_row($st);
//    $total = $row[0];
//}

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// $objWriter->save('temp/CONTATOCORREIO_'.$pedido.'.xls');

// mysql_close($con);
// Header("Location: temp/CONTATOCORREIO_$pedido.xls");
?>