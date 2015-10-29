<?php
include 'auth.php';
include 'lib.php';

 include 'topo.php';

$idmodel = request("idmodel");
  ?>

<style type="text/css">
	
button{
	padding: 10px;background-color: #5fbf98;text-decoration: none;color: #FFF;font-weight: bold;border: none;
}
form{
	display: block;
	padding: 20px;
	margin-left: 30px;
}
input{
	display: block;
	margin-bottom: 20px;
}
select{
	display: block;
	margin-bottom: 20px;
}
</style>
<form method="POST" action="nova_medida_inc.php" enctype="multipart/form-data">
	<input type="hidden" name="modelo" value="<?php echo $idmodel ?>" />
	<label>Tamanho
		<select name="tamanho">
			<option value="0">Selecione...</option>
			<?php
            	$sql = "SELECT idtamanho, genero, tamanho from tamanhos_medidas order by idtamanho ASC";
                $st = mysql_query($sql);

                if (mysql_num_rows($st) > 0) {
                  while($row = mysql_fetch_row($st)) {
                   $idtamanho     = $row[0];
                   $genero        = $row[1];
                   $tamanho 	  = $row[2];

                   $lista = $genero ." - ". $tamanho; 
                ?>
                <option value="<?php echo $idtamanho; ?>"><?php echo utf8_decode($lista); ?></option>
                <?php
                  }
                }
            ?>
		</select>
	</label>
	<label> Tabela Medida
		<input type="file" name="foto">
	</label>
	<button type="submit">Gravar</button>
</form>

<?php include 'rodape.php'; ?>