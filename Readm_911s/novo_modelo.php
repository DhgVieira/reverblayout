<?php
include 'auth.php';
include 'lib.php';

 include 'topo.php'; ?>

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
</style>
<form method="POST" action="novo_modelo_inc.php" enctype="multipart/form-data">
	<label>Descrição
		<input type="text" name="descricao">
	</label>
	<label> Tabela Modelo
		<input type="file" name="foto">
	</label>
	<button type="submit">Gravar</button>
</form>

<?php include 'rodape.php'; ?>