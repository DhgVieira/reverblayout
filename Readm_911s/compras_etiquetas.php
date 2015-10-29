<?php
include 'auth.php';
include 'lib.php';

$compras = $_POST['etiq'];
$pos_ini = $_POST['ini_et'];

if (!$compras) {
	Header("Location: compras.php");
	exit();
}

define('FPDF_FONTPATH','pdf/font/');
require("pdf/fpdf.php");

// Variaveis de Tamanho

$mesq = "6"; // Margem Esquerda (mm)
$mdir = "5"; // Margem Direita (mm)
$msup = "19"; // Margem Superior (mm)
$leti = "70"; // Largura da Etiqueta (mm)
$aeti = "25.4"; // Altura da Etiqueta (mm)
$ehet = "2"; // Espaço horizontal entre as Etiquetas (mm)

$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo com tamanho tipo carta
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12,7'); // Define as margens do documento
$pdf->SetAuthor("ReverbCity"); // Define o autor
$pdf->SetFont('Arial','',9); // Define a fonte
//$pdf->SetDisplayMode();

// Variaveis pro Loop

$coluna = 0;
$linha = 0;

$idscomp = "";
foreach ($compras as $idc) {
    $idscomp .= $idc.",";
}

$idscomp = substr($idscomp,0,strlen($idscomp)-1);

$sql = "select * from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO in ($idscomp) order by DS_NOME_CASO";
$st = mysql_query($sql);

if ($pos_ini > 1){
    for ($f=1;$f<=$pos_ini;$f++){
        if($coluna == "3") { // Se for a terceira coluna
    	$coluna = 0; // $coluna volta para o valor inicial
    	$linha = $linha +1; // $linha é igual ela mesma +1
    	}
    	
    	if($linha == "10") { // Se for a última linha da página
    	$pdf->AddPage(); // Adiciona uma nova página
    	$linha = 0; // $linha volta ao seu valor inicial
    	}
        $coluna = $coluna+1;
    }
}

//MONTA A ARRAY PARA ETIQUETAS
while($dados = mysql_fetch_array($st)) {
    $idc = $dados["NR_SEQ_COMPRA_COSO"];
	
	$sql2 = "select * from enderecos where NR_SEQ_COMPRA_ENRC = $idc";
	$st2 = mysql_query($sql2);
	
	if (mysql_num_rows($st2) <= 0) {
		$nome = ucwords(strtolower($dados["DS_NOME_CASO"]));
		$ende = ucwords(strtolower($dados["DS_ENDERECO_CASO"])).",".$dados["DS_NUMERO_CASO"];
		$bairro = "Bairro: ".ucwords(strtolower($dados["DS_BAIRRO_CASO"]));
		$complem = ucwords(strtolower($dados["DS_COMPLEMENTO_CASO"]));
		$estado = $dados["DS_UF_CASO"];
		$cida = $dados["DS_CIDADE_CASO"];
        $cep = "CEP: " . $dados["DS_CEP_CASO"];
		$local = ucwords(strtolower($cida)) . "/" . $estado . "-" . $cep;
		
	}else{
		$dados2 = mysql_fetch_array($st2);
		$nome = ucwords(strtolower($dados2["DS_DESTINATARIO_ENRC"]));
		$ende = ucwords(strtolower($dados2["DS_ENDERECO_ENRC"])).",".$dados2["DS_NUMERO_ENRC"];
		$bairro = "Bairro: ".ucwords(strtolower($dados2["DS_BAIRRO_ENRC"]));
		$complem =ucwords(strtolower($dados2["DS_COMPLEMENTO_ENRC"]));
		$estado = $dados2["DS_UF_ENRC"];
		$cida = ucwords(strtolower($dados2["DS_CIDADE_ENRC"]));
        $cep = "CEP: " . $dados2["DS_CEP_ENRC"];
		$local = $cida . "/" . $estado . "-" . $cep;
		
	}
	
	if($coluna == "3") { // Se for a terceira coluna
	$coluna = 0; // $coluna volta para o valor inicial
	$linha = $linha +1; // $linha é igual ela mesma +1
	}
	
	if($linha == "10") { // Se for a última linha da página
	$pdf->AddPage(); // Adiciona uma nova página
	$linha = 0; // $linha volta ao seu valor inicial
	}
	
	$posicaoV = $linha*$aeti;
	$posicaoH = $coluna*$leti;
	
	if($coluna == "0") { // Se a coluna for 0
	$somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
	} else { // Senão
	$somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
	}
	
	if($linha =="0") { // Se a linha for 0
	$somaV = $msup; // Soma Vertical é apenas a margem superior inicial
	} else { // Senão
	$somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
	}
	
    $mais = 0;    
	$pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
	$pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
    if (trim($complem) != "" && trim($complem) != "-"){
        $pdf->Text($somaH,$somaV+8,$complem); 
        $mais = 4;  
    }    
    if (trim($bairro) != "" && trim($bairro) != "-"){    
        $pdf->Text($somaH,$somaV+8+$mais,$bairro." / Ped.: ".$idc); 
        $mais += 4;  
    }else{
        $pdf->Text($somaH,$somaV+8+$mais,"Ped.: ".$idc); 
        $mais += 4;  
    }            
	$pdf->Text($somaH,$somaV+8+$mais,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
	//$pdf->Text($somaH,$somaV+12+$mais,$cep); // Imprime o cep da pessoa de acordo com as coordenadas
	
	$coluna = $coluna+1;
}


$pdf->Output(); // encerra o arquivo PDF
?>