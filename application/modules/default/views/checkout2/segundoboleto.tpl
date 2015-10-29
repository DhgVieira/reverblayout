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

    <h1 class="rvb-title"> 2ª Via <span>Boleto</span></h1>
    Perdeu o boleto do pagamento da sua compra? Não se preocupe, basta clicar em “Gerar  2ª Via do Boleto” para emitir um novo e garantir as peças que estão reservadas para você.
    <div class="formulario">
        {*{if $dadosCompras->DS_TID_COSO}*}
            <form action="{$boleto_url}" method="get" name="pagamento" target="_blank">
                <button type="submit">
                    Gerar  2ª Via do Boleto
                </button>
            </form>
        {*{else}*}
            {*<form action="https://www16.bancodobrasil.com.br/site/mpag/" method="post" name="pagamento" target="_blank">*}


                {*<input type="hidden" name="idConv" value="303990" />*}
                {*<input type="hidden" name="refTran" value="{$refTran}" />*}
                {*<input type="hidden" name="valor" value="{$vlTran}" />*}
                {*<input type="hidden" name="dtVenc" value="{$dtVenc}"/>*}
                {*<input type="hidden" name="tpPagamento" value="21" />*}
                {*<input type="hidden" name="urlRetorno" value="/" />*}
                {*<input type="hidden" name="urlInforma" value="RecBol.aspx" />*}
                {*<input type="hidden" name="nome" value="{$nome}" />*}
                {*<input type="hidden" name="endereco" value="{$endereco},{$numero}" />*}
                {*<input type="hidden" name="cidade" value="{$cidade}" />*}
                {*<input type="hidden" name="uf" value="{$estado}" />*}
                {*<input type="hidden" name="cep" value="{$cep}" />*}
                {*<input type="hidden" name="msgLoja" value="Voce fez uma reverb-compra" />           *}
                {*<button type="submit">*}
                    {*Gerar  2ª Via do Boleto*}
                {*</button>*}
            {*</form>*}
        {*{/if}*}
    </div>