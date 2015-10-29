		<div class="span4 hide-320" id="complementary">
			<aside class="row">
				<h1 class="shifted-out">Complementar</h1>

				<div class="span4 hide-768">
					<div>
						<div style="text-align:center;width:201px;">
						</div>
					</div>
				</div>

				<div class="span4 hide-768">
					<div class="social-media">
						<ul>
							<li><a href="https://www.facebook.com/Reverbcity" target="_blank" title="Facebook" class="icon facebook">Facebook</a></li>

							<li><a  href="https://twitter.com/reverbcity" title="Twitter" target="_blank" class="icon twitter">Twitter</a></li>

							<li><a href="http://reverbcity.tumblr.com/" title="Tumblr" target="_blank" class="icon tumblr ">Tumblr</a></li>

							<li><a  href="http://pinterest.com/reverbcity/" title="Pinterest" target="_blank" class="icon pinterest ">Pinterest</a></li>

							<li><a href="http://instagram.com/reverbcity" title="Instagram" target="_blank" class="icon instagram">Instagram</a></li>

							<li><a href="http://reverbcity.com.br/rss/rss.php" title="RSS" target="_blank" class="icon rss">RSS</a></li>
						</ul>
					</div>
				</div>

				<div class="span4 login">
					<div class="content">
						<h2>
							<label for="campoemail">Reverbme</label>
						</h2>
						{if $_logado eq 1}
							<a href="{$this->url([], 'reverbmedetalhe')}">Você já está logado! Veja seu perfil.</a>
						{else}
							<form method="post" action="{$this->url([], 'login', TRUE)}">
								<div class="control-group">
									<div class="controls">
										<input type="text" id="campoemail" name="email" class="field" placeholder="E-mail" data-required data-validate="email" />
									</div>
								</div>

								<div class="control-group">
									<div class="controls">
										<label for="camposenha" class="shifted-out">Senha</label>
										<input type="password" id="camposenha" name="senha" class="field" placeholder="Senha" data-required />
									</div>
								</div>

								<div>
									<button type="submit" class="btn btn-primary">LOGIN</button>
									<a href="{$this->url([], 'reverbme', TRUE)}" class="btn">Cadastre-se</a>
								</div>

								<div class="control-group">
									<div class="controls">
										<label for="staylogged" title="Permanecer logado na página" class="checkbox"><input id="staylogged" type="checkbox" value="">Permanecer logado</label>
									</div>
								</div>
							</form>
						{/if}
					</div>

					<ul class="people">
						{foreach from=$fotos item=foto}
							{assign var="foto_people" value="{$foto['NR_SEQ_FOTO_FORC']}"}
							{assign var="extensao" value="{$foto['DS_EXT_FORC']}"}
							{assign var="foto_completa" value="{$foto_people}.{$extensao}"}
							<li><img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa],
                                        "imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" /></li>
						{/foreach}
					</ul>
				</div>

				<div class="span4 blog">
					<h2 class="oapcTitle">Blog</h2>

					<img class="content" src="http://lorempixel.com/220/110" alt="imagem temporaria"/>

					<ul>
						<li>
							<h3>{$post->DS_TITULO_BLRC|strip_tags}</h3>

							<div>
								<small><data value="{$post->DT_PUBLICACAO_BLRC|date_format:'%Y-%m-%d'}">{$post->DT_PUBLICACAO_BLRC|date_format:"%d/%m/%Y"}</data> ás {$post->DT_PUBLICACAO_BLRC|date_format:"%H:%M"}h <a a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}" >por:  {$post->DS_COLUNISTA_CORC}</a></small>

								<div id="mini-chamada">{$post->DS_TEXTO_BLRC|strip_tags}</div>

								<p class="text-right">
									<a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}" class="more">Ler post completo</a>
								</p>
							</div>
						</li>
					</ul>
				</div>

				<div class="span4 forum">
					<h2>Forum</h2>

					<ul>
						{foreach from=$foruns item=forum}
							<li class="forum-feeds">
								<a href="{$this->url(["titulo"=>{$this->createslug($forum->DS_FORUM_FOSO)}, "idforum"=>{$forum->NR_SEQ_FORUM_FOSO}], 'detalheforum', TRUE)}">
									<data value="{$forum->DT_CADASTRO_FOSO|date_format:'%d/%m'}">
										{$forum->DT_CADASTRO_FOSO|date_format:'%d/%m'}
									</data> |
									{$forum->DS_FORUM_FOSO|truncate:25:"...":TRUE}
								</a>
							</li>
						{/foreach}
					</ul>
				</div>

				<div class="span4 hide-768">
					<h2 class="shifted-out">Publicidade</h2>

					{foreach from=$banners item=banner}
			        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
			        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
			        {assign var="foto_completa" value="{$foto}.{$extensao}"}
			          <a href="{$banner->DS_LINK_BARC}">
			            {if file_exists("arquivos/uploads/banners/$foto_completa")}
			              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}"
			              />
			            {else}
			              <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="Avatar Padrão Rerverbcity">
			            {/if}
			          </a>
			      {/foreach}
				</div>
			</aside>
		</div>
