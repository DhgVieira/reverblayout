<div class="banners-advertisement cycle-slideshow"
	 data-cycle-fx="fadeout"
	 data-cycle-timeout="5000"
	 data-cycle-slides="> a"
	 data-cycle-log="true"
	 data-cycle-pause-on-hover="true" style="margin-bottom:10px;">

	{foreach from=$banners_topo item=banner}
		{assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
		{assign var="extensao" value="{$banner->DS_EXT_BARC}"}
		{assign var="foto_completa" value="{$foto}.{$extensao}"}

		<a href="{$banner->DS_LINK_BARC}">
			{if file_exists("arquivos/uploads/banners/$foto_completa")}
				<img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
			{else}
				<img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
			{/if}
		</a>
	{/foreach}
</div>