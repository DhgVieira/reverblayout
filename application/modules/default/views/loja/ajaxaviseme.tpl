<html>
{foreach from=$contadores item=produto name=produtosForEach}
    {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
    {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
    {assign var="foto_completa" value="{$foto}.{$extensao}"}
    <div class="grid-item">
        <div class="flip-container">
            <div class="flipper">
                <div class="front">
                    <div id="home-front2">
                        <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'classic', TRUE)}" class="product-photo">
                            {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="produto" />
                            {else}
                                {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                                {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                                {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                                {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                    <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                                {else}
                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                {/if}
                            {/if}
                        </a>
                    </div>
                </div>
                <div class="back">
                    <div id="home-back2">
                        {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                            <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                        {else}
                            {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                            {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                            {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                            {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                            {/if}
                        {/if}
                        <div class="image_over">
                            <div class="image_hover_text">
                                {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">*}

                                {*<br/>*}
                                {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title text_bold">*}
                                {*Eu quero!*}
                                {*</a>*}
                                <span>{$produto->DS_PRODUTO_PRRC}</span>
                                <br/>
                                <br/>
                                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'classic', TRUE)}" class="title text_bold">
                                    <button class="reprint-button">Pedir Reprint</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/foreach}
</html>