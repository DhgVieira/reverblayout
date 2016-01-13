<html>
            {foreach from=$contadores item=cycle}

                <br>
                <br>
                <br>
                <br>
                {assign var="foto" value="{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}"}
                {assign var="extensao" value="{$cycle['DS_EXT_RCRC']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                {{$foto->DS_NOME_CASO}}
                <div class="grid-item">
                    <div class="flip-container">
                        <div class="flipper">
                            <div class="front">
                                <div id="home-front2">
                                    <a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}">
                                        <!-- Adicao da classe deal-c para poder aparecera tag na LI, só que precisa criar um span, precisa mexer nos if também -->
                                        {if $cycle['ST_CLIENTE_RCRC'] eq 'I'}
                                            <span class="deal-c"></span>
                                        {/if}
                                        {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" />
                                        {else}
                                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />
                                        {/if}
                                    </a>
                                </div>
                            </div>
                            <div class="back">
                                <div id="home-back2">

                                    {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                                        <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" />
                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />
                                    {/if}
                                    <div class="image_over">
                                        <div class="image_hover_text">
                                            <a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">
                                                {$cycle['DS_OBJETO_RCRC']}
                                            </a>
                                            <br/>
                                            <a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">
                                                Eu quero!
                                            </a>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}


    {*<ul class="thumbnails cycle-thumbnails">*}

    {*<!-- PARA ADICIONAR DISPLAY NONE NA PRIMEIRA LI SÓ COLOCAR ATIC (CLASSE QUE DEIXA DISPLAY NONE) -->*}

    {*<li class="span4 cycle-items inserir-cycle">*}

    {*<a href="#" class="insert-object md-trigger" data-modal="inserir-objeto">*}

    {*<span>INSERIR<br>OBJETO</span>*}

    {*</a>*}

    {*</li>*}


    {*{foreach from=$contadores item=cycle}*}
    {*{assign var="foto" value="{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}"}*}
    {*{assign var="extensao" value="{$cycle['DS_EXT_RCRC']}"}*}
    {*{assign var="foto_completa" value="{$foto}.{$extensao}"}*}
    {*<li class="span4 cycle-items {if !($cycle@index%4)}{/if}">*}

    {*<div class="thumbnail">*}
    {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}">*}
    {*<!-- Adicao da classe deal-c para poder aparecera tag na LI, só que precisa criar um span, precisa mexer nos if também -->*}
    {*{if $cycle['ST_CLIENTE_RCRC'] eq 'I'}*}
    {*<span class="deal-c"></span>*}
    {*{/if}*}
    {*{if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}*}
    {*<img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />*}
    {*{else}*}
    {*<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>170, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$cycle['DS_OBJETO_RCRC']}" width="220" height="170" />*}
    {*{/if}*}
    {*</a>*}

    {*<div class="caption">*}
    {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">*}
    {*{$cycle['DS_OBJETO_RCRC']}*}
    {*</a>*}

    {*<div class="by">by <a href="{$this->url(["nome"=>{$this->createslug($cycle['DS_NOME_CASO'])}, "idperfil"=>{$cycle['NR_SEQ_CADASTRO_CASO']}], 'perfil', TRUE)}">{$cycle['DS_NOME_CASO']}</a></div>*}

    {*<div class="commentaries">Comentários: {$cycle['total_comentarios']}</div>*}

    {*<div class="views">Views: {$cycle['NR_VIEWS_RCRC']}</div>*}

    {*<ul class="social-media social-media-comp">*}
    {*<li>*}
    {*<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-facebook"></a>*}
    {*</li>*}

    {*<li>*}
    {*<a target="_blank" href="http://twitter.com/home?status={utf8_decode($cycle['DS_OBJETO_RCRC'])|escape:'url'}%20disponível%20para%20negociação%20na%20Reverbcycle!%20-%20{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-twitter"></a>*}
    {*</li>*}

    {*<li>*}
    {*<a target="_blank" href="http://tumblr.com/share?s=&v=3&t={utf8_decode($cycle['DS_OBJETO_RCRC'])|escape:'url'}%20disponível%20para%20negociação%20na%20Reverbcycle!&u={$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)|escape:'url'}" class="icon user-tumblr"></a>*}
    {*</li>*}

    {*<li><a href="" class="icon user-pinterest"></a></li>*}
    {*</ul>*}
    {*</div>*}
    {*</div>*}
    {*</li>*}
    {*{/foreach}*}
    {*</ul>*}

    {*<div class="pagination">*}
    {*<ul>*}
    {*{$this->paginationControl($contadores, NULL, 'paginator_cycle.tpl')}*}
    {*</ul>*}
    {*</div>*}
</html>