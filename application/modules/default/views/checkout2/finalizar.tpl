<div class="my-cart-steps clearfix">
    <div class="steps step-1">Etapa 1 - Carrinho</div>
    <div class="steps step-2">Etapa 2 - Endereço / Pagamento</div>
    <div class="steps step-3 current">Etapa 3 - Confirmação</div>
</div>

<h2 class="rvb-title">
    {if $compra->DS_FORMAPGTO_COSO neq 'boleto' AND $compra->ST_COMPRA_COSO != 'P' AND $compra->ST_COMPRA_COSO != 'A'}
        Ops! Algo deu errado :(
    {else}
        Obrigado pelo seu pedido!
    {/if}
</h2>

	<hr class="mycart-border">

    <div id="mycart-demand">
        <a href="https://www.reverbcity.com/minhas-compras">Pedido número: <strong>{$pedido}</strong></a>
    </div>
    
    {if $compra->DS_FORMAPGTO_COSO neq 'boleto' AND $compra->ST_COMPRA_COSO != 'P' AND $compra->ST_COMPRA_COSO != 'A'}
        <a href="{$this->url([], 'carrinho', TRUE)}" class="mycart-button avancar" style="float: right; margin-top: 30px; width: 275px;">Escolher nova forma de pagamento</a>
    {/if}
	<div class="clearfix"></div>

    <div id="mycart-text">
    	<p>
            {if $compra->ST_COMPRA_COSO == 'P'}
                    <br /><br /><strong>Seu pedido foi aprovado!</strong> e já estamos separando sua compra aqui na Reverbcity!<br />
                    Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.
            {elseif $compra->ST_COMPRA_COSO == 'C'}
                {if $compra->DS_FORMAPGTO_COSO neq 'boleto'}
                    <br /><br />Sua compra não foi aprovada pela administradora do seu cartão de crédito e seu pedido ainda não foi finalizado.<br />
                    Você pode <strong><a href="{$this->url([], 'carrinho', true)}">Clicar Aqui</a></strong> e escolher outra forma de pagamento.
                {/if}
            {else}
                {if $compra->DS_FORMAPGTO_COSO neq 'boleto'}
                    <br /><br />Pedido Recebido na Reverbcity. <strong>Aguardando Confirmação de Pagamento.</strong><br/>
                    A equipe da Reverbcity já está quase pronta para dar o play no seu pedido, mas antes da música começar <br/>
                    precisamos fazer a confirmação do seu pagamento.
                {/if}
            {/if}

    	</p>
    	<br>
        {if $compra->DS_FORMAPGTO_COSO eq 'boleto'}
    	<p>
    		Este boleto pode ser pago em qualquer banco ou lotérica até o seu vencimento.
Pagamentos efetuados em dias úteis são confirmados no dia seguinte e pagamentos efetuados durante os fins de semana e feriados serão confirmados em até dois dias úteis.

    	</p>
        {/if}
    </div>
    {if $compra->DS_FORMAPGTO_COSO eq 'boleto'}
        <form id="form-finalizar" action="{$this->boleto_url}" method="get" name="pagamento">
        {*<form id="form-finalizar" action="https://geraboleto.sicoobnet.com.br/geradorBoleto/GerarBoleto.do" method="post" name="pagamento">*}
            {*<input type="hidden" name="idConv" value="303990" />
            <input type="hidden" name="refTran" value="{$refTran}" />
            <input type="hidden" name="valor" value="{$vlTran}" />
            <input type="hidden" name="dtVenc" value="{$t}"/>
            <input type="hidden" name="tpPagamento" value="2" />
            <input type="hidden" name="urlRetorno" value="/" />
            <input type="hidden" name="urlInforma" value="RecBol.aspx" />
            <input type="hidden" name="nome" value="{$nome}" />
            <input type="hidden" name="endereco" value="{$endereco}, {$numero}" />
            <input type="hidden" name="cidade" value="{$cidade}" />
            <input type="hidden" name="uf" value="{$estado}" />
            <input type="hidden" name="cep" value="{$cep}" />
            <input type="hidden" name="msgLoja" value="Voce fez uma reverb-compra" />
            <input name="numCliente" type="hidden" value="369098" size="15" />
            <input name="coopCartao" type="hidden" value="4355" size="15" />
            <input name="chaveAcessoWeb" type="hidden" value="99C593DC-4F35-4E01-8F64-DC8A492B8BA7" />
            <input name="numContaCorrente" type="hidden" value="198471" size="15" />
            <input name="codMunicipio" type="hidden" value="30836" size="15" />

            <!-- preencher com php -->
            <input size="25" maxlength="50" name="nomeSacado" type="hidden" value="{$nome}" />
            <input size="10" maxlength="14" name="cpfCGC" type="text" />
            <input name="dataNascimento" type="text" size="5" />
            <input size="15" maxlength="20" name="endereco" type="hidden" value="{$endereco}, {$numero}" />
            <input size="10" maxlength="15" name="bairro" type="hidden" value="{$bairro}" />
            <input size="15" maxlength="15" name="cidade" type="hidden" value="{$cidade}" />
            <input size="8" maxlength="8" name="cep" type="hidden" value="{$cep}" />
            <input size="5" maxlength="2" name="uf" type="text" value="{$estado}" />
            <input name="telefone" type="text" size="10" />
            <input name="bolRecebeBoletoEletronico" type="hidden" value="1" size="3" />
            <input name="email" type="text" size="25" />

            <input name="codEspDocumento" type="hidden" value="DM" size="5" />
            <input name="dataEmissao" type="hidden" size="5" />
            <input name="seuNumero" type="hidden" size="25" />
            <input name="nomeSacador" type="hidden" size="25" />
            <input name="numCGCCPFSacador" type="hidden" size="25" />
            <input name="qntMonetaria" type="hidden" size="5" />
            <input name="valorTitulo" type="hidden" size="5" />
            <input name="codTipoVencimento" type="hidden" value="1" size="5" />
            <input name="dataVencimentoTit" type="hidden" size="5" />
            <input name="valorAbatimento" type="hidden" value="0" size="5" />
            <input name="valorIOF" type="hidden" value="0" size="5" />
            <input name="bolAceite" type="hidden" value="1" size="5" />
            <input name="percTaxaMulta" type="hidden" value="0" size="5" />
            <input name="percTaxaMora" type="hidden" value="0" size="5" />
            <input name="dataPrimDesconto" type="hidden" size="5" />
            <input name="valorPrimDesconto" type="hidden" value="0" size="5" />
            <input name="dataSegDesconto" type="hidden" size="5" />
            <input name="valorSegDesconto" type="hidden" value="0" size="5" />
            <input name="descInstrucao1" type="hidden" size="25" />
            <input name="descInstrucao2" type="hidden" size="25" />
            <input name="descInstrucao4" type="hidden" size="25" />
            <input name="descInstrucao3" type="hidden" size="25" />
            <input name="descInstrucao5" type="hidden" size="25" />*}

            <input type="submit" value="Imprimir Boleto" id="mycart-print" />
        </form>
    {/if}
    <hr class="mycart-border">

    {if $compra->DS_FORMAPGTO_COSO eq 'boleto' OR $compra->ST_COMPRA_COSO == 'P'}
    <div id="mycart-confirm-message">
    	{*<a href="" class="md-trigger" data-modal="indique-lightbox">*}
        <a href="#" class="md-trigger" data-modal="indicar-lightbox">
    		<img pagespeed_no_transform src="{$basePath}/arquivos/default/images/mycart_confirm_M.png">
    	</a>
    </div>
    <div id="mycart-confirm-total">
    	<p>
    		<strong>Entrega</strong> <br>
                        {$enderecoCompra->nome} <br>
			{$enderecoCompra->endereco}, {$enderecoCompra->numero} | {$enderecoCompra->complemento} <br>
			{$enderecoCompra->bairro} <br>
			{$enderecoCompra->cidade} - {$enderecoCompra->estado} <br>
			{$enderecoCompra->cep}
    	</p>
        
    	<p>
    		<strong>Resumo do pedido</strong> <br>
                {foreach from=$carrinho item=dadosProduto}
                    {if $dadosProduto['valor_total_desconto']}
                        {$dadosProduto['quantidade']} {$dadosProduto['nome']} - {$dadosProduto['total_produto']|number_format:2:",":"."}<br>
                        {assign var=totalProduto value=$totalProduto+$dadosProduto['valor_total_desconto']}
                    {else}
                        {$dadosProduto['quantidade']} {$dadosProduto['nome']} - {$dadosProduto['total_produto']|number_format:2:",":"."}<br>
                        {assign var=totalProduto value=$totalProduto+$dadosProduto['total_produto']}
                    {/if}

                {/foreach}
    	</p>

    	<p>
    		<strong>Valores</strong> <br>
			Produtos: R$ {$totalProduto|number_format:2:",":"."} <br>
            {if $desconto_promo}
                Descontos: R$ {$desconto_promo|number_format:2:",":"."} <br>
            {else}
                Descontos: R$ {$compra->VL_DESCONTO_COSO|number_format:2:",":"."} <br>
            {/if}
			Frete: R$ {$compra->VL_FRETE_COSO|number_format:2:",":"."}
    	</p>

    	<p>
    		<strong>TOTAL: R$ {$compra->VL_TOTAL_COSO|number_format:2:",":"."}</strong>
    	</p>
        
        <p>
            <strong>Forma de pagamento: </strong>{$compra->DS_FORMAPGTO_COSO|ucfirst}</strong> <br>
            <!-- Prazo de entrega: <strong>3 dias úteis após a confirmação do pagamento</strong> -->
            
            {if $compra->DS_FORMAPGTO_COSO neq 'boleto'}
                {if $compra->NR_PARCELAS_COSO eq 1}
                    <strong>Pagamento à vista</strong>: R$ {$total_fim|number_format:2:",":"."}
                {else}
                    {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    <strong>Pagamento em {$compra->NR_PARCELAS_COSO} vezes de :</strong> R$ {$valor_parcela|number_format:2:",":"."}
                {/if}
            {/if}
        </p>
        {if $compra->DS_FORMAPGTO_COSO eq 'boleto' OR ($compra->ST_COMPRA_COSO == 'P' and $compra->ST_COMPRA_COSO == 'C')}
            <a href="{$this->url([], 'todos-produtos', TRUE)}" class="mycart-button avancar">Voltar para a loja</a>
        {/if}
    </div>
    {/if}
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

<div class="md-modal md-effect-1" id="indique-lightbox">
    <div class="md-content">
        <p class="md-title">INDIQUE AMIGOS E GANHE DESCONTOS!</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <form action="{$this->url([], "avisemeproduto", TRUE)}" method="POST">
                <div class="md-bg">
                <p class="md-description">
	                Coisas boas a gente compartilha com os amigos! Que tal indicar a Reverbcity e ganhar descontos nas suas próximas compras?
	            </p>
                    <div class="col">
                        <input class="field" type="text" id="indique-nome" name="nome" placeholder="Seu Nome">
                        <input class="field" type="text" id="indique-email" name="nome" placeholder="Seu Email">

                        <input class="field" type="text" id="indique-nome-amigo" name="nome_amigo" placeholder="Nome do Amigo">
                        <input class="field" type="text" id="indique-email-amigo" name="nome_amigo" placeholder="Email do Amigo">

                        <textarea class="field" id="indique-mensagem" name="mensagem" placeholder="Mensagem" cols="30" rows="10"></textarea>
                    </div>
                    <div class="send-button">
                        <button class="btn" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
            <p class="md-description">
                Caso haja algum problema, entre em contato através do
                <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
            </p>

       </div>
    </div>
</div>
<!-- Google Code for Compra Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1047813471;
    var google_conversion_language = "pt";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "BHLMCOn_2gQQ37rR8wM";
    var google_conversion_value = {$total_fim|number_format:0:"":""};
    var google_conversion_currency = "BRL";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<div style="display: none;">
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="Conversion" src="//www.googleadservices.com/pagead/conversion/1047813471/?value={$total_fim|number_format:0:"":""}&amp;currency_code=BRL&amp;label=BHLMCOn_2gQQ37rR8wM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
</div>