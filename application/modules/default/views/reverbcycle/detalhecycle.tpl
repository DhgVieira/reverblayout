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

<section id="detalhecycle">
    <h1 class="rvb-title">Reverb <span>cycle</span></h1>




    <div class="top-details">
        <div id="texto-cycle">
            <p>A vida é uma troca. Invés de jogar tudo fora e poluir nosso planeta, que tal fazer um escambo básico de coisas que já não quer mais por outras que são objeto de deseto? Você pode garimpar verdadeiras pechinchas e até fazer alguns novos amigos no meio tempo.</p>
        </div>
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


    <div class="row">
        <div class="span8 foto">
            <div class="cycle-product-photo">

                {if $cycle['ST_CYCLE_RCRC'] eq 'I'}
                    <span class="deal-c"></span>
                {/if}

                <ul id="carousel-cycle" class="owl-carousel owl-theme">
                    {assign var="foto" value="{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}"}
                    {assign var="extensao" value="{$cycle['DS_EXT_RCRC']}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    {assign var="foto_completa2" value="{$cycle['IMG_1_RCRC']}"}
                    {assign var="foto_completa3" value="{$cycle['IMG_2_RCRC']}"}

                    {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                        <li class="item">
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>460, 'altura'=>460, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" />
                        </li>
                    {/if}
                    {if $cycle['IMG_1_RCRC'] neq ""}
                        <li class="item">
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>460, 'altura'=>460, 'imagem'=>$foto_completa2], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" />
                        </li>
                    {/if}  
                    {if $cycle['IMG_2_RCRC'] neq ""}
                        <li class="item">
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>460, 'altura'=>460, 'imagem'=>$foto_completa3], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" />
                        </li>
                    {/if}
                </ul>
            </div>

            <div class="send-button left no-margin">
                <a href="{$this->url([], 'reverbcycle', TRUE)}" class="btn">Voltar</a>
            </div>

            <div class="share-buttons">
                <ul>

                    <li class="fb-like-count-box">
                        <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </li>

                    <li class="pinit-box">
                        <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" width="40" height="20" alt="Pin it" />
                        <a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark">
                        </a>
                    </li>

                    <li class="tweet-button">
                        <a href="https://twitter.com/share" data-lang="en" class="twitter-share-button">Tweet</a>
                        {literal}
                        <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
                        </script>
                        {/literal}
                    </li>

                    <li class="email-indique">
                        <a href="#" data-modal="indique-lightbox" class="md-trigger">
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="span8 comentarios">
            <div class="time">
                {$cycle['DS_OBJETO_RCRC']} - Enviado em {$cycle['DT_CADASTRO_RCRC']|date_format:"%d/%m/%Y"} ás {$cycle['DT_CADASTRO_RCRC']|date_format:"%H:%M"}h
            </div>
                <div class="data-content object">
                    <span class="label-content">Categoria:</span>
                    {if $cycle['NR_SEQ_CADASTRO_RCRC'] eq $idusuario}
                            <a href="{$this->url(["idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}, "status"=>{$cycle['ST_CYCLE_RCRC']}], 'fecharnegocio', TRUE)}"
                                {if $cycle['ST_CYCLE_RCRC'] eq 'I'}
                                    class="botao-fecharnegocio fechado"
                                {else}
                                    class="botao-fecharnegocio fechar"
                                {/if}>
                            </a>
                    {/if}

                    <span class="texto-catdesc">{$cycle['DS_CATEGORIA_RVRC']}</span>


                    <span class="label-content">Tags:</span>
                    <span class="texto-catdesc">
                        {foreach from=$tags item=tag}
                            {$tag->tag},
                        {/foreach}
                    </span>

                    <span class="label-content">Descrição:</span>
                    <span class="texto-catdesc">{$cycle['DS_CARACTERISTICAS_RCRC']}</span>
                    <a href="#" class="remove"></a>
                </div>
                <div class="data-title"><span>Contato:</span></div>
                <div class="data-content contact">
                    <form method="post" action="{$this->url([], 'cyclecontato', TRUE)}">
                        <span class="label-content nomeusuario">{$nomeusuario}</span>
                        <input type="hidden" name="idcycle" value="{$idcycle}">
                        <textarea name="mensagem" id="mensagem" name="mensagem" placeholder="Escreva aqui seu comentário..."></textarea>
                        <div class="send-button">
                            <input type="submit" class="btn"></input>
                        </div>
                    </form>
                </div>
                <div class="topo-comentarios"><span>Comentários</span></div>
                {foreach from=$comentarios item=comentario}
                <div class="data-content commentary" style="background-color: #FFFFFF; border-bottom: 2px solid #f2f2f2;">
                    <span class="nome-comentario"><a href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">{$comentario['DS_NOME_CASO']}</a></span>
                    <span class="data-comentario">
                        {$comentario['DT_CADASTRO_CRRC']|date_format:"%d/%m/%Y"} 
                        {$comentario['DT_CADASTRO_CRRC']|date_format:"%H:%M"}h
                        {if $_idperfil == 2 || $_idperfil == 4162 || $_idperfil == 22652}
                            <a href="{$this->url(['idcomentario' => $comentario['NR_SEQ_COMENTARIO_CRRC']], 'apagarcomentariocycle', true)}" class="remove">Remover</a>
                        {/if}
                    </span>
                    <span class="texto-comentario">{$comentario['DS_TEXTO_CRRC']}</span>
                    <span class="reply reply-comment-btn" style="float: right;">Responder</span>

                    {assign var=respostas value=$this->respostacyclecoments($comentario['NR_SEQ_COMENTARIO_CRRC'])}
                    {foreach from=$respostas item=mensagem_filha}
                        <div class="replied-item" style="background-color: #E5E5E5;">
                            <p class="person-name">{$mensagem_filha['DS_NOME_CASO']}</p>
                            <ul class="status-comment">
                                <li class="status-item last">
                                    <time datetime="{$mensagem_filha['DT_CADASTRO_CRRC']|date_format:'%d/%m/%Y'}" class="timestamp">
                                        {$mensagem_filha['DT_CADASTRO_CRRC']|date_format:'%d/%m/%Y'} {$mensagem_filha['DT_CADASTRO_CRRC']|date_format:"%H:%M"}h
                                    </time>
                                </li>
                            </ul>
                            <p class="person-answer">
                                {$this->utf8($mensagem_filha['DS_TEXTO_CRRC'])}
                            </p>
                        </div> <!-- replied-item -->
                    {/foreach}

                    <div class="user-reply-comment disabled">
                        <p class="person-name">{$_nome_usuario}</p>
                        <div class="clearfix"></div>
                        <form action="{$this->url([], 'cyclecontato', TRUE)}" method="post">
                            <input type="hidden" name="idcycle" value="{$idcycle}">
                            <input type="hidden" name="idmensagem" value="{$comentario['NR_SEQ_COMENTARIO_CRRC']}">
                            <textarea name="mensagem" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
                            <div class="send-button">
                                <button type="submit" class="btn">Responder comentário</button>
                            </div>
                        </form>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        <div class="row other-products">
            {include file="suggestion-cycle.tpl"}
        </div>
    </section>
</div>

{include file="lightbox-indique.tpl"}