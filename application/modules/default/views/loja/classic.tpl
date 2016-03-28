    <div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true">
        {foreach from=$banners item=banner}
        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a href="{$banner->DS_LINK_BARC}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                    <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {else}
                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {/if}
            </a>
        {/foreach}
    </div>

    <section id="classic">
        <h1 class="rvb-title">Classics</h1>

        <div class="top-details">
            <div id="texto-classic">
                <p>
                As camisetas que já estiveram em nosso playlist
                </p>
            </div>
        </div>


        <div class="row">
            <div class="span8 foto">
                <div class="classic-product-photo">
                    
                    {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC, true)}
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}

                    {assign var="foto_completa_produto" value="{$foto_produto}.{$extensao_produto}"}
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_produto")}
                        <img pagespeed_no_transform src="{$basePath}/thumb/fotosprodutos/1/460/512/{$foto_completa_produto}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                    {else}
                        {assign var="foto_produto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                        {assign var="extensao_produto" value="{$produto->DS_EXT_PRRC}"}
                        {assign var="foto_completa_produto" value="{$foto_produto}.{$extensao_produto}"}

                        {if file_exists("arquivos/uploads/produtos/$foto_completa_produto")}
                            <img pagespeed_no_transform src="{$basePath}/thumb/produtos/1/460/512/{$foto_completa_produto}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                        {else}
                            <img pagespeed_no_transform 2 src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>493, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                        {/if}
                    {/if}

                </div>

                <div class="send-button left no-margin">
                    <a href="{$this->url([], 'loja', TRUE)}" class="btn bold">Voltar</a>
                </div>
                <div class="send-button left">
                    <a href="#" data-modal="avise-lightbox" class="md-trigger btn bold">Avise-me</a>
                </div>

                {include file="share-buttons.tpl"}
            </div>
            <div class="span8 comentarios">
                <div class="data-title"><span>{$produto->DS_PRODUTO_PRRC}</span></div>
                <div class="data-content contact">
                    <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'comentarproduto', TRUE)}" method="post">
                        <span class="label-content nomeusuario">{$nomeusuario}</span>
                        <input type="hidden" name="idproduto" value="{$idproduto}">
                        <textarea name="comentario" id="mensagem" name="mensagem" placeholder="Escreva aqui seu comentário..."></textarea>
                        <div class="send-button">
                            <!-- <a href="#" data-modal="avise-lightbox" class="md-trigger btn bold">Avise-me</a> -->
                            <button type="submit" class="btn bold">Comentar</button>
                        </div>
                    </form>
                </div>
                <div class="topo-comentarios"><span>Comentários</span></div>
                {foreach from=$comentarios item=comentario}
                <div class="data-content commentary" style="background-color: #FFFFFF; border-bottom: 2px solid #f2f2f2;">
                    <span class="nome-comentario"><a href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">{$comentario['DS_NOME_CASO']}</a></span>
                    <span class="data-comentario">
                        {$comentario['DT_COMENT_PCRC']|date_format:"%d/%m/%Y"} 
                        {$comentario['DT_COMENT_PCRC']|date_format:"%H:%M"}h
                        {if $_idperfil == 2 || $_idperfil == 4162 || $_idperfil == 22652}
                            <a href="{$this->url(['idcomentario' => $comentario['NR_SEQ_PRODCOMENT_PCRC']], 'apagarcomentario', true)}" class="remove">Remover</a>
                        {/if}
                    </span>
                    <span class="texto-comentario">{$this->utf8($comentario['DS_COMENTARIO_PCRC'])}</span>
                    <span class="reply reply-comment-btn" style="float: right;">Responder</span>

                    {foreach from=$comentario->findDependentRowset('Default_Model_Produtoscoments', null, $select_coments_where->reset(Zend_Db_Select::WHERE)->where('DS_STATUS_PCRC = "A"')) item=mensagem_filha}
                        <div class="replied-item" style="background-color: #E5E5E5;">
                            <p class="person-name">
                                <a href="{$this->url(["nome"=>{$this->createslug($mensagem_filha->DS_AUTOR_PCRC)}, "idperfil"=>{$mensagem_filha->NR_SEQ_CADASTRO_PCRC}], "perfil", TRUE)}">
                                    {$mensagem_filha->DS_AUTOR_PCRC}
                                </a>
                            </p>
                            <ul class="status-comment">
                                <li class="status-item last">
                                    <time datetime="{$mensagem_filha->DT_COMENT_PCRC|date_format:'%d/%m/%Y'}" class="timestamp">
                                        {$mensagem_filha->DT_COMENT_PCRC|date_format:'%d/%m/%Y'} {$mensagem_filha->DT_COMENT_PCRC|date_format:"%H:%M"}h
                                    </time>
                                </li>
                            </ul>
                            <p class="person-answer">
                                {$this->utf8($mensagem_filha->DS_COMENTARIO_PCRC)}
                            </p>
                        </div> <!-- replied-item -->
                    {/foreach}

                    <div class="user-reply-comment disabled">
                        <p class="person-name">{$_nome_usuario}</p>
                        <div class="clearfix"></div>
                        <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'comentarproduto', TRUE)}" method="post">
                            <input type="hidden" name="idmensagem" value="{$comentario->NR_SEQ_PRODCOMENT_PCRC}">
                            <textarea name="new-comment" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
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

<div class="md-modal md-effect-1" id="avise-lightbox">
    <div class="md-content">
        <p class="md-title">Avise-me</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <p class="md-description">Caso você queira ser avisado da volta ao estoque de algum tamanho deste produto, preencha seus dados abaixo:</p>
            <form action="{$this->url(['idproduto' => $idproduto], "avisemeproduto", TRUE)}" id="avise-form" method="POST">
                <div class="md-bg">
                    <div class="col">
                         {if $_logado eq 1}

                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" value="{$nome}" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" value="({$ddd}) - {$telefone}" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" value="{$email}" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    {foreach from=$tamanhos item=tamanho}
                                        <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}">{$tamanho->DS_TAMANHO_TARC}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span>{$uf}</span>
                                <select id="avise-estado" name="estado" required value="{$uf}">

                                </select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span>{$cidade}</span>
                                <select id="avise-cidade" name="cidade" required value="{$cidade}">
                                </select>
                            </div>

                        {else}
                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    {foreach from=$tamanhos item=tamanho}
                                        <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}">{$tamanho->DS_TAMANHO_TARC}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span>Selecione o Estado</span>
                                <select id="avise-estado" name="estado" required></select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span>Selecione a cidade</span>
                                <select id="avise-cidade" name="cidade" required></select>
                            </div>
                        {/if}
                        <textarea placeholder="Comentários" name="observacoes"></textarea>
                    </div>
                </div>

                <div class="send-button">
                    <button class="btn" type="submit">Avise-me</button>
                </div>
            </form>

           </div>
        </div>
    </div>
</div>

{include file="lightbox-indique.tpl"}
