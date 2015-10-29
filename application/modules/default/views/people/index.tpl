<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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

<section id="people">
	<h1 class="rvb-title">Reverb <span>people</span></h1>

	{include file="share-buttons.tpl"}

	<div class="row">

		<div class="span16 busca-people-container">

			<span class="texto-ppl">
				Foi pro rolê usando uma de nossa camisetas? Que tal mostrar para todo mundo que você se veste de música e quais são as suas camisetas preferidas? Para isso, basta enviar sua foto para a nossa galeria e deixar a música ser fotografada.
			</span>
			<form name="busca-people" id="busca-people-form" method="POST">
				<input type="text" name="busca_people" id="busca-people"/>
				<input type="submit" id="buscar-form" valeu="Buscar"/>
			</form>
	</div>

	<ul class="thumbnails">

		<!-- PARA ADICIONAR DISPLAY NONE NA PRIMEIRA LI SÓ COLOCAR ATIC (CLASSE QUE DEIXA DISPLAY NONE) -->
		<li class="span4 inserir">
                    <a href="#" class="md-trigger insert-object" data-modal="people-lightbox" style="background: url('https://www.reverbcity.com/arquivos/default/images/imagem_base.jpg') no-repeat;">
                        <span style="position: relative;top: 110px;float: left;width: 100%;color: #fff;text-align: center;font-weight: 700;font-size: 16.7px;line-height: 20px;">INSERIR FOTO</span>
                    </a>
		</li>


		{foreach from=$contadores item=foto}
		{assign var="foto_me" value="{$foto->NR_SEQ_FOTO_FORC}"}
		{assign var="extensao" value="{$foto->DS_EXT_FORC}"}
		{assign var="foto_completa" value="{$foto_me}.{$extensao}"}
		<li class="span4">
			<div class="thumbnail">
				<a href="{$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}">
					{if file_exists("arquivos/uploads/people/$foto_completa")}
						<img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>$foto_completa], "imagem", TRUE)}" width="220" height="170" alt="{$foto->DS_NOME_CASO}" />
					{else}
						<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" width="220" height="170" alt="{$foto->DS_NOME_CASO}" />
					{/if}
				</a>

				<div class="caption">
					<div class="nome">
                        <a href="{$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}">
                            {$foto->DS_NOME_CASO}
                        </a>
                        {if $_idperfil == 359733}
                           <a href="/people/remove/foto_id/{$foto->NR_SEQ_FOTO_FORC}"> - Remover </a>
                        {/if}
                    </div>

					<!-- <span>{utf8_decode($foto->DS_CIDADE_CASO)}</a> -->

					<div class="commentaries">Comentários: {$foto->total_comentarios}</div>

					<div class="views">Views: {$foto->NR_VIEWS_FORC}</div>

					<ul class="social-media social-media-comp">
						<li>
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="icon user-facebook"></a>
						</li>

						<li>
							<a target="_blank" href="http://twitter.com/home?status=Olhe%20essa%20foto%20postada%20na%20Reverbpeople!%20-%20{$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="icon user-twitter"></a>
						</li>

						<li>
							<a target="_blank" href="http://tumblr.com/share?s=&v=3&t=Olhe%20essa%20foto%20postada%20na%20Reverbpeople!&u={$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="icon user-tumblr"></a>
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
			{$this->paginationControl($contadores, NULL, 'paginator_people.tpl')}
		</ul>
	</div>
</section>
</div>
<!-- lightbox para adicionar fotos -->
<div class="md-modal md-effect-1" id="people-lightbox">
    <div class="md-content">
        <p class="md-title">Reverbpeople</p>
        <div class="mg-bg">
            <button class="md-close ir">Fechar</button>
            <form id="form-people" action="{$this->url([], 'cadastrarpeople', TRUE)}" method="POST" enctype="multipart/form-data">
				<div class="fields-people">
					<label for="Imagem" class="title">imagem</label>
					<div class="fakeimg">
						<span>Clique e selecione a imagem</span>
						<input type="file" name="imagem" id="imagem">
					</div>
				</div>

				<div class="description-people">
					<p>
						Itens inapropriados que não se qualificam como objetos pertencentes ao universo musical e seu estilo de vida, que tenham cunho pornográfico, criminoso, racista, ofensivo serão deletados sem aviso prévio.Itens postados que não tenham sido apagados por seus donos após já terem sido trocados ou aqueles que estejam no ar há 12 meses serão automaticamente deletados pela equipe Reverbcity. <br>
						A Reverbcity não se responsabilizará pela logística das trocas feitas via Reverbcycle ou qualquer necessidade e/ou problema decorrente no seu processo.
					</p>
				</div>
				<div class="send-button">
                    <button type="submit" class="btn">Aceitar e Enviar</button>
                </div>
			</form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>


{include file="lightbox-indique.tpl"}