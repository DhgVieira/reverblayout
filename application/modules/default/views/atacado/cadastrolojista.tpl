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

<h1 class="rvb-title">Reverb <span>Me</span></h1>

<div class="rvb-column left">
    <!-- login -->
    <h2 class="full-strip">Fazer login</h2>
    <form class="lighten" id="reverbme-form-login" action="{$this->url([], 'login', TRUE)}" method="post">

        <div class="rvb-field">
          <label for="email" class="arrowed">E-mail</label>
          <input id="email" name="email" type="email" class="input-txt" required>
        </div>

        <div class="rvb-field">
          <label for="senha" class="arrowed">Senha</label>
          <input id="senha" name="senha" type="password" class="input-txt" required>
        </div>
        <a class="forgot-passwd" href="#">Esqueceu a senha?</a>
        <div class="send-button">
          <button type="submit" class="btn">Login</button>
        </div>
    </form>

    <div class="advertisement clearfix">
        <h2>Que tal comprar Reverbcity no atacado?</h2>
        <p>Desde 2004 estampamos o melhor do rock n’ roll em camisetas incríveis, buttons, canecas, eco-bags e muito mais!</p>
        <p>É super fácil! Temos Pronta-entrega, preços ótimos e facilidades de pagamento!!!</p>
        <p>Entre em contato conosco e conheça as condições especiais que temos para você complementar o estoque de sua loja e aumentar seu faturamento!</p>
        <p>Email: vendas@reverbcity.com</p>
    </div>

    <h2 class="full-strip social">Social</h2>
    <ul class="socials-network-dark">
      <li><a href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>
      <li><a href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>
      <li><a href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>
      <li><a href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>
      <li><a href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>
      <li class="last"><a href="http://reverbcity.com/rss/rss.php" class="icon rss ir">RSS</a></li>
    </ul>
</div>

<div class="rvb-column right">
    <h2 class="full-strip">Cadastro de Atacado</h2>
    <form class="lighten" id="reverbme-form-cadastro" action="#" method="post">

        <div class="rvb-field">
          <label for="razaosocial" class="arrowed"><abbr title="Razão Social">Raz. social</abbr></label>
          <input id="razaosocial" name="razaosocial" type="text" class="input-txt full">
        </div>

        <div class="rvb-field">
          <label for="nomefantasia" class="arrowed"><abbr title="Nome fantasia">N. fantasia</abbr></label>
          <input id="nomefantasia" name="nomefantasia" type="text" class="input-txt full" required>
        </div>

        <div class="rvb-field">
          <label for="contato" class="arrowed">Contato</label>
          <input id="contato" name="contato" type="text" class="input-txt full">
        </div>

        <div class="rvb-field">
          <label class="arrowed">Fundação</label>
          <input id="cadastro-dia" name="dia" type="text" class="input-txt min day" placeholder="DIA" maxlength="2" required> /
          <input id="cadastro-mes" name="mes" type="text" class="input-txt min month" placeholder="MÊS" maxlength="2" required> /
          <input id="cadastro-ano" name="ano" type="text" class="input-txt min year" placeholder="ANO" maxlength="4" required>
        </div>

        <div class="rvb-field">
          <label for="cadastro-cnpj" class="arrowed"><abbr title="Cadastro Nacional de Pessoa Jurídica">CNPJ</abbr></label>
          <input id="cadastro-cnpj" name="cnpj" type="text" class="input-txt middle1" maxlength="14" required>
          <span class="legend">Preencha sem traços e pontos</span>
        </div>

        <div class="rvb-field">
          <label for="inscricaoestadual" class="arrowed"><abbr title="Inscrição Estadual">Insc. Est</abbr></label>
          <input id="inscricaoestadual" name="inscricaoestadual" type="text" class="input-txt middle1" required>
        </div>

        <div class="rvb-field">
          <label for="cep" class="arrowed">CEP</label>
          <input id="cadastro-cep" name="cep" type="text" class="input-txt middle2" required maxlength="8">
          <button id="buscarCep" type="button">Pesquisar</button>
          <span class="legend">Digite sem traços e pontos</span>
        </div>

        <div class="rvb-field">
          <label for="endereco" class="arrowed">Endereço</label>
          <input id="endereco" name="endereco" type="text" class="input-txt middle2" required>
        </div>

        <div class="rvb-field">
          <label for="numero" class="arrowed">Número</label>
          <input id="numero" name="numero" type="text" class="input-txt middle3" required>
        </div>

        <div class="rvb-field">
          <label for="complemento" class="arrowed"><abbr title="Complemento">Compl.</abbr></label>
          <input id="complemento" name="complemento" type="text" class="input-txt middle2">
        </div>

        <div class="rvb-field">
          <label for="bairro" class="arrowed">Bairro</label>
          <input id="bairro" name="bairro" type="text" class="input-txt middle3" required>
        </div>

        <div class="rvb-field clearleft">
          <div class="select-form middle3">
            <label for="estado" class="arrowed">Estado</label>
            <span>Selecione o estado</span>
            <select name="estado" id="estado" class="select-box"></select>
          </div>
        </div>

        <div class="rvb-field">
          <div class="select-form">
            <label for="cidade" class="arrowed">Cidade</label>
            <span>Selecione</span>
            <select name="cidade" id="cidade" class="select-box"></select>
          </div>
        </div>

        <div class="rvb-field">
          <div class="select-form middle3">
            <label for="pais" class="arrowed">País</label>
            <span>Selecione o País</span>
            <select name="pais" id="pais" class="select-box">
                <option value="Brasil">Brasil</option>
                <option value="Outro">Outro</option>
            </select>
            <span class="legend md-trigger" data-modal="international-purchases-lightbox">International purchase (click here)</span>
          </div>
        </div>

        <div class="rvb-field clearleft">
          <label for="telefone1" class="arrowed"><abbr title="Telefone">Fone</abbr></label>
          <input id="telefone1" name="telefone1" type="text" class="input-txt middle2 phonemask" required>
        </div>

        <div class="rvb-field">
          <label for="telefone2" class="arrowed">Celular</label>
          <input id="telefone2" name="telefone2" type="text" class="input-txt middle3 phonemask">
        </div>

        <!-- <div class="rvb-field">
          <label for="facebook" class="arrowed">Facebook</label>
          <input id="facebook" name="facebook" type="text" class="input-txt full" placeholder="Ex: http://www.facebook.com/seuperfil">
        </div>

        <div class="rvb-field">
          <label for="twitter" class="arrowed">Twitter</label>
          <input id="twitter" name="twitter" type="text" class="input-txt full" placeholder="Ex: http://www.twitter.com/seuperfil">
        </div> -->

        <p class="full-strip bottom">Dados para login</p>

        <div class="rvb-field">
          <label for="atacadistaemail" class="arrowed">E-mail</label>
          <input id="atacadistaemail" name="atacadistaemail" type="email" class="input-txt full" required>
        </div>

        <div class="rvb-field">
          <label for="atacadistaemail2" class="arrowed">Confirme</label>
          <input id="atacadistaemail2" name="atacadistaemail2" type="email" class="input-txt full" required>
        </div>

        <div class="rvb-field">
          <label for="atacadistasenha" class="arrowed">Senha</label>
          <input id="atacadistasenha" name="atacadistasenha" type="password" class="input-txt middle4" maxlength="8">
          <span class="legend">Mínimo de 4 caracteres</span>
        </div>

        <div class="rvb-field">
          <label for="atacadistasenha2" class="arrowed">Confirme</label>
          <input id="atacadistasenha2" name="atacadistasenha2" type="password" class="input-txt full" maxlength="8">
        </div>

        <p class="full-strip">Observações</p>
        <textarea name="observacoes" id="observacoes" cols="1" rows="5" class="input-message" placeholder="Digite aqui"></textarea>

        <div class="checkbox-dif checked">
          <label class="checkbox" for="mailing">
            <input type="checkbox" id="mailing" name="mailing" checked value="S">
            Quero receber o reverbmailing
          </label>
        </div>

        <div class="checkbox-dif checked">
          <label class="checkbox" for="sms">
            <input type="checkbox" id="sms" name="sms" checked value="S">
            Autorizo o recebimento de SMS (Mensagens de texto no celular)
          </label>
        </div>

        <div class="send-button">
          <button type="submit" class="btn">Registrar</button>
        </div>
    </form>
</div>
