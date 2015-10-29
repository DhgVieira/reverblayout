    <section id="detalhepeople">
        <h1 class="rvb-title">Reverb <span>people</span></h1>
                {assign var="foto_me" value="{$foto->NR_SEQ_FOTO_FORC}"}
                {assign var="extensao" value="{$foto->DS_EXT_FORC}"}
                {assign var="foto_completa" value="{$foto_me}.{$extensao}"}
        <div class="top-details">
            <div id="texto-people">
                <p>Foi pro rolê usando uma de nossa camisetas? Que tal mostrar para todo mundo que você se veste de música e quais são as suas camisetas preferidas? Para isso, basta enviar sua foto para a nossa galeria e deixar a música ser fotografada.</p>
            </div>
            <form action="" id="form-busca">
                <input type="text" id="busca-p"><a href="#" id="buscar"></a>
            </form>
        </div>
        <div class="row">
            <div class="span8 foto">
                <div class="people-product-photo">
                    {if file_exists("arquivos/uploads/people/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>460, 'altura'=>640, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>460, 'altura'=>640, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
                    {/if}
                </div>

                <div class="send-button left no-margin">
                    <a href="{$this->url([], 'people', TRUE)}" class="btn">Voltar</a>
                </div>
                {include file="share-buttons.tpl"}
            </div>


            <div class="span8 comentarios">
                <div class="data-title"><span>{$foto['DS_NOME_CASO']} - <a href="{$this->url(["nome"=>{$this->createslug($foto['DS_NOME_CASO'])}, "idperfil"=>{$foto['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">Ver perfil</a></span></div>

                <div class="data-content contact">
                    <form method="post" action="{$this->url([], 'comentarpeople', TRUE)}">

                        <span class="label-content nomeusuario">{$_nome_usuario}</span>
                        <input type="hidden" name="idpeople" value="{$idpeople}">
                        <textarea name="mensagem" id="mensagem" name="mensagem" placeholder="Escreva aqui seu comentário..."></textarea>

                        <div class="send-button">
                            <button type="submit" class="btn">Enviar</button>
                        </div>
                    </form>
                </div>

                <div class="topo-comentarios"><span>Comentários</span></div>

                {foreach from=$comentarios item=comentario}
                <div class="data-content commentary" style="background-color: #FFFFFF; border-bottom: 2px solid #f2f2f2;">

                    <span class="nome-comentario"><a href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">{$comentario['DS_NOME_CASO']}</a></span>

                    <span class="data-comentario">
                        {$comentario['DT_CADASTRO_MCRC']|date_format:"%d/%m/%Y"} 
                        {$comentario['DT_CADASTRO_MCRC']|date_format:"%H:%M"}h
                        {if $_idperfil == 2 || $_idperfil == 4162 || $_idperfil == 22652}
                            <a href="{$this->url(['idcomentario' => $comentario['NR_SEQ_COMENTARIO_MCRC']], 'apagarcomentariome', true)}" class="remove">Remover</a>
                        {/if}
                    </span>

                    <span class="texto-comentario">{utf8_decode($comentario['DS_TEXTO_MCRC'])}</span>
                    <span class="reply reply-comment-btn" style="float: right;">Responder</span>

                    {assign var=respostas value=$this->respostapeoplecoments($comentario['NR_SEQ_COMENTARIO_MCRC'])}
                    {foreach from=$respostas item=mensagem_filha}
                        <div class="replied-item" style="background-color: #E5E5E5;">
                            <p class="person-name">{$mensagem_filha['DS_NOME_CASO']}</p>
                            <ul class="status-comment">
                                <li class="status-item last">
                                    <time datetime="{$mensagem_filha['DT_CADASTRO_MCRC']|date_format:'%d/%m/%Y'}" class="timestamp">
                                        {$mensagem_filha['DT_CADASTRO_MCRC']|date_format:'%d/%m/%Y'} {$mensagem_filha['DT_CADASTRO_MCRC']|date_format:"%H:%M"}h
                                    </time>
                                </li>
                            </ul>
                            <p class="person-answer">
                                {$this->utf8($mensagem_filha['DS_TEXTO_MCRC'])}
                            </p>
                        </div> <!-- replied-item -->
                    {/foreach}

                    <div class="user-reply-comment disabled">
                        <p class="person-name">{$_nome_usuario}</p>
                        <div class="clearfix"></div>
                        <form action="{$this->url([], 'comentarpeople', TRUE)}" method="post">
                            <input type="hidden" name="idpeople" value="{$idpeople}">
                            <input type="hidden" name="idmensagem" value="{$comentario['NR_SEQ_COMENTARIO_MCRC']}">
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
            {include file="suggestion-products.tpl"}
        </div>
    </section>
</div>
{include file="lightbox-indique.tpl"}