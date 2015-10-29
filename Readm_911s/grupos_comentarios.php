<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
include 'topo.php';

$idproduto = request("idp");

?>

<style>
    body {
    	font-family:Calibri, Helvetica, sans-serif;
        font-size: 15px;
        width: 960px;
    }

    h2{
    	font-size: 16px;
    	font-family:Calibri, Helvetica, sans-serif;
    	font-weight: bold;
    	line-height: 20px;
    	background-color: #414042;
    	color: #FFF;
    	text-align: center;
    	width: 800px;
    	display: block;
   
    }
	.foto{
		display: inline;
	}
    .foto img{
    	margin-top: -3px;
		margin-left: -793px;
		border: 4px solid #414042;
		display: inline;
    }

    .mensagem-informativo{
    	font-size: 14px;
    	font-family:Calibri, Helvetica, sans-serif;
    	color: #000;
    	display: inline;
    	margin-left: 20px;
        margin-top: 30px;
        font-weight: bold;
        position: absolute;
    }

    .lista-comentarios{
    	margin-top: 50px;
    	margin-left: 30px;
    }
    .lista-comentarios ul{
    	list-style-type: none;
    }

    .lista-comentarios ul li span{
    	font-size: 14px;
    	font-family:Calibri, Helvetica, sans-serif;
    	color: #000;
    	
    	padding-left: 10px;
		padding-right: 10px;
		width: 310px;
		border-right: 2px solid black;

    }

     .lista-comentarios ul li a{
    	font-size: 14px;
    	font-family:Calibri, Helvetica, sans-serif;
    	color: #FFF;
    	background-color: #FF0000;
    	padding-left: 10px;
		padding-right: 10px;
		width: 310px;
		border: 2px solid #FF0000;
		text-decoration: none;

    }

    button{
    	width: 100px;
    	height: 50px;
    	background-color: #5ec099;
    	color: #FFF;
    	font-weight: bold;
    	border: none;
    	margin-left: 30px;
    	margin-top: 15px;
    }

    button:hover{
    	
    	background-color: #0b975f;
    
    }

    .aprovado{
    	font-weight: bold;
    	color: #5ec099;
    	display: inline;
    	margin-left: 10px;
    }

     .reprovado{
    	font-weight: bold;
    	color: #FF0000;
    	display: inline;
    	margin-left: 10px;
    }


 
</style>

	<table class="textosjogos" cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td align="left">
            	<ul id="titulos_abas">
                  <li id="abaVer" class="abaativa"><a href="/grupos.php">Voltar aos produtos</a></li>
                </ul>
            </td>
        </tr>
    </table>

<?php 

$sql_produto = "SELECT DS_PRODUTO2_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC from produtos where NR_SEQ_PRODUTO_PRRC = $idproduto";


$st = mysql_query($sql_produto);
			
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);

	$foto = $row[2].".".$row[1];
	$nome = $row[0]; 

}


$sql_comentarios_aprovados = "SELECT 
    					DS_COMENTARIO_PCRC, DT_COMENT_PCRC, DS_STATUS_PCRC, DS_NOME_CASO, NR_SEQ_PRODCOMENT_PCRC
					FROM
					    produtos_coments
					INNER JOIN cadastros ON produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO
					where
					    NR_SEQ_PRODUTO_PCRC = $idproduto
                    AND 
                     DS_STATUS_PCRC = 'A'";

$st_c = mysql_query($sql_comentarios_aprovados);

$sql_comentarios = "SELECT 
                        DS_COMENTARIO_PCRC, DT_COMENT_PCRC, DS_STATUS_PCRC, DS_NOME_CASO, NR_SEQ_PRODCOMENT_PCRC
                    FROM
                        produtos_coments
                    INNER JOIN cadastros ON produtos_coments.NR_SEQ_CADASTRO_PCRC = cadastros.NR_SEQ_CADASTRO_CASO
                    where
                        NR_SEQ_PRODUTO_PCRC = $idproduto
                    AND 
                     DS_STATUS_PCRC = 'I'";

$st_co = mysql_query($sql_comentarios);

?>

<body>
	<h2><?php echo $nome; ?></h2></br>
	<div class="foto">
		<img src="../arquivos/uploads/produtos/<?php echo $foto; ?>" width="71" height="76" border="0" />
	</div>
    <div class="mensagem-informativo">
        <?php echo utf8_decode("Comentários Aprovados"); ?>
    </div>
    <div class="lista-comentarios">

            <ul>
                <?php 
                    while($row = mysql_fetch_row($st_c)) { 
                        $id_coment = $row[4];
                        $nome = $row[3];
                        $status = $row[2];
                        $data_comentario = $row[1];
                        $comentario = $row[0];
                ?>
                <li>
                    
                   <span> <?php echo $nome; ?> </span> <span> <?php echo $comentario; ?></span> <span> <?php echo  $data_comentario; ?> </span> <div class="aprovado"> Aprovado </div>
                </li>
                <?php } ?>
            </ul>
    </div>
	<div class="mensagem-informativo">
		<?php echo utf8_decode("Selecione os comentários que você quer alterar o status."); ?>
	</div>



	<form action="grupos_comentarios2.php" method="POST">
		<div class="lista-comentarios">

			<ul>
				<?php 
					while($row = mysql_fetch_row($st_co)) { 
						$id_coment = $row[4];
						$nome = $row[3];
						$status = $row[2];
						$data_comentario = $row[1];
						$comentario = $row[0];
				?>
				<li>
					<?php if ($status == 'A'){ ?>
					<input type="checkbox" value="<?php echo $id_coment; ?>"  name="idcomentario[]"/> <span> <?php echo $nome; ?> </span> <span> <?php echo $comentario; ?></span> <span> <?php echo $data_comentario; ?> </span> <div class="aprovado"> Aprovado </div>
					<?php }else{ ?>
					<input type="checkbox" value="<?php echo $id_coment; ?>"  name="idcomentario[]"/> <span> <?php echo $nome; ?> </span> <span> <?php echo $comentario; ?></span> <span> <?php echo $data_comentario; ?> </span> <div class="reprovado"> Não aprovado </div>
					<?php } ?>
					
					<input type="hidden" name="status[]" value="<?php echo $status ?>">
				</li>
				<?php } ?>
			</ul>
		</div>
		<button type="submit"> Aprovar </button>
	</form>
</body>