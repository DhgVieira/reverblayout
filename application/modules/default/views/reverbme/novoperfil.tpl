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

<h1 class="rvb-title">Reverb <span>Me</span></h1>
{assign var="foto" value="{$perfil->NR_SEQ_CADASTRO_CASO}"}
{assign var="extensao" value="{$perfil->DS_EXT_CACH}"}
{assign var="foto_completa" value="{$foto}.{$extensao}"}
<div class="rvb-column left">
    <div class="rvb-header-item">
        <p>{$perfil->DS_NOME_CASO}</p>
        <a href="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], "denunciarperfil", TRUE)}" class="rvb-content-button denounce">Denunciar</a>
    </div>
    <div class="rvb-content-item user clearfix">
        <div class="rvb-me-details user-image">
            <!--<img class="profile" src="{$basePath}/arquivos/default/images/reverb-profile.gif" alt="Avatar do ReverbMe de {$perfil->DS_NOME_CASO}">-->
            {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                <img class="profile" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>120,'altura'=>142,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="Avatar do ReverbMe de {$perfil->DS_NOME_CASO}">
            {else}
                <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>120,'altura'=>142,'imagem'=>'not_found_bkp.jpg'],'imagem', TRUE)}" alt="Avatar Padrão Rerverbcity">
            {/if}

            {if $solicitacao|count > 0}
                 <a href="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], 'cancelaramizade', TRUE)}" class="btn-detail undo-friendship">Cancelar Solicitação</a>
            {else}
                {if $amizade|count > 0}
                    <a href="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], 'desfazeramizade', TRUE)}" class="btn-detail undo-friendship">Desfazer amizade</a>
                {else}
                    <a href="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], 'adicionaramigo', TRUE)}" class="btn-detail add-friendship">Adicionar amigo</a>
                {/if}
            {/if}
        </div>
        <div class="rvb-me-details user-profile">
            <form action="#" method="post" id="reverbme-profile">
                <input type="hidden" name="idperfil" value="{$perfil->NR_SEQ_CADASTRO_CASO}" />
                <div class="lines">
                    <label for="nome" class="legend-user">Nome:</label>
                    <input type="text" class="input-user" id="nome" value="{$perfil->DS_NOME_CASO}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="ocupacao" class="legend-user">Ocupação:</label>
                    <input type="text" class="input-user" id="ocupacao" value="{$perfil->DS_OCUPACAO_CACH}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="idade" class="legend-user">Idade:</label>
                    <input type="text" class="input-user" id="idade" value="{$idade}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="cidade" class="legend-user">Cidade:</label>
                    <input type="text" class="input-user" id="cidade" value="{$perfil->DS_CIDADE_CASO}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="bandas" class="legend-user">Bandas:</label>
                    <input type="text" class="input-user" id="bandas" value="" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="twitter" class="legend-user">Twitter:</label>
                    <input type="text" class="input-user" id="twitter" value="{$perfil->DS_TWITTER_CACH}" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <a href="{$perfil->DS_FACEBOOK_CACH}">
                        <label for="facebook" class="legend-user">Facebook:</label>
                        <input type="text" class="input-user" id="facebook" value="{$perfil->DS_FACEBOOK_CACH}" data-readable="true" readonly>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="rvb-header-item">
        <h2>
            Galeria de Fotos
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        {if $fotos|count le 0}
            <p class="centered">
                Mostre que você fica ainda mais gatinha(o)<br>
                quando usa Reverbcity. Mande suas fotos para nossa galeria!
            </p>
        {else}
            <ul class="rvb-list-of-photos clearfix" id="gallery-list">
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

                        <ul class="social-share-small">
                            <li class="social-item">
                                <a href="#" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                {/foreach}
            </ul>
        {/if}
        <div id="gallery-pagination" data-lastpage="{$paginas_fotos}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="9">
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
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <ul class="rvb-list-of-videos" id="videos-list">
            {foreach from=$videos item=video}
            {assign var=img_youtube value="/"|explode:$video->DS_YOUTUBE_VIRC}
            {assign var=idyoutube value='&'|explode:$img_youtube[4]}
            <li class="rvb-video-item">
                <a href="{$video->DS_YOUTUBE_VIRC}" class="video-thumb">
                    <img src="http://img.youtube.com/vi/{$idyoutube[0]}/hqdefault.jpg" alt="{$video->DS_NOME_VIRC}"></a>
                    <a href="{$video->DS_YOUTUBE_VIRC}" title="{$video->DS_NOME_VIRC}" class="video-link" target="_blank">{$video->DS_NOME_VIRC}</a>

                <ul class="social-share-small">
                    <li class="social-item">
                        <a href="#" class="social-link ir facebook" target="_blank">Facebook</a>
                    </li>
                    <li class="social-item">
                        <a href="#" class="social-link ir twitter" target="_blank">Twitter</a>
                    </li>
                    <li class="social-item">
                        <a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>
                    </li>
                    <li class="social-item">
                        <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                    </li>
                </ul>
            </li>
            {/foreach}
        </ul>
        <div id="videos-pagination" data-lastpage="{$paginas_videos}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="4">
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
    <!-- <div class="rvb-header-item">
        <h2>
            Blog
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <form action="/work/reverb/trunk/publicar-me" method="post">
          <input name="titulo" type="text" class="title-of-post" placeholder="Insira o título do seu post">
          <textarea name="post" id="full-post" cols="30" rows="10" class="message-box full-post"></textarea>
          <button type="submit" class="rvb-send-button publish">Publicar</button>
        </form>
    </div> -->
    <div class="rvb-header-item">
        <h2>
            Últimos posts
        </h2>
    </div>
    <div class="rvb-content-item clearfix">

        <div class="rvb-list-of-posts" id="latest-posts-list">
            {foreach from=$posts item=post}
                <div class="latest-post">

                    <a href="#" class="post-thumb">
                        <img src="http://dummyimage.com/120x143/888/ccc" alt="titulo do post teste">
                    </a>
                    <a href="#" class="post-title">{$post->titulo}</a>
                    <p class="post-date">
                        {$post->data_publicacao|date_format:"%d/%m/%Y"} ás  {$post->data_publicacao|date_format:"%H:%M"} Por: <span class="post-author">{$_nome_usuario}</span>
                    </p>
                    <p class="post-tiny-description"></p>
                    <p>
                        {$post->post|truncate:230:"...":true}
                    </p>
                    <a href="#" class="button comments">0 comentários</a><a href="#" class="button read-post">Ler post completo</a>
                </div>
            {/foreach}
        </div>
        <div id="latest-posts-pagination" data-lastpage="{$paginas_post}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="3">
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
    <div class="rvb-header-item">
        <h2>
            Amigos
        </h2><input type="text" id="searchFriendInput" data-iduser="{$perfil->NR_SEQ_CADASTRO_CASO}" class="search-friend" placeholder="Digite o nome para buscar" name="filter"> <a href="#" id="searchFriendButton" class="rvb-content-button">Buscar</a>
    </div>
    <div class="rvb-content-item friends">
        <ul class="rvb-list-of-friends" id="friends-list">
            {foreach from=$amigos item="amigo"}
                {assign var="foto" value="{$amigo['NR_SEQ_AMIGO_FRRC']}"}
                {assign var="extensao" value="{$amigo['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <li>
                    <a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" class="profile-thumb">
                        {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                            <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>103,'altura'=>90,'imagem'=>$foto_completa],'imagem', TRUE)}">
                        {else}
                            <img src="{$basePath}/arquivos/default/images/sem_foto.jpg" alt="{$amigo['DS_NOME_CASO']}" title="{$amigo['DS_NOME_CASO']}"/>
                        {/if}
                    </a>
                    <a href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_AMIGO_FRRC']}], "perfil", TRUE)}" title="Visualizar perfil de {$amigo->NR_SEQ_AMIGO_FRRC}" class="profile-link">{$amigo['DS_NOME_CASO']}</a>
                </li>
            {/foreach}
        </ul>
        <div id="friends-pagination" data-lastpage="{$paginas_amigos}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="8">
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
    <form method="post" action="{$this->url(["idperfil"=>{$perfil->NR_SEQ_CADASTRO_CASO}], "enviarmensagem", TRUE)}">
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
            <textarea class="message-box" name="reverbme-mensagem" placeholder="Escreva aqui sua mensagem..."></textarea>
            <label class="label-checkbox" for="isPrivate"><input type="checkbox" name="isPrivate" id="isPrivate" value="1"> Mensagem privada</label> <input type="submit" class="rvb-send-button" value="Enviar">
            <div class="horizontal-line"></div>
            <div class="list-of-scraps" id="scraps-list">
                {foreach from=$recados item=recado}
                    <div class="rvb-comment-box">
                        <!-- <a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" data-message-id="{$recado->NR_SEQ_SCRAP_SBRC}" class="md-close ir" title="Remover mensagem">Excluir</a> -->
                        <p class="rvb-comment-author-name">
                           <a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">{$recado->DS_NOME_CASO}</a>
                        </p>
                        <p class="rvb-comment-date">
                            {assign var="datarecado" value=$recado->DT_POST_SBRC|cat:" -3 hour"}
                            {$datarecado|date_format:"%Y-%m-%d %H:%M:%S"}
                        </p>
                        <div class="rvb-comment-message">
                            {$recado->DS_POST_SBRC}
                        </div>
                        <!-- <div class="rvb-comment-buttons">
                            <a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}" class="button">Responder |</a>
                            <a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" class="button">Excluir</a>
                        </div> -->
                    </div>
                {/foreach}
            </div>
            <div id="scraps-pagination" data-lastpage="{$paginas_recados}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="5">
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
            <ul class="rvb-list-of-wishlist clearfix" id="wishlist-list">
                {foreach from=$wishlists item=wish}
                    {assign var="foto" value="{$wish->NR_SEQ_PRODUTO_PRRC}"}
                    {assign var="extensao" value="{$wish->DS_EXT_PRRC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <li class="rvb-photo-item">
                    <a href="{$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)}" class="photo-thumb">
                        <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$wish->DS_PRODUTO_PRRC}"></a>
                    <a href="{$this->url(["titulo"=>{$this->createslug($wish->DS_PRODUTO_PRRC)}, "idproduto"=>{$wish->NR_SEQ_PRODUTO_PRRC}], "produto", TRUE)}" class="photo-link">
                        {$wish->DS_PRODUTO_PRRC}
                    </a>

                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="#" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
                {/foreach}

            </ul>
        {/if}
        <div id="wishlist-pagination" data-lastpage="{$paginas_wishlist}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="6">
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
            <ul class="rvb-list-of-photos-cycle clearfix" id="cycle-list">
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
                                <a href="#" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                {/foreach}

            </ul>
        {/if}
        <div id="cycle-pagination" data-lastpage="{$paginas_cycle}" data-perfil="{$perfil->NR_SEQ_CADASTRO_CASO}" data-size="6">
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
    <div class="rvb-content-item clearfix">
        {foreach from=$banners item=banner}
            {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
            {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a href="{$banner->DS_LINK_BARC}"><img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>440,'altura'=>180,'imagem'=>$foto_completa],'imagem', TRUE)}"  alt="{$banner->DS_DESCRICAO_BARC}"></a>
        {/foreach}

    </div>
</div>

<div class="md-overlay"></div>