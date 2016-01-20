<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
    {foreach from=$banners_topo item=banner}
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

<h1 class="rvb-title">
    Reverb <span>Me</span>
</h1>

<div id="texto-reverbme">
    <p>Facebook? Instragram? Tinder? A Reverbcity também tem a sua rede social, o ReverbME. Todo mundo que faz um cadastro no site, automaticamente também já ganha um profile na nossa rede. Nele você pode adicionar novos amigos, conversar com a equipe da Reverb e receber informações de promos, lançamentos, sobre o seu pedido e também ter um blog todinho seu hospedado no nosso site.</p>
</div>

<div class="clearfix"></div>

{* Topo *}

<div class="rvb-me-top">
    <div class="rvb-me-details user-image">
        {assign var="foto" value="{$perfil->NR_SEQ_CADASTRO_CASO}"}
        {assign var="extensao" value="{$perfil->DS_EXT_CACH}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
            <img class="profile" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>130,'altura'=>139,'imagem'=>$foto_completa],'imagem', TRUE)}" width="130" height="139" alt="Avatar do ReverbMe de {$perfil->DS_NOME_CASO}">
        {else}
            <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>130,'altura'=>139,'imagem'=>'not_found_bkp.jpg'],'imagem', TRUE)}" width="130" height="139" alt="Avatar Padrão Rerverbcity">
        {/if}
    </div>
    <div class="rvb-me-user left">
        <p class="name">
            {$_nome_usuario}
        </p>
        <p class="local"><i class="fa fa-map-marker hover"></i>{$perfil->DS_CIDADE_CASO}, {$perfil->DS_UF_CASO}</p>
        <ul class="my-social-networks">
            {if $perfil->DS_TWITTER_CACH neq ""}

                <li class="social-network-item">
                    <a href="{$perfil->DS_TWITTER_CACH}" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>
                </li>
            {/if}
            {if $perfil->DS_FACEBOOK_CACH neq ""}
                <li class="social-network-item">
                    <a href="{$perfil->DS_FACEBOOK_CACH}" target="_blank"><i class="fa fa-facebook fa-2x"></i></a>
                </li>
            {/if}
            <li class="social-network-item">
                <a href="{$perfil->DS_INSTAGRAM_CASO}" target="_blank"><i class="fa fa-instagram fa-2x"></i></a>
            </li>
            <li class="social-network-item">
                <a href="#" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a>
            </li>
        </ul>
    </div>
    <div class="rvb-me-user-controls">
        <ul class="rbv-me-control">
            <li>
                <a><i class="fa fa-cog fa-2x"></i></a>
                <ul class="hide">
                    <li><a href="#" class="btn-detail md-trigger modal-info" data-modal="lightbox-alterar-dados">Editar Perfil</a></li>
                    <li>
                        <div class="rvb-my-orders">
                            <span>Minhas compras:</span> <a href="#" class="btn-detail">Consultar</a>
                            <div class="reverb-flyout">
                                <div class="flyout-header"></div>
                                <div class="flyout-container">
                                    <p class="flyout-title">
                                        Minhas compras:
                                    </p>
                                    <ul class="flyout-list">
                                        {foreach from=$cestas item=cesta}
                                            {assign var="foto" value="{$cesta->NR_SEQ_PRODUTO_PRRC}"}
                                            {assign var="extensao" value="{$cesta->DS_EXT_PRRC}"}
                                            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                                            <li class="flyout-item">

                                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>38,'altura'=>34,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$cesta->DS_PRODUTO_PRRC}" class="thumb"> <span class="order-product-name">{$cesta->DS_PRODUTO_PRRC}</span> <span class="order-date">{$cesta->DT_INCLUSAO_CESO|date_format:"%d/%m/%Y"}</span>
                                            </li>
                                        {/foreach}

                                    </ul><a href="{$this->url([], "minhascompras", TRUE)}" class="flyout-button see-more">Ver mais</a>
                                </div>
                            <div class="flyout-footer"></div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
 {* Amigos *}
<div class="rvb-me-friends">
    <h2>Amigos ( {$total_amigos} )</h2>
    <div class="rvb-content-item friends">
        <ul class="rvb-list rvb-list-of-friends grid" id="grid-friends-list">
            {foreach from=$amigos item="amigo"}
                {assign var="foto" value="{$amigo['NR_SEQ_AMIGO_FRRC']}"}
                {assign var="extensao" value="{$amigo['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    <li class="grid-item" data-url="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}">
                        <div class="flip-container">
                            <div class="flipper">
                                <div class="front">
                                    <div id="home-front2">
                                        {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                            <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>117,'altura'=>126,'imagem'=>$foto_completa],'imagem', TRUE)}">
                                        {else}
                                            <img src="{$basePath}/arquivos/default/images/sem_foto.jpg" width="117" height="126" alt="{$amigo['DS_NOME_CASO']}" title="{$amigo['DS_NOME_CASO']}"/>
                                        {/if}
                                    </div>
                                </div>
                                <div class="back">
                                    <div id="home-back2">
                                        {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                            <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>117,'altura'=>126, 'imagem'=>$foto_completa], "imagem", TRUE)}"/>
                                        {else}
                                            <img src="{$basePath}/arquivos/default/images/sem_foto.jpg" width="117" height="126" alt="{$amigo['DS_NOME_CASO']}" title="{$amigo['DS_NOME_CASO']}"/>
                                        {/if}
                                        <div class="image_over">
                                            <div class="image_hover_text">
                                                {*<a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" title="Visualizar perfil de {$amigo->NR_SEQ_AMIGO_FRRC}" class="profile-link">*}
                                                    {*<a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" title="Open" rel="nofollow"></a>*}
                                                    <i class="fa fa-play fa-2x"></i> <br />{$amigo['DS_NOME_CASO']}
                                                {*</a>*}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
            {/foreach}
        </ul>
        <div class="row">
            <div id="more-nav">
                {*<a href="/people/?page={$page + 1}">*}
                <button id="more-friends" data-page="0" data-size="16">CARREGAR MAIS</>
                {*</a>*}
            </div>
        </div>
        <div id="friends-pagination" data-lastpage="{$paginas_amigos}" data-size="16">
            <ul class="pagination" id="page-nav">
                {if $paginas_amigos <= 1}

                {elseif $paginas_amigos > 16}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_amigos}" class="page">{$paginas_amigos}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_amigos <= 17}

                    {for $i=1; $i <= $paginas_amigos; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
</div>

{* Mensagens *}

{include file="../modules/default/views/reverbme/messages.tpl"}

<div class="rvb-column left">
    <div class="rvb-header-item">
        <p>
           {$_nome_usuario}
        </p>
        <a href="#" class="rvb-content-button edit-info" style="right: 70px;">Alterar dados</a>
        <a href="#" class="rvb-content-button btn-indique md-trigger" style="background-color: #e85238;" data-modal="indicar-lightbox">Indique!</a>
    </div>
    <div class="rvb-content-item user clearfix">
        <div class="rvb-me-details user-image">
            {assign var="foto" value="{$perfil->NR_SEQ_CADASTRO_CASO}"}
            {assign var="extensao" value="{$perfil->DS_EXT_CACH}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <!--<img class="profile" src="/reverbcity/arquivos/default/images/reverb-profile.gif" alt="Avatar do ReverbMe de TONY STRAUSS">-->
            {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                <img class="profile" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>260,'altura'=>306,'imagem'=>$foto_completa],'imagem', TRUE)}" width="130" height="152" alt="Avatar do ReverbMe de {$perfil->DS_NOME_CASO}">
            {else}
                <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>260,'altura'=>306,'imagem'=>'not_found_bkp.jpg'],'imagem', TRUE)}" width="130" height="152" alt="Avatar Padrão Rerverbcity">
            {/if}

            <div class="btn-detail">
                Alterar imagem
                <form action="{$this->url(["idperfil"=>{$NR_SEQ_CADASTRO_CASO}], "alterarfoto", TRUE)}" method="post" enctype="multipart/form-data">
                    <input type="file" class="file-field" name="imagem_perfil" id="imagem_perfil">
                </form>
            </div>
            <a href="#" class="btn-detail md-trigger modal-info" data-modal="lightbox-alterar-dados">Dados cadastrais</a>
        </div>
        <div class="rvb-me-details user-profile">
            <form action="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], 'alterardados', TRUE)}" method="post" id="reverbme-profile">
                <div class="lines">
                    <label for="nome" class="legend-user">Nome:</label> <input type="text" class="input-user" id="nome" value="{$perfil->DS_NOME_CASO}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="ocupacao" class="legend-user">Ocupação:</label> <input type="text" class="input-user" id="ocupacao" value="{$perfil->DS_OCUPACAO_CACH}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="idade" class="legend-user">Idade:</label> <input type="text" class="input-user" id="idade" value="{$idade}" data-readable="true" readonly disabled>
                </div>
                <div class="lines">
                    <label for="cidade" class="legend-user">Cidade:</label> <input type="text" class="input-user" id="cidade" value="{$perfil->DS_CIDADE_CASO}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="bandas" class="legend-user">Bandas:</label> <input type="text" class="input-user" id="bandas" value="{$perfil->DS_PLAYLIST_CACH}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="twitter" class="legend-user">Twitter:</label> <input type="text" class="input-user" id="twitter" value="{$perfil->DS_TWITTER_CACH}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="facebook" class="legend-user">Facebook:</label> <input type="text" class="input-user" id="facebook" value="{$perfil->DS_FACEBOOK_CACH}" data-readable="true" readonly>
                </div>
            </form>
        </div>
    </div>
    <div class="rvb-footer-item">
        <p>
            Pontos de experiência
        </p>
        <div class="xp-bar">
            <div class="current-value">
                {$experiencia_user|truncate:4:"":TRUE}%
            </div>
            <div class="loading-bar">
                <div class="progress" data-value="{$experiencia_user|truncate:4:TRUE}%"></div>
            </div>
        </div>
    </div>
    <div class="rvb-content-item user-and-order-details">
        <div class="rvb-my-orders">
            <span>Minhas compras:</span> <a href="#" class="btn-detail">Consultar</a>
            <div class="reverb-flyout">
                <div class="flyout-header"></div>
                <div class="flyout-container">
                    <p class="flyout-title">
                        Minhas compras:
                    </p>
                    <ul class="flyout-list">
                        {foreach from=$cestas item=cesta}
                            {assign var="foto" value="{$cesta->NR_SEQ_PRODUTO_PRRC}"}
                            {assign var="extensao" value="{$cesta->DS_EXT_PRRC}"}
                            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                            <li class="flyout-item">

                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>38,'altura'=>34,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$cesta->DS_PRODUTO_PRRC}" class="thumb"> <span class="order-product-name">{$cesta->DS_PRODUTO_PRRC}</span> <span class="order-date">{$cesta->DT_INCLUSAO_CESO|date_format:"%d/%m/%Y"}</span>
                            </li>
                        {/foreach}

                    </ul><a href="{$this->url([], "minhascompras", TRUE)}" class="flyout-button see-more">Ver mais</a>
                </div>
                <div class="flyout-footer"></div>
            </div>
        </div>
        <div class="rvb-privacy">
            <span>Privacidade perfil:</span>
                {if $perfil->DS_PRIVADO_CASO eq 1}
                    <a href="{$this->url(["tipo"=>"1"], "alterarprivacidade", TRUE)}" class="btn-detail" title="Tornar o perfil visível somente para os amigos">Amigos</a>
                {else}
                    <a href="{$this->url(["tipo"=>"1"], "alterarprivacidade", TRUE)}" class="btn-detail inactive" title="Tornar o perfil visível somente para os amigos">Amigos</a>
                {/if}
                {if $perfil->DS_PRIVADO_CASO eq 0}
                    <a href="{$this->url(["tipo"=>"0"], "alterarprivacidade", TRUE)}" class="btn-detail" title="Tornar o perfil visível para todos">Público</a>
                {else}
                    <a href="{$this->url(["tipo"=>"0"], "alterarprivacidade", TRUE)}" class="btn-detail inactive" title="Tornar o perfil visível para todos">Público</a>
                {/if}
        </div>
        <div class="rvb-my-social-share">
            <span>Redes sociais:</span>
            <ul class="my-social-networks">
                {if $perfil->DS_TWITTER_CACH neq ""}
                    <li class="social-network-item">
                        <a href="{$perfil->DS_TWITTER_CACH}" class="ir icon twitter" target="_blank">Twitter</a>
                    </li>
                {/if}
                {if $perfil->DS_FACEBOOK_CACH neq ""}
                    <li class="social-network-item">
                        <a href="{$perfil->DS_FACEBOOK_CACH}" class="ir icon facebook" target="_blank">Facebook</a>
                    </li>
                {/if}
                {if $perfil->DS_FACEBOOK_CACH neq ""}
                    <li class="social-network-item">
                        <a href="#" class="ir icon tumblr" target="_blank">Tumblr</a>
                    </li>
                {/if}
                <li class="social-network-item">
                    <a href="{$perfil->DS_INSTAGRAM_CASO}" class="ir icon instagram" target="_blank">Instagram</a>
                </li>
                <li class="social-network-item">
                    <a href="#" class="ir icon pinterest" target="_blank">Pinterest</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Galeria de Fotos
        </h2>
        <a href="#" class="md-trigger rvb-content-button insert-photo" data-modal="people-lightbox">Incluir fotos</a>
    </div>
    <div class="rvb-content-item clearfix">
        <p class="centered">
            {if $fotos|count le 0}
                Mostre que você fica ainda mais gatinha(o)<br>
                quando usa Reverbcity. Mande suas fotos para nossa galeria!
            {else}
            </p>
            <ul class="rvb-list rvb-list-of-photos clearfix" id="gallery-list">
                {foreach from=$fotos item=me}
                    {assign var="foto" value="{$me->NR_SEQ_FOTO_FORC}"}
                    {assign var="extensao" value="{$me->DS_EXT_FORC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    <li class="rvb-photo-item">
                        <a href="{$this->url(["nome"=>{$this->createslug($me->DS_NOME_FORC)}, "idfoto"=>{$me->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}" class="photo-thumb">
                            <img src="{$this->Url(['tipo'=>"people", 'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$me->DS_NOME_FORC}">
                        </a>
                        <a href="{$this->url(["nome"=>{$this->createslug($me->DS_NOME_FORC)}, "idfoto"=>{$me->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}" class="photo-link">{$me->DS_NOME_FORC}</a>
                        <span class="comments">Comentários: {$me->total_coments}</span>
                        <span class="views">Views: {$me->NR_VIEWS_FORC}</span>
                        <a href="{$this->url(["idfoto"=>{$me->NR_SEQ_FOTO_FORC}], "removerfoto", TRUE)}" data-foto-id="{$me->NR_SEQ_FOTO_FORC}" class="me-remove" title="Excluir foto">Excluir</a>
                        <ul class="social-share-small">
                            <li class="social-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["nome"=>{$this->createslug($me->DS_NOME_FORC)}, "idfoto"=>{$me->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="http://twitter.com/home?status={$this->url(["nome"=>{$this->createslug($me->DS_NOME_FORC)}, "idfoto"=>{$me->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="http://tumblr.com/share?s=&v=3&t={$this->url(["nome"=>{$this->createslug($me->DS_NOME_FORC)}, "idfoto"=>{$me->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)|escape:'url'}" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                {/foreach}
            </ul>
        {/if}
        <div id="gallery-pagination" data-lastpage="{$paginas_fotos}" data-size="9">
            <ul class="pagination">
                {if $paginas_fotos <= 1}

                {elseif $paginas_fotos > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="dots">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_fotos}" class="page">{$paginas_fotos}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_fotos <= 9}

                    {for $i=1; $i <= $paginas_fotos; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Top Music Videos
        </h2><a href="#" class="rvb-content-button md-trigger" data-modal="insert-url-video-lightbox">Incluir vídeo</a>
    </div>
    <div class="rvb-content-item clearfix">
        <ul class="rvb-list rvb-list-of-videos" id="videos-list">
            {foreach from=$videos item=video}
            {assign var=img_youtube value="/"|explode:$video->DS_YOUTUBE_VIRC}
            {assign var=idyoutube value='&'|explode:$img_youtube[4]}

            {if $idyoutube[0] neq ""}


                <li class="rvb-video-item">
                    <a href="{$video->DS_YOUTUBE_VIRC}" class="video-thumb">
                        <img src="http://img.youtube.com/vi/{$idyoutube[0]}/hqdefault.jpg" alt="{$video->DS_NOME_VIRC}">
                    </a>
                    <a href="{$video->DS_YOUTUBE_VIRC}" title="{$video->DS_NOME_VIRC}" class="video-link" target="_blank">{$video->DS_NOME_VIRC}</a>
                    <a href="{$this->url(["idvideo"=>{$video->NR_SEQ_VIDEO_VIRC}], "removervideo", TRUE)}" data-video-id="{$video->NR_SEQ_VIDEO_VIRC}" class="me-remove" title="Excluir vídeo">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$video->DS_YOUTUBE_VIRC|escape:'url'}" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status={$video->DS_YOUTUBE_VIRC|escape:'url'}" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t={$video->DS_YOUTUBE_VIRC|escape:'url'|escape:'url'}" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
            {else}
            {assign var=idyoutube2 value="v="|explode:$img_youtube[3]}
                <li class="rvb-video-item">
                    <a href="{$video->DS_YOUTUBE_VIRC}" class="video-thumb">
                        <img src="http://img.youtube.com/vi/{$idyoutube2[1]}/hqdefault.jpg" alt="{$video->DS_NOME_VIRC}">
                    </a>
                    <a href="{$video->DS_YOUTUBE_VIRC}" title="{$video->DS_NOME_VIRC}" class="video-link" target="_blank">{$video->DS_NOME_VIRC}</a>
                    <a href="{$this->url(["idvideo"=>{$video->NR_SEQ_VIDEO_VIRC}], "removervideo", TRUE)}" data-video-id="{$video->NR_SEQ_VIDEO_VIRC}" class="me-remove" title="Excluir vídeo">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$video->DS_YOUTUBE_VIRC|escape:'url'}" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status={$video->DS_YOUTUBE_VIRC|escape:'url'}" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t={$video->DS_YOUTUBE_VIRC|escape:'url'|escape:'url'}" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
            {/if}
            {/foreach}
        </ul>
        <div id="videos-pagination" data-lastpage="{$paginas_videos}" data-size="4">
            <ul class="pagination">
                {if $paginas_videos <= 1}

                {elseif $paginas_videos > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_videos}" class="page">{$paginas_videos}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_videos <= 9}

                    {for $i=1; $i <= $paginas_videos; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Blog
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <form action="{$this->url([], "publicarblog", TRUE)}" method="post" enctype="multipart/form-data">
          <input name="titulo" type="text" class="title-of-post" placeholder="Insira o título do seu post">
          <div class="blogme-img">
              <span>Escolha a imagem</span>
              <input type="file" name="imagem" />
          </div>
          <textarea name="post" id="full-post" cols="30" rows="10" class="message-box full-post"></textarea>
          <button type="submit" class="rvb-send-button publish">Publicar</button>
        </form>
    </div>
    <div class="rvb-header-item">
        <h2>
            Últimos posts
        </h2>
    </div>
    <div class="rvb-content-item clearfix">

        <div class="rvb-list rvb-list-of-posts" id="latest-posts-list">
            {foreach from=$posts item=post}
                <div class="latest-post">
                        <a href="{$this->url(["idpost"=>{$post->idme_blog}], "blogme", TRUE)}" class="post-thumb">
                            {if file_exists("arquivos/upload/blogme/$imagem_path")}
                                <img src="{$this->Url(['tipo'=>"blogme", 'crop'=>1,'largura'=>120,'altura'=>143,'imagem'=>{$post->imagem_path}],'imagem', TRUE)}" alt="{$post->titulo}"/>
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>120,'altura'=>143,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$post->titulo}"/>
                            {/if}
                        </a>
                    <a href="{$this->url(["idpost"=>{$post->idme_blog}], "blogme", TRUE)}" class="post-title">{$post->titulo}</a>
                    <p class="post-date">
                        {$post->data_publicacao|date_format:"%d/%m/%Y"} ás  {$post->data_publicacao|date_format:"%H:%M"} Por: <span class="post-author">{$_nome_usuario}</span>
                    </p>
                    <p class="post-tiny-description"></p>
                    <p class="post-text-truncate">
                        {$post->post|regex_replace:"/\<[^>]*\>/":" "|truncate:230:"...":true}
                    </p>
                    <a href="{$this->url(["idpost"=>{$post->idme_blog}], "blogme", TRUE)}" class="button comments">0 comentários</a>
                    <a href="{$this->url(["idblog"=>{$post->idme_blog}], "removerblog", TRUE)}" data-post-id="{$post->idme_blog}" class="me-remove post-remove" title="Remover post">Excluir</a>
                    <a href="{$this->url(["idpost"=>{$post->idme_blog}], "blogme", TRUE)}" class="button read-post">Ler post completo | </a>
                </div>
            {/foreach}
        </div>
        <div id="latest-posts-pagination" data-lastpage="{$paginas_post}" data-size="3">
            <ul class="pagination">
                {if $paginas_post <= 1}

                {elseif $paginas_post > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_post}" class="page">{$paginas_post}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_post <= 9}

                    {for $i=1; $i <= $paginas_post; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div><a href="#" class="rvb-button back">Voltar</a>
</div>
<div class="rvb-column right">
    <form method="POST">
        <div class="rvb-header-item" id="rvb-header-friends">
            <h2>
                Amigos
            </h2>
            <input type="text" id="searchFriendInput" class="search-friend" placeholder="Digite o nome para buscar" name="filter">
            <button type="submit" id="searchFriendButton" class="rvb-content-button">Buscar</button>
        </div>
    </form>
    <div class="rvb-content-item friends">
        <ul class="rvb-list rvb-list-of-friends" id="friends-list">
            {foreach from=$amigos item="amigo"}
                {assign var="foto" value="{$amigo['NR_SEQ_AMIGO_FRRC']}"}
                {assign var="extensao" value="{$amigo['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <li>
                    <a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" class="profile-thumb">
                        {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                            {if $aniversariante eq 1}
                                <div class="bday"></div>
                            {/if}
                            <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>103,'altura'=>90,'imagem'=>$foto_completa],'imagem', TRUE)}">
                        {else}
                            {if $aniversariante eq 1}
                                <div class="bday"></div>
                            {/if}
                            <img src="{$basePath}/arquivos/default/images/sem_foto.jpg" alt="{$amigo['DS_NOME_CASO']}" title="{$amigo['DS_NOME_CASO']}"/>
                        {/if}
                    </a>
                    <a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" title="Visualizar perfil de {$amigo->NR_SEQ_AMIGO_FRRC}" class="profile-link">{$amigo['DS_NOME_CASO']}</a>
                </li>
            {/foreach}
        </ul>
        <div id="friends-pagination" data-lastpage="{$paginas_amigos}" data-size="8">
            <ul class="pagination">
                {if $paginas_amigos <= 1}

                {elseif $paginas_amigos > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_amigos}" class="page">{$paginas_amigos}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_amigos <= 9}

                    {for $i=1; $i <= $paginas_amigos; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
    <form method="post" action="{$this->url(["idperfil"=>{$NR_SEQ_CADASTRO_CASO}], "enviarmensagem", TRUE)}">
        <div class="rvb-header-item">
            <h2>
                Mensagens
            </h2><label class="label-checkbox" for="sendByMail">
            <input type="checkbox" name="sendByMail" id="sendByMail" value="1"> Avisar por e-mail</label>
        </div>
        <div class="rvb-content-item read-scraps clearfix">
            <p class="user-login-name">
               {$_nome_usuario}
            </p>
            <textarea class="message-box mb" name="reverbme-mensagem" placeholder="Escreva aqui sua mensagem..."></textarea>

            <label class="label-checkbox" for="isPrivate">
                <input type="checkbox" name="isPrivate" id="isPrivate" value="1"> Mensagem privada
            </label>

            <input type="submit" class="rvb-send-button" value="Enviar">

            <div class="clearfix"></div>

            <div class="horizontal-line"></div>

            <div class="rvb-list list-of-scraps" id="scraps-list">
                {foreach from=$recados item=recado}
                    <div class="rvb-comment-box">
                        <!-- <a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" data-message-id="{$recado->NR_SEQ_SCRAP_SBRC}" class="md-close ir" title="Remover mensagem">Excluir</a> -->
                        <p class="rvb-comment-author-name">
                            <a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">
                                {$recado->DS_NOME_CASO}
                            </a>
                        </p>
                        <p class="rvb-comment-date">
                            {assign var="datarecado" value=$recado->DT_POST_SBRC|cat:" -3 hour"}
                            {$datarecado|date_format:"%Y-%m-%d %H:%M:%S"}
                        </p>
                        <div class="rvb-comment-message">
                            {$recado->DS_POST_SBRC}
                        </div>
                        <div class="rvb-comment-buttons">
                            <a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}" class="button">Responder |</a>
                            <a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" class="button">Excluir</a>
                        </div>
                    </div>
                {/foreach}
            </div>
            <div id="scraps-pagination" data-lastpage="{$paginas_recados}" data-size="5">
                 <ul class="pagination">
                        {if $paginas_recados <= 1}

                        {elseif $paginas_recados > 8}

                            <li>
                                <a href="#" class="prev disabled">◀</a>
                            </li>
                            {for $i=1; $i <= 5; $i++}
                                {if $i == 1}
                                    <li>
                                        <a href="#" data-page="{$i}" class="page current">{$i}</a>
                                    </li>
                                {else}
                                    <li>
                                        <a href="#" data-page="{$i}" class="page">{$i}</a>
                                    </li>
                                {/if}
                            {/for}
                            <li>
                                <a class="prev">...</a>
                            </li>
                            <li>
                                <a href="#" data-page="{$paginas_recados}" class="page">{$paginas_recados}</a>
                            </li>
                            <li>
                                <a href="#" class="next">▶</a>
                            </li>
                        {elseif $paginas_recados <= 9}

                            {for $i=1; $i <= $paginas_recados; $i++}

                                {if $i == 1}
                                    <li>
                                        <a href="#" data-page="{$i}" class="page current">{$i}</a>
                                    </li>
                                {else}
                                    <li>
                                        <a href="#" data-page="{$i}" class="page">{$i}</a>
                                    </li>
                                {/if}

                            {/for}

                        {/if}
                    </ul>
            </div>
        </div>
    </form>
    <div class="rvb-header-item">
        <h2>
            Wishlist Reverbcity
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        {if $wishlists|count le 0}
            <p class="centered">
                Todo mundo tem desejos e você não precisa<br>
                esconder os seus, coloque sua peça desejada no "whishlist".
            </p>
        {else}
            <ul class="rvb-list rvb-list-of-wishlist clearfix" id="wishlist-list">
                {foreach from=$wishlists item=wish}
                    {assign var="foto" value="{$wish->NR_SEQ_PRODUTO_PRRC}"}
                    {assign var="extensao" value="{$wish->DS_EXT_PRRC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}

                    {assign var="fotos" value=$this->fotoproduto($wish->NR_SEQ_PRODUTO_PRRC)}
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                <li class="rvb-photo-item">
                    <a href="{$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)}" class="photo-thumb">
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$wish->DS_PRODUTO_PRRC}"></a>
                        {else}
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$wish->DS_PRODUTO_PRRC}"></a>
                        {/if}
                    <a href="{$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)}" class="photo-link">
                        {$wish->DS_PRODUTO_PRRC}
                    </a>
                    <a href="{$this->url(["idwishlist"=>{$wish->NR_SEQ_WISHLIST_WLRC}], "removerwishlist", TRUE)}" class="me-remove" title="Excluir este produto da minha wishlist">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)|escape:'url'}" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status={$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)|escape:'url'}" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t={$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)|escape:'url'}" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
                {/foreach}
            </ul>
        {/if}
        <div id="wishlist-pagination" data-lastpage="{$paginas_wishlist}" data-size="6">
          <ul class="pagination">
                {if $paginas_wishlist <= 1}

                {elseif $paginas_wishlist > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                       {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_wishlist}" class="page">{$paginas_wishlist}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_wishlist <= 9}

                    {for $i=1; $i <= $paginas_wishlist; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Reverbcycle
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        {if $cycles|count le 0}
            <p class="centered">
                Tudo aquilo que você já se cansou pode ser<br>
                interessante para outra pessoa. Entre no escambo do Reverbcycle!
            </p>
        {else}
            <ul class="rvb-list rvb-list-of-photos-cycle clearfix" id="cycle-list">
                {foreach from=$cycles item=cycle}
                    {assign var="foto" value="{$cycle->NR_SEQ_REVERBCYCLE_RCRC}"}
                    {assign var="extensao" value="{$cycle->DS_EXT_RCRC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    <li class="rvb-photo-item">
                        <a href="{$this->url(["titulo"=>{$this->createslug($cycle->DS_OBJETO_RCRC)}, "idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], "cycledetalhe", TRUE)}" class="photo-thumb">
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$cycle->DS_OBJETO_RCRC}">
                        </a>
                        <a  href="{$this->url(["titulo"=>{$this->createslug($cycle->DS_OBJETO_RCRC)}, "idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], "cycledetalhe", TRUE)}" class="photo-link">
                            {$cycle->DS_OBJETO_RCRC}
                        </a>
                        <span class="comments">
                            Comentários: {$cycle->total_comentarios}
                        </span>
                        <span class="views">
                            Views: {$cycle->NR_VIEWS_RCRC}
                        </span>
                        <ul class="social-share-small">
                            <li class="social-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["titulo"=>{$this->createslug($cycle->DS_OBJETO_RCRC)}, "idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], "cycledetalhe", TRUE)}" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="http://twitter.com/home?status={$this->url(["titulo"=>{$this->createslug($cycle->DS_OBJETO_RCRC)}, "idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], "cycledetalhe", TRUE)}" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="http://tumblr.com/share?s=&v=3&t={$this->url(["titulo"=>{$this->createslug($cycle->DS_OBJETO_RCRC)}, "idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], "cycledetalhe", TRUE)}" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                {/foreach}

            </ul>
        {/if}
        <div id="cycle-pagination" data-lastpage="{$paginas_cycle}" data-size="6">
            <ul class="pagination">
                {if $paginas_cycle <= 1}

                {elseif $paginas_cycle > 8}

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    {for $i=1; $i <= 5; $i++}
                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}
                    {/for}
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="{$paginas_cycle}" class="page">{$paginas_cycle}</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                {elseif $paginas_cycle <= 9}

                    {for $i=1; $i <= $paginas_cycle; $i++}

                        {if $i == 1}
                            <li>
                                <a href="#" data-page="{$i}" class="page current">{$i}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#" data-page="{$i}" class="page">{$i}</a>
                            </li>
                        {/if}

                    {/for}

                {/if}
            </ul>
        </div>
    </div>
    {foreach from=$banners item=banner}
        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
          <a class="rvb-banners-bottom" href="{$banner->DS_LINK_BARC}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img class="profile reverbme-ads" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>460,'altura'=>180,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}"
              />
            {else}
              <img class="profile reverbme-ads" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>180,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}">
            {/if}
          </a>
    {/foreach}
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
                
<!-- lightbox para indicar -->
<div class="md-modal md-effect-1" id="indicar-lightbox">
    <div class="md-content">
        <p class="md-title">
            INDIQUE!
        </p>
        <button class="md-close ir">Fechar</button>
        <div>
            <form action="{$this->url([], "indiqueamigo2", TRUE)}" method="post" id="form-url-video" class="rvb-form">

                <label class="rvb-label" for="NomeAmigo">Nome:</label>
                <input class="rvb-input-txt" name="NomeAmigo" type="text" required="">

                <label class="rvb-label" for="EmailAmigo">Email:</label>
                <input class="rvb-input-txt" name="EmailAmigo" type="email" required=""><br>

                <div class="send-button">
                    <button type="submit" class="btn">Enviar</button>
                </div>

                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="insert-url-video-lightbox">
    <div class="md-content">
        <p class="md-title">
            Inclusão de novo vídeo - Reverb me
        </p>
        <button class="md-close ir">Fechar</button>
        <div>
            <form action="{$this->url([], "cadastrarvideo", TRUE)}" method="post" id="form-url-video" class="rvb-form">

                <label class="rvb-label" for="url-video">Insira a URL do vídeo:</label>
                <input class="rvb-input-txt" name="url-video" id="url-video" type="text" required="">

                <label class="rvb-label" for="titulo-video">Insira nome do vídeo:</label>
                <input class="rvb-input-txt" name="titulo-video" id="url-video2" type="text" required=""><br>

                <div class="send-button">
                    <button type="submit" class="btn">Enviar</button>
                </div>

                <div class="clearfix"></div>
            </form>
            <p>
                Pode não parecer, mas somos comportadinhos. Portando, nada de vídeos XxX no seu ReverbMe! A Reverbcity não se responsabilizar pelo conteúdo publicado nesta área do site.
            </p>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="lightbox-alterar-dados">
    <div class="md-content">
    <button class="md-close ir">Fechar</button>
        <form class="lighten" id="reverbme-form-cadastro" action="{$this->url([], "alterardados", TRUE)}" method="post">
            <div class="alterar-dados-box">
                {if $incompleto == 1}
                    <p class="full-strip" style="color: #f05626; background-color:transparent; text-align: center; font-size: 13px;">Complete seu cadastro para continuar a compra.</p>
                {/if}
                <p class="full-strip">Dados</p>
                <input type="hidden" name="cadastro_completo" value="1" />

                <div class="rvb-field">
                  <label for="nomecompleto" class="arrowed">Nome</label>
                  <input id="nomecompleto" name="nomecompleto" type="text" class="input-txt full" value="{$perfil->DS_NOME_CASO}"required>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle1">
                    <label for="sexo" class="arrowed">Sexo</label>
                    <span class="select-fake">{$perfil->DS_SEXO_CACH}</span>
                    <select name="sexo" id="sexo" class="select-box" required>
                        <option selected value="{$perfil->DS_SEXO_CACH}">{$perfil->DS_SEXO_CACH}</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                  </div>
                </div>
                {if $perfil->ST_CADASTROCOMPLETO_CASO neq 1}
                    <div class="rvb-field">
                      <label class="arrowed">Nascimento</label>
                      <input id="cadastro-dia" name="dia_nascimento" type="text" class="input-txt min day" placeholder="DIA" maxlength="2" required>
                      <input id="cadastro-mes" name="mes_nascimento" type="text" class="input-txt min month" placeholder="MÊS" maxlength="2" required>
                      <input id="cadastro-ano" name="ano_nascimento" type="text" class="input-txt min year" placeholder="ANO" maxlength="4" required>
                    </div>
                {/if}

                <div class="rvb-field">
                  <label for="cadastro-cpf" class="arrowed">CPF</label>
                  <input id="cadastro-cpf" name="cpf" type="text" class="input-txt middle1" maxlength="11" required value="{$perfil->DS_CPFCNPJ_CASO}">
                  <span class="legend">Preencha sem traços e pontos</span>
                </div>

                <div class="rvb-field">
                  <label for="cep" class="arrowed">CEP</label>
                  <input id="cadastro-cep" name="cep" type="text" class="input-txt middle2" required value="{$perfil->DS_CEP_CASO}">
                  <button id="buscarCep" type="button">Pesquisar</button>
                  <span class="legend">Digite sem traços e pontos</span>
                </div>

                <div class="rvb-field">
                  <label for="endereco" class="arrowed">Endereço</label>
                  <input id="endereco" name="endereco" type="text" class="input-txt middle2" required value="{$perfil->DS_ENDERECO_CASO}">
                </div>

                <div class="rvb-field">
                  <label for="numero" class="arrowed">Número</label>
                  <input id="numero" name="numero" type="text" class="input-txt middle3" required value="{$perfil->DS_NUMERO_CASO}">
                </div>

                <div class="rvb-field">
                  <label for="complemento" class="arrowed">Compl.</label>
                  <input id="complemento" name="complemento" type="text" class="input-txt middle2" value="{$perfil->DS_COMPLEMENTO_CASO}">
                </div>

                <div class="rvb-field">
                  <label for="bairro1" class="arrowed">Bairro</label>
                  <input id="bairro" name="bairro1" type="text" class="input-txt middle3" required value="{$perfil->DS_BAIRRO_CASO}">
                </div>

                <div class="rvb-field">
                  <div class="select-form middle3">
                    <label for="estado1" class="arrowed">Estado</label>
                    <span class="select-fake">{if $perfil->DS_UF_CASO}{$perfil->DS_UF_CASO}{else}Selecione o estado{/if}</span>
                    <select name="estado1" id="alterar_estado" class="select-box" value="{$perfil->DS_UF_CASO}">
                    </select>
                  </div>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle2">
                    <label for="cidade1" class="arrowed">Cidade</label>
                    <span class="select-fake">{if $perfil->DS_CIDADE_CASO}{$perfil->DS_CIDADE_CASO}{else}Selecione{/if}</span>
                    <select name="cidade1" id="alterar_cidade" class="select-box" required value="{$perfil->DS_CIDADE_CASO}">
                    </select>
                  </div>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle3">
                    <label for="pais" class="arrowed">País</label>
                    <span class="select-fake">Brasil</span>
                    <select name="pais" id="pais" class="select-box">
                        <option selected value="Brasil">Brasil</option>
                        <option value="Outro">Outro</option>
                    </select>
                    <span id="international-purchase" class="legend md-trigger" data-modal="international-purchases-lightbox">International purchase (click here)</span>
                  </div>
                </div>
                {assign var="telefone" value="{$perfil->DS_DDDFONE_CASO}.{$perfil->DS_FONE_CASO}"}
                <div class="rvb-field">
                  <label for="telefone11" class="arrowed">Fone</label>
                  <input id="telefone11" name="telefone11" type="text" class="input-txt middle2 phonemask" value="{$telefone}">
                </div>
                 {assign var="celular" value="{$perfil->DS_DDDCEL_CASO}.{$perfil->DS_CELULAR_CASO}"}
                <div class="rvb-field">
                  <label for="telefone21" class="arrowed">Cel</label>
                  <input id="telefone21" name="telefone21" type="text" class="input-txt middle3 phonemask" value="{$celular}">
                </div>
            </div>

            <div class="alterar-dados-box">
                <p class="full-strip">Dados para login</p>

                <div class="rvb-field">
                  <label for="usuarioemail" class="arrowed">E-mail</label>
                  <input id="usuarioemail" name="usuarioemail" type="email" class="input-txt full" required value="{$perfil->DS_EMAIL_CASO}">
                </div>

                <div class="rvb-field">
                  <label for="usuarioemail2" class="arrowed">Confirme</label>
                  <input id="usuarioemail2" name="usuarioemail2" type="email" class="input-txt full" required>
                </div>

                <div class="rvb-field">
                  <label for="usuariosenha" class="arrowed">Senha</label>
                  <input id="usuariosenha" name="usuariosenha" type="password" class="input-txt middle4" value="{$perfil->DS_SENHA_CASO}">
                  <span class="legend">Mínimo de 4 caracteres</span>
                </div>

                <div class="rvb-field">
                  <label for="usuariosenha2" class="arrowed">Confirme</label>
                  <input id="usuariosenha2" name="usuariosenha2" type="password" class="input-txt full">
                </div>
            </div>

            <div class="alterar-dados-box last">
                <p class="full-strip">Redes sociais</p>

                <div class="rvb-field">
                  <label for="facebook" class="arrowed">Facebook</label>
                  <input id="facebook" name="facebook" type="text" class="input-txt full" value="{$perfil->DS_FACEBOOK_CACH}">
                </div>

                <div class="rvb-field">
                  <label for="twitter" class="arrowed">Twitter</label>
                  <input id="twitter" name="twitter" type="text" class="input-txt full" value="{$perfil->DS_TWITTER_CACH}">
                </div>

                <div class="rvb-field">
                  <label for="instagram" class="arrowed">Instagram</label>
                  <input id="instagram" name="instagram" type="text" class="input-txt full" value="{$perfil->DS_INSTAGRAM_CASO}">
                </div>

                <div class="rvb-field margin-b">
                  <label for="pinterest" class="arrowed">Pinterest</label>
                  <input id="pinterest" name="pinterest" type="text" class="input-txt full" value="{$perfil->DS_PINTEREST_CASO}">
                </div>

                <div class="checkbox-dif {if $perfil->ST_ENVIO_CASO == 'S'}checked{/if}">
                  <label class="checkbox" for="mailing">
                    <input type="checkbox" id="mailing" name="mailing" {if $perfil->ST_ENVIO_CASO == 'S'}checked{/if} value="S">
                    Quero receber o reverbmailing
                  </label>
                </div>

                <div class="checkbox-dif {if $perfil->ST_ENVIOSMS_CACH == 'S'}checked{/if}">
                  <label class="checkbox" for="sms">
                    <input type="checkbox" id="sms" name="sms" {if $perfil->ST_ENVIOSMS_CACH == 'S'}checked{/if} value="S">
                    Autorizo o recebimento de SMS (Mensagens de texto no celular)
                  </label>
                </div>

                <div class="back-button">
                  <a href="{$this->url([], "desativarconta", TRUE)}" class="btn">Desativar Conta</a>
                </div>
                <div class="send-button">
                  <button type="submit" class="btn">Alterar</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>


<div class="md-overlay"></div>
{if $incompleto == 1}
    <script type="text/javascript" src="/arquivos/default/js/libs/jquery.min.js?v=1"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function() {
                  $('.modal-info').click();
            }, 1000);
        })
    </script>
{/if}