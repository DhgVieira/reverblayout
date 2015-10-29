<?php
define('FPDF_FONTPATH','pdf/font/');
require("pdf/fpdf.php");

include 'lib.php';

$sql = "select * from cadastros where NR_SEQ_CADASTRO_CASO = 4160";
$st = mysql_query($sql);

// Variaveis de Tamanho

$mesq = "7"; // Margem Esquerda (mm)
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
$pdf->SetFont('Arial','',11); // Define a fonte
//$pdf->SetDisplayMode();

// Variaveis pro Loop

$coluna = 0;
$linha = 0;
$xx = 1;
//MONTA A ARRAY PARA ETIQUETAS
while($dados = mysql_fetch_array($st)) {
	while($xx<31){
        $nome = utf8_decode($dados["DS_NOME_CASO"]);
    	$ende = utf8_decode($dados["DS_ENDERECO_CASO"]).",".$dados["DS_NUMERO_CASO"];
    	$bairro = utf8_decode($dados["DS_BAIRRO_CASO"]);
    	$complem = $bairro;
    	$estado = $dados["DS_UF_CASO"];
    	$cida = utf8_decode($dados["DS_CIDADE_CASO"]);
    	$local = $cida . "/" . $estado;
    	$cep = "CEP: " . $dados["DS_CEP_CASO"];
    	
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
    	
    	$pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
    	$pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
    	$pdf->Text($somaH,$somaV+8,$complem);
    	$pdf->Text($somaH,$somaV+12,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
    	$pdf->Text($somaH,$somaV+16,$cep); // Imprime o cep da pessoa de acordo com as coordenadas
    	
    	$coluna = $coluna+1;
        $xx++;
     }
}


$pdf->Output(); // encerra o arquivo PDF
?>