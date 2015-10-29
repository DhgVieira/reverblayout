
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site &gt; Banners
        </div>
        <div id="header-section-name">
            Cadastrar Novo Banner
        </div>
    </header>
    <div id="banner-form">
        <div class="container">
            <div class="hw lt">
                <form method="post" enctype="multipart/form-data">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="titulo">Título do Banner</label>
                            <input  class="bs reverb-input-1" type="text" id="titulo" name="DS_DESCRICAO_BARC">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="subtitulo">Subtítulo</label>
                            <input  class="bs reverb-input-1" type="text" id="subtitulo" name="MSG_BANNER_BARC">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="localbanner">Local</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="localbanner" name="NR_SEQ_LOCAL_BARC">
                                    <option value="" selected disabled>Selecione</option>
                                    {foreach from=$dadosBannerslocal item=local}
                                        <option value="{$local->NR_SEQ_BANLOCAL_BLRC}">{$local->DS_LOCAL_BLRC}</option>
                                    {/foreach}
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="destino">URL de destino</label>
                            <input  class="bs reverb-input-1" type="text" id="destino" name="DS_LINK_BARC">
                        </div>
                    </div>
                    {*<div class="row posr fw lt">*}
                        {*<div class="reverb-fields reverb-field-3">*}
                            {*<label class="reverb-label-1" for="agendamento">Agendamento ?</label>*}
                            {*<div class="reverb-input-1 select-1">*}
                                {*<select class="select bs" id="agendamento" name="agendamento" required>*}
                                    {*<option value="" selected disabled>Selecione</option>*}
                                    {*<option value="1">SIM</option>*}
                                    {*<option value="2">NÃO</option>*}
                                {*</select>*}
                                {*<span class="select-value">SIM</span>*}
                            {*</div>*}
                        {*</div>*}
                        {*<div class="reverb-fields reverb-field-8 wrap-date-input">*}
                            {*<label class="reverb-label-1" for="qual">Qual ?</label>*}
                            {*<input  class="bs reverb-input-1 date-input date-interval" type="text" id="peso" name="peso">*}
                            {*<span class="ico-calendars"></span>*}
                        {*</div>*}
                    {*</div>*}
                    {*<div class="row posr fw lt">*}
                        {*<div class="reverb-fields reverb-field-3">*}
                            {*<label class="reverb-label-1" for="referencia">Hora início</label>*}
                            {*<input  class="bs reverb-input-1" type="text" id="referencia" name="referencia">*}
                        {*</div>*}
                        {*<div class="reverb-fields reverb-field-3">*}
                            {*<label class="reverb-label-1" for="peso">Hora fim</label>*}
                            {*<input  class="bs reverb-input-1" type="text" id="peso" name="peso">*}
                        {*</div>*}
                    {*</div>*}
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="image-uploader">Imagem</label>
                            <div class="load-more-images posr image-uploader-1">
                                Clique para adicionar imagens
                                <span class="plus bs posa"> + </span>
                                <input type="file" class="upload-images posa" name="imagem">
                            </div>
                        </div>
                    </div>
                    {*<div class="row posr fw lt">*}
                            {*<div class="fw lt uploaded-product-previews">*}
                                {*<table width="100%" class="preview-tables">*}
                                    {*<tbody>*}
                                        {*<tr>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                            {*<td class="preview-items posr">*}
                                                {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                {*<button class="remove-preview"></button>*}
                                            {*</td>*}
                                        {*</tr>*}
                                    {*</tbody>*}
                                {*</table>*}
                            {*</div>*}
                    {*</div>*}
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </form>
            </div>
            <div class="hw lt">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/site';
            //history.go(-1);
        });
    });
</script>