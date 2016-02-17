
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>

<div class="banners-advertisement cycle-slideshow"
data-cycle-fx="fadeout"
data-cycle-timeout="5000"
data-cycle-slides="> a"
data-cycle-log="false"
data-cycle-pause-on-hover="true">
 	{foreach from=$banners item=banner}
        {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
        {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <a href="{$banner['DS_LINK_BARC']}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
</div>

<section id="reverbcycle">

	<h1 class="rvb-title">Reverb <span>cycle</span></h1>

	{include file="share-buttons.tpl"}

	<div class="row-fluid cycle-top">


		<p class="span12 float-left-cycle texto-ppl">
			A vida é uma troca! Ao invés de jogar tudo fora e poluir nosso planeta, que tal fazer um escambo com a galera que frequenta nosso site? No Reverbcycle você pode trocar ou vender objetos que não tem mais significado para você. Você pode pechincar demais por aqui, a única regra é que o item negociado tem que ter algo relacionado com o nosso universo musical. 

		</p>


		<div class="span4 wrap-select-category select-category float-right-cycle">
			<div class="navigation">
				<ul>
					<li><a href="#">Buscar por</a>
						<ul>
							{foreach from=$categorias item=categoria}
							<li><a href="{$this->url(["idcategoria"=>{$categoria->NR_SEQ_CATEGREV_RVRC}, "categoria"=>{$categoria->DS_CATEGORIA_RVRC}], 'reverbcycle', TRUE)}">{$categoria->DS_CATEGORIA_RVRC}</a></li>
							{/foreach}
						</ul>
					</li>
				</ul>
			</div> <!-- navigation -->
		</div>
	</div>

	<ul class="thumbnails cycle-thumbnails">

		<!-- PARA ADICIONAR DISPLAY NONE NA PRIMEIRA LI SÓ COLOCAR ATIC (CLASSE QUE DEIXA DISPLAY NONE) -->

		<li class="span4 cycle-items inserir-cycle">

			<a href="#" class="insert-object md-trigger" data-modal="inserir-objeto">

				<span>INSERIR<br>OBJETO</span>

			</a>

		</li>


		{foreach from=$contadores item=cycle}
		{assign var="foto" value="{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}"}
		{assign var="extensao" value="{$cycle['DS_EXT_RCRC']}"}
		{assign var="foto_completa" value="{$foto}.{$extensao}"}
		<li class="span4 cycle-items {if !($cycle@index%4)}{/if}">

			<div class="thumbnail">
				<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}">
				<!-- Adicao da classe deal-c para poder aparecera tag na LI, só que precisa criar um span, precisa mexer nos if também -->
				{if $cycle['ST_CLIENTE_RCRC'] eq 'I'}
				<span class="deal-c"></span>
				{/if}
					{if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
						<img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />
					{else}
						<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />
					{/if}
				</a>

				<div class="caption">
					<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">
						{$cycle['DS_OBJETO_RCRC']}
					</a>

					<div class="by">by <a href="{$this->url(["nome"=>{$this->createslug($cycle['DS_NOME_CASO'])}, "idperfil"=>{$cycle['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">{$cycle['DS_NOME_CASO']}</a></div>

					<div class="commentaries">Comentários: {$cycle['total_comentarios']}</div>

					<div class="views">Views: {$cycle['NR_VIEWS_RCRC']}</div>

					<ul class="social-media social-media-comp">
						<li>
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-facebook"></a>
						</li>

						<li>
							<a target="_blank" href="http://twitter.com/home?status={utf8_decode($cycle['DS_OBJETO_RCRC'])|escape:'url'}%20disponível%20para%20negociação%20na%20Reverbcycle!%20-%20{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-twitter"></a>
						</li>

						<li>
							<a target="_blank" href="http://tumblr.com/share?s=&v=3&t={utf8_decode($cycle['DS_OBJETO_RCRC'])|escape:'url'}%20disponível%20para%20negociação%20na%20Reverbcycle!&u={$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-tumblr"></a>
						</li>

						<li><a href="" class="icon user-pinterest"></a></li>
					</ul>
				</div>
			</div>
		</li>
		{/foreach}
	</ul>

	<div class="pagination">
		<ul>
			{$this->paginationControl($contadores, NULL, 'paginator_cycle.tpl')}
		</ul>
	</div>
</section>

</div>

<div class="md-modal md-effect-1" id="inserir-objeto">

	<div class="md-content">
		<p class="md-title">Reverbcycle</p>
		<button class="md-close ir">Fechar</button>

		<form id="cycle-form" action="{$this->url([], 'cadastrocycle', TRUE)}" method="POST" enctype="multipart/form-data">
			<div class="md-bg">

				<label for="Objeto" class="title">Objeto</label>
				<input class="input-text" type="text" name="objeto" placeholder="Nome do obejeto" required>

				<label for="categoria" class="title">Categoria</label>
				<div id="categoria-select">
					<span>Escolha uma categoria</span>

					<select name="categoria" id="categoria" required>
						{foreach from=$categorias item=categoria}
						<option value="{$categoria->NR_SEQ_CATEGREV_RVRC}">{$categoria->DS_CATEGORIA_RVRC}</option>
						{/foreach}
					</select>
				</div>

				<label for="descricao" class="title">Descrição</label>
				<textarea name="descricao" id="descricao" placeholder="Descrição do objeto" required></textarea>

				<label for="contatos" class="title">Contatos</label>
				<input class="input-text" type="text" name="contatos" id="contatos" placeholder="Email, telefone, facebook, etc.">

				<label for="tags" class="title">Tags</label>
				<input class="input-text" type="text" name="tags" id="tags" value"teste,teste2" placeholder="Separe as Tags por Virgula">

				<label for="Imagem" class="title">Imagens</label>

				<div class="bg-image imagem-op">
					<a href="#" class="img-remove">REMOVER</a>
					<div class="img-add">
						<p>Clique e selecione a imagem</p>
						<input class="img-input" type="file" name="imagem" value="">
					</div>
					<div class="img">
						<img class="img-preview" src="" alt="" width="67" height="67">
					</div>
				</div>

				<div class="bg-image imagem-op">
					<a href="#" class="img-remove">REMOVER</a>
					<div class="img-add">
						<p>Clique e selecione a imagem</p>
						<input class="img-input" type="file" name="imagem1" value="">
					</div>
					<div class="img">
						<img class="img-preview" src="" alt="" width="67" height="67">
					</div>
				</div>

				<div class="bg-image imagem-op">
					<a href="#" class="img-remove">REMOVER</a>
					<div class="img-add">
						<p>Clique e selecione a imagem</p>
						<input class="img-input" type="file" name="imagem2" value="">
					</div>
					<div class="img">
						<img class="img-preview" src="" alt="" width="67" height="67">
					</div>
				</div>

			</div>

			<p>
				Itens inapropriados que não se qualificam como objetos pertencentes ao universo musical e seu estilo de vida, que tenham cunho pornográfico, criminoso, racista, ofensivo serão deletados sem aviso prévio.Itens postados que não tenham sido apagados por seus donos após já terem sido trocados ou aqueles que estejam no ar há 12 meses serão automaticamente deletados pela equipe Reverbcity. <br>
				A Reverbcity não se responsabilizará pela logística das trocas feitas via Reverbcycle ou qualquer necessidade e/ou problema decorrente no seu processo.
			</p>

			<div class="send-button">
				<button type="submit" class="btn">Enviar</button>
			</div>
		</form>
	</div>
</div>

{include file="lightbox-indique.tpl"}