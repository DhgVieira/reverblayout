<!-- ----------------------------------------- CONTEÚDO ----------------------------------------- -->
<div class="main-content">
    <div class="row">
        <form id="mydropzone" class="dropzone" action="{$this->url([], "novousuario", TRUE)}" method="POST">

            <div class="borded-r">

                <div class="form-group col-sm-12">
                    <label for="nome" class="control-label custom-label">
                        <abbr title="Nome">Nome</abbr>
                    </label>
                    <input type="text" class="form-control input-lg" id="nome" name="nome" placeholder="Ex: Tony Strauss">
                </div>

                <div class="form-group col-sm-12">
                    <label for="email" class="control-label custom-label">
                        <abbr title="email">E-mail</abbr>
                    </label>
                    <input type="text" class="form-control input-lg" id="email" name="email" placeholder="Ex: contato@reverbcity.com">
                </div>

                <div class="clearfix"></div>

                <div class="form-group col-sm-6">
                    <label for="field-1" class="control-label custom-label">
                        <abbr title="Tipo">Perfil</abbr>
                    </label>
                    <select name="idperfil" id="tipo" class="selectboxit input-lg" data-text="Selecione o Perfil do Usuário">
                      {foreach from=$perfis item=perfil}
                        <option value="{$perfil->idperfil}">{$perfil->descricao_perfil}</option>
                      {/foreach}
                    </select>
                </div>
                <div class="clearfix"></div>

                <div class="form-group col-sm-6">
                    <label for="login" class="control-label custom-label">
                        <abbr title="login">Login</abbr>
                    </label>
                    <input type="text" class="form-control input-lg" id="login" name="login">
                </div>

                <div class="form-group col-sm-6">
                    <label for="senha" class="control-label custom-label">
                        <abbr title="senha">Senha</abbr>
                    </label>
                    <input type="password" class="form-control input-lg" id="senha" name="senha">
                </div>

              <div class="clearfix"></div>

                <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-cancel btn-icon">
                        Cancelar
                        <i class="entypo-cancel"></i>
                    </button>
                    <button type="submit" id="submit" class="btn btn-confirm btn-icon">
                        Pronto, cadastrar!
                        <i class="entypo-check"></i>
                    </button>
                </div>

            </div>

           
        </form>
    </div>
</div>
<!-- ----------------------------------------- FIM DO CONTEÚDO ----------------------------------------- -->


<script>
    $(document).ready(function() {
        var previewTemplate =  '<div class="dz-preview dz-file-preview">';
            previewTemplate +=    '<div class="dz-details">';
            previewTemplate +=        '<img data-dz-thumbnail />';
            previewTemplate +=    '</div>';
            // previewTemplate +=    '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>';
            // previewTemplate +=    '<div class="dz-success-mark"><span>✔</span></div>';
            // previewTemplate +=    '<div class="dz-error-mark"><span>✘</span></div>';
            previewTemplate +=  '</div>';

        var _dropZone = $("#mydropzone").dropzone({
          url: "data/upload-file.php",
          thumbnailWidth: 78,
          thumbnailHeight: 88,
          previewTemplate: previewTemplate,
          dictDefaultMessage: "",
          dictRemoveFile: "x",
          acceptedFiles: ".png,.jpg",
          addRemoveLinks: true,
          autoProcessQueue: false,
          autoDiscover: false,
          paramName: "pic",
          previewsContainer: "#mydropzone .dropzone-area .thumbs-preview",
          clickable: "#mydropzone .dropzone-area .fileinput-button",
          accept: function(file, done) {
            console.log("uploaded");
            done();
          },
          error: function(file, msg) {
            alert(msg);
          },
          init: function(){

            var myDropzone = this;
            $("#mydropzone").find("button[type=submit]").on("click", function(e) {
              // e.preventDefault();
              // myDropzone.processQueue();
            });

          }

        });
    });
</script>


<!-- -----------------------------------------  ALERTAS/MODAIS ----------------------------------------- -->

<!-- -----------------------------------------  FIM DE ALERTAS/MODAIS ----------------------------------------- -->