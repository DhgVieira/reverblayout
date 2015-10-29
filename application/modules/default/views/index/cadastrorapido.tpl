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

<h1 class="rvb-title">Reverb <span>Me</span></h1>

<div class="rvb-column left">
    <!-- login -->
    <h2 class="full-strip">Fazer login</h2>
    <form class="lighten" id="reverbme-form-login" action="{$this->url([], 'login', TRUE)}" method="post">

        <div class="rvb-field">
          <input placeholder="E-MAIL" id="email" name="email" type="email" class="input-txt" required>
        </div>

        <div class="rvb-field">
          <input placeholder="SENHA" id="senha" name="senha" type="password" class="input-txt" required>
        </div>

        <div class="clearfix"></div>

        <a class="forgot-passwd" href="#">Esqueceu a senha?</a>
        <div class="send-button">
          <button type="submit" class="btn">Login</button>
        </div>
    </form>

    <div class="advertisement clearfix">
        <p>ESTE FORMULÁRIO CRIA AUTOMATICAMENTE UMA CONTA PESSOAL NA REVERBCITY. ASSIM, É MAIS FÁCIL O PROCESSO DE COMPRAS.</p>
        <p>VOCÊ TAMBÉM, TEM ACESSO LIVRE A CONTEÚDOS E AS FERRAMENTAS DE INTERATIVIDADE COM O SITE.</p>
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
	<div id="social-login">
		<a href="https://www.facebook.com/dialog/oauth?client_id=222802401243110&redirect_uri=http://reverbcity.com/cadastro-rapido&scope=email,user_website,user_location,user_birthday" class="facebook-login">
			<span class="login-facebook-icon"></span>
			<span class="login-facebook-text">Login com <strong>facebook</strong></span>
		</a>
		<a href="{$this->url([], "logintwitter", TRUE)}" class="twitter-login">
			<span class="login-twitter-icon"></span>
			<span class="login-twitter-text">Login com <strong>twitter</strong></span>
		</a>
	</div>
    <h2 class="full-strip">Dados para login</h2>
    <form class="lighten" id="reverbme-form-cadastro" action="{$this->url([], "inserircadastro", TRUE)}" method="post">

        <div class="rvb-field no-label">
          <input placeholder="E-MAIL" id="usuarioemail" name="email" type="email" class="input-txt full" required>
        </div>

        <div class="rvb-field no-label">
          <input  placeholder="CONFIRME O E-MAIL" id="usuarioemail2" name="confirma_email" type="email" class="input-txt full">
        </div>

        <div class="rvb-field no-label">
          <input  placeholder="SENHA" id="usuariosenha" name="senha" type="password" class="input-txt middle4">
          <span class="legend">Mínimo de 4 caracteres</span>
        </div>

        <div class="rvb-field no-label">
          <input  placeholder="CONFIRME A SENHA" id="usuariosenha2" name="confirma_senha" type="password" class="input-txt full">
        </div>

        <p class="full-strip">Observações</p>
        <textarea name="observacoes" id="observacoes" cols="1" rows="5" class="input-message" placeholder="DIGITE AQUI"></textarea>

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
          <button type="submit" class="btn">Finalizar</button>
        </div>
    </form>
</div>
