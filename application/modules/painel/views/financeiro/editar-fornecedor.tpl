
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Site > Financeiros > Fornecedores
        </div>
        <div id="header-section-name">
            Editar Fornecedor
        </div>
    </header>
    <div class="lt bs posr container-contents" id="config-body">
        <form action="" method="post">
            <div class="container">
                <div class="hw lt">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="fornecedor">Fornecedor</label>
                            <input  class="bs reverb-input-1" type="text" id="fornecedor" name="DS_FANTASIA_FORC" value="{$dadosFornecedor->DS_FANTASIA_FORC}" required>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="razao">Razão Social</label>
                            <input  class="bs reverb-input-1" type="text" id="razao" name="DS_RAZAO_FORC" value="{$dadosFornecedor->DS_RAZAO_FORC}" required>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="cnpj">CNPJ</label>
                            <input  class="bs reverb-input-1" type="text" id="cnpj" name="DS_CNPJ_FORC" value="{$dadosFornecedor->DS_CNPJ_FORC}" required>
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="inscricao">Inscrição Estadual</label>
                            <input  class="bs reverb-input-1" type="text" id="inscricao" name="DS_IE_FORC" value="{$dadosFornecedor->DS_IE_FORC}" required>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="endereco">Endereço Número e Complemento</label>
                            <input  class="bs reverb-input-1" type="text" id="endereco" name="DS_ENDERECO_FORC" value="{$dadosFornecedor->DS_ENDERECO_FORC}" required>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9 lt">
                            <label class="reverb-label-1" for="estado">Estado</label>
                            <input  class="bs reverb-input-1" type="text" id="estado" name="DS_ESTADO_FORC" value="{$dadosFornecedor->DS_ESTADO_FORC}" required>
                        </div>
                        <div class="reverb-fields reverb-field-9 lt">
                            <label class="reverb-label-1" for="Cidade">Cidade</label>
                            <input  class="bs reverb-input-1" type="text" id="Cidade" name="DS_CIDADE_FORC" value="{$dadosFornecedor->DS_CIDADE_FORC}" required>
                        </div>
                        <div class="reverb-fields reverb-field-3">
                            <label class="reverb-label-1" for="cep">CEP
                                <input  class="bs reverb-input-1 cep" type="text" id="cep" name="DS_CEP_FORC" value="{$dadosFornecedor->DS_CEP_FORC}" required>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="telefone1">Telefone 1</label>
                            <input  class="bs reverb-input-1 fone" type="text" id="telefone1" name="DS_TEL_FORC" value="{$dadosFornecedor->DS_TEL_FORC}" required>
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="telefone2">Telefone 2</label>
                            <input  class="bs reverb-input-1 fone" type="text" id="telefone2" name="DS_TEL2_FORC" value="{$dadosFornecedor->DS_TEL2_FORC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="email">E-mail</label>
                            <input  class="bs reverb-input-1" type="email" id="email" name="DS_EMAIL_FORC" value="{$dadosFornecedor->DS_EMAIL_FORC}" required>
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="contato">Contato</label>
                            <input  class="bs reverb-input-1" type="text" id="contato" name="DS_CONTATO_FORC" value="{$dadosFornecedor->DS_CONTATO_FORC}">
                        </div>
                    </div>
                </div>
                <div class="hw rt">

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="favorecido">Nome do Favorecido</label>
                            <input  class="bs reverb-input-1" type="text" id="favorecido" name="DS_FAVORECIDO_FORC" value="{$dadosFornecedor->DS_FAVORECIDO_FORC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="banco">Banco</label>
                            <input  class="bs reverb-input-1" type="text" id="banco" name="DS_BANCO_FORC" value="{$dadosFornecedor->DS_BANCO_FORC}">
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="agencia">Agência</label>
                            <input  class="bs reverb-input-1" type="text" id="agencia" name="DS_AGENCIA_FORC" value="{$dadosFornecedor->DS_AGENCIA_FORC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="conta">Número da Conta</label>
                            <input  class="bs reverb-input-1" type="text" id="conta" name="DS_CONTA_FORC" value="{$dadosFornecedor->DS_CONTA_FORC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="observacoes">Observações</label>
                            <div class="wrap-textarea">
                                <textarea  class="reverb-input-4" type="text" id="descricao" name="DS_OBS_FORC">{$dadosFornecedor->DS_OBS_FORC}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.fone').mask('(99)9999-9999?9');
        $('.cep').mask('99.999-999');
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/financeiro/fornecedores';
            //history.go(-1);
        });
    });
</script>