<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:04:31
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/lightbox-indica-produto.tpl" */ ?>
<?php /*%%SmartyHeaderCode:689285890562d27bf2a69a0-78359491%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72b7a6c6b49c9f6578315c67670c7ba90d7472b4' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/lightbox-indica-produto.tpl',
      1 => 1445396226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '689285890562d27bf2a69a0-78359491',
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

                <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"indiqueproduto",true);?>
" id="indique-form" method="POST">

                    <div class="md-bg">

                        <input class="field field-left" type="text" name="Nome" placeholder="Seu nome">

                        <input class="field field-right" type="text" name="Email" placeholder="Seu e-mail">

                        <input class="field field-left" type="text" name="NomeAmigo" placeholder="Nome do seu amigo">

                        <input class="field field-right" type="text" name="EmailAmigo" placeholder="E-mail do seu amigo">

                        <input type="hidden" name="idproduto" value="<?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
" />

                        <input type="hidden" name="extensao" value="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_EXT_PRRC;?>
" />

                        <input  type="hidden" name="nome_produto" value="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" />

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
