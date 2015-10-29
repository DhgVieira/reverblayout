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
    Minhas <span>Compras</span>
</h1>


<table id="minhas-compras" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><abbr title="Número do pedido">Nr</abbr></th>
            <th>Data do pedido</th>
            <th><abbr title="Quantidade de itens comprados">Quantidade</abbr></th>
            <th>Forma de pagamento</th>
            <th><abbr title="Valor Total">Valor</abbr></th>
            <th>Status</th>
            <th><abbr title="Código de Rastreamento">Cód. Rastreamento</abbr></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$compras item=compra}
            <tr>
                <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">{$compra['NR_SEQ_COMPRA_COSO']}<a></td>
                <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">{$compra['DT_COMPRA_COSO']|date_format:"%d/%m/%Y %H:%M"}</a></td>
                <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">{$compra['total_itens']}</a></td>
                <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">{$compra['DS_FORMAPGTO_COSO']}</a></td>
                <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">R$ {$compra['VL_TOTAL_COSO']|number_format:2:",":"."}</a></td>

                {if $compra['ST_COMPRA_COSO'] eq 'V'}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">ENVIADA</a></td>
                {/if}
                {if $compra['ST_COMPRA_COSO'] eq 'E'}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">ENTREGUE</a></td>
                {/if}
                {if $compra['ST_COMPRA_COSO'] eq 'C'}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">CANCELADA</a></td>
                {/if}
                {if $compra['ST_COMPRA_COSO'] eq 'P'}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">PAGA</a></td>
                {/if}
                {if $compra['ST_COMPRA_COSO'] eq 'A'}
                    <td style=" font-weight: bold; " {if $vencimentoBoleto < $smarty.now|date_format:"%Y-%m-%d"} class="has-tooltip" {/if}>
                        {if $compra['DS_FORMAPGTO_COSO'] eq 'boleto'}
                            {assign var=vencimentoBoleto value=$compra['DT_COMPRA_COSO']|cat:"+3 days"}
                            {assign var=vencimentoBoleto value=$vencimentoBoleto|date_format:"%Y-%m-%d"}

                            {if $vencimentoBoleto >= $smarty.now|date_format:"%Y-%m-%d"}
                                <a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "segundoboleto", TRUE)}">2ª Via Boleto</a>
                            {else}
                                <a class="novo-pagamento" href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "reabrircompra", TRUE)}">NOVO PGTO.</a>
                            {/if}
                        {else}
                            <a class="novo-pagamento" href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "reabrircompra", TRUE)}">NOVO PGTO.</a>
                        {/if}
                        {if $vencimentoBoleto < $smarty.now|date_format:"%Y-%m-%d"}
                        <div class="tooltip">
                            Se você já pagou o boleto não prossiga com esta operação. <br/><br/>Aguarde o email de confirmação de pagamento e caso tenha qualquer dúvida mande email para o atendimento@reverbcity.com
                        </div>
                        {/if}
                    </td>
                {/if}
                {if $compra['DS_RASTREAMENTO_COSO'] eq ""}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">AGUARDANDO CORREIOS</a></td>
                {else}
                    <td><a href="{$this->url(["idcompra"=>{$compra['NR_SEQ_COMPRA_COSO']}], "detalhecompra", TRUE)}">{$compra['DS_RASTREAMENTO_COSO']}</a></td>
                {/if}
            </tr>
        {/foreach}
    </tbody>
</table>

<div class="send-button left no-margin">
    <a href="{$this->url([], 'novome', TRUE)}" class="btn">Voltar</a>
</div>