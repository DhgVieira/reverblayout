<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
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
    <div class="row">

        <div class="span16 busca-people-container">

            <span class="texto-ppl">
                Foi pro rolê usando uma de nossa camisetas? Que tal mostrar para todo mundo que você se veste de música e quais são as suas camisetas preferidas? Para isso, basta enviar sua foto para a nossa galeria e deixar a música ser fotografada.
            </span>
        </div>
    </div>
    <div class="row">
        <div id="grid">

            <div class="grid-item">
                <a href="#" class="md-trigger" data-modal="people-lightbox">
                    <span>ADICIONE UMA FOTO +</span>
                </a>
            </div>
            {foreach from=$contadores item=foto}
                {assign var="foto_me" value="{$foto->NR_SEQ_FOTO_FORC}"}
                {assign var="extensao" value="{$foto->DS_EXT_FORC}"}
                {assign var="foto_completa" value="{$foto_me}.{$extensao}"}
                <div class="grid-sizer"></div>
                <div class="grid-item">
                    <div class="flip-container">
                        <div class="flipper">
                            <div class="front">
                                <div id="home-front2">
                                    {if file_exists("arquivos/uploads/people/$foto_completa")}
                                        <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                                    {/if}
                                </div>
                            </div>
                            <div class="back">
                                <div id="home-back2">

                                    {if file_exists("arquivos/uploads/people/$foto_completa")}
                                        <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                                    {/if}
                                    <div class="image_over">
                                        <div class="image_hover_text">
                                            <a href="{$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}" class="reverb-button ir open" title="Open" rel="nofollow"></a>
                                            <a href="#" class="reverb-button ir share" title="Share" rel="nofollow"></a>
                                            <br/>
                                            {$foto->DS_NOME_CASO}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}

        </div>
    </div>
    <div class="row">
        <div id="more-nav">
            {*<a href="/people/?page={$page + 1}">*}
                <button id="more">CARREGAR MAIS</>
            {*</a>*}
        </div>
    </div>
</section>

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