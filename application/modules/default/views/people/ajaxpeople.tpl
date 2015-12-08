{foreach from=$contadores item=foto}
    {assign var="foto_me" value="{$foto->NR_SEQ_FOTO_FORC}"}
    {assign var="extensao" value="{$foto->DS_EXT_FORC}"}
    {assign var="foto_completa" value="{$foto_me}.{$extensao}"}

    <div class="grid-item">
       {* <div class="image_over">
            <div class="image_hover_text">
                <a href="{$this->url(["nome"=>{$this->createslug($foto->DS_NOME_CASO)}, "idfoto"=>{$foto->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}" class="reverb-button ir open" title="Open" rel="nofollow"></a>
                <a href="#" class="reverb-button ir share" title="Share" rel="nofollow"></a>
                <br/>
                {$foto->DS_NOME_CASO}
            </div>
        </div>*}
        {if file_exists("arquivos/uploads/people/$foto_completa")}
            <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
        {else}
            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$foto->DS_NOME_CASO}" />
        {/if}
    </div>
{/foreach}