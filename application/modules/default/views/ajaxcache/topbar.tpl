<div id="page-nav" class="container">
	{if $currentController=="reverbcycle"}
	<span class="logo-topo ir cycle">
		<a accesskey="1" href="{$this->url([], 'reverbcycle', TRUE)}">
			<img pagespeed_no_transform src="{$basePath}/arquivos/default/images/reverb-cycle-logo.png" width="88" height="88" alt="Reverbcycle – Música que veste!">
		</a>
		<span class="alt-logo ir">Reverbcity – Música que veste!</span>
	</span>
	{else}
	<a accesskey="1" href="{$this->url([], 'inicio', TRUE)}">
		<span class="logo-topo ir">
			<span class="alt-logo ir">Reverbcity – Música que veste!</span>
		</span>
	</a>
	{/if}
	<div class="left-side">
		<ul class="actions-user">
			{if $_logado eq 1}
			<li>
				<a href="#" class="reverb-button ir user" aria-labelledby="requestsCountWrapper" rel="nofollow">
					<span class="reverb-count green" id="requestsCountWrapper">
						{if $_amigos|count > 0}
						<span id="requestsCountValue">{$_amigos|count}</span>
						{/if}
						<i class="accessible-elem"> Solicitações</i>
					</span>
				</a>
				<div class="reverb-flyout">
					<div class="flyout-header"></div>
					<div class="flyout-container">
						<p class="flyout-title">Solicitações de amizade:</p>
						<ul class="flyout-list friend-requests">
							{if $_amigos|count}
							{foreach from=$_amigos item=amigo name=friends}
							{assign var="foto" value="{$amigo['NR_SEQ_CADASTRO_CASO']}"}
							{assign var="extensao" value="{$amigo['DS_EXT_CACH']}"}
							{assign var="foto_completa" value="{$foto}.{$extensao}"}
							{if $smarty.foreach.friends.index == 3}
							{break}
							{/if}
							<li class="request-item clearfix">
								<a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}" >
									{if file_exists("arquivos/upload/reverbme/$foto_completa")}
									<img class="thumb" alt="nome" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>38, 'altura'=>43, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
									{else}
									<img class="thumb" alt="nome" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>38, 'altura'=>43, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
									{/if}
								</a>
								<p class="name">{utf8_decode($amigo['DS_NOME_CASO'])}</p>
								<div class="buttons">
									<a rel="nofollow" href="{$this->url(["idsolicitacao"=>{$amigo['NR_SEQ_AUT_AURC']}, "idamigo"=>{$amigo['NR_SEQ_CADASTRO_CASO']}], 'aceitaramigo', TRUE)}" class="button accept">Aceitar</a>
									<a rel="nofollow" href="{$this->url(["idamigo"=>{$amigo['NR_SEQ_AUT_AURC']}], 'recusaramigo', TRUE)}" class="button decline">Rejeitar</a>
								</div>
							</li>
							{/foreach}
							{else}
							<center> <p class="name">Você não possui solicitações no momento.</p> </center>
							{/if}
						</ul>
						<a rel="nofollow" href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more">Ver mais</a>
					</div>
					<div class="flyout-footer"></div>
				</div>
			</li>
			<li>
				<a href="#" class="reverb-button ir messages" aria-labelledby="messagesCountWrapper" rel="nofollow">
					<span class="reverb-count green" id="messagesCountWrapper">
						{if $_privados|count > 0}
						<span id="mercurymessagesCountValue">{$_privados|count}</span>
						{/if}
						<i class="accessible-elem"> Mensagens</i>
					</span>
				</a>
				<div class="reverb-flyout">
					<div class="flyout-header"></div>
					<div class="flyout-container">
						<p class="flyout-title">Mensagens privadas:</p>
						<ul class="flyout-list private-messages">
							{if $_privados|count > 0}
							{foreach from=$_privados item=privado name=private}
							{assign var="foto" value="{$privado['NR_SEQ_CADASTRO_CASO']}"}
							{assign var="extensao" value="{$privado['DS_EXT_CACH']}"}
							{assign var="foto_completa" value="{$foto}.{$extensao}"}
							{if $smarty.foreach.private.index == 3}
							{break}
							{/if}
							<li class="request-item clearfix">
								<p class="name">{utf8_decode($privado['DS_NOME_CASO'])}</p>
								<div class="details-column-left">
									{if file_exists("arquivos/upload/reverbme/$foto_completa")}
									<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
									{else}
									<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
									{/if}
									<span class="date">em {$privado['DT_POST_SBRC']|date_format:"%d/%m"}</span>
								</div>
								<p class="message"> {utf8_decode($privado['DS_POST_SBRC']|truncate:40:"...":TRUE)}</p>
								<div class="buttons">
									<a href="{$this->url([], 'reverbmedetalhe')}" class="button accept" rel="nofollow">Ler tudo</a>
									<a href="{$this->url(["idrecado"=>{$privado->NR_SEQ_SCRAP_SBRC}], 'deletarrecado', TRUE)}" class="button decline" rel="nofollow">Deletar</a>
								</div>
							</li>
							{/foreach}
							{else}
							<center> <p class="name">Você não possui mensagens privadas no momento.</p> </center>
							{/if}
						</ul>
						<a href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more" rel="nofollow">Ver todas</a>
					</div>
					<div class="flyout-footer"></div>
				</div>
			</li>
			<li>
				<a href="#" class="reverb-button ir notifications" aria-labelledby="notificationsCountWrapper" rel="nofollow">
					<span class="reverb-count green" id="notificationsCountWrapper">
						{if $_publicos|count > 0}
						<span id="notificationsCountValue">{$_publicos|count}</span>
						{/if}
						<i class="accessible-elem"> Notificações</i>
					</span>
				</a>
				<div class="reverb-flyout">
					<div class="flyout-header"></div>
					<div class="flyout-container">
						<p class="flyout-title">Meus scraps:</p>
						<ul class="flyout-list scrap-wall">
							{if $_publicos|count > 0}
							{foreach from=$_publicos item=publico name=public}
							{assign var="foto" value="{$publico['NR_SEQ_CADASTRO_CASO']}"}
							{assign var="extensao" value="{$publico['DS_EXT_CACH']}"}
							{assign var="foto_completa" value="{$foto}.{$extensao}"}
							{if $smarty.foreach.public.index == 3}
							{break}
							{/if}
							<li class="request-item clearfix">
								<p class="name"> {$publico['DS_NOME_CASO']}</p>
								<div class="details-column-left">
									{if file_exists("arquivos/upload/reverbme/$foto_completa")}
									<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
									{else}
									<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
									{/if}
									<span class="date">em {$publico['DT_POST_SBRC']|date_format:"%d/%m"}</span>
								</div>
								{assign var=mensagemScrap value=$publico['DS_POST_SBRC']|strip_tags}
								<p class="message">{$mensagemScrap|truncate:40:"...":TRUE}</p>
								<div class="buttons">
									<a href="{$this->url([], 'reverbmedetalhe')}" class="button accept" rel="nofollow">Ler tudo</a>
									<a href="{$this->url(["idrecado"=>{$publico->NR_SEQ_SCRAP_SBRC}], 'deletarrecado', TRUE)}" class="button decline" rel="nofollow">Deletar</a>
								</div>
							</li>
							{/foreach}
							{else}
							<center> <p class="name">Você não possui recados no momento.</p> </center>
							{/if}
						</ul>
						<a href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more" rel="nofollow">Ver todos</a>
					</div>
					<div class="flyout-footer"></div>
				</div>
			</li>
			{/if}
		</ul>
	</div>
	<div class="right-side">
		<ul class="actions-site">
			{if $_logado eq 1}
			<li>
				<a class="ac-action ac-io" href="{$this->url([], "minhascompras", TRUE)}" rel="nofollow">MINHAS COMPRAS</a>
			</li>
			{/if}
			<li>
				{if $_logado eq 1}
				<a class="ac-action ac-io" href="{$this->url([], 'logout', TRUE)}" rel="nofollow">LOGOUT</a>
				{else}
				<a href="#" class="reverb-button {if $email_error}opened{/if}" rel="nofollow">Login</a>
				<div class="reverb-flyout login">
					<div class="flyout-header"></div>
					<div class="flyout-container">
						<form id="rvb-form-login" method="post" action="{$this->url([], 'login', TRUE)}">
							<div class="rvb-form-field">
								<label class="legend" for="quickemail">E-mail</label>
								<input id="quickemail" type="email" name="email" required value="{$email_error}">
							</div>
							<div class="rvb-form-field">
								<label class="legend"  for="quicksenha">Senha</label>
								<input id="quicksenha" type="password" name="senha" required>
							</div>
							<div class="rvb-form-field status">
								<label class="checkbox" for="stay">
									<input id="stay" type="checkbox" name="manter_logado" value="1"> Permanecer logado
								</label>
							</div>
							<a class="forgot-pwd md-trigger" data-modal="lightbox-recuperar-senha" href="#" rel="nofollow">Esqueceu a senha?</a>
							<div class="send-button">
								<button type="submit" class="btn">Login</button>
							</div>
						</form>
					</div>
					<div class="flyout-footer"></div>
				</div>
				{/if}
			</li>
			<li>
				<a href="{$this->url([], 'novome')}" rel="nofollow">
					{if $_logado eq 1}
					{$_nome_usuario|truncate:10:"..":true}
					- Meu Perfil
					{else}
					Novo Cadastro
					{/if}
				</a>
			</li>
			<li class="no-border cart">
				{*                                    {if $_ultima_action eq 'produto'}*}
				{*                                        <a href="#" class="reverb-button my-cart opened" aria-labelledby="ordersCountWrapper" rel="nofollow">*}
				{*                                    {else}*}
				<a href="#" class="reverb-button my-cart" aria-labelledby="ordersCountWrapper" rel="nofollow">
					{*  {/if}*}
					Meu Carrinho
					<span class="reverb-count red" id="ordersCountWrapper">
						<span id="orderCountValue">{$_totalprodutos|count}</span>
					</span>
				</a>
				<div class="reverb-flyout cart">
					<a href="#" class="my-cart-close reverb-button" rel="nofollow"></a>
					<div class="flyout-header"></div>
					<div class="flyout-container">
						<p class="flyout-title">Últimos itens do seu carrinho:</p>
						<ul class="flyout-list my-cart-items">
							{if $_totalprodutos|count > 0}
							{foreach from=$_totalprodutos item=produto name=prod}
							{assign var="foto" value="{$produto['codigo']}"}
							{assign var="extensao" value="{$produto['path']}"}
							{assign var="foto_completa1" value="{$foto}.{$extensao}"}

							{assign var="fotos" value=$this->fotoproduto($produto['codigo'])}
							{assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
							{assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
							{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
							{if $smarty.foreach.prod.index == 3}
							{break}
							{/if}
							<li>
								<a class="my-cart-product-thumb" rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
									{if file_exists("arquivos/uploads/fotosprodutos/$foto_completa") and $foto_completa != '.'}
									<img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>$foto_completa], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
									{elseif file_exists("arquivos/uploads/produtos/$foto_completa1")}
									<img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>$foto_completa1], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
									{else}
									<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
									{/if}
								</a>
								<a class="my-cart-product-name" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
									{utf8_decode($produto['nome'])|truncate:13:"..":true}
								</a>
								{if $produto['tipo'] neq 9}
								<a href="{$this->url(["idestoque"=>{$produto['idestoque']}], 'removercarrinho', TRUE)}" rel="nofollow" class="my-cart-remove-item ir">Remover</a>
								{else}
								<a href="{$this->url(["idproduto"=>{$produto['codigo']}], 'removercarrinho', TRUE)}" rel="nofollow" class="my-cart-remove-item ir">Remover</a>
								{/if}
								<a rel="nofollow" class="my-cart-product-description" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
									<span class="product-gender">{if $produto['genero'] == 'm'}masculino{else}feminino{/if}</span>
									<span class="product-size">Tamanho {utf8_decode($produto['sigla'])}</span>
									<span class="product-amount">Quantidade {utf8_decode($produto['quantidade'])}</span>

									{assign var="vl_lojista_tmp" value="{math equation="x * y" x=$produto['valor'] y=0.6}"}

									{if $produto['vl_promo'] neq 0 and $vl_lojista_tmp > $produto['vl_promo']}
									<span class="product-price">R$ {$produto['vl_promo']|number_format:2:",":"."}</span>
									{else}
									<span class="product-price">R$ {$produto['total_produto']|number_format:2:",":"."}</span>
									{/if}
								</a>
							</li>
							{/foreach}

							{if $exibeBrindeCanecaPoster == 1}
							<li>
								<a href="{$this->url([], 'casa', TRUE)}" rel="nofollow" class="my-cart-product-thumb">
									<img src="{$basePath}/arquivos/default/images/reverb-gift.png" />
								</a>
								<a class="my-cart-product-name" href="{$this->url([], 'casa', TRUE)}" rel="nofollow">
									Brinde!
								</a>
								<a href="{$this->url([], 'casa', TRUE)}" class="my-cart-product-description" rel="nofollow">
									<span class="product-gender">Brinde liberado! Escolha uma caneca ou um poster de brinde!</span>
								</a>
							</li>
							{/if}
							{else}
							<li>
								<p class="name" style="text-align: center;">Seu carrinho esta vazio.</p>
							</li>
							{/if}
						</ul>
						<span class="total">Total: R$ {$_total_carrinho|number_format:2:",":"."}</span>
						{if $_totalprodutos|count > 0}
						<a href="#" class="flyout-button see-more" rel="nofollow">{$_totalprodutos|count} itens</a>
						<a href="{$this->url([], 'carrinho', TRUE)}" class="flyout-button see-more" rel="nofollow">Ver carrinho</a>
						{*<a href="{$this->url([], 'loja', TRUE)}" class="flyout-button see-more">Continuar comprando</a>*}
						{else}
						<a href="{$this->url([], 'loja', TRUE)}" class="flyout-button see-more">Comprar</a>
						{/if}
					</div>
					<div class="flyout-footer"></div>
				</div>
			</li>
			<li class="no-border last international">
				<a href="#" class="reverb-button ir international md-trigger" data-modal="international-purchases-lightbox" title="International Purchases" rel="nofollow">
					Compras Internacionais
				</a>
			</li>
		</ul>
		<form action="{$this->url([], 'busca', TRUE)}" id="topbar-search-desktop" class="topbar-search" method="post">
			<input type="text" name="busca_topo" id="busca_site" placeholder="Busca" class="input-box">
			<button type="submit" class="submit search-icon">Buscar</button>
		</form>
	</div>
</div>
<script type="text/javascript">
        $(function() {
            reverb.init();
            $.reject({
                reject: {
                    safari: false,
                    chrome: false,
                    firefox: false,
                    msie: true,
                    opera: false,
                    konqueror: false,
                    unknown: false
                },
                display: ["firefox", "chrome", "opera", "msie"]
            });
            $('#site-menu').removeClass('hidden');
            {literal}
            window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
                d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
                _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
                $.src='//v2.zopim.com/?2Z58nkKSaFYfK6W9xTVaK5iULjxTJQTu';z.t=+new Date;$.
                type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
            {/literal}
            
            {if $_logado eq 1}
                var nomeUsuario = '{$_nome_usuario}', emailUsuario =  '{$_email_usuario}';       
                {literal}  
                $zopim(function(){
                        $zopim.livechat.setName(nomeUsuario);
                        $zopim.livechat.setEmail(emailUsuario);
                });
                {/literal}
            {/if}
            return false
        })
</script>