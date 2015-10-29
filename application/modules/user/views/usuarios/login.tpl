<!doctype html>
<html>
	<head>
		{$this->headMeta()} {$this->headTitle()} {$this->headLink()}
		{$this->headScript()}
		  <script type="text/javascript">
           document.basePath = '{$basePath}';
        </script>
	</head>
<body>
	<div class="topo">
		<img src="{$basePath}/arquivos/user/images/logo-adm.png" />
		<span></span>
	</div>
	<div id="conteudo_login">
		<div class="formulario">
			<div class="espaco"></div> 
			<form enctype="application/x-www-form-urlencoded" action="{$this->url([], "loginadm", TRUE)}" method="post">
				<div>
					<div class="user"><span>|</span></div>
					<input type="text" name="login" id="login" placeholder="Usuário" field-type="text" class="string" />
				</div>
				<div>
					<div class="passw"><span>|</span></div>
					<input type="password" name="senha" id="senha" placeholder="Password" field-type="password" class="string password" />
				</div>
				<div class="buttons">
				
					<input type="submit" name="submit" id="submit" value="LOG IN" />
					<span></span>
				</div>
			</form>
		</div>
	</div>
	<div class="esqueceu-senha">
		<a href="#">Esqueceu a sua senha?</a>
	</div>
	
	{if $success|default:"" != ""}
		<div id="msg-formulario" class="msg-success">
			{$success}
		</div>
	{/if}
	{if $error|default:"" != ""}
		<div id="msg-formulario" class="msg-error">
			{$error}
		</div>
	{/if}
		
	</body>
</html>
