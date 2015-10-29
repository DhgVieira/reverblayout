<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:03:09
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/lightbox-indique.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1501068532562d276dd05539-83496924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '595c45353fe25a5f6b9ce918b13a5b5d90993632' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/lightbox-indique.tpl',
      1 => 1445396226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1501068532562d276dd05539-83496924',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="md-modal md-effect-1" id="indique-lightbox">
    <div class="md-content">
        <p class="md-title">INDIQUE PARA UM AMIGO</p>
        <button class="md-close ir">Fechar</button>
        <div>
            <div id="in">

                <p>
                    Coisas boas a gente compartilha com os amigos! Que tal indicar essa peça para aquele seu melhor amigo poder ter também?
                </p>

                <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"indiqueamigo",true);?>
" id="indique-form" method="POST">

                    <div class="md-bg">

                        <input class="field field-left" type="text" name="Nome" placeholder="Seu nome">

                        <input class="field field-right" type="text" name="Email" placeholder="Seu e-mail">

                        <input class="field field-left" type="text" name="NomeAmigo" placeholder="Nome do seu amigo">

                        <input class="field field-right" type="text" name="EmailAmigo" placeholder="E-mail do seu amigo">

                        <textarea placeholder="Envie uma mensagem personalizada..." name="mensagem"></textarea>

                    </div>

                    <div class="send-button">
                        <button class="btn" type="submit">Enviar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
