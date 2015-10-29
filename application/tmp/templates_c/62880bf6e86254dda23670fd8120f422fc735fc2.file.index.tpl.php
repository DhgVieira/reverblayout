<?php /* Smarty version Smarty-3.0.7, created on 2015-10-27 23:23:44
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1149547364563023a0d26988-68096848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62880bf6e86254dda23670fd8120f422fc735fc2' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/index.tpl',
      1 => 1445396250,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1149547364563023a0d26988-68096848',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
      <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['NR_SEQ_BANNER_BARC']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['DS_EXT_BARC']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_LINK_BARC'];?>
">
            <?php if (file_exists("arquivos/uploads/banners/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
              <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"banners",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
"/>
            <?php }else{ ?>
              <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
"/>
            <?php }?>
        </a>
    <?php }} ?>
</div>

<h1 class="rvb-title">Reverb <span>Me</span></h1>

<div class="rvb-column left">
    <!-- login -->
    <h2 class="full-strip">Fazer login</h2>
    <form class="lighten" id="reverbme-form-login" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'login',true);?>
" method="post">

        <div class="rvb-field">
          <input placeholder="E-MAIL" id="email" name="email" type="email" class="input-txt" required>
        </div>

        <div class="rvb-field">
          <input placeholder="SENHA" id="senha" name="senha" type="password" class="input-txt" required>
        </div>

        <div class="clearfix"></div>

        <a class="forgot-passwd md-trigger" data-modal="lightbox-recuperar-senha" href="#">Esqueceu a senha?</a>
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
    <h2 class="full-strip">Cadastro</h2>
    <form class="lighten" id="reverbme-form-cadastro" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'cadastro',true);?>
" method="post" enctype="multipart/form-data">

        <div class="rvb-field no-label">
          <input placeholder="NOME" id="nomecompleto" name="nomecompleto" type="text" class="input-txt middle4" required>
          <span id="adicionarFoto" type="button">
            <input class="adicionarFoto" type="file" name="foto">
            Adicione uma foto
          </span>
        </div>

        <div class="rvb-field">
          <label for="sexo" class="arrowed">Sexo</label>

          <div class="select-form middle3">
            <span class="select-fake">Selecione</span>
            <select name="sexo" id="sexo" class="select-box" required>
                <option selected value="">Selecione</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
            </select>
          </div>
        </div>

        <div class="rvb-field">
          <label class="arrowed">Nascimento</label>
          <input id="cadastro-dia" name="dia" type="text" class="input-txt min day" placeholder="DIA" maxlength="2" required>
          <input id="cadastro-mes" name="mes" type="text" class="input-txt min month" placeholder="MÊS" maxlength="2" required>
          <input id="cadastro-ano" name="ano" type="text" class="input-txt min year" placeholder="ANO" maxlength="4" required>
        </div>

        <div class="rvb-field">
          <label for="cadastro-cpf" class="arrowed">CPF</label>
          <input id="cadastro-cpf" name="cpf" type="text" class="input-txt middle1" maxlength="11" required>
          <span class="legend">Preencha sem traços e pontos</span>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="CEP" id="cadastro-cep" name="cep" type="text" class="input-txt middle2" required>
          <button id="buscarCep" type="button">Pesquisar</button>
          <span class="legend">Digite sem traços e pontos</span>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="ENDEREÇO" id="endereco" name="endereco" type="text" class="input-txt middle2" required>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="NÚMERO" id="numero" name="numero" type="text" class="input-txt middle3" required>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="COMPLEMENTO" id="complemento" name="complemento" type="text" class="input-txt middle2">
        </div>

        <div class="rvb-field no-label">
          <input placeholder="BAIRRO" id="bairro" name="bairro" type="text" class="input-txt middle3" required>
        </div>

        <div class="rvb-field">
          <label for="estado" class="arrowed">Estado</label>
          <div class="select-form middle3">
            <span class="select-fake">Selecione o estado</span>
            <select name="estado" id="estado" class="select-box">
            </select>
          </div>
        </div>

        <div class="rvb-field">
          <label for="cidade" class="arrowed">Cidade</label>
          <div class="select-form middle2">
            <span class="select-fake">Selecione</span>
            <select name="cidade" id="cidade" class="select-box">
            </select>
          </div>
        </div>

        <div class="rvb-field">
          <label for="pais" class="arrowed">País</label>
          <div class="select-form middle3">
            <span class="select-fake">Brasil</span>
            <select name="pais" id="pais" class="select-box">
                <option selected value="Brasil">Brasil</option>
                <option value="Outro">Outro</option>
            </select>
          </div>
          <span id="international-purchase" class="legend md-trigger" data-modal="international-purchases-lightbox">International purchase (click here)</span>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="FONE" id="telefone1" name="telefone1" type="text" class="input-txt middle2 phonemask" required>
        </div>

        <div class="rvb-field no-label">
          <input placeholder="CEL" id="telefone2" name="telefone2" type="text" class="input-txt middle3 phonemask">
        </div>

        <p class="full-strip bottom">Dados para login</p>

        <div class="rvb-field">
          <label for="usuarioemail" class="arrowed">E-mail</label>
          <input id="usuarioemail" name="usuarioemail" type="email" class="input-txt full" required>
        </div>

        <div class="rvb-field">
          <label for="usuarioemail2" class="arrowed">Confirme</label>
          <input id="usuarioemail2" name="usuarioemail2" type="email" class="input-txt full" required>
        </div>

        <div class="rvb-field">
          <label for="usuariosenha" class="arrowed">Senha</label>
          <input id="usuariosenha" name="usuariosenha" type="password" class="input-txt middle4">
          <span class="legend">Mínimo de 4 caracteres</span>
        </div>

        <div class="rvb-field">
          <label for="usuariosenha2" class="arrowed">Confirme</label>
          <input id="usuariosenha2" name="usuariosenha2" type="password" class="input-txt full">
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
          <button type="submit" class="btn">Finalizar</button>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
